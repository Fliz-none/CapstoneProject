<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Export;
use App\Models\ExportDetail;
use App\Models\Import;
use App\Models\ImportDetail;
use App\Models\Indication;
use App\Models\Prescription;
use App\Models\Stock;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

class ExportController extends Controller
{
    const NAME = 'xuất hàng',
        RULES = [
            'note' => ['required', 'string'],
            'date' => ['required', 'date_format:Y-m-d'],
            'receiver_id' => ['required', 'numeric'],
            'status' => ['required', 'numeric'],
            'stock_ids' => ['required', 'array', 'min:1'],
            'stock_ids.*' => ['required', 'numeric'],
            'unit_ids' => ['array', 'min:1'],
            'unit_ids.*' => ['required', 'numeric'],
            'rates' => ['array', 'min:1'],
            'rates.*' => ['required', 'numeric'],
            'quantities' => ['array'],
            'quantities.*' => ['required', 'numeric', 'min:0'],
            'notes' => ['array'],
            'notes.*' => ['nullable', 'string'],
        ],
        MESSAGES = [
            'note.required' => 'Nội dung xuất hàng: ' . Controller::NOT_EMPTY,
            'note.string' => 'Nội dung xuất hàng: ' . Controller::DATA_INVALID,
            'date.required' => 'Ngày xuất hàng: ' . Controller::NOT_EMPTY,
            'date.date_format' => 'Ngày xuất hàng: ' . Controller::DATA_INVALID,
            'receiver_id.required' => 'Người nhận hàng xuất: ' . Controller::NOT_EMPTY,
            'receiver_id.numeric' => 'Người nhận hàng xuất: ' . Controller::DATA_INVALID,
            'stock_ids.required' => 'Hàng hóa: ' . Controller::ONE_LEAST,
            'stock_ids.array' => 'Hàng hóa: ' . Controller::ONE_LEAST,
            'stock_ids.min' => 'Hàng hóa: ' . Controller::ONE_LEAST,
            'stock_ids.*.required' => 'Hàng hóa: ' . Controller::NOT_EMPTY,
            'stock_ids.*.numeric' => 'Hàng hóa: ' . Controller::NOT_EMPTY,
            'unit_ids.array' => 'Đơn vị tính: ' . Controller::ONE_LEAST,
            'unit_ids.min' => 'Đơn vị tính: ' . Controller::ONE_LEAST,
            'unit_ids.*.required' => 'Đơn vị tính: ' . Controller::NOT_EMPTY,
            'unit_ids.*.numeric' => 'Đơn vị tính: ' . Controller::NOT_EMPTY,
            'rates.array' => 'Mã đơn vị tính: ' . Controller::ONE_LEAST,
            'rates.min' => 'Mã đơn vị tính: ' . Controller::ONE_LEAST,
            'rates.*.required' => 'Mã đơn vị tính: ' . Controller::NOT_EMPTY,
            'rates.*.numeric' => 'Mã đơn vị tính: ' . Controller::NOT_EMPTY,
            'quantities' => 'Số lượng hàng hóa: ' . Controller::DATA_INVALID,
            'quantities.*.required' => 'Số lượng hàng hóa: ' . Controller::NOT_EMPTY,
            'quantities.*.numeric' => 'Số lượng hàng hóa: ' . Controller::DATA_INVALID,
            'quantities.*.min' => 'Số lượng hàng hóa: Không thể âm!',
            'notes' => 'Lý do xuất hàng: ' . Controller::DATA_INVALID,
            'notes.*.numeric' => 'Lý do xuất hàng: ' . Controller::DATA_INVALID,
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
            $export = Export::withTrashed()->with(['export_details._stock.import_detail._import._warehouse', 'export_details._unit', '_to_warehouse', '_receiver', 'export_details._stock.import_detail._variable._product'])->find($request->key);
            if ($export) {
                switch ($request->action) {
                    case 'print':
                        return view('admin.templates.prints.export_c80', ['export' => $export]);
                        break;
                    default:
                        $export->export_details->each(function ($export_detail) {
                            $export_detail->_stock->convertQuantity = $export_detail->_stock->import_detail->_variable->convertUnit($export_detail->_stock->quantity);
                        });
                        $result = $export;
                        break;
                }
            } else {
                abort(404);
            }
            return response()->json($result, 200);
        } else {
            if ($request->ajax()) {
                $objs = Export::where('exports.company_id', $this->user->company_id)
                    ->with(['_user.local', '_receiver.local', 'import', 'export_details._stock.import_detail._import.import_details.stock.export_details'])->whereHas('export_details', function ($query) use ($request) {
                        $query->whereHas('_stock', function ($query) use ($request) {
                            $query->whereHas('import_detail', function ($query) use ($request) {
                                $query->whereHas('_import', function ($query) use ($request) {
                                    $query->when($request->has('warehouse_id'), function ($query) use ($request) {
                                        $query->where('warehouse_id', $request->warehouse_id);
                                    }, function ($query) {
                                        $query->whereIn('warehouse_id', $this->user->warehouses->pluck('id'));
                                    });
                                });
                            });
                        });
                    });
                $can_read_export = $this->user->can(User::READ_EXPORT);
                $can_read_user = $this->user->can(User::READ_USER);
                $can_delete_export = $this->user->can(User::DELETE_EXPORT);
                return DataTables::of($objs)
                    ->addColumn('checkboxes', function ($obj) {
                        return '<input class="form-check-input choice" type="checkbox" name="choices[]" value="' . $obj->id . '">';
                    })
                    ->editColumn('code', function ($obj) use ($can_read_export) {
                        if ($can_read_export) {
                            $code = '<a class="btn btn-link text-decoration-none fw-bold text-start btn-update-export" data-id="' . $obj->id . '">' . $obj->code . '</a>';
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
                                $query->whereYear('exports.created_at', $date['year']);
                            })
                            ->when($date['month'], function ($query) use ($date) {
                                $query->whereMonth('exports.created_at', $date['month']);
                            })
                            ->when($date['day'], function ($query) use ($date) {
                                $query->whereDay('exports.created_at', $date['day']);
                            });
                        }, function ($query) use ($keyword) {
                            $numericKeyword = ltrim(preg_replace('/[^0-9]/', '', $keyword), '0');
                            if (!empty($numericKeyword)) {
                                $query->where('exports.id', 'like', "%" . $numericKeyword . "%");
                            }
                        });
                    })
                    ->orderColumn('code', function ($query, $order) {
                        $query->orderBy('id', $order);
                    })
                    ->editColumn('note', function ($obj) use ($can_read_export) {
                        if ($can_read_export) {
                            return '<a class="btn btn-link text-decoration-none text-start btn-update-export" data-id="' . $obj->id . '">' . $obj->note . '</a>';
                        } else {
                            return $obj->note;
                        }
                    })
                    ->filterColumn('note', function ($query, $keyword) {
                        $query->where('exports.note', 'like', "%" . $keyword . "%");
                    })
                    ->orderColumn('note', function ($query, $order) {
                        $query->orderBy('note', $order);
                    })
                    ->editColumn('user', function ($obj) use ($can_read_user) {
                        if ($can_read_user) {
                            return '<a class="btn btn-link text-decoration-none text-start btn-update-user" data-id="' . $obj->user_id . '">' . $obj->_user->fullName . '</a>';
                        } else {
                            return $obj->_user->fullName;
                        }
                    })
                    ->filterColumn('user', function ($query, $keyword) {
                        $query->whereHas('_user', function ($query) use ($keyword) {
                            $query->where('name', 'like', "%" . $keyword . "%");
                        });
                    })
                    ->orderColumn('user', function ($query, $order) {
                        $query->join('users', 'exports.user_id', '=', 'users.id')
                            ->orderBy('users.name', $order);
                    })
                    ->addColumn('receiver', function ($obj) use ($can_read_user) {
                        if ($can_read_user) {
                            return '<a class="btn btn-link text-decoration-none text-start btn-update-user" data-id="' . $obj->receiver_id . '">' . $obj->_receiver->fullName . '</a>';
                        } else {
                            return $obj->_receiver->fullName;
                        }
                    })
                    ->filterColumn('receiver', function ($query, $keyword) {
                        $query->whereHas('_user', function ($query) use ($keyword) {
                            $query->where('name', 'like', "%" . $keyword . "%");
                        });
                    })
                    ->orderColumn('receiver', function ($query, $order) {
                        $query->join('users', 'exports.user_id', '=', 'users.id')
                            ->orderBy('users.name', $order);
                    })
                    ->addColumn('type', function ($obj) {
                        if ($obj->order_id) {
                            return '<span class="badge bg-success text-white">Xuất bán hàng</span>';
                        } else if ($obj->import) {
                            return '<span class="badge bg-primary text-white">Xuất nội bộ</span>';
                        } else {
                            return '<span class="badge bg-danger text-white">Xuất bỏ</span>';
                        }
                    })
                    ->filterColumn('type', function ($query, $keyword) {
                        $query->when(str_contains('xuatbanhang', $keyword), function ($query) {
                            $query->whereNotNull('order_id')->whereNull('to_warehouse_id');
                        });
                        $query->when(str_contains('xuatnoibo', $keyword), function ($query) {
                            $query->whereNull('order_id')->whereNotnull('to_warehouse_id');
                        });
                        $query->when(str_contains('xuatbo', $keyword), function ($query) {
                            $query->whereNull('order_id')->whereNull('to_warehouse_id');
                        });
                    })
                    ->editColumn('status', function ($obj) {
                        return $obj->statusStr;
                    })
                    ->orderColumn('status', function ($query, $order) {
                        $query->orderBy('status', $order);
                    })
                    ->filterColumn('status', function ($query, $keyword) {
                        $statusMap = [
                            'daxuat' => 1,
                            'choduyet' => 0,
                        ];
                        if (isset($statusMap[Str::lower($keyword)])) {
                            $query->where('status', $statusMap[Str::lower($keyword)]);
                        }
                    })
                    ->addColumn('action', function ($obj) use ($can_delete_export) {
                        if ($can_delete_export) {
                            return '
                                <form method="post" action="' . route('admin.export.remove') . '" class="save-form">
                                    <input type="hidden" name="choices[]" value="' . $obj->id . '"/>
                                    <button type="submit" class="btn btn-link text-decoration-none btn-remove cursor-pointer">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>';
                        }
                    })
                    ->rawColumns(['checkboxes', 'code', 'note', 'user', 'receiver', 'type', 'action'])
                    ->setTotalRecords($objs->count())
                    ->make(true);
            } else {
                if ($request->has('check') && $request->has('warehouse_id') && $request->has('variable_id')) {
                    $export_details = ExportDetail::whereHas('stock', function ($query) use ($request) {
                        $query->whereHas('import_detail', function ($query) use ($request) {
                            $query->whereHas('import', function ($query) use ($request) {
                                $query->where('warehouse_id', $request->warehouse_id);
                            })->where('variable_id', $request->variable_id);
                        });
                    })->get();
                    $stock_id = $request->stock_id ?? '';
                    return view('admin.templates.previews.export_detail', compact('export_details', 'stock_id'));
                }
                $pageName = 'Quản lý ' . self::NAME;
                return view('admin.exports', compact('pageName'));
            }
        }
    }

    public function create(Request $request)
    {
        $request->validate(self::RULES, self::MESSAGES);
        if (!empty($this->user->can(User::CREATE_EXPORT))) {
            DB::beginTransaction();
            try {
                $export = Export::create([
                    'date' => $request->date,
                    'receiver_id' => $request->receiver_id,
                    'to_warehouse_id' => $request->to_warehouse_id,
                    'user_id' => $this->user->id,
                    'order_id' => $request->order_id,
                    'company_id' => $this->user->company_id,
                    'note' => $request->note,
                    'status' => $request->status,
                ]);
                if ($export) {
                    if ($request->has('to_warehouse_id')) {
                        $import = Import::create([
                            'warehouse_id' => $request->to_warehouse_id,
                            'export_id' => $export->id,
                            'company_id' => $this->user->company_id,
                            'note' => 'Nhập từ ' . $export->code,
                            'created_at' => $export->created_at,
                            'status' => 0,
                        ]);
                    }
                    $units = Unit::withTrashed()->whereIn('id', $request->unit_ids)->get();
                    foreach ($request->stock_ids as $i => $value) {
                        $unit = $units->where('id', $request->unit_ids[$i])->first();
                        if ($unit) {
                            $export_detail = ExportDetail::create([
                                'export_id' => $export->id,
                                'stock_id' => $request->stock_ids[$i],
                                'unit_id' => $unit->id,
                                'detail_id' => $request->detail_id ?? null,
                                'quantity' => $request->quantities[$i],
                                'note' => $request->notes[$i]
                            ]);
                            if ($export_detail) {
                                if ($request->has('to_warehouse_id')) {
                                    $import_detail = ImportDetail::create([
                                        'import_id' => $import->id,
                                        'export_detail_id' => $export_detail->id,
                                        'variable_id' => $export_detail->_stock->import_detail->variable_id,
                                        'unit_id' => $unit->id,
                                        'quantity' => $request->quantities[$i],
                                        'price' => $export_detail->_stock->import_detail->price,
                                    ]);
                                    if ($import_detail) {
                                        $stock = Stock::create([
                                            'company_id' => $this->user->company_id,
                                            'import_detail_id' => $import_detail->id,
                                            'quantity' => $request->quantities[$i] * $unit->rate,
                                            'lot' => $export_detail->_stock->lot,
                                            'expired' => $export_detail->_stock->expired
                                        ]);
                                        $ids[] = $import_detail->id;
                                    }
                                }
                                $stock = $export_detail->_stock;
                                $stock->decrement('quantity', $request->quantities[$i] * $unit->rate);
                                $variable = $stock->import_detail->_variable;
                                if ($variable->isExhausted()) {
                                    StockController::pushExhaustedNoti($stock, $variable);
                                }
                            }
                        }
                    }
                    if ($request->prescription_id != null) {
                        $prescription = Prescription::find($request->prescription_id);
                        $prescription->update(['export_id' => $export->id]);
                    }
                }

                DB::commit();
                LogController::create('tạo', self::NAME, $export->id);
                $response = [
                    'status' => 'success',
                    'msg' => 'Đã tạo xuất hàng ' . $export->note,
                ];
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error(
                    'Có lỗi xảy ra: ' . $e->getMessage() . ';' . PHP_EOL .
                    'URL truy vấn: "' . request()->fullUrl() . '";' . PHP_EOL .
                    'Dữ liệu nhận được: ' . json_encode(request()->all()) . ';' . PHP_EOL .
                    'User ID: ' . (Auth::check() ? Auth::id() : 'Khách') . ';' . PHP_EOL .
                    'Chi tiết lỗi: ' . $e->getTraceAsString()
                );
                Controller::resetAutoIncrement(['exports', 'imports', 'export_details', 'import_details', 'stocks']);
                return response()->json(['errors' => ['error' => ['Đã xảy ra lỗi: ' . $e->getMessage()]]], 422);
            }
        } else {
            return response()->json(['errors' => ['role' => ['Thao tác chưa được cấp quyền!']]], 422);
        }
        return response()->json($response, 200);
    }

    public function update(Request $request)
    {
        $request->validate(self::RULES, self::MESSAGES);
        if (!empty($this->user->can(User::UPDATE_EXPORT))) {
            if ($request->has('id')) {
                DB::beginTransaction();
                try {
                    $export = Export::find($request->id);
                    if ($export) {
                        if ($export->import && $export->import->status == 1) {
                            return response()->json(['errors' => ['import_confirmed' => ['Kho tiếp nhận xác nhận nhập kho thì không thể điều chỉnh phiếu xuất kho nữa']]], 422);
                        }
                        if ($export->order_id) {
                            return response()->json(['errors' => ['export_order' => ['Xuất kho bán hàng không thể điều chỉnh. Hãy điều chỉnh trên hóa đơn']]], 422);
                        }
                        $export = Export::updateOrCreate([
                            'id' => $request->id
                        ], [
                            'date' => $request->date,
                            'receiver_id' => $request->receiver_id,
                            'to_warehouse_id' => $request->to_warehouse_id,
                            'company_id' => $this->user->company_id,
                            'user_id' => $this->user->id,
                            'note' => $request->note,
                            'status' => $request->status,
                        ]);

                        if ($request->has('to_warehouse_id')) {
                            $import = Import::updateOrCreate([
                                'id' => $export->import->id
                            ], [
                                'warehouse_id' => $request->to_warehouse_id,
                                'export_id' => $export->id,
                                'company_id' => $this->user->company_id,
                                'note' => 'Nhập từ ' . $export->code,
                                'created_at' => $export->created_at,
                                'status' => 0,
                            ]);
                        }
                        $units = Unit::withTrashed()->whereIn('id', $request->unit_ids)->get();
                        foreach ($request->stock_ids as $i => $value) {
                            $unit = $units->where('id', $request->unit_ids[$i])->first();
                            $old = ExportDetail::find($request->ids[$i]);
                            if ($unit) {
                                $export_detail = ExportDetail::updateOrCreate([
                                    'id' => $request->ids[$i]
                                ], [
                                    'export_id' => $export->id,
                                    'stock_id' => $request->stock_ids[$i],
                                    'unit_id' => $request->unit_ids[$i],
                                    'quantity' => $request->quantities[$i],
                                    'note' => $request->notes[$i]
                                ]);
                                if ($export_detail) {
                                    if ($request->has('to_warehouse_id')) {
                                        $import_detail = ImportDetail::updateOrCreate([
                                            'id' => $export_detail->import_detail ? $export_detail->import_detail->id : null
                                        ], [
                                            'import_id' => $import->id,
                                            'export_detail_id' => $export_detail->id,
                                            'variable_id' => $export_detail->_stock->import_detail->variable_id,
                                            'unit_id' => $unit->id,
                                            'quantity' => $request->quantities[$i],
                                            'price' => $export_detail->_stock->import_detail->price,
                                        ]);
                                        if ($import_detail) {
                                            $stock = Stock::updateOrCreate([
                                                'id' => $import_detail->stock ? $import_detail->stock->id : null
                                            ], [
                                                'company_id' => $this->user->company_id,
                                                'import_detail_id' => $import_detail->id,
                                                'quantity' => $request->quantities[$i] * $unit->rate,
                                                'lot' => $export_detail->_stock->lot,
                                                'expired' => $export_detail->_stock->expired
                                            ]);
                                            $ids[] = $import_detail->id;
                                        }
                                    }
                                    $old_quantity = $old ? $old->quantity : 0;
                                    $diff = $export_detail->quantity - $old_quantity;
                                    $stock = $export_detail->_stock;
                                    $stock->decrement('quantity', $diff * $unit->rate);
                                    $variable = $stock->import_detail->_variable;
                                    if ($diff && $variable->isExhausted()) {
                                        StockController::pushExhaustedNoti($stock, $variable);
                                    }
                                }
                            }
                        }

                        DB::commit();
                        LogController::create('sửa', self::NAME, $export->id);
                        $response = [
                            'status' => 'success',
                            'msg' => 'Đã sửa xuất hàng ' . $export->note,
                        ];
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
                    Controller::resetAutoIncrement(['exports', 'imports', 'export_details', 'import_details', 'stocks']);
                    return response()->json(['errors' => ['error' => ['Đã xảy ra lỗi: ' . $e->getMessage()]]], 422);
                }
            } else {
                $response = array(
                    'status' => 'error',
                    'msg' => 'Đã có lỗi xảy ra, vui lòng tải lại trang và thử lại!'
                );
            }
        } else {
            return response()->json(['errors' => ['role' => ['Thao tác chưa được cấp quyền!']]], 422);
        }
        return response()->json($response, 200);
    }

    public function remove(Request $request)
    {
        $names = [];
        foreach ($request->choices as $key => $id) {
            $obj = Export::find($id);
            if (!$obj) {
                return response()->json(['errors' => ['message' => ['Không tìm thấy phiếu xuất hàng ' . $id . '']]], 422);
            }
            if ($obj->order_id) {
                return response()->json(['errors' => ['message' => ['Không thể xóa phiếu xuất bán hàng. Hãy thử xóa đơn hàng']]], 422);
            }
            if ($obj->import && $obj->import->status) {
                return response()->json(['errors' => ['message' => ['Bên nhận đã xác nhận nhập hàng thì không thể xóa phiếu xuất hàng']]], 422);
            }
            DB::beginTransaction();
            try {
                $obj->export_details->each(function ($export_detail) {
                    if ($export_detail->import_detail) {
                        $export_detail->import_detail->stock->update(['quantity' => 0]);
                        $export_detail->import_detail->update(['quantity', 0]);

                        $count_details = $export_detail->import_detail->stock->order_details()->withTrashed()->count();
                        $count_export_details = $export_detail->import_detail->stock->export_details()->withTrashed()->count();
                        if (!$count_details && !$count_export_details) {
                            $export_detail->import_detail->stock->forceDelete();
                            $export_detail->import_detail->forceDelete();
                        } else {
                            $export_detail->import_detail->stock->delete();
                            $export_detail->import_detail->delete();
                        }
                    }
                    $export_detail->_stock->increment('quantity', $export_detail->_unit->rate * $export_detail->quantity);
                    $export_detail->update(['quantity' => 0]);
                    if (!$export_detail->import_detail()->withTrashed()->count()) {
                        $export_detail->forceDelete();
                    } else {
                        $export_detail->delete();
                    }
                });
                if ($obj->import) {
                    if (!$obj->import->import_details()->withTrashed()->count()) {
                        $obj->import->forceDelete();
                        $obj->unsetRelation('import');
                    } else {
                        $obj->import->delete();
                    }
                }
                $has_import = $obj->import;
                $count_export_detail = $obj->export_details()->withTrashed()->count();
                if (!$has_import && !$count_export_detail) {
                    $obj->forceDelete();
                } else {
                    $obj->delete();
                }
                DB::commit();
                array_push($names, $obj->code);
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error(
                    'Có lỗi xảy ra: ' . $e->getMessage() . ';' . PHP_EOL .
                    'URL truy vấn: "' . request()->fullUrl() . '";' . PHP_EOL .
                    'Dữ liệu nhận được: ' . json_encode(request()->all()) . ';' . PHP_EOL .
                    'User ID: ' . (Auth::check() ? Auth::id() : 'Khách') . ';' . PHP_EOL .
                    'Chi tiết lỗi: ' . $e->getTraceAsString()
                );
                Controller::resetAutoIncrement(['exports', 'export_details', 'imports', 'import_details', 'stocks']);
                return response()->json(['errors' => ['error' => ['Đã xảy ra lỗi: ' . $e->getMessage()]]], 422);
            }
        }
        return response()->json([
            'status' => 'success',
            'msg' => 'Đã xóa xuất hàng ' . implode(', ', $names),
        ], 200);
    }
}
