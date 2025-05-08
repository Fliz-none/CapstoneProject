<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Import;
use App\Models\ImportDetail;
use App\Models\Stock;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\DataTables;

class ImportController extends Controller
{
    const MESSAGES = [
        'note.required' => 'Nội dung nhập hàng: ' . Controller::NOT_EMPTY,
        'note.min' => 'Nội dung nhập hàng: ' . Controller::MIN,
        'note.max' => 'Nội dung nhập hàng: ' . Controller::MAX,
        'warehouse_id.required' => 'Kho nhập: ' . Controller::NOT_EMPTY,
        'warehouse_id.numeric' => 'Kho nhập: ' . Controller::DATA_INVALID,
        'supplier_id.required' => 'Nhà cung cấp: ' . Controller::NOT_EMPTY,
        'supplier_id.numeric' => 'Nhà cung cấp: ' . Controller::DATA_INVALID,
        'status.required' => 'Nội dung nhập hàng: ' . Controller::NOT_EMPTY,
        'status.string' => 'Nội dung nhập hàng: ' . Controller::DATA_INVALID,
        'status.max' => 'Nội dung nhập hàng: ' . Controller::MAX,

        'variable_ids.required' => 'Sản phẩm: ' . Controller::NOT_EMPTY,
        'variable_ids.array' => 'Sản phẩm: ' . Controller::DATA_INVALID,
        'variable_ids.*.required' => 'Sản phẩm: ' . Controller::NOT_EMPTY,
        'variable_ids.*.numeric' => 'Sản phẩm: ' . Controller::DATA_INVALID,
        'unit_ids.required' => '' . Controller::NOT_EMPTY,
        'unit_ids.array' => '' . Controller::DATA_INVALID,
        'unit_ids.*.required' => '' . Controller::NOT_EMPTY,
        'unit_ids.*.numeric' => '' . Controller::DATA_INVALID,
        'current_unit_ids.required' => 'Đơn vị tính: ' . Controller::NOT_EMPTY,
        'current_unit_ids.array' => 'Đơn vị tính: ' . Controller::DATA_INVALID,
        'current_unit_ids.*.required' => 'Đơn vị tính: ' . Controller::NOT_EMPTY,
        'current_unit_ids.*.numeric' => 'Đơn vị tính: ' . Controller::DATA_INVALID,
        'quantities.required' => 'Số lượng nhập: ' . Controller::NOT_EMPTY,
        'quantities.array' => 'Số lượng nhập: ' . Controller::DATA_INVALID,
        'quantities.*.required' => 'Số lượng nhập: ' . Controller::NOT_EMPTY,
        'quantities.*.numeric' => 'Số lượng nhập: ' . Controller::DATA_INVALID,
        'prices.required' => 'Giá nhập: ' . Controller::NOT_EMPTY,
        'prices.array' => 'Giá nhập: ' . Controller::DATA_INVALID,
        'prices.*.required' => 'Giá nhập: ' . Controller::NOT_EMPTY,
        'prices.*.numeric' => 'Giá nhập: ' . Controller::DATA_INVALID,
        'lots.required' => 'Lô hàng: ' . Controller::NOT_EMPTY,
        'lots.array' => 'Lô hàng: ' . Controller::DATA_INVALID,
        'lots.*.string' => 'Lô hàng: ' . Controller::DATA_INVALID,
        'lots.*.max' => 'Lô hàng: ' . Controller::MAX,
        'expireds.required' => 'Hạn sử dụng: ' . Controller::NOT_EMPTY,
        'expireds.array' => 'Hạn sử dụng: ' . Controller::DATA_INVALID,
        'expireds.*.date_format' => 'Hạn sử dụng: ',
        'import_detail_ids.required' => Controller::DATA_INVALID,
        'import_detail_ids.array' => Controller::DATA_INVALID,
        'import_detail_ids.*.numeric' => Controller::DATA_INVALID,
        'stock_ids.required' => Controller::DATA_INVALID,
        'stock_ids.array' => Controller::DATA_INVALID,
        'stock_ids.*.numeric' => Controller::DATA_INVALID,
    ];

