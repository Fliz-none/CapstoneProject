<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ImportDetail;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class ImportDetailController extends Controller
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

    public function index(Request $request)
    {
        $obj = ImportDetail::with('_import', '_variable._product', '_unit')->whereHas('_variable._product', function ($query) use ($request) {
            $query->where('id', $request->product_id);
        });
        $can_read_import = $this->user->can(User::READ_IMPORT);
        $can_read_user = $this->user->can(User::READ_USER);
        $can_read_warehouse = $this->user->can(User::READ_WAREHOUSES);
        $can_read_supplier = $this->user->can(User::READ_SUPPLIER);
        $can_read_export = $this->user->can(User::READ_EXPORT);
        $can_read_product = $this->user->can(User::READ_PRODUCT);
        return DataTables::of($obj)
            ->addColumn('code', function ($obj) use ($can_read_import) {
                if ($can_read_import) {
                    $code = '<a class="btn btn-link text-decoration-none fw-bold text-start btn-update-import" data-id="' . $obj->import_id . '">' . $obj->_import->code . '</a>';
                } else {
                    $code =  '<span class="fw-bold">' . $obj->_import->code . '</span>';
                }
                $code .=  '<span class="fw-bold">' . $obj->id . '</span>';
                return $code . '<br/><small>' . $obj->created_at->format('d/m/Y H:i') . '</small>';
            })
            ->filterColumn('code', function ($query, $keyword) {
                $array = explode('/', $keyword);
                $query->when(count($array) > 1, function ($query) use ($keyword, $array) {
                    $date = (count($array) == 3 ? $array[2] : date('Y')) . '-' . str_pad($array[1], 2, "0", STR_PAD_LEFT) . '-' . str_pad($array[0], 2, "0", STR_PAD_LEFT);
                    $query->whereDate('created_at', $date);
                });
                $query->when(count($array) == 1, function ($query) use ($keyword) {
                    $query->where('id', $keyword);
                });
            })
            ->addColumn('note', function ($obj) use ($can_read_import) {
                if ($can_read_import) {
                    return '<a class="btn btn-link text-decoration-none text-start btn-update-import" data-id="' . $obj->import_id . '">' . $obj->_import->note . '</a>';
                } else {
                    return $obj->_import->note;
                }
            })
            ->filterColumn('note', function ($query, $keyword) {
                $query->whereHas('_import', function ($q) use ($keyword) {
                    $q->where('note', 'like', "%" . $keyword . "%");
                });
            })
            ->addColumn('user', function ($obj) use ($can_read_user) {
                if ($obj->_import->user_id) {
                    if ($can_read_user) {
                        return '<a class="btn btn-link text-decoration-none text-start btn-update-user" data-id="' . $obj->_import->user_id . '">' . $obj->_import->_user->fullName . '</a>';
                    } else {
                        return $obj->_import->_user->fullName;
                    }
                } else {
                    return 'N/A';
                }
            })
            ->filterColumn('user', function ($query, $keyword) {
                $query->whereHas('_import', function ($query) use ($keyword) {
                    $query->whereHas('_user', function ($query) use ($keyword) {
                        $query->where('name', 'like', "%" . $keyword . "%");
                    });
                });
            })
            ->addColumn('warehouse', function ($obj) use ($can_read_warehouse) {
                if ($can_read_warehouse) {
                    return '<a class="btn btn-link text-decoration-none text-start btn-update-warehouse" data-id="' . $obj->_import->warehouse_id . '">' . $obj->_import->_warehouse->fullName . '</a>';
                } else {
                    return $obj->_import->_warehouse->fullName;
                }
            })
            ->filterColumn('warehouse', function ($query, $keyword) {
                $query->whereHas('_import', function ($query) use ($keyword) {
                    $query->whereHas('_warehouse', function ($query) use ($keyword) {
                        $query->where('name', 'like', "%" . $keyword . "%");
                    });
                });
            })
            ->addColumn('supplier', function ($obj) use ($can_read_supplier, $can_read_export) {
                if ($obj->_import->supplier_id) {
                    if ($can_read_supplier) {
                        return '<a class="btn btn-link text-decoration-none text-start btn-update-supplier" data-id="' . $obj->_import->supplier_id . '">' . $obj->_import->_supplier->fullName . '</a>';
                    } else {
                        return $obj->_import->_supplier->fullName;
                    }
                } else if ($obj->_import->export_id) {
                    if ($can_read_export) {
                        return '<a class="btn btn-link text-decoration-none text-start btn-update-export" data-id="' . $obj->_import->export_id . '">' . $obj->_import->_export->code . '</a>';
                    } else {
                        return $obj->_import->_export->code;
                    }
                } else {
                    return 'N/A';
                }                                         
            })
            ->filterColumn('supplier', function ($query, $keyword) {
                $query->whereHas('_import', function ($query) use ($keyword) {
                    $query->whereHas('_supplier', function ($query) use ($keyword) {
                        $query->where('name', 'like', "%" . $keyword . "%");
                    });
                });
            })
            ->addColumn('variable', function ($obj) use ($can_read_product) {
                if ($can_read_product) {
                    return '<a class="btn btn-link text-decoration-none text-start btn-update-variable" data-id="' . $obj->variable_id . '">' . $obj->_variable->fullName . '</a>';
                } else {
                    return $obj->_variable->fullName;
                }
            })
            ->filterColumn('variable', function ($query, $keyword) {
                $query->whereHas('_variable', function ($query) use ($keyword) {
                    $query->where('name', 'like', "%" . $keyword . "%");
                });
            })
            ->editColumn('quantity', function ($obj) {
                return $obj->_variable->convertUnit($obj->quantity);
            })
            ->filterColumn('quantity', function ($query, $keyword) {
                $query->where('quantity', 'like', "%" . $keyword . "%");
            })
            ->editColumn('price', function ($obj) {
                return number_format($obj->price);
            })
            ->filterColumn('price', function ($query, $keyword) {
                $query->where('price', 'like', "%" . $keyword . "%");
            })
            ->rawColumns(['code', 'note', 'user', 'warehouse', 'supplier', 'variable'])
            ->setTotalRecords($obj->count())
            ->make(true);
    }

    public function remove(Request $request)
    {
        $names = [];
        $choices = $request->choices;
        foreach ($choices as $key => $id) {
            $obj = ImportDetail::find($id);
            if (!$obj) {
                return response()->json(['errors' => ['message' => ['Cannot find import detail ' . $id]]], 422);
            }
            if ($obj->stock->export_details->count()) {
                return response()->json(['errors' => ['message' => ['This item has been sold and cannot be modified']]], 422);
            }
            if ($obj->export_detail_id) {
                return response()->json(['errors' => ['message' => ['Cannot modify internal warehouse receipt. Please try modifying export receipt']]], 422);
            }
            DB::beginTransaction();
            try {
                array_push($names,  $obj->quantity . ' ' . $obj->_unit->term . ' ' . $obj->_variable->_product->name);
                $obj->stock->update(['quantity' => 0]);
                $count_details = $obj->stock->order_details()->withTrashed()->count();
                $count_export_details = $obj->stock->export_details()->withTrashed()->count();
                $obj->update(['quantity' => 0]);
                if (!$count_details && !$count_export_details) {
                    $obj->stock->forceDelete();
                    $obj->forceDelete();
                } else {
                    $obj->stock->delete();
                    $obj->delete();
                }
                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                log_exception($e);
                Controller::resetAutoIncrement('import_details', 'stocks');
                return response()->json(['errors' => ['error' => ['An error occurred: ' . $e->getMessage()]]], 422);
            }
        }
        return response()->json([
            'status' => 'success',
            'msg' => 'Deleted stock ' . implode(', ', $names),
        ], 200);
    }
}
