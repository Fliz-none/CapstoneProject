<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Detail;
use App\Models\Export;
use App\Models\ExportDetail;
use App\Models\Order;
use App\Models\Transaction;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    const NAME = 'đơn hàng';

    public function __construct()
    {
        parent::__construct();
        if ($this->user === null) {
            $this->user = Auth::user();
        }
        $this->middleware('auth');
        // $this->middleware(['verified','auth']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        if (isset($request->key)) {
            $objs = Order::query();
            switch ($request->key) {
                case 'new':
                    $pageName = 'Bán hàng';
                    $settings = cache()->get('settings');
                    $bankInfos = isset($settings['bank_info']) ? json_decode($settings['bank_info'], true) : [];
                    return view('admin.order', compact('pageName', 'bankInfos'));
                    break;

                default:
                    $relationships = [
                        '_dealer',
                        '_branch',
                        '_customer',
                        'transactions._cashier',
                        'transactions._customer',
                        'details.export_detail',
                        'details._unit',
                        'details._stock.import_detail._variable._product',
                        'details._stock.import_detail._import._warehouse',
                    ];
                    $obj = $objs->with($relationships)->find($request->key);
                    if ($obj) {
                        switch ($request->action) {
                            case 'print':
                                return view('admin.templates.prints.order_' . ($request->template ?? 'c80'), ['order' => $obj]);
                                break;
                            case 'preview':
                                return view('admin.templates.previews.order', ['order' => $obj]);
                                break;
                            default:
                                $result = $obj;
                                break;
                        }
                    } else {
                        abort(404);
                    }
                    break;
            }
            return response()->json($result, 200);
        } else {
            if ($request->ajax()) {
                $objs = Order::with('_customer.local', '_dealer.local', '_branch', 'details', 'transactions')
                    ->when($request->has('customer_id'), function ($query) use ($request) {
                        $query->where('customer_id', $request->customer_id);
                    })
                    ->when($request->has('branch_id'), function ($query) use ($request) {
                        $query->where('branch_id', $request->branch_id);
                    }, function ($query) {
                        $query->whereIn('branch_id', $this->user->branches->pluck('id'));
                    });
                $can_read_order = $this->user->can(User::READ_ORDER);
                $can_update_order = $this->user->can(User::UPDATE_ORDER);
                $can_read_user = $this->user->can(User::READ_USER);
                $can_update_branch = $this->user->can(User::UPDATE_BRANCH);
                $can_delete_order = $this->user->can(User::DELETE_ORDER);
                $can_create_transaction = $this->user->can(User::CREATE_TRANSACTION);
                return DataTables::of($objs)
                    ->addColumn('checkboxes', function ($obj) {
                        return '<input class="form-check-input choice" type="checkbox" name="choices[]" value="' . $obj->id . '">';
                    })
                    ->addColumn('code', function ($obj) use ($can_read_order, $can_update_order) {
                        $color = $obj->total > $obj->paid ? 'danger' : ($obj->total < $obj->paid ? 'success' : 'primary');
                        if ($can_update_order) {
                            $code = '<a class="btn btn-link text-decoration-none text-' . $color . ' fw-bold p-0 btn-update-order" data-id="' . $obj->id . '">' . $obj->code . '</a> ';
                            $code .= $obj->discount || $obj->details->where('discount', '!=', 0)->count() ? '<small><i class="bi bi-info-circle text-danger" data-bs-toggle="tooltip" data-bs-title="Đơn hàng có điều chỉnh giá"></i></small>' : '';
                        } else {
                            if ($can_read_order) {
                                $code =  '<a class="btn btn-link text-decoration-none text-' . $color . ' btn-preview preview-order fw-bold p-0" data-id="' . $obj->id . '" data-url="' . getPath(route('admin.order')) . '">' . $obj->code . '</a>';
                            } else {
                                $code =  '<span class="fw-bold">' . $obj->code . '</span>';
                            }
                        }
                        return $code . '<br/><small>' . $obj->created_at->format('d/m/Y H:i') . '</small>';
                    })
                    ->filterColumn('code', function ($query, $keyword) {
                        $array = explode('/', $keyword);
                        $query->when(count($array) > 1, function ($query) use ($keyword, $array) {
                            $date = parseDate($keyword);
                            $query->when($date['year'], function ($query) use ($date) {
                                $query->whereYear('orders.created_at', $date['year']);
                            })
                            ->when($date['month'], function ($query) use ($date) {
                                $query->whereMonth('orders.created_at', $date['month']);
                            })
                            ->when($date['day'], function ($query) use ($date) {
                                $query->whereDay('orders.created_at', $date['day']);
                            });
                        }, function ($query) use ($keyword) {
                            $numericKeyword = ltrim(preg_replace('/[^0-9]/', '', $keyword), '0');
                            if (!empty($numericKeyword)) {
                                $query->where('orders.id', 'like', "%" . $numericKeyword . "%");
                            }
                        });
                    })
                    ->orderColumn('code', function ($query, $order) {
                        $query->orderBy('id', $order);
                    })
                    ->editColumn('customer', function ($obj) use ($can_read_user) {
                        if ($obj->customer_id) {
                            if ($can_read_user) {
                                return '<a class="btn btn-update-user text-primary text-start" data-id="' . $obj->_customer->id . '">' . $obj->_customer->fullName . '</a>';
                            }
                            return '<span class="fw-bold">' . $obj->_customer->name . '</span>';
                        } else {
                            return '<span class="px-3">Vô danh</span>';
                        }
                    })
                    ->filterColumn('customer', function ($query, $keyword) {
                        $query->whereHas('customer', function ($query) use ($keyword) {
                            $query->where('users.name', 'like', "%" . $keyword . "%")
                                ->orWhere('users.phone', 'like', "%" . $keyword . "%")
                                ->orWhere('users.email', 'like', "%" . $keyword . "%")
                                ->orWhere('users.address', 'like', "%" . $keyword . "%");
                        });
                    })
                    ->orderColumn('customer', function ($query, $order) {
                        $query->select('orders.*', 'users.name')->join('users', 'orders.customer_id', '=', 'users.id')
                            ->orderBy('users.name', $order);
                    })
                    ->editColumn('dealer', function ($obj) use ($can_read_user) {
                        if ($can_read_user) {
                            return '<a class="btn btn-update-user text-primary text-start" data-id="' . $obj->dealer_id . '">' . $obj->_dealer->fullName . '</a>';
                        }
                        return '<span class="fw-bold">' . $obj->_dealer->name . '</span>';
                    })
                    ->filterColumn('dealer', function ($query, $keyword) {
                        $query->whereHas('dealer', function ($query) use ($keyword) {
                            $query->where('users.name', 'like', "%" . $keyword . "%")
                                ->orWhere('users.phone', 'like', "%" . $keyword . "%");
                        });
                    })
                    ->orderColumn('dealer', function ($query, $order) {
                        $query->join('users', 'orders.dealer_id', '=', 'users.id')
                            ->orderBy('users.name', $order);
                    })
                    ->addColumn('branch', function ($obj) use ($can_update_branch) {
                        if ($can_update_branch) {
                            return '<a class="btn btn-update-branch text-primary text-start" data-id="' . $obj->branch_id . '">' . $obj->_branch->fullName . '</a>';
                        }
                        return '<span class="fw-bold">' . $obj->_branch->name . '</span>';
                    })
                    ->filterColumn('branch', function ($query, $keyword) {
                        $query->whereHas('branch', function ($query) use ($keyword) {
                            $query->where('branches.name', 'like', "%" . $keyword . "%");
                        });
                    })
                    ->addColumn('paid', function ($obj) {
                        if ($obj->total > $obj->paid) {
                            $color = 'error';
                            $minus = 'Thiếu ' . number_format($obj->total - $obj->paid);
                        } elseif ($obj->total < $obj->paid) {
                            $color = 'success';
                            $minus = 'Thừa ' . number_format($obj->paid - $obj->total);
                        } else {
                            $color = 'primary';
                            $minus = 'Thu đủ';
                        }
                        return '<div class="row justify-content-end">
                            <div class="col-6 border-end text-' . $color . '"><a data-bs-toggle="tooltip" data-bs-title="' . $minus . '">' . number_format($obj->paid) . '</a></div>
                            <div class="col-auto fw-bold">' . number_format($obj->total) . '</div>
                        </div>';
                    })
                    ->filterColumn('paid', function ($query, $keyword) {
                        $query->where('total', 'like', "%" . $keyword . "%");
                    })
                    ->editColumn('status', function ($obj) {
                        return '<span class="badge bg-' . $obj->statusStr['color'] . '">' . $obj->statusStr['string'] . '</span>';
                    })
                    ->orderColumn('status', function ($query, $order) {
                        $query->orderBy('status', $order);
                    })
                    ->filterColumn('status', function ($query, $keyword) {
                        $statusMap = [
                            'hoàn thành' => 3,
                            'đang xử lý' => 2,
                            'hàng đợi' => 1,
                            'bị hủy' => 0,
                        ];
                        if (isset($statusMap[Str::lower($keyword)])) {
                            $query->where('status', $statusMap[Str::lower($keyword)]);
                        }
                    })
                    ->addColumn('action', function ($obj) use ($can_delete_order, $can_create_transaction) {
                        if ($can_create_transaction) {
                            if ($obj->total > $obj->paid) {
                                $btnTransaction = '<button
                                                    type="button"
                                                    class="btn btn-link text-decoration-none btn-create-transaction text-danger"
                                                    data-bs-toggle="tooltip" data-bs-title="Thiếu ' . number_format($obj->total - $obj->paid) . '"
                                                    data-order="' . $obj->id . '"
                                                    data-customer="' . $obj->_customer_id . '"
                                                    data-amount="' . ($obj->total - $obj->paid) . '">
                                                            <i class="bi bi-coin"></i>
                                                    </button>';
                            } elseif ($obj->total < $obj->paid) {
                                $btnTransaction = '<button
                                                    type="button"
                                                    class="btn btn-link text-decoration-none btn-create-transaction text-success"
                                                    data-bs-toggle="tooltip" data-bs-title="Thừa ' . number_format($obj->paid - $obj->total) . '"
                                                    data-order="' . $obj->id . '"
                                                    data-customer="' . $obj->_customer_id . '"
                                                    data-amount="' . ($obj->total - $obj->paid) . '">
                                                            <i class="bi bi-coin"></i>
                                                    </button>';
                            } else {
                                $btnTransaction = '';
                            }
                        }
                        if ($can_delete_order) {
                            return $btnTransaction . '
                                <form action="' . route('admin.order.remove') . '" method="post" class="save-form d-inline-block">
                                    <input type="hidden" name="_token" value="' . csrf_token() . '"/>
                                    <input type="hidden" name="choices[]" value="' . $obj->id . '" data-id="'  . $obj->id . '"/>
                                    <button class="btn btn-link text-decoration-none btn-remove">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </form>';
                        }
                    })
                    ->rawColumns(['checkboxes', 'code', 'customer', 'sku', 'paid', 'branch', 'dealer', 'catalogue', 'status', 'action'])
                    ->setTotalRecords($objs->count())
                    ->make(true);
            } else {
                $pageName = 'Quản lý ' . self::NAME;
                return view('admin.orders', compact('pageName'));
            }
        }
    }

    public function create(Request $request)
    {
        $rules = [
            //Đơn hàng
            'customer_id' => [
                'numeric'
            ],
            'discount' => ['nullable', 'numeric'],
            'note' => ['nullable', 'string', 'max:125'],
            'id' => ['nullable', 'numeric'],

            //Chi tiết đơn hàng
            'prices' => ['required', 'array'],
            'discounts' => ['required', 'array'],
            'quantities' => ['required', 'array'],
            'notes' => ['array'],
            'ids' => ['array'],

            'prices.*' => ['required', 'numeric'],
            'discounts.*' => ['nullable', 'numeric'],
            'quantities.*' => ['required', 'numeric', 'min:0'],
            'notes.*' => ['nullable', 'string', 'max:125'],
            'ids.*' => ['nullable', 'numeric'],

            //Thanh toán
            'transaction_payments' => ['nullable', 'array'],
            'transaction_amounts' => ['nullable', 'array'],
            'transaction_payments.*' => ['required', 'numeric'],
            'transaction_amounts.*' => ['required', 'numeric'],
        ];
        $messages = [
            //Đơn hàng
            'customer_id.numeric' => 'Khách hàng: ' . Controller::DATA_INVALID,
            'discount.numeric' => 'Giảm giá đơn hàng: ' . Controller::DATA_INVALID,
            'note.string' => 'Ghi chú đơn hàng: ' . Controller::DATA_INVALID,
            'note.max' => 'Ghi chú đơn hàng: ' . Controller::MAX,
            'id.numeric' => 'Mã đơn hàng: ' . Controller::DATA_INVALID,

            //Chi tiết đơn hàng
            'unit_ids.required' => 'Mã đơn vị tính: ' . Controller::ONE_LEAST,
            'unit_ids.array' => 'Mã đơn vị tính: ' . Controller::DATA_INVALID,
            'prices.required' => 'Đơn giá hàng hóa: ' . Controller::ONE_LEAST,
            'prices.array' => 'Đơn giá hàng hóa: ' . Controller::DATA_INVALID,
            'discounts.required' => 'Giảm giá hàng hóa: ' . Controller::ONE_LEAST,
            'discounts.array' => 'Giảm giá hàng hóa: ' . Controller::DATA_INVALID,
            'quantities.required' => 'Số lượng hàng hóa: ' . Controller::ONE_LEAST,
            'quantities.array' => 'Số lượng hàng hóa: ' . Controller::DATA_INVALID,
            'rates.required' => 'Đơn vị tính hàng hóa: ' . Controller::ONE_LEAST,
            'rates.array' => 'Đơn vị tính hàng hóa: ' . Controller::DATA_INVALID,
            'notes.array' => 'Ghi chú hàng hóa: ' . Controller::DATA_INVALID,
            'ids.required' => 'Mã chi tiết đơn hàng: ' . Controller::ONE_LEAST,
            'ids.array' => 'Mã chi tiết đơn hàng: ' . Controller::DATA_INVALID,

            'unit_ids.*.required' => 'Mã đơn vị tính: ' . Controller::DATA_INVALID,
            'unit_ids.*.numeric' => 'Mã đơn vị tính: ' . Controller::DATA_INVALID,
            'prices.*.required' => 'Đơn giá hàng hóa: ' . Controller::DATA_INVALID,
            'prices.*.numeric' => 'Đơn giá hàng hóa: ' . Controller::DATA_INVALID,
            'discounts.*.numeric' => 'Giảm giá hàng hóa: ' . Controller::DATA_INVALID,
            'quantities.*.required' => 'Số lượng hàng hóa: ' . Controller::DATA_INVALID,
            'quantities.*.numeric' => 'Số lượng hàng hóa: ' . Controller::DATA_INVALID,
            'quantities.*.min' => 'Số lượng hàng hóa: Không thể âm!',
            'rates.*.required' => 'Đơn vị tính hàng hóa: ' . Controller::DATA_INVALID,
            'rates.*.numeric' => 'Đơn vị tính hàng hóa: ' . Controller::DATA_INVALID,
            'notes.*.string' => 'Ghi chú hàng hóa: ' . Controller::DATA_INVALID,
            'ids.*.numeric' => 'Mã chi tiết đơn hàng: ' . Controller::DATA_INVALID,

            //Thanh toán
            'transaction_payments.array' => 'Hình thức thanh toán: ' . Controller::DATA_INVALID,
            'transaction_amounts.array' => 'Số tiền thanh toán: ' . Controller::DATA_INVALID,
            'transaction_refund.array' => 'Trạng thái hoàn tiền: ' . Controller::DATA_INVALID,

            'transaction_payments.*.required' => 'Hình thức thanh toán: ' . Controller::NOT_EMPTY,
            'transaction_refund.*.required' => 'Trạng thái hoàn tiền: ' . Controller::NOT_EMPTY,
            'transaction_refund.*.numeric' => 'Trạng thái hoàn tiền: ' . Controller::DATA_INVALID,
            'transaction_amounts.*.required' => 'Số tiền thanh toán: ' . Controller::NOT_EMPTY,
            'transaction_amounts.*.numeric' => 'Số tiền thanh toán: ' . Controller::DATA_INVALID,
        ];
        $request->validate($rules, $messages);

        // if (getPath(request()->headers->get('referer')) === '/quantri/order/new') {
        //     $new_rules = [
        //         'stock_ids' => ['required', 'array'],
        //         'stock_ids.*' => ['required', 'numeric'],
        //     ];
        //     $new_messages = [
        //         'stock_ids.required' => 'Hàng hóa: ' . Controller::ONE_LEAST,
        //         'stock_ids.array' => 'Hàng hóa: ' . Controller::DATA_INVALID,

        //         'stock_ids.*.required' => 'Hàng hóa: ' . Controller::DATA_INVALID,
        //         'stock_ids.*.numeric' => 'Hàng hóa: ' . Controller::DATA_INVALID,
        //     ];
        //     $request->validate($new_rules, $new_messages);
        // }

        if (!$request->filled('customer_id') && !$request->filled('id') && !$request->has('transaction_payments')) {
            return response()->json(['errors' => ['role' => ['Hãy chọn một khách hàng để lưu công nợ!']]], 422);
        }
        if (!empty($this->user->can(User::CREATE_ORDER))) {
            if ($this->user->branch) {
                if (!$request->has('id') && !$request->has('transaction_payments') && !$request->has('customer_id')) {
                    return response()->json(['errors' => ['customer_required' => ['Khách hàng: Vui lòng chọn một khách hàng để lưu công nợ!']]], 422);
                }
                DB::beginTransaction();
                try {
                    $order = Order::create([
                        'branch_id' => $this->user->main_branch,
                        'customer_id' => $request->customer_id,
                        'dealer_id' => Auth::id(),
                        'method' => 1,
                        'discount' => $request->discount ?? 0,
                        'status' => $request->has('status') ? $request->status : 0,
                        'note' => $request->note,
                    ]);
                    if ($request->has('scores')) {
                        optional($order->customer)->update(['scores' => $request->scores]);
                    }
                    if ($order) {
                        $export = Export::create([
                            'user_id' => Auth::id(),
                            'receiver_id' => Auth::id(),
                            'order_id' => $order->id,
                            'status' => 1,
                            'note' => 'Xuất theo đơn ' . $order->code,
                            'date' => date('Y-m-d'),
                        ]);

                        if ($request->has('stock_ids')) {
                            $units = Unit::withTrashed()->whereIn('id', $request->unit_ids)->get();
                            foreach ($request->stock_ids as $i => $id) {
                                $unit = $units->where('id', $request->unit_ids[$i])->first();
                                $detail = Detail::create([
                                    'order_id' => $order->id,
                                    'stock_id' => $id,
                                    'unit_id' => $unit->id,
                                    'quantity' => $request->quantities[$i],
                                    'price' => $request->prices[$i],
                                    'discount' => $request->discounts[$i],
                                    'note' => $request->notes[$i]
                                ]);
                                if ($detail) {
                                    $export_detail = ExportDetail::create([
                                        'stock_id' => $id,
                                        'export_id' => $export->id,
                                        'detail_id' => $detail->id,
                                        'unit_id' => $unit->id,
                                        'quantity' => $request->quantities[$i],
                                        'note' => 'Xuất theo đơn ' . $order->code
                                    ]);
                                    if ($export_detail) {
                                        $stock = $export_detail->_stock;
                                        $stock->decrement('quantity', $request->quantities[$i] * $unit->rate);
                                        $variable = $stock->import_detail->_variable;
                                        if ($variable->isExhausted()) {
                                            StockController::pushExhaustedNoti($stock, $variable);
                                        }
                                    }
                                }
                            }
                        }

                        if ($request->has('transaction_payments') && count($request->transaction_payments)) {
                            foreach ($request->transaction_payments as $i => $payment) {
                                $refund = $request->transaction_refund[$i] ? -1 : 1;
                                $transaction = Transaction::create([
                                    'order_id' => $order->id,
                                    'customer_id' => $request->customer_id,
                                    'cashier_id' => Auth::id(),
                                    'payment' => $request->transaction_payments[$i],
                                    'amount' => $request->transaction_amounts[$i] * $refund,
                                    'date' => Carbon::now(),
                                    'note' => $request->transaction_notes[$i] . ' - ' . $order->code,
                                ]);
                            }
                        }
                        if ($request->has('change') && $request->change > 0) {
                            $transaction = Transaction::create([
                                'order_id' => $order->id,
                                'customer_id' => $request->customer_id,
                                'cashier_id' => Auth::id(),
                                'payment' => 1,
                                'amount' => $request->change * -1,
                                'date' => Carbon::now(),
                                'note' => 'Tiền thừa đơn hàng ' . $order->code,
                            ]);
                        }
                        $order->sync_scores($order->paid);

                        LogController::create('tạo', self::NAME, $order->id);
                        $response = array(
                            'id' => $order->id,
                            'status' => 'success',
                            'msg' => 'Đã tạo ' . self::NAME . ' ' . $order->code
                        );
                        DB::commit();
                    } else {
                        return response()->json(['errors' => ['role' => ['Đã có lỗi xảy ra. Vui lòng thử lại sau!']]], 422);
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
                    Controller::resetAutoIncrement(['orders', 'details', 'imports', 'import_details', 'stocks', 'transactions']);
                    return response()->json(['errors' => ['error' => ['Đã xảy ra lỗi: ' . $e->getMessage()]]], 422);
                }
            } else {
                return response()->json(['errors' => ['branch_id' => ['Tài khoản chưa được thiết lập chi nhánh']]], 422);
            }
        } else {
            return response()->json(['errors' => ['role' => ['Thao tác chưa được cấp quyền!']]], 422);
        }
        return response()->json($response, 200);
    }

    public function update(Request $request)
    {
        $rules = [
            //Đơn hàng
            'customer_id' => [
                'numeric'
            ],
            'discount' => ['nullable', 'numeric'],
            'note' => ['nullable', 'string', 'max:125'],
            'id' => ['nullable', 'numeric'],

            //Chi tiết đơn hàng
            'stock_ids' => ['nullable', 'array'],
            'prices' => ['nullable', 'array'],
            'discounts' => ['nullable', 'array'],
            'quantities' => ['nullable', 'array'],
            'notes' => ['array'],
            'ids' => ['array'],

            'stock_ids.*' => ['required', 'numeric'],
            'prices.*' => ['required', 'numeric'],
            'discounts.*' => ['nullable', 'numeric'],
            'quantities.*' => ['required', 'numeric', 'min:0'],
            'notes.*' => ['nullable', 'string', 'max:125'],
            'ids.*' => ['nullable', 'numeric'],

            //Thanh toán
            'transaction_payments' => ['nullable', 'array'],
            'transaction_amounts' => ['nullable', 'array'],
            'transaction_payments.*' => ['required', 'numeric'],
            'transaction_amounts.*' => ['required', 'numeric'],
        ];
        $messages = [
            //Đơn hàng
            'customer_id.numeric' => 'Khách hàng: ' . Controller::DATA_INVALID,
            'discount.numeric' => 'Giảm giá đơn hàng: ' . Controller::DATA_INVALID,
            'note.string' => 'Ghi chú đơn hàng: ' . Controller::DATA_INVALID,
            'note.max' => 'Ghi chú đơn hàng: ' . Controller::MAX,
            'id.numeric' => 'Mã đơn hàng: ' . Controller::DATA_INVALID,

            //Chi tiết đơn hàng
            'stock_ids.required' => 'Hàng hóa: ' . Controller::ONE_LEAST,
            'stock_ids.array' => 'Hàng hóa: ' . Controller::DATA_INVALID,
            'unit_ids.required' => 'Mã đơn vị tính: ' . Controller::ONE_LEAST,
            'unit_ids.array' => 'Mã đơn vị tính: ' . Controller::DATA_INVALID,
            'prices.required' => 'Đơn giá hàng hóa: ' . Controller::ONE_LEAST,
            'prices.array' => 'Đơn giá hàng hóa: ' . Controller::DATA_INVALID,
            'discounts.required' => 'Giảm giá hàng hóa: ' . Controller::ONE_LEAST,
            'discounts.array' => 'Giảm giá hàng hóa: ' . Controller::DATA_INVALID,
            'quantities.required' => 'Số lượng hàng hóa: ' . Controller::ONE_LEAST,
            'quantities.array' => 'Số lượng hàng hóa: ' . Controller::DATA_INVALID,
            'rates.required' => 'Đơn vị tính hàng hóa: ' . Controller::ONE_LEAST,
            'rates.array' => 'Đơn vị tính hàng hóa: ' . Controller::DATA_INVALID,
            'notes.array' => 'Ghi chú hàng hóa: ' . Controller::DATA_INVALID,
            'ids.required' => 'Mã chi tiết đơn hàng: ' . Controller::ONE_LEAST,
            'ids.array' => 'Mã chi tiết đơn hàng: ' . Controller::DATA_INVALID,

            'stock_ids.*.required' => 'Hàng hóa: ' . Controller::DATA_INVALID,
            'stock_ids.*.numeric' => 'Hàng hóa: ' . Controller::DATA_INVALID,
            'unit_ids.*.required' => 'Mã đơn vị tính: ' . Controller::DATA_INVALID,
            'unit_ids.*.numeric' => 'Mã đơn vị tính: ' . Controller::DATA_INVALID,
            'prices.*.required' => 'Đơn giá hàng hóa: ' . Controller::DATA_INVALID,
            'prices.*.numeric' => 'Đơn giá hàng hóa: ' . Controller::DATA_INVALID,
            'discounts.*.numeric' => 'Giảm giá hàng hóa: ' . Controller::DATA_INVALID,
            'quantities.*.required' => 'Số lượng hàng hóa: ' . Controller::DATA_INVALID,
            'quantities.*.numeric' => 'Số lượng hàng hóa: ' . Controller::DATA_INVALID,
            'quantities.*.min' => 'Số lượng hàng hóa: Không thể âm!',
            'rates.*.required' => 'Đơn vị tính hàng hóa: ' . Controller::DATA_INVALID,
            'rates.*.numeric' => 'Đơn vị tính hàng hóa: ' . Controller::DATA_INVALID,
            'notes.*.string' => 'Ghi chú hàng hóa: ' . Controller::DATA_INVALID,
            'ids.*.numeric' => 'Mã chi tiết đơn hàng: ' . Controller::DATA_INVALID,

            //Thanh toán
            'transaction_payments.array' => 'Hình thức thanh toán: ' . Controller::DATA_INVALID,
            'transaction_amounts.array' => 'Số tiền thanh toán: ' . Controller::DATA_INVALID,
            'transaction_refund.array' => 'Trạng thái hoàn tiền: ' . Controller::DATA_INVALID,

            'transaction_payments.*.required' => 'Hình thức thanh toán: ' . Controller::NOT_EMPTY,
            'transaction_refund.*.required' => 'Trạng thái hoàn tiền: ' . Controller::NOT_EMPTY,
            'transaction_refund.*.numeric' => 'Trạng thái hoàn tiền: ' . Controller::DATA_INVALID,
            'transaction_amounts.*.required' => 'Số tiền thanh toán: ' . Controller::NOT_EMPTY,
            'transaction_amounts.*.numeric' => 'Số tiền thanh toán: ' . Controller::DATA_INVALID,
        ];
        $request->validate($rules, $messages);
        if (!empty($this->user->can(User::UPDATE_ORDER))) {
            if ($request->has('id')) {
                if (!$request->has('id') && !$request->has('transaction_payments') && !$request->has('customer_id')) {
                    return response()->json(['errors' => ['customer_required' => ['Khách hàng: Vui lòng chọn một khách hàng để lưu công nợ!']]], 422);
                }
                DB::beginTransaction();
                try {
                    $order = Order::find($request->id);
                    if ($order) {
                        $order->update([
                            'customer_id' => $request->customer_id,
                            'dealer_id' => Auth::id(),
                            'method' => 1,
                            'discount' => $request->discount ?? 0,
                            'status' => $request->status ? $request->status : 0,
                            'note' => $request->note,
                        ]);
                        if ($request->has('stock_ids')) {
                            foreach (array_unique(array_filter($request->export_ids)) as $i => $id) {
                                $export = Export::updateOrCreate([
                                    'id' => $id
                                ], [
                                    'user_id' => Auth::id(),
                                    'receiver_id' => Auth::id(),
                                    'order_id' => $order->id,
                                    'status' => 1,
                                    'note' => 'Xuất theo đơn ' . $order->code,
                                    'date' => date('Y-m-d'),
                                ]);
                            }
                            $export_id = null;
                            $units = Unit::withTrashed()->whereIn('id', $request->unit_ids)->get();
                            foreach ($request->stock_ids as $i => $id) {
                                $unit = $units->where('id', $request->unit_ids[$i])->first();
                                $detail = Detail::updateOrCreate([
                                    'id' => $request->ids[$i]
                                ], [
                                    'order_id' => $order->id,
                                    'stock_id' => $request->stock_ids[$i],
                                    'unit_id' => $unit->id,
                                    'quantity' => $request->quantities[$i],
                                    'price' => $request->prices[$i],
                                    'discount' => $request->discounts[$i],
                                    'note' => $request->notes[$i]
                                ]);
                                $export_id = $request->export_ids[$i] ? $request->export_ids[$i] : $export_id;
                                if (!$export_id) {
                                    $export = Export::create([
                                        'user_id' => Auth::id(),
                                        'receiver_id' => Auth::id(),
                                        'order_id' => $order->id,
                                        'status' => 1,
                                        'note' => 'Xuất theo đơn ' . $order->code,
                                        'date' => date('Y-m-d'),
                                    ]);
                                    $export_id = $export->id;
                                }
                                $old = $detail->export_detail ? ExportDetail::find($detail->export_detail->id) : 0;
                                $export_detail = ExportDetail::updateOrCreate([
                                    'id' => $detail->export_detail ? $detail->export_detail->id : null
                                ], [
                                    'stock_id' => $request->stock_ids[$i],
                                    'export_id' => $export_id,
                                    'detail_id' => $detail->id,
                                    'unit_id' => $unit->id,
                                    'quantity' => $request->quantities[$i],
                                    'note' => 'Xuất theo đơn ' . $order->id
                                ]);
                                if ($export_detail) {
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
                        if ($request->has('transaction_payments') && count($request->transaction_payments)) {
                            foreach ($request->transaction_payments as $i => $payment) {
                                $refund = $request->transaction_refund[$i] ? -1 : 1;
                                $transaction = Transaction::create([
                                    'order_id' => $order->id,
                                    'customer_id' => $request->customer_id,
                                    'cashier_id' => Auth::id(),
                                    'payment' => $request->transaction_payments[$i],
                                    'amount' => $request->transaction_amounts[$i] * $refund,
                                    'date' => Carbon::now(),
                                    'note' => $request->transaction_notes[$i] . ' - ' . $order->code,
                                ]);
                                $order->sync_scores($transaction->amount);
                            }
                        }
                        $order->update(['total' => $order->total()]);
                        LogController::create('sửa', self::NAME, $order->id);
                        $response = array(
                            'id' => $order->id,
                            'status' => 'success',
                            'msg' => 'Đã cập nhật ' . self::NAME . ' ' . $order->code
                        );
                        DB::commit();
                    } else {
                        DB::rollBack();
                        $response = [
                            'status' => 'error',
                            'msg' => 'Đã có lỗi xảy ra, vui lòng tải lại trang và thử lại!',
                        ];
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
                    Controller::resetAutoIncrement(['orders', 'details', 'imports', 'import_details', 'stocks']);
                    return response()->json(['errors' => ['error' => ['Đã xảy ra lỗi: ' . $e]]], 422);
                }
            } else {
                $response = [
                    'status' => 'error',
                    'msg' => 'Đã có lỗi xảy ra, vui lòng tải lại trang và thử lại!',
                ];
            }
        } else {
            return response()->json(['errors' => ['role' => ['Thao tác chưa được cấp quyền!']]], 422);
        }
        return response()->json($response, 200);
    }

    public function remove(Request $request)
    {
        $orders = [];
        foreach ($request->choices as $key => $id) {
            $obj = Order::find($id);
            if ($obj && $obj->status < 3) {
                DB::beginTransaction();
                try {
                    $obj->details->each(function ($detail) {
                        if ($detail->stock_id) {
                            $export_detail = $detail->export_detail;
                            if ($export_detail) {
                                $export_detail->_stock->increment('quantity', $export_detail->_unit->rate * $export_detail->quantity);
                                $export_detail->update(['quantity' => 0]);
                                $export_detail->delete();
                            }
                            $detail->update(['quantity' => 0]);
                            $detail->delete();
                        }
                    });
                    $obj->exports->each(function ($export) {
                        if (!$export->export_details->count()) {
                            $export->delete();
                        } else {
                            DB::rollBack();
                        }
                    });
                    $obj->sync_scores($obj->total);
                    $obj->delete();
                    DB::commit();
                    array_push($orders, $obj->code);
                } catch (\Exception $e) {
                    DB::rollBack();
                    Log::error(
                        'Có lỗi xảy ra: ' . $e->getMessage() . ';' . PHP_EOL .
                            'URL truy vấn: "' . request()->fullUrl() . '";' . PHP_EOL .
                            'Dữ liệu nhận được: ' . json_encode(request()->all()) . ';' . PHP_EOL .
                            'User ID: ' . (Auth::check() ? Auth::id() : 'Khách') . ';' . PHP_EOL .
                            'Chi tiết lỗi: ' . $e->getTraceAsString()
                    );
                    Controller::resetAutoIncrement(['imports', 'import_details', 'stocks', 'exports', 'export_details']);
                    return response()->json(['errors' => ['error' => ['Đã xảy ra lỗi: ' . $e->getMessage()]]], 422);
                }
            } else {
                return response()->json(['errors' => ['message' => ['Không thể xóa đơn hàng đã hoàn thành']]], 422);
            }
        }
        $response = array(
            'status' => 'success',
            'msg' => 'Đã xóa đơn hàng ' . implode(', ', $orders)
        );
        return  response()->json($response, 200);
    }
}
