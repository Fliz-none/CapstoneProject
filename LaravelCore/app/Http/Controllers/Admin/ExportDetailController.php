<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ExportDetail;
use App\Models\Stock;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class ExportDetailController extends Controller
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
        if (isset($request->key)) {
            $export = ExportDetail::withTrashed()->with('_order', '_stock._variable._product')->find($request->key);
            if ($export) {
                $result = $export;
            } else {
                abort(404);
            }
            return response()->json($result, 200);
        } else {
            $obj = ExportDetail::with('_export', '_stock', '_stock._import_detail._variable._product', '_unit')
                ->whereHas('_stock._import_detail._variable._product', function ($query) use ($request) {
                    $query->where('id', $request->product_id);
                });
            $can_read_export = $this->user->can(User::READ_EXPORT);
            $can_read_user = $this->user->can(User::READ_USER);
            $can_read_product = $this->user->can(User::READ_PRODUCT);
            return DataTables::of($obj)
                ->addColumn('code', function ($obj) use ($can_read_export) {
                    if ($can_read_export) {
                        $code = '<a class="btn btn-link text-decoration-none fw-bold text-start btn-update-export" data-id="' . $obj->export_id . '">' . $obj->_export->code . '</a>';
                    } else {
                        $code =  '<span class="fw-bold">' . $obj->_export->code . '</span>';
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
                ->addColumn('note', function ($obj) use ($can_read_export) {
                    if ($can_read_export) {
                        return '<a class="btn btn-link text-decoration-none text-start btn-update-export" data-id="' . $obj->export_id . '">' . $obj->_export->note . '</a>';
                    } else {
                        return $obj->_export->note;
                    }
                })
                ->filterColumn('note', function ($query, $keyword) {
                    $query->whereHas('_export', function ($q) use ($keyword) {
                        $q->where('note', 'like', "%" . $keyword . "%");
                    });
                })
                ->addColumn('user', function ($obj) use ($can_read_user) {
                    if ($obj->_export->user_id) {
                        if ($can_read_user) {
                            return '<a class="btn btn-link text-decoration-none text-start btn-update-user" data-id="' . $obj->_export->user_id . '">' . $obj->_export->_user->fullName . '</a>';
                        } else {
                            return $obj->_export->_user->fullName;
                        }
                    } else {
                        return 'Không có';
                    }
                })
                ->filterColumn('user', function ($query, $keyword) {
                    $query->whereHas('_export', function ($query) use ($keyword) {
                        $query->whereHas('_user', function ($query) use ($keyword) {
                            $query->where('name', 'like', "%" . $keyword . "%");
                        });
                    });
                })
                ->addColumn('receiver', function ($obj) use ($can_read_user) {
                    if ($obj->_export->user_id) {
                        if ($can_read_user) {
                            return '<a class="btn btn-link text-decoration-none text-start btn-update-user" data-id="' . $obj->_export->receiver_id . '">' . $obj->_export->_user->fullName . '</a>';
                        } else {
                            return $obj->_export->_user->fullName;
                        }
                    } else {
                        return 'Không có';
                    }
                })
                ->filterColumn('receiver', function ($query, $keyword) {
                    $query->whereHas('_export', function ($query) use ($keyword) {
                        $query->whereHas('_user', function ($query) use ($keyword) {
                            $query->where('name', 'like', "%" . $keyword . "%");
                        });
                    });
                })
                ->addColumn('variable', function ($obj) use ($can_read_product) {
                    if ($can_read_product) {
                        return '<a class="btn btn-link text-decoration-none text-start btn-update-variable" data-id="' . $obj->_stock->_import_detail->_variable->variable_id . '">' . $obj->_stock->_import_detail->_variable->fullName . '</a>';
                    } else {
                        return $obj->_stock->_import_detail->_variable->fullName;
                    }
                })
                ->filterColumn('variable', function ($query, $keyword) {
                    $query->whereHas('_stock', function ($query) use ($keyword) {
                        $query->whereHas('_import_detail', function ($query) use ($keyword) {
                            $query->whereHas('_variable', function ($query) use ($keyword) {
                                $query->where('name', 'like', "%" . $keyword . "%");
                            });
                        });
                    });
                })
                ->editColumn('quantity', function ($obj) {
                    return $obj->_stock->_import_detail->_variable->convertUnit($obj->quantity);
                })
                ->filterColumn('quantity', function ($query, $keyword) {
                    $query->where('quantity', 'like', "%" . $keyword . "%");
                })
                ->rawColumns(['code', 'note', 'user', 'receiver', 'variable'])
                ->setTotalRecords($obj->count())
                ->make(true);
        }
    }

    public function remove(Request $request)
    {
        $names = [];
        foreach ($request->choices as $key => $id) {
            $obj = ExportDetail::find($id);
            if (!$obj) {
                return response()->json(['errors' => ['message' => ['Không tìm thấy nội dung xuất hàng này']]], 422);
            }
            if ($obj->detail_id) {
                return response()->json(['errors' => ['message' => ['Không thể điều chỉnh phiếu xuất bán']]], 422);
            }
            if ($obj->import_detail && $obj->import_detail->_import->status) {
                return response()->json(['errors' => ['message' => ['Bên nhận đã xác nhận nhập hàng thì không thể điều chỉnh phiếu xuất hàng']]], 422);
            }
            DB::beginTransaction();
            try {
                array_push($names, $obj->quantity . ' ' . $obj->_stock->import_detail->_variable->unit . ' ' . $obj->_stock->import_detail->_variable->product->name . ' - ' . $obj->_stock->import_detail->_variable->name);
                if ($obj->import_detail) {
                    $obj->import_detail->stock->update(['quantity' => 0]);
                    $obj->import_detail->update(['quantity', 0]);

                    $count_export_details = $obj->_stock->export_details()->withTrashed()->count();
                    if (!$count_export_details) {
                        $obj->import_detail->stock->forceDelete();
                        $obj->import_detail->forceDelete();
                    } else {
                        $obj->import_detail->stock->delete();
                        $obj->import_detail->delete();
                    }
                }
                $obj->_stock->increment('quantity', $obj->_unit->rate * $obj->quantity);
                $obj->update(['quantity' => 0]);
                if (!$obj->import_detail) {
                    $obj->forceDelete();
                } else {
                    $obj->delete();
                }
                DB::commit();
                return response()->json([
                    'status' => 'success',
                    'msg' => 'Đã xóa chi tiết xuất hàng ' . implode(', ', $names),
                ], 200);
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error('Có lỗi xảy ra: ' . $e->getMessage() . ';' . PHP_EOL .
                        'URL truy vấn: "' . request()->fullUrl() . '";' . PHP_EOL .
                        'Dữ liệu nhận được: ' . json_encode(request()->all()) . ';' . PHP_EOL .
                        'User ID: ' . (Auth::check() ? Auth::id() : 'Khách') . ';' . PHP_EOL .
                        'Chi tiết lỗi: ' . $e->getTraceAsString()
                );
                Controller::resetAutoIncrement(['imports', 'import_details', 'stocks']);
                return response()->json(['errors' => ['error' => ['Đã xảy ra lỗi: ' . $e->getMessage()]]], 422);
            }
        }
    }
}
