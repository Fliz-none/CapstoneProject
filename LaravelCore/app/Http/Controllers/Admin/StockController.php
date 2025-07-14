<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Catalogue;
use App\Models\Export;
use App\Models\ExportDetail;
use App\Models\Import;
use App\Models\ImportDetail;
use App\Models\Product;
use App\Models\Stock;
use App\Models\User;
use App\Models\Variable;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class StockController extends Controller
{
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
            $objs = Stock::where('quantity', '>', 0);
            switch ($request->key) {
                case 'search':
                    $result = $objs->with('import_detail._variable.units', 'import_detail._variable._product.catalogues')
                        ->whereHas('import_detail', function ($query) use ($request) {
                            $query->whereHas('import', function ($query) use ($request) {
                                $query->where(function ($query) use ($request) {
                                    $query->when($request->has('warehouse_id'), function ($query) use ($request) {
                                        $query->where('warehouse_id', $request->warehouse_id);
                                    }, function ($query) {
                                        $query->when($this->user->main_branch, function ($query) {
                                            $query->whereIn('warehouse_id', $this->user->branch->warehouses->pluck('id'));
                                        }, function ($query) {
                                            $query->whereNull('warehouse_id');
                                        });
                                    });
                                })
                                    ->where('status', 1)
                                    ->whereHas('warehouse', function ($query) use ($request) {
                                        $query->when($request->has('action') && $request->action == 'export', function ($query) {
                                            $query->where('status', '>=', 1);
                                        }, function ($query) {
                                            $query->where('status', 2);
                                        });
                                    });
                            })->whereHas('_variable', function ($query) use ($request) {
                                $query->where('status', 1)->where(function ($query) use ($request) {
                                    $query->where('name', 'LIKE', '%' . $request->q . '%')
                                        ->orWhereHas('units', function ($query) use ($request) {
                                            $query->where('barcode', 'LIKE', '%' . $request->q . '%')
                                                ->orWhere('term', 'LIKE', '%' . $request->q . '%');
                                        })
                                        ->orWhereHas('_product', function ($query) use ($request) {
                                            $query->where('name', 'LIKE', '%' . $request->q . '%')
                                                ->orWhere('keyword', 'LIKE', '%' . $request->q . '%')
                                                ->orWhere('slug', 'LIKE', '%' . $request->q . '%')
                                                ->orWhere('sku', 'LIKE', '%' . $request->q . '%');
                                        });
                                })->whereHas('_product', function ($query) {
                                    $query->where('status', '>', 0)->whereHas('catalogues', function ($query) {
                                        $query->where('status', 1);
                                    });
                                });
                            });
                        })
                        ->orderByDesc('id')
                        ->distinct()
                        ->take(20)
                        ->get()
                        ->map(function ($obj) {
                            $unit = $obj->import_detail->_variable->units->where('rate', 1)->first();
                            $stockQuantity = $obj->import_detail->_variable->convertUnit($obj->quantity);
                            return '<li>
                                        <a class="dropdown-item cursor-pointer btn-select-stock px-0 py-0"
                                        data-stock-id="' . $obj->id . '"
                                        data-variable-id="' . $obj->variable_id . '"
                                        data-product-avatarUrl="' . $obj->import_detail->_variable->_product->avatarUrl . '"
                                        data-product-name="' . e($obj->productName()) . '"
                                        data-product-sku="' . $obj->import_detail->_variable->_product->sku . '"
                                        data-price="' . optional($unit)->price . '"
                                        data-expired="' . $obj->expired . '"
                                        data-unit="' . e(optional($unit)->toJson()) . '"
                                        data-units="' . e($obj->import_detail->_variable->units->toJson()) . '"
                                        data-stock-quantity="' . e('[' . $obj->quantity . ', "' . $stockQuantity . '"]') . '">
                                            <div class="row mx-2 mb-2 align-items-center">
                                                <div class="col-3 col-lg-2 p-0">
                                                    <div class="ratio-1x1">
                                                        <img class="img-fluid rounded-start" src="' . $obj->import_detail->_variable->_product->avatarUrl . '" alt="' . $obj->import_detail->_variable->_product->name . '">
                                                    </div>
                                                </div>
                                                <div class="col-9 col-lg-10 text-wrap">
                                                    <h6 class="card-title mb-0">&nbsp;&nbsp;' . $obj->productName() . ' - ' . optional($unit)->term . '</h6>
                                                    <p class="badge bg-light-secondary mb-0">' . $obj->import_detail->_variable->_product->sku . '</p>
                                                    <div class="row">
                                                        <div class="col-auto">
                                                            <p class="card-text mb-0">&nbsp;&nbsp;Inventory stock: ' . $stockQuantity . '</p>
                                                        </div>
                                                        ' . ($obj->expired ? '<div class="col-auto">
                                                            <p class="card-text mb-0">&nbsp;&nbsp;HSD: ' . Carbon::parse($obj->expired)->format('d/m/Y') . '</p>
                                                        </div>' : '') . '
                                                        <div class="col-auto ms-auto">
                                                            <h5 class="card-text text-end text-primary mb-0">' . number_format(optional($unit)->price) . '</h5>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </li>';
                        });
                    break;
                case 'select2':
                    $result = $objs->with(['import_detail._variable._product', 'import_detail._variable.units', 'import_detail._import._warehouse'])
                        ->whereHas('import_detail', function ($query) use ($request) {
                            $query->whereHas('import', function ($query) use ($request) {
                                $query->where(function ($query) use ($request) {
                                    $query->when($request->has('warehouse_id'), function ($query) use ($request) {
                                        $query->where('warehouse_id', $request->warehouse_id);
                                    });
                                    $query->when(!$request->has('warehouse_id'), function ($query) {
                                        $query->whereIn('warehouse_id', $this->user->branch->warehouses->pluck('id'));
                                    });
                                })->whereHas('warehouse', function ($query) {
                                    $query->where('status', 2);
                                });
                            })
                                ->whereHas('_variable', function ($query) use ($request) {
                                    $query->where('name', 'LIKE', '%' . $request->q . '%')
                                        ->orWhereHas('units', function ($query) use ($request) {
                                            $query->where('barcode', 'LIKE', '%' . $request->q . '%')
                                                ->orWhere('term', 'LIKE', '%' . $request->q . '%');
                                        })
                                        ->orWhereHas('_product', function ($query) use ($request) {
                                            $query->where('name', 'LIKE', '%' . $request->q . '%')
                                                ->orWhere('keyword', 'LIKE', '%' . $request->q . '%')
                                                ->orWhere('slug', 'LIKE', '%' . $request->q . '%')
                                                ->orWhere('sku', 'LIKE', '%' . $request->q . '%');
                                        });
                                });
                        })
                        ->where(function ($query) {
                            $query->when(cache()->get('settings')['allow_expired_sale'] > 0, function ($query) {
                                $query->where('expired', '>', Carbon::now())->orWhereNull('expired');
                            });
                        })
                        ->orderByDesc('id')
                        ->distinct()
                        ->take(100)
                        ->get()
                        ->map(function ($obj) {
                            return [
                                'id' => $obj->id,
                                'text' => $obj->productName() . ' (QuantityQuantity: ' . $obj->import_detail->_variable->convertUnit($obj->quantity) . ($obj->expired ? ' - Expired: ' . Carbon::parse($obj->expired)->format('d/m/Y') : '') . ')'
                            ];
                        });
                    break;
                case 'scan':
                    $result = $objs->with(['import_detail._variable._product', 'import_detail._variable.units', 'import_detail._import._warehouse'])
                        ->whereHas('import_detail', function ($query) use ($request) {
                            $query->whereHas('import', function ($query) use ($request) {
                                $query->whereIn('warehouse_id', $this->user->branch->warehouses->pluck('id'))
                                    ->where('status', 1)
                                    ->whereHas('warehouse', function ($query) use ($request) {
                                        $query->when(
                                            $request->has('action') && $request->action == 'export',
                                            function ($query) {
                                                $query->where('status', '>', 1);
                                            },
                                            function ($query) {
                                                $query->where('status', 2);
                                            }
                                        );
                                    });
                            })
                                ->whereHas('variable', function ($query) use ($request) {
                                    $query->whereHas('units', function ($query) use ($request) {
                                        $query->whereBarcode($request->barcode);
                                    });
                                });
                        })
                        ->whereHas('import_detail._variable.units', function ($query) use ($request) {
                            $query->whereBarcode($request->barcode)
                                ->whereRaw('`quantity` >= `rate`'); // So sánh quantity với rate của unit
                        })
                        ->where(function ($query) {
                            $query->when(cache()->get('settings')['allow_expired_sale'] > 0, function ($query) {
                                $query->where('expired', '>', Carbon::now())->orWhereNull('expired');
                            });
                        })
                        ->orderBy('expired', 'ASC')->orderBy('created_at', 'ASC')->get()->each(function ($stock) {
                            $stock->convertQuantity = $stock->import_detail->_variable->convertUnit($stock->quantity);
                        });
                    break;
                case 'print':
                    $range = explode(' - ', $request->range);
                    $range[0] = Carbon::createFromFormat('d/m/Y', $range[0])->format('Y-m-d') . ' 00:00:00';
                    $range[1] = Carbon::createFromFormat('d/m/Y', $range[1])->format('Y-m-d') . ' 23:59:59';
                    $products = json_decode($request->catalogue_id) ? Catalogue::find($request->catalogue_id)->all_products() : collect();
                    if (!$products->count()) {
                        Product::withTrashed()->with('variables')->chunk(300, function ($chunk) use (&$products) {
                            $products = $products->merge($chunk);
                        });
                    }
                    $result = $products->map(function ($product) use ($request, $range) {
                        return $product->variables->map(function ($variable) use ($request, $range) {
                            [$sum_import_before, $sum_export_before, $sum_import, $sum_export] = $this->calculate_stock($variable, $range, $request->warehouse_id);

                            $sum_stock_after = $sum_import_before - $sum_export_before + $sum_import - $sum_export;

                            return ($sum_import_before != 0 || $sum_export_before != 0 || $sum_import != 0 || $sum_export != 0) ? '<tr><td>' . $variable->id . '</td>
                                        <td>' . $variable->full_name . '</td>
                                        <td>' . ($sum_import_before - $sum_export_before) . '</td>
                                        <td>' . $sum_import . '</td>
                                        <td>' . $sum_export . '</td>
                                        <td>' . $sum_stock_after . '</td>
                                        <td>
                                            <input type="text" class="form-control form-control-plaintext" placeholder="Enter quantity" name="real_stock[' . $variable->id . '][quantity]">
                                            <input type="hidden" name="real_stock[' . $variable->id . '][variable_id]" value="' . $variable->id . '">
                                        </td>
                                        <td>' . $variable->stock_limit . ' ' . optional($variable->units->firstWhere('rate', 1))->term . '</td>
                                        </tr>' : '';
                        })->implode('');
                    })->implode('');
                    break;
                default:
                    $obj = $objs->withTrashed()->with(['import_detail._import._warehouse', 'import_detail._variable._product', 'import_detail._variable.units'])->find($request->key);
                    if ($obj) {
                        $result = $obj;
                    } else {
                        abort(404);
                    }
                    break;
            }
            return response()->json($result, 200);
        } else {
            if ($request->ajax()) {
                $objs = Stock::with(['import_detail._import._warehouse', 'import_detail._variable.units', 'import_detail._variable._product', 'import_detail._import.import_details.stock.export_details'])
                    // ->where('stocks.quantity', '!=', 0)
                    ->whereHas('import_detail._import', function ($query) {
                        $query->where('status', 1);
                    })
                    ->whereHas('import_detail', function ($query) use ($request) {
                        $query->whereHas('_import', function ($query) use ($request) {
                            $query->when($request->has('warehouse_id'), function ($query) use ($request) {
                                $query->where('warehouse_id', $request->warehouse_id);
                            }, function ($query) {
                                $query->whereIn('warehouse_id', $this->user->warehouses->pluck('id'));
                            });
                        })->when($request->has('variable_id'), function ($query) use ($request) {
                            $query->where('variable_id', $request->variable_id);
                        });
                    })
                    ->when($request->has('expired'), function ($query) use ($request) {
                        $query->where('expired', '<', Carbon::createFromFormat('Y-m-d', $request->expired));
                    });
                $can_update_import = $this->user->can(User::UPDATE_IMPORT);
                $can_read_product = $this->user->can(User::READ_PRODUCT);
                $can_read_import = $this->user->can(User::READ_IMPORT);
                $can_read_warehouses = $this->user->can(User::READ_WAREHOUSES);
                return DataTables::of($objs)
                    ->addColumn('code', function ($obj) use ($can_read_import) {
                        if ($can_read_import) {
                            $code = '<a class="btn btn-update-import fw-bold text-start text-primary" data-id="' . $obj->import_detail->import_id . '">' . $obj->code . '</a>';
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
                                $query->whereYear('stocks.created_at', $date['year']);
                            })
                                ->when($date['month'], function ($query) use ($date) {
                                    $query->whereMonth('stocks.created_at', $date['month']);
                                })
                                ->when($date['day'], function ($query) use ($date) {
                                    $query->whereDay('stocks.created_at', $date['day']);
                                });
                        }, function ($query) use ($keyword) {
                            $numericKeyword = ltrim(preg_replace('/[^0-9]/', '', $keyword), '0');
                            if (!empty($numericKeyword)) {
                                $query->where('stocks.id', 'like', "%" . $numericKeyword . "%");
                            }
                        });
                    })
                    ->orderColumn('code', function ($query, $order) {
                        $query->orderBy('id', $order);
                    })
                    ->addColumn('variable', function ($obj) use ($can_read_product) {
                        if ($can_read_product) {
                            $str = '<a class="btn btn-link text-decoration-none text-start btn-update-product" data-id="' . $obj->import_detail->_variable->product_id . '">';
                            $str .= $obj->productName();
                            $str .= '</a>';
                            return $str;
                        } else {
                            return $obj->productName();
                        }
                    })
                    ->filterColumn('variable', function ($query, $keyword) {
                        $query->whereHas('import_detail', function ($query) use ($keyword) {
                            $query->whereHas('_variable', function ($query) use ($keyword) {
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
                        });
                    })
                    ->orderColumn('variable', function ($query, $order) {
                        $query->select('stocks.*', 'variables.product_id', 'variables.name', 'products.name')
                            ->join('import_details', 'stocks.import_detail_id', '=', 'import_details.id')
                            ->join('variables', 'import_details.variable_id', '=', 'variables.id')
                            ->join('products', 'variables.product_id', '=', 'products.id')
                            ->orderBy('products.name', $order);
                    })
                    ->addColumn('avatar', function ($obj) {
                        return '<img src="' . $obj->import_detail->_variable->_product->avatarUrl . '" class="thumb cursor-pointer object-fit-cover" alt="Image ' . $obj->import_detail->_variable->_product->name . '" width="60px" height="60px">';
                    })
                    ->editColumn('quantity', function ($obj) {
                        return $obj->import_detail->_variable->convertUnit($obj->quantity);
                    })
                    ->filterColumn('quantity', function ($query, $keyword) {
                        $query->where('quantity', 'like', '%' . $keyword . '%');
                    })
                    ->addColumn('price', function ($obj) {
                        return number_format($obj->import_detail->price) . 'đ';
                    })
                    ->filterColumn('price', function ($query, $keyword) {
                        $query->whereHas('import_detail', function ($query) use ($keyword) {
                            $query->where('price', 'like', "%" . $keyword . "%");
                        });
                    })
                    ->orderColumn('price', function ($query, $order) {
                        $query->join('import_details', 'stocks.import_detail_id', '=', 'import_details.id')
                            ->orderBy('import_details.price', $order);
                    })
                    ->addColumn('import', function ($obj) use ($can_read_import, $can_read_warehouses) {
                        if ($can_read_import) {
                            $import_btn = '<a class="btn btn-link text-decoration-none text-start btn-update-import" data-id="' . $obj->import_detail->import_id . '">Import code ' . $obj->import_detail->import_id . '</a>';
                        } else {
                            $import_btn = 'Import code ' . $obj->import_detail->import_id;
                        }
                        if ($can_read_warehouses) {
                            $warehouse_btn = '<a class="btn btn-link text-decoration-none text-start btn-update-warehouse" data-id="' . $obj->import_detail->_import->warehouse_id . '">' . $obj->import_detail->_import->_warehouse->name . '</a>';
                        } else {
                            $warehouse_btn = $obj->import_detail->_import->_warehouse->name;
                        }
                        return $import_btn . '<br/>' . $warehouse_btn;
                    })
                    ->filterColumn('import', function ($query, $keyword) {
                        $query->whereHas('import_detail', function ($query) use ($keyword) {
                            $query->whereHas('import', function ($query) use ($keyword) {
                                $query->where('id', 'like', "%" . $keyword . "%")
                                    ->orWhereHas('warehouse', function ($query) use ($keyword) {
                                        $query->where('name', 'like', "%" . $keyword . "%");
                                    });
                            });
                        });
                    })
                    ->orderColumn('import', function ($query, $order) {
                        $query->join('import_details', 'stocks.import_detail_id', '=', 'import_details.id')
                            ->orderBy('import_details.import_id', $order);
                    })
                    ->editColumn('expired', function ($obj) {
                        $expired = $obj->expired ? Carbon::createFromFormat('Y-m-d', $obj->expired)->format('d/m/Y') : '';
                        return $expired;
                    })
                    ->filterColumn('expired', function ($query, $keyword) {
                        $array = explode('/', $keyword);
                        $query->when(count($array) > 1, function ($query) use ($keyword, $array) {
                            $date = parseDate($keyword);
                            $query->when($date['year'], function ($query) use ($date) {
                                $query->whereYear('stocks.expired', $date['year']);
                            })
                                ->when($date['month'], function ($query) use ($date) {
                                    $query->whereMonth('stocks.expired', $date['month']);
                                })
                                ->when($date['day'], function ($query) use ($date) {
                                    $query->whereDay('stocks.expired', $date['day']);
                                });
                        }, function ($query) use ($keyword) {
                            if (is_numeric($keyword)) {
                                $query->where('expired', '<=', Carbon::now()->addDays($keyword)->format('Y-m-d'));
                            }
                        });
                    })
                    ->orderColumn('expired', function ($query, $order) {
                        $query->orderBy('expired', $order);
                    })
                    ->editColumn('lot', function ($obj) {
                        $lot = $obj->lot ? $obj->lot : '';
                        return $lot;
                    })
                    ->filterColumn('lot', function ($query, $keyword) {
                        $query->where('lot', 'like', "%" . $keyword . "%");
                    })
                    ->orderColumn('lot', function ($query, $order) {
                        $query->orderBy('lot', $order);
                    })
                    ->addColumn('action', function ($obj) use ($can_update_import) {
                        if ($can_update_import) {
                            $remove_btn = '
                                <form method="post" action="' . route('admin.stock.remove') . '" class="save-form">
                                    <input type="hidden" name="choices[]" value="' . $obj->id . '"/>
                                    <button type="submit" class="btn btn-link text-decoration-none btn-remove cursor-pointer">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>';
                            return '<a class="btn btn-link text-decoration-none btn-view-stock-detail" data-id="' . $obj->id . '">
                                        <i class="bi bi-eye" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="View export history"></i>
                                    </a>';
                        }
                    })
                    ->rawColumns(['code', 'variable', 'avatar', 'import', 'expired', 'action'])
                    ->setTotalRecords($objs->count())
                    ->with([
                        'totalQuantity' => function () use ($objs, $request) {
                            return $request->search['value'] ? $objs->get()->sum('quantity') : 0; // Lấy tổng quantity sau khi đã áp dụng các bộ lọc
                        }
                    ])
                    ->make(true);
            } else {
                if ($request->has('check') && $request->has('warehouse_id')) {
                    $variables = Variable::get();
                    $warehouse_id = $request->warehouse_id;
                    $variable_id = $request->variable_id ?? null;
                    return view('admin.templates.previews.stock', compact('variables', 'variable_id', 'warehouse_id'));
                } else {
                    $pageName = 'Stock management';
                    return view('admin.stocks', compact('pageName'));
                }
            }
        }
    }

    public function sync(Request $request)
    {
        $request->validate([
            'real_stock.*.quantity' => 'nullable|numeric|min:0',
            'real_stock.*.variable_id' => 'required|numeric|exists:variables,id',
        ], [
            'real_stock.*.quantity.numeric' => 'The quantity you entered is not valid.',
            'real_stock.*.quantity.min' => 'The quantity must be greater than 0.',
            'real_stock.*.variable_id.required' => 'Invalid data.',
            'real_stock.*.variable_id.numeric' => 'Invalid data.',
            'real_stock.*.variable_id.exists' => 'An error occurred please refresh and try again.',
        ]);
        if (!$this->user->can(User::CREATE_IMPORT) && !$this->user->can(User::CREATE_EXPORT)) {
            return response()->json(['errors' => ['role' => ['You do not have permission!']]], 422);
        }
        DB::beginTransaction();
        try {
            $filtered = array_filter($request->real_stock ?? [], function ($item) {
                return $item['quantity'] !== null;
            });
            $range = explode(' - ', $request->daterange);
            $range[0] = Carbon::createFromFormat('d/m/Y', $range[0])->format('Y-m-d') . ' 00:00:00';
            $range[1] = Carbon::createFromFormat('d/m/Y', $range[1])->format('Y-m-d') . ' 23:59:59';

            //Đồng bộ stock
            foreach ($filtered as $data) {
                $variable = Variable::find($data['variable_id']);
                if (!$variable) {
                    continue;
                }
                $last_import_detail = ImportDetail::where('variable_id', $variable->id)
                    ->where('price', '>', 0)
                    ->whereHas('import', function ($query) use ($request) {
                        $query->where('warehouse_id', $request->warehouse_id);
                    })->latest()->first();
                $unit = $variable->units->where('rate', 1)->first();
                [$sum_import_before, $sum_export_before, $sum_import, $sum_export] = $this->calculate_stock($variable, $range, $request->warehouse_id);
                $system_quantity = $sum_import_before - $sum_export_before + $sum_import - $sum_export;
                $actual_quantity = $data['quantity'];
                $diff = $system_quantity - $actual_quantity; //Chênh lệch
                if ($diff < 0) { // Tạo phiếu nhập
                    $import = Import::create([
                        'user_id' => $this->user->id,
                        'warehouse_id' => $request->warehouse_id,
                        'note' => 'Sync stock ' . Carbon::now()->format('d/m/Y'),
                        'created_at' => $range[1],
                        'status' => 0,
                    ]);
                    if ($import) {
                        $import_detail = ImportDetail::create([
                            'import_id' => $import->id,
                            'variable_id' => $variable->id,
                            'unit_id' => $unit->id,
                            'quantity' => abs($diff),
                            'price' => $last_import_detail ? $last_import_detail->price : 0,
                            'created_at' => $range[1],
                        ]);
                        if ($import_detail) {
                            Stock::create([
                                'import_detail_id' => $import_detail->id,
                                'quantity' => abs($diff),
                                'lot' => $last_import_detail ? $last_import_detail->stock->lot : null,
                                'expired' => $last_import_detail ? $last_import_detail->stock->expired : Carbon::now()->format('Y-m-d'),
                                'created_at' => $range[1],
                            ]);
                        }
                    }
                } elseif ($diff > 0) { // Tạo phiếu xuat
                    $stocks = Stock::whereHas('_import_detail', function ($query) use ($variable, $range, $request) {
                        $query->where('variable_id', $variable->id)
                            ->whereHas('_import', function ($query) use ($request) {
                                $query->where('warehouse_id', $request->warehouse_id)
                                    ->where('status', 1);
                            });
                    })
                        ->where('quantity', '!=', 0)
                        ->get();
                    $export = Export::create([
                        'date' => $range[1],
                        'user_id' => $this->user->id,
                        'receiver_id' => $this->user->id,
                        'note' => __('messages.sync') . Carbon::now()->format('d/m/Y'),
                        'status' => 0,
                        'created_at' => $range[1],
                    ]);
                    if ($export) {
                        foreach ($stocks as $stock) {
                            if ($diff <= 0)
                                break;
                            $reduce = $diff > $stock->quantity ? $stock->quantity : $diff;
                            $export_detail = ExportDetail::create([
                                'export_id' => $export->id,
                                'stock_id' => $stock->id,
                                'unit_id' => $unit->id,
                                'quantity' => $reduce,
                                'note' => 'Sync stock ' . Carbon::now()->format('d/m/Y'),
                                'created_at' => $range[1],
                            ]);
                            if ($export_detail) {
                                $stock->decrement('quantity', $reduce);
                                $diff -= $reduce;
                                if ($variable->isExhausted()) {
                                    StockController::pushExhaustedNoti($stock, $variable);
                                }
                            }
                        }
                    }
                }
            }
            DB::commit();
            $response = [
                'status' => 'success',
                'msg' => __('messages.stock.sync_stock'),
            ];
            return response()->json($response, 200);
        } catch (\Exception $e) {
            DB::rollBack();
            log_exception($e);
            Controller::resetAutoIncrement(['exports', 'imports', 'export_details', 'import_details', 'stocks']);
            return response()->json(['errors' => ['error' => [__('messages.error') . $e->getMessage()]]], 422);
        }
    }

    public function calculate_stock($variable, $range, $warehouse_id)
    {
        $sum_import_before = 0;
        $variable->import_details()->whereHas('import', function ($query) use ($range, $warehouse_id) {
            $query->whereDate('created_at', '<', $range[0])->where('warehouse_id', $warehouse_id)->where('status', 1);
        })->chunk(300, function ($import_details) use (&$sum_import_before) {
            $sum_import_before += $import_details->sum(function ($import_detail) {
                return $import_detail->_unit->rate * (float) $import_detail->quantity;
            });
        });

        $sum_export_before = 0;
        $variable->import_details()->whereHas('_import', function ($query) use ($range, $warehouse_id) {
            $query->where('warehouse_id', $warehouse_id)->where('status', 1);
        })->chunk(300, function ($import_details) use ($range, &$sum_export_before) {
            $sum_export_before += $import_details->map(function ($import_detail) use ($range) {
                return $import_detail->stock->export_details()->whereHas('_export', function ($query) use ($range) {
                    $query->whereDate('created_at', '<', $range[0])->where('status', 1);
                })->get()->sum(function ($export_detail) {
                    return (float) $export_detail->_unit->rate * (float) $export_detail->quantity;
                });
            })->sum();
        });

        $sum_import = 0;
        $variable->import_details()->whereHas('import', function ($query) use ($range, $warehouse_id) {
            $query->whereBetween('created_at', $range)->where('warehouse_id', $warehouse_id)->where('status', 1);
        })->chunk(300, function ($import_details) use (&$sum_import) {
            $sum_import += $import_details->sum(function ($import_detail) {
                return $import_detail->_unit->rate * (float) $import_detail->quantity;
            });
        });

        $sum_export = 0;
        $variable->import_details()->whereHas('import', function ($query) use ($warehouse_id) {
            $query->where('warehouse_id', $warehouse_id)->where('status', 1);
        })->chunk(300, function ($import_details) use ($range, &$sum_export) {
            $sum_export += $import_details->sum(function ($import_detail) use ($range) {
                return $import_detail->stock->export_details()->whereHas('_export', function ($query) use ($range) {
                    $query->whereBetween('created_at', $range)->where('status', 1);
                })->get()->sum(function ($export_detail) {
                    return $export_detail->_unit->rate * (float) $export_detail->quantity;
                });
            });
        });

        return [$sum_import_before, $sum_export_before, $sum_import, $sum_export];
    }


    static function pushExhaustedNoti($stock, $variable)
    {
        $warehouse = $stock->import_detail->_import->_warehouse;
        $txt = $variable->sumStocks() ? ' only ' . $variable->sumStocks() . ' ' . optional($variable->_units->where('rate', 1)->first())->term : ' out of stock ';
        $str = '<div class="row">
                <a class="d-flex align-items-center fw-bold text-start text-primary py-2" href="' . route('admin.stock', ['variable_id' => $variable->id, 'warehouse_id' => $warehouse->id]) . '">
                    <div class="col-2 px-0 d-flex justify-content-center">
                        <div class="notification-icon bg-danger">
                            <i class="bi bi-house-exclamation-fill"></i>
                        </div>
                    </div>
                    <div class="col-10">
                        <div class="notification-text text-wrap">
                            <p class="notification-title fw-bold text-danger">Out of stock in warehouse</p>
                            <small class="notification-subtitle text-danger">' . $stock->productName() . $txt . ' in warehouse ' . $warehouse->name . '</small>
                        </div>
                    </div>
                </a>
            </div>';
        $noti = NotificationController::create(cleanStr($str));
        if ($noti) {
            NotificationController::push($noti, $warehouse->users);
        }
    }
}
