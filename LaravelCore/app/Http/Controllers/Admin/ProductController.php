<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\UnitsImport;
use App\Models\Catalogue;
use App\Models\Unit;
use App\Models\Variable;
use App\Models\Product;
use App\Models\User;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    const NAME = 'Product',
        MESSAGES = [
            'sku.string' => Controller::DATA_INVALID,
            'sku.max' => Controller::MAX,
            'name.required' => Controller::NOT_EMPTY,
            'name.string' => Controller::DATA_INVALID,
            'name.max' => Controller::MAX,
            'status.numeric' => Controller::DATA_INVALID,
            'catalogues.required' => 'Category can not be empty',
            'catalogues.array' => 'Category: ' . Controller::DATA_INVALID,
        ];

    public function __construct()
    {
        parent::__construct();
        if ($this->user === null) {
            $this->user = Auth::user();
        }
        $this->middleware(['admin', 'auth']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        if (isset($request->key)) {
            $catalogues = Cache::get('catalogues')->whereNull('parent_id');
            switch ($request->key) {
                case 'render':
                    $request->validate([
                        'columns' => 'required',
                        'catalogue_id' => 'required|numeric',
                    ], [
                        'columns.required' => 'Please select at least one column',
                        'catalogue_id.required' => 'Category can not be empty',
                    ]);
                    $catalogue_ids = Controller::getDescendantIds($request->catalogue_id);
                    $catalogue_ids[] = $request->catalogue_id;
                    $objs = Product::with('variables.units')
                        ->when($request->catalogue_id, function ($query) use ($catalogue_ids) {
                            $query->whereHas('catalogues', function ($query) use ($catalogue_ids) {
                                $query->whereIn('catalogues.id', $catalogue_ids);
                            });
                        })
                        ->orderBy('sort', 'ASC')
                        ->get();
                    return view('admin.templates.renders.product', ['products' => $objs, 'columns' => $request->columns]);
                case 'new':
                    $pageName = 'New Product';
                    return view('admin.product', compact('pageName', 'catalogues'));
                    break;
                case 'list':
                    $ids = json_decode($request->ids);
                    $result = Product::orderBy('sort', 'ASC')->when(count($ids), function ($query) use ($ids) {
                        $query->whereIn('id', $ids);
                    })->get();
                    break;
                case 'barcode':
                    $ids = json_decode($request->ids);
                    $result = Product::withTrashed()->with('variables.units')->when(count($ids), function ($query) use ($ids) {
                        $query->whereIn('id', $ids);
                    })->get();
                    break;
                case 'select2':
                    if ($request->barcode) {
                        $product = Product::with('catalogues', 'variables.units')
                            ->whereHas('variables', function ($query) use ($request) {
                                $query->whereHas('units', function ($query) use ($request) {
                                    $query->whereBarcode($request->barcode);
                                });
                            })->first();
                        if ($product) {
                            $product->variable = Variable::with('units', 'attributes')->whereHas('units', function ($query) use ($request) {
                                $query->whereBarcode($request->barcode);
                            })->first();
                            $result = $product;
                        } else {
                            $result = false;
                        }
                    } else {
                        $result = Product::with('variables.units')
                            ->where('status', '>', 0)
                            ->where(function ($query) use ($request) {
                                $query->where('name', 'LIKE', '%' . $request->q . '%')
                                    ->orWhere('sku', 'LIKE', '%' . $request->q . '%')
                                    ->orWhereHas('variables', function ($query) use ($request) {
                                        $query->where('name', 'LIKE', '%' . $request->q . '%');
                                    });
                            })
                            ->orderByDesc('id')
                            ->distinct()
                            ->get()
                            ->map(function ($obj) {
                                return [
                                    'id' => $obj->id,
                                    'text' => $obj->sku . ' - ' . $obj->name
                                ];
                            });
                    }
                    break;
                default:
                    $product = Product::withTrashed()->with('catalogues', 'variables.units')->find($request->key);
                    if ($product) {
                        if ($request->ajax()) {
                            $result = $product;
                        } else {
                            $pageName = 'Product Details';
                            return view('admin.product', compact('pageName', 'catalogues', 'product'));
                        }
                    } else {
                        return redirect()->route('admin.product', ['key' => 'new']);
                    }
                    break;
            }
            return response()->json($result, 200);
        } else {
            if ($request->ajax()) {
                $objs = Product::with([
                    'variables.units',
                    'catalogues',
                    'variables' => function ($query) {
                        $query->withTrashed()->with('_product');
                    }
                ]);
                $can_update_product = $this->user->can(User::UPDATE_PRODUCT);
                $can_read_catalogues = $this->user->can(User::READ_CATALOGUES);
                $can_delete_product = $this->user->can(User::DELETE_PRODUCT);
                $can_create_variable = $this->user->can(User::CREATE_VARIABLE);
                $can_update_variable = $this->user->can(User::UPDATE_VARIABLE);
                return DataTables::of($objs)
                    ->addColumn('checkboxes', function ($obj) {
                        return '<input class="form-check-input choice" type="checkbox" name="choices[]" value="' . $obj->id . '">';
                    })
                    ->addColumn('code', function ($obj) use ($can_update_product) {
                        if ($can_update_product) {
                            $code = '<a class="btn btn-link text-decoration-none btn-update-product fw-bold p-0" data-id="' . $obj->id . '">' . $obj->code . '</a>';
                        } else {
                            $code = '<span class="fw-bold">' . $obj->code . '</span>';
                        }
                        return $code . '<br/><small>' . $obj->created_at->format('d/m/Y H:i') . '</small>';
                    })
                    ->filterColumn('code', function ($query, $keyword) {
                        $array = explode('/', $keyword);
                        $query->when(count($array) > 1, function ($query) use ($keyword, $array) {
                            $date = (count($array) == 3 ? $array[2] : date('Y')) . '-' . str_pad($array[1], 2, "0", STR_PAD_LEFT) . '-' . str_pad($array[0], 2, "0", STR_PAD_LEFT);
                            $query->whereDate('created_at', $date);
                        });
                        $query->when(count($array) == 1, function ($query) use ($keyword) {
                            $numericKeyword = ltrim(preg_replace('/[^0-9]/', '', $keyword), '0');
                            if (!empty($numericKeyword)) {
                                $query->where('products.id', 'like', "%" . $numericKeyword . "%");
                            }
                        });
                    })
                    ->orderColumn('code', function ($query, $order) {
                        $query->orderBy('id', $order);
                    })
                    ->editColumn('name', function ($obj) use ($can_update_product) {
                        if ($can_update_product) {
                            $color = $obj->deleted_at ? 'danger' : 'success';
                            return '<a href="' . route('admin.product', ['key' => $obj->id]) . '" class="btn btn-link text-' . $color . ' text-decoration-none btn-update-product fw-bold text-start" data-id="' . $obj->id . '">' . $obj->name . '</a>' . ($obj->sku ? '<br/><span class="px-3">' . $obj->sku . '</span>' : '');
                        }
                        return '<span class="fw-bold">' . $obj->name . '</span>';
                    })
                    ->filterColumn('name', function ($query, $keyword) {
                        $query->where('name', 'like', "%" . $keyword . "%")
                            ->orWhere('sku', 'like', "%" . $keyword . "%")
                            ->orWhereHas('variables', function ($query) use ($keyword) {
                                $query->where('name', 'like', "%" . $keyword . "%")
                                    ->orWhereHas('units', function ($query) use ($keyword) {
                                        $query->where('barcode', 'like', "%" . $keyword . "%")
                                            ->orWhere('term', 'like', "%" . $keyword . "%");
                                    });
                            });
                    })
                    ->addColumn('avatar', function ($obj) {
                        return '<img src="' . $obj->avatarUrl . '" class="thumb cursor-pointer object-fit-cover" alt="Ảnh ' . $obj->name . '" width="60px" height="60px">';
                    })
                    ->addColumn('catalogues', function ($obj) use ($can_read_catalogues) {
                        return $obj->catalogues->map(function ($catalogue) use ($can_read_catalogues) {
                            if ($can_read_catalogues) {
                                return '<a class="btn btn-link text-decoration-none btn-update-catalogue py-0" data-id="' . $catalogue->id . '">' . $catalogue->fullName . '</a>';
                            } else {
                                return $catalogue->fullName;
                            }
                        })->join('');
                    })
                    ->filterColumn('catalogues', function ($query, $keyword) {
                        $query->whereHas('catalogues', function ($query) use ($keyword) {
                            $query->where('name', 'like', "%" . $keyword . "%");
                        });
                    })
                    ->addColumn('variables', function ($obj) use ($can_create_variable, $can_update_variable) {
                        $btn_create_variable = $can_create_variable ? '<a class="btn btn-link text-decoration-none btn-create-variable py-1" data-product="' . $obj->id . '"><i class="bi bi-plus-circle"></i></a>' : '';
                        return $obj->variables->map(function ($variable) use ($can_update_variable) {
                            $color = $variable->deleted_at ? 'danger' : 'success';
                            return $can_update_variable ? '<a class="btn btn-link text-decoration-none text-' . $color . ' btn-update-variable py-1" data-id="' . $variable->id . '">' . ($variable->name ? $variable->name : $variable->id) . '</a>' : '';
                        })->push($btn_create_variable)->join('');
                    })
                    ->filterColumn('variables', function ($query, $keyword) {
                        $query->whereHas('variables', function ($query) use ($keyword) {
                            $query->where('name', 'like', "%" . $keyword . "%")
                                ->orWhereHas('_product', function ($query) use ($keyword) {
                                    $query->where('name', 'like', "%" . $keyword . "%")
                                        ->orWhere('sku', 'like', "%" . $keyword . "%");
                                })
                                ->orWhereHas('units', function ($query) use ($keyword) {
                                    $query->where('barcode', 'like', "%" . $keyword . "%")
                                        ->orWhere('term', 'like', "%" . $keyword . "%");
                                });
                        });
                    })
                    ->editColumn('status', function ($obj) {
                        return '<span class="badge bg-' . ($obj->status ? 'success' : 'danger') . '">' . $obj->statusStr . '</span>';
                    })
                    ->orderColumn('status', function ($query, $order) {
                        $query->orderBy('status', $order);
                    })
                    ->addColumn('action', function ($obj) use ($can_delete_product) {
                        $actionButtons = '
                            <div class="d-flex align-items-center">
                                <a class="btn btn-link text-decoration-none btn-view-import_detail" data-id="' . $obj->id . '">
                                    <i class="bi bi-box-arrow-in-down" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="View product import history"></i>
                                </a>
                                <a class="btn btn-link text-decoration-none btn-view-export_detail" data-id="' . $obj->id . '">
                                    <i class="bi bi-box-arrow-in-up" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="View product export history"></i>
                                </a>';
                        if ($can_delete_product) {
                            $actionButtons .= '
                                <form action="' . route('admin.product.remove') . '" method="post" class="save-form d-inline">
                                    <input type="hidden" name="_token" value="' . csrf_token() . '"/>
                                    <input type="hidden" name="choices[]" value="' . $obj->id . '" data-id="' . $obj->id . '"/>
                                    <button class="btn btn-link text-decoration-none btn-remove">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </form>';
                        }
                        $actionButtons .= '</div>';
                        return $actionButtons;
                    })
                    ->rawColumns(['checkboxes', 'code', 'name', 'avatar', 'catalogues', 'variables', 'status', 'action', 'hidden'])
                    ->setTotalRecords($objs->count())
                    ->make(true);
            } else {
                $objs = Product::get();
                $pageName = self::NAME . ' management';
                return view('admin.products', compact('pageName'));
            }
        }
    }
    public function sort(Request $request)
    {
        $ids = $request->input('sort');
        $totalProducts = Product::count();

        if (count($ids) == $totalProducts) {
            $sql = "UPDATE products SET sort = CASE ";
            $idArray = [];

            foreach ($ids as $index => $id) {
                $sql .= "WHEN id = ? THEN ? ";
                $idArray[] = $id;
                $idArray[] = $index + 1;
            }

            $sql .= "END WHERE id IN (" . implode(',', array_fill(0, count($ids), '?')) . ")";
            $idArray = array_merge($idArray, $ids);

            DB::statement($sql, $idArray);
        } else {
            $sorts = Product::whereIn('id', $ids)->orderBy('sort', 'ASC')->pluck('sort');
            $sql = "UPDATE products SET sort = CASE ";
            $idArray = [];

            foreach ($sorts as $index => $sort) {
                $sql .= "WHEN id = ? THEN ? ";
                $idArray[] = $ids[$index];
                $idArray[] = $index + 1;
            }

            $sql .= "END WHERE id IN (" . implode(',', array_fill(0, count($ids), '?')) . ")";
            $idArray = array_merge($idArray, $ids);

            DB::statement($sql, $idArray);
        }

        return response()->json(['msg' => 'The sort order has been updated successfully!'], 200);
    }

    public function save(Request $request)
    {
        $rules = [
            'sku' => ['nullable', 'string', 'max:125'],
            'name' => ['required', 'string', 'max:125'],
            'status' => ['nullable', 'numeric'],
            'catalogues' => ['required'],
        ];
        $request->validate($rules, self::MESSAGES);

        if (!empty($this->user->can(User::CREATE_PRODUCT, User::UPDATE_PRODUCT))) {
            try {
                $product = Product::updateOrCreate(
                    ['id' => $request->id],
                    [
                        'sku' => $request->sku,
                        'name' => $request->name,
                        'slug' => Str::slug($request->name),
                        'excerpt' => $request->excerpt,
                        'description' => $request->description,
                        'specs' => $request->specs,
                        'keyword' => $request->keyword,
                        'gallery' => $request->gallery,
                        'allow_review' => $request->has('allow_review'),
                        'status' => $request->status,
                    ]
                );
                if ($product) {
                    $product->syncCatalogues($request->catalogues);
                }
                $action = ($request->id) ? 'update' : 'create';
                LogController::create($action, self::NAME, $product->id);
                $response = array(
                    'status' => 'success',
                    'msg' => 'Successfully ' . $action . ' ' . self::NAME . ' ' . $product->name
                );
            } catch (\Exception $e) {
                log_exception($e);
                return response()->json(['errors' => ['error' => ['An error occurred: ' . $e->getMessage()]]], 422);
            }
        } else {
            return response()->json(['errors' => ['role' => ['You do not have permission!']]], 422);
        }
        return redirect()->route('admin.product', ['key' => $product->id])->with('response', $response);
    }

    public function create(Request $request)
    {
        $rules = [
            'sku' => ['nullable', 'string', 'max:125'],
            'name' => ['required', 'string', 'max:125'],
            'status' => ['nullable', 'numeric'],
            'catalogues' => ['required', 'array'],
        ];

        $request->validate($rules, self::MESSAGES);

        if (!empty($this->user->can(User::CREATE_PRODUCT, User::UPDATE_PRODUCT))) {
            DB::beginTransaction();
            try {
                $product = Product::create([
                    'sku' => $request->sku,
                    'name' => $request->name,
                    'slug' => Str::slug($request->name),
                    'excerpt' => $request->excerpt,
                    'description' => $request->description,
                    'specs' => $request->specs,
                    'keyword' => $request->keyword,
                    'gallery' => $request->gallery,
                    'allow_review' => $request->has('allow_review'),
                    'status' => $request->status,
                ]);
                if ($product) {
                    LogController::create('create', self::NAME, $product->id);
                    if ($request->avatar) {
                        $image = $request->file('avatar');
                        $imageName = $image->getClientOriginalName();
                        $tmp = explode('.', $imageName);
                        $path = 'public/' . Str::slug($tmp[0]) . '.' . $tmp[count($tmp) - 1];
                        $imageName = $product->code . ((Storage::exists($path)) ? Carbon::now()->format('-YmdHis.') : '.') . $tmp[count($tmp) - 1];
                        $uploadedImages[] = $image->storeAs('public/', $imageName);

                        $image = Image::create([
                            'name' => $imageName,
                            'author_id' => Auth::user()->id
                        ]);
                        LogController::create('create', 'Image ' . $image->name, $image->id);
                        $product->update(['gallery' => '|' . $imageName]);
                    }
                    $product->syncCatalogues($request->catalogues);
                }
                DB::commit();
                $response = array(
                    'status' => 'success',
                    'msg' => 'Created ' . self::NAME . ' ' . $product->name
                );
            } catch (\Exception $e) {
                DB::rollBack();
                log_exception($e);
                Controller::resetAutoIncrement(['products', 'images']);
                return response()->json(['errors' => ['error' => ['An error occurred: ' . $e->getMessage()]]], 422);
            }
        } else {
            return response()->json(['errors' => ['role' => ['You do not have permission!']]], 422);
        }
        return response()->json($response, 200);
    }

    public function update(Request $request)
    {
        $rules = [
            'sku' => ['nullable', 'string', 'max:125'],
            'name' => ['required', 'string', 'max:125'],
            'status' => ['nullable', 'numeric'],
            'catalogues' => ['required', 'array'],
        ];

        $request->validate($rules, self::MESSAGES);

        if (!empty($this->user->can(User::CREATE_PRODUCT, User::UPDATE_PRODUCT))) {
            if ($request->has('id')) {
                DB::beginTransaction();
                try {
                    $product = Product::find($request->id);
                    if ($product) {
                        $product->update([
                            'sku' => $request->sku,
                            'name' => $request->name,
                            'slug' => Str::slug($request->name),
                            'excerpt' => $request->excerpt,
                            'description' => $request->description,
                            'specs' => $request->specs,
                            'keyword' => $request->keyword,
                            'gallery' => $request->gallery,
                            'allow_review' => $request->has('allow_review'),
                            'status' => $request->status,
                        ]);

                        if ($request->avatar) {
                            $image = $request->file('avatar');
                            $imageName = $image->getClientOriginalName();
                            $tmp = explode('.', $imageName);
                            $path = 'public/' . Str::slug($tmp[0]) . '.' . $tmp[count($tmp) - 1];
                            $imageName = $product->code . ((Storage::exists($path)) ? Carbon::now()->format('-YmdHis.') : '.') . $tmp[count($tmp) - 1];
                            $uploadedImages[] = $image->storeAs('public/', $imageName);

                            $image = Image::create([
                                'name' => $imageName,
                                'author_id' => Auth::user()->id
                            ]);
                            LogController::create('create', 'Image ' . $image->name, $image->id);
                            $product->update(['gallery' => '|' . $imageName]);
                        }

                        $product->syncCatalogues($request->catalogues);

                        LogController::create('update', self::NAME, $product->id);
                        DB::commit();
                        $response = array(
                            'status' => 'success',
                            'msg' => 'Updated ' . self::NAME . ' ' . $product->name
                        );
                    } else {
                        DB::rollBack();
                        $response = array(
                            'status' => 'error',
                            'msg' => 'An error occurred, please reload the page and try again!'
                        );
                    }
                } catch (\Exception $e) {
                    DB::rollBack();
                    log_exception($e);
                    Controller::resetAutoIncrement(['products', 'images']);
                    return response()->json(['errors' => ['error' => ['An error occurred: ' . $e->getMessage()]]], 422);
                }
            } else {
                $response = array(
                    'status' => 'error',
                    'msg' => 'An error occurred, please reload the page and try again!'
                );
            }
        } else {
            return response()->json(['errors' => ['role' => ['You do not have permission!']]], 422);
        }
        return response()->json($response, 200);
    }

    public function remove(Request $request)
    {
        $success = [];
        if ($this->user->can(User::DELETE_PRODUCT)) {
            try {
                foreach ($request->choices as $key => $id) {
                    $obj = Product::withTrashed()->find($id);
                    if ($obj) {
                        $obj->variables()->withTrashed()->get()->each(function ($variable) { // Xử lý từng biến thể, kể cả đã xóa mềm
                            /*----- Xử lý đơn vị tính liên quan -----*/
                            $variable->units()->withTrashed()->get()->each(function ($unit) { //Xử lý từng đơn vị tính, kể cả đã xóa mềm
                                $details = $unit->details()->withTrashed()->count();
                                $import_details = $unit->import_details()->withTrashed()->count();
                                $export_details = $unit->export_details()->withTrashed()->count();
                                if (!$details && !$import_details && !$export_details) { // Nếu ĐVT không có chi tiết đơn hàng, chi tiết nhập hàng hay chi tiết xuất hàng nào thì xóa cứng
                                    $unit->forceDelete();
                                } else { //Ngược lại xóa mềm
                                    $unit->delete();
                                }
                            });
                            $units = $variable->units()->withTrashed()->count();
                            $import_details = $variable->import_details()->withTrashed()->count();
                            if (!$units && !$import_details) { // Nếu biến thể không có ĐVT, k có chi tiết nhập hàng nào thì xóa cứng
                                DB::table('attribute_variable')->where('variable_id', $variable->id)->delete();
                                $variable->forceDelete();
                            } else {
                                $variable->delete();
                            }
                        });
                        if ($obj->variables()->withTrashed()->count()) {
                            $obj->delete();
                        } else {
                            DB::table('catalogue_product')->where('product_id', $obj->id)->delete();
                            $obj->forceDelete();
                        }
                        LogController::create("delete", self::NAME, $obj->id);
                        array_push($success, $obj->name);
                    }
                }
                $msg = '';
                if (count($success)) {
                    $msg .= 'Deleted ' . self::NAME . ' ' . implode(', ', $success) . '. ';
                }
                $response = array(
                    'status' => 'success',
                    'msg' => $msg
                );
                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                log_exception($e);
                Controller::resetAutoIncrement(['units', 'variables', 'products', 'medicines', 'dosages']);
                return response()->json(['errors' => ['error' => ['An error occurred: ' . $e->getMessage()]]], 422);
            }
        } else {
            return response()->json(['errors' => ['role' => ['You do not have permission!']]], 422);
        }
        return response()->json($response, 200);
    }

    public function refill(Request $request)
    {
        $request->validate([
            'refill_file' => 'required',
        ]);
        $data = Excel::toArray(new UnitsImport, $request->file('refill_file'));
        $invalidRow = [];
        foreach ($data[0] as $row) {
            $u = Unit::find($row['unit_id']);
            if (Hash::check($u->created_at, $row['unit_created_at'])) {
                Unit::where('id', $row['unit_id'])->update(['price' => $row['gia']]);
            } else {
                $invalidRow[] = $row['ten_san_pham'] . ' - ' . $row['unit_id'];
            }
        }
        $msg = 'File imported successfully';
        $status = '';
        if (count($invalidRow)) {
            $msg .= ', but there are ' . count($invalidRow) . ' items that could not be updated. ' . implode(', ', $invalidRow);
        } else {
            $status = 'success';
        }
        $response = array(
            'status' => $status,
            'msg' => $msg
        );
        return response()->json($response, 200);
    }

    public function remove_catalogues(Request $request)
    {
        if (!$request->choices || count($request->choices) <= 1) return response()->json(['errors' => ['catalogue' => ['You must select more than one category!']]], 422);
        $success = [];
        if ($this->user->can(User::UPDATE_PRODUCT)) {
            try {
                $product_ids = $request->choices;
                $all_categories = [];

                foreach ($product_ids as $id) {
                    $obj = Product::withTrashed()->find($id);
                    if ($obj) {
                        $categories = $obj->catalogues()->pluck('id')->toArray();
                        $all_categories[] = $categories;
                        $success[] = $obj->name;
                    }
                }

                $common_categories = array_intersect(...$all_categories);
                if (count($common_categories)) {
                    foreach ($product_ids as $id) {
                        $obj = Product::withTrashed()->find($id);
                        if ($obj) {
                            $obj->catalogues()->detach($common_categories);
                        }
                    }
                    $msg = 'Deleted common categories of ' . implode(', ', $success) . '.';
                    $response = [
                        'status' => 'success',
                        'msg' => $msg,
                    ];
                } else {
                    // Không có danh mục chung
                    $response = [
                        'status' => 'error',
                        'msg' => 'No common categories found between products.',
                    ];
                }
                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                log_exception($e);
                Controller::resetAutoIncrement(['units', 'variables', 'products', 'medicines', 'dosages']);
                return response()->json(['errors' => ['error' => ['An error occurred: ' . $e->getMessage()]]], 422);
            }
        } else {
            return response()->json(['errors' => ['role' => ['You do not have permission!']]], 422);
        }

        return response()->json($response, 200);
    }

    public function add_catalogues(Request $request)
    {
        if ($this->user->can(User::UPDATE_PRODUCT)) {
            try {
                DB::beginTransaction();
                $catalogue = Catalogue::find($request->catalogue_id);
                if (!$catalogue) {
                    return response()->json(['errors' => ['catalogue' => ['This category does not exist!']]], 422);
                }

                // Thêm danh mục vào tất cả các sản phẩm trong choices mà không xóa danh mục cũ
                Product::whereIn('id', $request->choices)->each(function ($product) use ($catalogue) {
                    $product->catalogues()->syncWithoutDetaching([$catalogue->id]);
                });

                DB::commit();
                return response()->json([
                    'status' => 'success',
                    'msg' => 'Added ' . $catalogue->name . ' to ' . count($request->choices) . ' products.',
                ], 200);
            } catch (\Exception $e) {
                DB::rollBack();
                log_exception($e);
                return response()->json(['errors' => ['error' => ['An error occurred: ' . $e->getMessage()]]], 422);
            }
        } else {
            return response()->json(['errors' => ['role' => ['You do not have permission!']]], 422);
        }
    }
}