    /**
     * Create a new controller instance.
     *
     * @return void
     */

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
            $import = Import::withTrashed()->with(['import_details.stock.export_details', '_supplier', 'import_details._unit', '_export', '_warehouse', 'import_details._variable._product', 'import_details._variable.units'])
                ->find($request->key);
            if ($import) {
                switch ($request->action) {
                    case 'print':
                        return view('admin.templates.prints.import_c80', ['import' => $import]);
                        break;
                    default:
                        $import->import_details->each(function ($import_detail) {
                            $import_detail->import_prices = ImportDetail::where('unit_id', $import_detail->unit_id)->pluck('price')->filter()->unique()->all();
                        });
                        $result = $import;
                        break;
                }
            } else {
                abort(404);
            }
            return response()->json($result, 200);
        } else {
            if ($request->ajax()) {
                $objs = Import::with(['import_details.stock.export_details', '_user.local', '_supplier', '_warehouse', '_export.export_details'])->when($request->has('warehouse_id'), function ($query) use ($request) {
                    $query->where('warehouse_id', $request->warehouse_id);
                }, function ($query) {
                    $query->whereIn('warehouse_id', $this->user->warehouses->pluck('id'));
                });
                $can_read_import = $this->user->can(User::READ_IMPORT);
                $can_read_user = $this->user->can(User::READ_USER);
                $can_read_warehouse = $this->user->can(User::READ_WAREHOUSES);
                $can_read_supplier = $this->user->can(User::READ_SUPPLIER);
                $can_read_export = $this->user->can(User::READ_EXPORT);
                $can_delete_import = $this->user->can(User::DELETE_IMPORT);
                return DataTables::of($objs)
                    ->addColumn('checkboxes', function ($obj) {
                        return '<input class="form-check-input choice" type="checkbox" name="choices[]" value="' . $obj->id . '">';
                    })
                    ->editColumn('code', function ($obj) use ($can_read_import) {
                        if ($can_read_import) {
                            $code = '<a class="btn btn-link text-decoration-none fw-bold text-start btn-update-import" data-id="' . $obj->id . '">' . $obj->code . '</a>';
                        } else {
                            $code = '<span class="fw-bold">' . $obj->code . '</span>';
                        }
                        return $code . '<br/><small>' . $obj->created_at->format('d/m/Y H:i') . '</small>';
                    })
                    ->filterColumn('code', function ($query, $keyword) {
                        $array = explode('/', $keyword);
                        $query->when(count($array) > 1, function ($query) use ($keyword, $array) {
                            $date = parseDate($keyword);
                            $query->when($date['year'], function ($query) use ($date) {
                                $query->whereYear('imports.created_at', $date['year']);
                            })
                                ->when($date['month'], function ($query) use ($date) {
                                    $query->whereMonth('imports.created_at', $date['month']);
                                })
                                ->when($date['day'], function ($query) use ($date) {
                                    $query->whereDay('imports.created_at', $date['day']);
                                });
                        }, function ($query) use ($keyword) {
                            $numericKeyword = ltrim(preg_replace('/[^0-9]/', '', $keyword), '0');
                            if (!empty($numericKeyword)) {
                                $query->where('imports.id', 'like', "%" . $numericKeyword . "%");
                            }
                        });
                    })
                    ->orderColumn('code', function ($query, $order) {
                        $query->orderBy('id', $order);
                    })
                    ->editColumn('note', function ($obj) use ($can_read_import) {
                        if ($can_read_import) {
                            return '<a class="btn btn-link text-decoration-none text-start btn-update-import" data-id="' . $obj->id . '">' . $obj->note . '</a>';
                        } else {
                            return $obj->note;
                        }
                    })
                    ->filterColumn('note', function ($query, $keyword) {
                        $query->where('imports.note', 'like', "%" . $keyword . "%");
                    })
                    ->addColumn('user', function ($obj) use ($can_read_user) {
                        if ($obj->user_id) {
                            if ($can_read_user) {
                                return '<a class="btn btn-link text-decoration-none text-start btn-update-user" data-id="' . $obj->user_id . '">' . $obj->_user->fullName . '</a>';
                            } else {
                                return $obj->_user->fullName;
                            }
                        } else {
                            return 'Không có';
                        }
                    })
                    ->filterColumn('user', function ($query, $keyword) {
                        $query->whereHas('_user', function ($query) use ($keyword) {
                            $query->where('name', 'like', "%" . $keyword . "%");
                        });
                    })
                    ->orderColumn('user', function ($query, $order) {
                        $query->join('users', 'imports.user_id', '=', 'users.id')
                            ->orderBy('users.name', $order);
                    })
                    ->addColumn('warehouse', function ($obj) use ($can_read_warehouse) {
                        if ($can_read_warehouse) {
                            return '<a class="btn btn-link text-decoration-none text-start btn-update-warehouse" data-id="' . $obj->warehouse_id . '">' . $obj->_warehouse->fullName . '</a>';
                        } else {
                            return $obj->_warehouse->fullName;
                        }
                    })
                    ->filterColumn('warehouse', function ($query, $keyword) {
                        $query->whereHas('_warehouse', function ($query) use ($keyword) {
                            $query->where('name', 'like', "%" . $keyword . "%");
                        });
                    })
                    ->orderColumn('warehouse', function ($query, $order) {
                        $query->join('warehouses', 'imports.warehouse_id', '=', 'warehouses.id')
                            ->orderBy('warehouses.name', $order);
                    })
                    ->addColumn('supplier', function ($obj) use ($can_read_supplier, $can_read_export) {
                        if ($obj->supplier_id) {
                            if ($can_read_supplier) {
                                return '<a class="btn btn-link text-decoration-none text-start btn-update-supplier" data-id="' . $obj->supplier_id . '">' . $obj->_supplier->fullName . '</a>';
                            } else {
                                return $obj->_supplier->fullName;
                            }
                        } else if ($obj->export_id) {
                            if ($can_read_export) {
                                return '<a class="btn btn-link text-decoration-none text-start btn-update-export" data-id="' . $obj->export_id . '">' . $obj->_export->code . '</a>';
                            } else {
                                return $obj->_export->code;
                            }
                        } else {
                            return 'Không có';
                        }
                    })
                    ->filterColumn('supplier', function ($query, $keyword) {
                        $query->whereHas('_supplier', function ($query) use ($keyword) {
                            $query->where('name', 'like', "%" . $keyword . "%");
                        })->orWhere('export_id', 'like', "%" . $keyword . "%");
                    })
                    ->addColumn('status', function ($obj) {
                        if ($obj->status == 1) {
                            return '<p class="badge bg-light-' . ($obj->checkLoss() ? 'success' : 'primary') . '">' . $obj->statusStr . '</p>';
                        } else {
                            return '<p class="badge bg-light-danger">' . $obj->statusStr . '</p>';
                        }
                    })
                    ->filterColumn('status', function ($query, $keyword) {
                        $query->when(str_contains('dangban', $keyword), function ($query) {
                            $query->whereStatus(1)->whereHas('import_details.stock.export_details');
                        });
                        $query->when(str_contains('danhap', $keyword), function ($query) {
                            $query->whereStatus(1)->whereDoesntHave('import_details.stock.export_details');
                        });
                        $query->when(str_contains('chohang', $keyword), function ($query) {
                            $query->whereStatus(0);
                        });
                    })
                    ->orderColumn('status', function ($query, $order) {
                        $query->orderBy('status', $order);
                    })
                    ->addColumn('action', function ($obj) use ($can_delete_import) {
                        if ($can_delete_import) {
                            return '
                        <form method="post" action="' . route('admin.import.remove') . '" class="save-form">
                            <input type="hidden" name="_token" value="' . csrf_token() . '"/>
                            <input type="hidden" name="choices[]" value="' . $obj->id . '"/>
                            <button type="submit" class="btn btn-link text-decoration-none btn-remove cursor-pointer">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>';
                        }
                    })
                    ->rawColumns(['checkboxes', 'code', 'note', 'user', 'warehouse', 'supplier', 'status', 'action'])
                    ->setTotalRecords($objs->count())
                    ->make(true);
            } else {
                if ($request->has('check') && $request->has('warehouse_id') && $request->has('variable_id')) {
                    $import_details = ImportDetail::whereHas('import', function ($query) use ($request) {
                        $query->where('warehouse_id', $request->warehouse_id);
                    })->where('variable_id', $request->variable_id)->get();
                    return view('admin.templates.previews.import_detail', compact('import_details'));
                }
                $pageName = 'Quản lý nhập hàng';
                return view('admin.imports', compact('pageName'));
            }
        }
    }

    public function create(Request $request)
    {
        $rules = [
            'note' => ['required', 'min: 2', 'max:125'],
            'warehouse_id' => ['required', 'numeric'],
            'supplier_id' => ['required', 'numeric'],
            'status' => ['required', 'numeric'],

            'variable_ids' => ['required', 'array'],
            'variable_ids.*' => ['required', 'numeric'],
            'unit_ids' => ['required', 'array'],
            'unit_ids.*' => ['required', 'numeric'],
            'current_unit_ids' => ['required', 'array'],
            'current_unit_ids.*' => ['required', 'numeric'],
            'quantities' => [
                'required',
                'array',
                function ($attribute, $value, $fail) {
                    if (in_array("0", $value, true)) {
                        $fail('Số lượng nhập kho phải lớn hơn 0');
                    }
                }
            ],
            'quantities.*' => ['required', 'numeric'],
            'prices' => ['required', 'array'],
            'prices.*' => ['required', 'numeric'],
            'lots' => ['required', 'array'],
            'lots.*' => ['nullable', 'string', 'max: 125'],
            'expireds' => ['required', 'array'],
            'expireds.*' => ['nullable', 'date_format:Y-m-d'],
            'import_detail_ids' => ['required', 'array'],
            'import_detail_ids.*' => ['nullable', 'numeric'],
            'stock_ids' => ['required', 'array'],
            'stock_ids.*' => ['nullable', 'numeric'],
        ];
        $request->validate($rules, self::MESSAGES);
        if (!empty($this->user->can(User::CREATE_IMPORT))) {
            DB::beginTransaction();
            try {
                $import = Import::create([
                    'user_id' => $this->user->id,
                    'warehouse_id' => $request->warehouse_id,
                    'supplier_id' => $request->supplier_id,
                    'note' => $request->note,
                    'created_at' => $request->created_at,
                    'status' => $request->status,
                ]);
                if ($import) {
                    $units = Unit::whereIn('id', $request->unit_ids)->get();
                    foreach ($request->variable_ids as $i => $id) {
                        $unit = $units->where('id', $request->unit_ids[$i])->first();
                        $import_detail = ImportDetail::create([
                            'import_id' => $import->id,
                            'variable_id' => $request->variable_ids[$i],
                            'unit_id' => $unit->id,
                            'quantity' => $request->quantities[$i],
                            'price' => $request->prices[$i]
                        ]);
                        if ($import_detail) {
                            $stock = Stock::create([
                                'import_detail_id' => $import_detail->id,
                                'quantity' => $request->quantities[$i] * $unit->rate,
                                'lot' => $request->lots[$i],
                                'expired' => $request->expireds[$i],
                            ]);
                        }
                    }

                    DB::commit();
                    LogController::create('tạo', 'nhập hàng', $import->id);
                    $response = [
                        'status' => 'success',
                        'msg' => 'Đã tạo nhập hàng ' . $import->note,
                    ];
                    return response()->json($response, 200);
                }
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error(
                    'Có lỗi xảy ra: ' . $e->getMessage() . ';' . PHP_EOL .
                    'URL truy vấn: "' . request()->fullUrl() . '";' . PHP_EOL .
                    'Dữ liệu nhận được: ' . json_encode(request()->all()) . ';' . PHP_EOL .
                    'User ID: ' . (Auth::check() ? Auth::id() : 'Khách') . ';' . PHP_EOL .
                    'Chi tiết lỗi: ' . $e->getTraceAsString()
                );
                Controller::resetAutoIncrement(['imports', 'import_details', 'stocks']);
                return response()->json(['errors' => ['error' => ['Đã xảy ra lỗi: ' . $e->getMessage()]]], 422);
            }
        } else {
            return response()->json(['errors' => ['role' => ['Thao tác chưa được cấp quyền!']]], 422);
        }
    }

    public function update(Request $request)
    {
        $rules = [
            'note' => ['required', 'min: 2', 'max:125'],
            'warehouse_id' => ['required', 'numeric'],
            'supplier_id' => ['nullable', 'numeric'],
            'status' => ['required', 'numeric'],

            'variable_ids' => ['required', 'array'],
            'variable_ids.*' => ['required', 'numeric'],
            'unit_ids' => ['required', 'array'],
            'unit_ids.*' => ['required', 'numeric'],
            'current_unit_ids' => ['required', 'array'],
            'current_unit_ids.*' => ['required', 'numeric'],
            'quantities' => [
                'required',
                'array',
                function ($attribute, $value, $fail) {
                    if (in_array("0", $value, true)) {
                        $fail('Số lượng nhập kho phải lớn hơn 0');
                    }
                }
            ],
            'quantities.*' => ['required', 'numeric'],
            'prices' => ['required', 'array'],
            'prices.*' => ['required', 'numeric'],
            'lots' => ['required', 'array'],
            'lots.*' => ['nullable', 'string', 'max: 125'],
            'expireds' => ['required', 'array'],
            'expireds.*' => ['nullable', 'date_format:Y-m-d'],
            'import_detail_ids' => ['required', 'array'],
            'import_detail_ids.*' => ['nullable', 'numeric'],
            'stock_ids' => ['required', 'array'],
            'stock_ids.*' => ['nullable', 'numeric'],
        ];
        $request->validate($rules, self::MESSAGES);
        if ($this->user->can(User::UPDATE_IMPORT)) {
            if ($request->has('id')) {
                DB::beginTransaction();
                try {
                    $old = Import::find($request->id);
                    if ($old) {
                        if ($old->export_id || $old->checkLoss()) { //Nếu là phiếu nhập kho nội bộ
                            if ($old->export_id) {
                                $old->user_id = $this->user->id;
                                $old->status = $request->status;
                                $old->save();
                            }
                            foreach (array_filter($request->import_detail_ids) as $i => $id) {
                                $import_detail = ImportDetail::find($id);
                                $import_detail->price = $request->prices[$i];
                                $import_detail->save();
                                if ($import_detail) {
                                    $stock = $import_detail->stock;
                                    $stock->lot = $request->lots[$i];
                                    $stock->expired = $request->expireds[$i];
                                    $stock->save();
                                    if ($stock) {
                                        $this->updateStockRecursive($stock);
                                    }
                                }
                            }
                            DB::commit();
                            $response = [
                                'status' => 'success',
                                'msg' => 'Đã điều chỉnh phiếu nhập hàng ' . $old->code . '. Chỉ điều chỉnh được người nhập và trạng thái',
                            ];
                            return response()->json($response, 200);
                        }
                        if ($old) {
                            $old->update([
                                'user_id' => $this->user->id,
                                'warehouse_id' => $old->checkLoss() ? $old->warehouse_id : $request->warehouse_id,
                                'supplier_id' => $request->supplier_id,
                                'note' => $request->note,
                                'status' => $old->checkLoss() ? $old->status : $request->status,
                            ]);

                            $units = Unit::whereIn('id', $request->unit_ids)->get();
                            if ($units) {
                                foreach ($request->variable_ids as $i => $id) {
                                    $unit = $units->where('id', $request->unit_ids[$i])->first();
                                    $import_detail = $request->import_detail_ids[$i] ? ImportDetail::find($request->import_detail_ids[$i]) : new ImportDetail();
                                    $import_detail->import_id = $old->id;
                                    $import_detail->variable_id = $request->variable_ids[$i];
                                    $import_detail->unit_id = ($old->checkLoss() && $import_detail->id) ? $import_detail->unit_id : $unit->id;
                                    $import_detail->quantity = ($old->checkLoss() && $import_detail->id) ? $import_detail->quantity : $request->quantities[$i];
                                    $import_detail->price = $request->prices[$i];
                                    $import_detail->save();
                                    if ($import_detail) {
                                        $stock = $request->stock_ids[$i] ? Stock::find($request->stock_ids[$i]) : new Stock();
                                        $stock->import_detail_id = $import_detail->id;
                                        $stock->quantity = ($old->checkLoss() && $stock->id) ? $stock->quantity : $request->quantities[$i] * $unit->rate;
                                        $stock->lot = $request->lots[$i];
                                        $stock->expired = $request->expireds[$i];
                                        $stock->save();
                                        if ($stock) {
                                            $this->updateStockRecursive($stock);
                                        }
                                    }
                                }
                            } else {
                                DB::rollBack();
                                Controller::resetAutoIncrement(['imports', 'import_details', 'stocks']);
                                $response = array(
                                    'status' => 'error',
                                    'msg' => 'Đã có lỗi xảy ra, vui lòng tải lại trang và thử lại!'
                                );
                            }

                            DB::commit();
                            LogController::create('sửa', 'nhập hàng', $old->id);
                            $response = [
                                'status' => 'success',
                                'msg' => 'Đã sửa nhập hàng ' . $old->code,
                            ];
                            return response()->json($response, 200);
                        } else {
                            DB::rollBack();
                            Controller::resetAutoIncrement(['imports', 'import_details', 'stocks']);
                            $response = array(
                                'status' => 'error',
                                'msg' => 'Đã có lỗi xảy ra, vui lòng tải lại trang và thử lại!'
                            );
                        }
                    } else {
                        DB::rollBack();
                        $response = array(
                            'status' => 'error',
                            'msg' => 'Đã có lỗi xảy ra, vui lòng tải lại trang và thử lại!'
                        );
                    }
                } catch (\Exception $e) {
                    DB::rollBack();
                    Log::error(
                        'Có lỗi xảy ra: ' . $e->getMessage() . ';' . PHP_EOL .
                        'URL truy vấn: "' . request()->fullUrl() . '";' . PHP_EOL .
                        'Dữ liệu nhận được: ' . json_encode(request()->all()) . ';' . PHP_EOL .
                        'User ID: ' . (Auth::check() ? Auth::id() : 'Khách') . ';' . PHP_EOL .
                        'Chi tiết lỗi: ' . $e->getTraceAsString()
                    );
                    Controller::resetAutoIncrement(['imports', 'import_details', 'stocks']);
                    return response()->json(['errors' => ['error' => ['Đã xảy ra lỗi: ' . $e->getMessage()]]], 422);
                }
            } else {
                return response()->json(['errors' => ['mission_id' => ['Đã có lỗi xảy ra. Hãy kiểm tra và thử lại']]], 422);
            }
        } else {
            return response()->json(['errors' => ['role_import' => ['Thao tác chưa được cấp quyền!']]], 422);
        }
    }

    public function remove(Request $request)
    {
        $names = [];
        foreach ($request->choices as $key => $id) {
            $obj = Import::find($id);
            if (!$obj) {
                return response()->json(['errors' => ['message' => ['Không thể xóa phiếu nhập hàng số ' . $id]]], 422);
            }
            if ($obj->checkLoss()) {
                return response()->json(['errors' => ['message' => ['Hàng trong phiếu đã xuất bán thì không thể xóa phiếu']]], 422);
            }
            if ($obj->export_id) {
                return response()->json(['errors' => ['message' => ['Không thể xóa phiếu nhập kho nội bộ. Hãy thử xóa phiếu xuất kho']]], 422);
            }
            DB::beginTransaction();
            try {
                $obj->import_details->map(function ($import_detail) {
                    $import_detail->stock->update(['quantity' => 0]);
                    $count_details = $import_detail->stock->order_details()->withTrashed()->count();
                    $count_export_details = $import_detail->stock->export_details()->withTrashed()->count();
                    // DB::table('prescription_detail_stock')->where('stock_id', $import_detail->stock->id)->delete();
                    $import_detail->update(['quantity' => 0]);
                    if (!$count_details && !$count_export_details) {
                        $import_detail->stock->forceDelete();
                        $import_detail->forceDelete();
                    } else {
                        $import_detail->stock->delete();
                        $import_detail->delete();
                    }
                });
                $obj->unsetRelation('import_details');
                $count_import_details = $obj->import_details()->withTrashed()->count();
                if (!$count_import_details) {
                    $obj->forceDelete();
                } else {
                    $obj->delete();
                }
                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error(
                    'Có lỗi xảy ra: ' . $e->getMessage() . ';' . PHP_EOL .
                    'URL truy vấn: "' . request()->fullUrl() . '";' . PHP_EOL .
                    'Dữ liệu nhận được: ' . json_encode(request()->all()) . ';' . PHP_EOL .
                    'User ID: ' . (Auth::check() ? Auth::id() : 'Khách') . ';' . PHP_EOL .
                    'Chi tiết lỗi: ' . $e->getTraceAsString()
                );
                Controller::resetAutoIncrement(['imports', 'import_details', 'stocks']);
                return response()->json(['errors' => ['error' => ['Đã xảy ra lỗi: ' . $e->getMessage()]]], 422);
            }
        }
        $response = array(
            'status' => 'success',
            'msg' => 'Đã xóa nhập hàng ' . implode(', ', $names)
        );
        return response()->json($response, 200);
    }

    static function updateStockRecursive($stock)
    {
        if ($stock->export_details->count()) {
            $stock->export_details->map(function ($export_detail) use ($stock) {
                if ($export_detail->to_warehouse_id) {

                    /**
                     * The authenticated user.
                     *
                     * @var \App\Models\User|null
                     */
                    $user = Auth::user();
                    $child = Stock::updateOrCreate([
                        'id' => $export_detail->import_detail->stock->id
                    ], [
                        'lot' => $stock->lot,
                        'expired' => $stock->expired,
                    ]);
                    self::updateStockRecursive($child);
                }
            });
        }
    }
}
