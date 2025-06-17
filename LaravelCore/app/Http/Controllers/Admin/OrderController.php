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
    const NAME = 'Order';

    public function __construct()
    {
        
        Controller::init();
        //dd(app()->getLocale()); 
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
                            $code .= $obj->discount || $obj->details->where('discount', '!=', 0)->count() ? '<small><i class="bi bi-info-circle text-danger" data-bs-toggle="tooltip" data-bs-title="Order with price adjustment"></i></small>' : '';
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
                                return '<span class="px-3">' . __('messages.unknown') . '</span>';

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
                            $minus = 'Short ' . number_format($obj->total - $obj->paid);
                        } elseif ($obj->total < $obj->paid) {
                            $color = 'success';
                            $minus = 'Excess ' . number_format($obj->paid - $obj->total);
                        } else {
                            $color = 'primary';
                            $minus = __('messages.pay_in_full');
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
                            __('messages.complete') => 3,
                            __('messages.processing') => 2,
                            __('messages.queued') => 1,
                            __('messages.cancel') => 0,
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
                $pageName = self::NAME . ' management';
                return view('admin.orders', compact('pageName'));
            }
        }
    }

    public function create(Request $request)
    {
        Controller::init();
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
            // Order
            'customer_id.numeric' => __('messages.order_controller.customer').': ' . Controller::$DATA_INVALID,
            'discount.numeric' =>  __('messages.order_controller.discount').': ' . Controller::$DATA_INVALID,
            'note.string' =>  __('messages.order_controller.order_note').': ' . Controller::$DATA_INVALID,
            'note.max' =>  __('messages.order_controller.order_note').': ' . Controller::$MAX,
            'id.numeric' =>  __('messages.order_controller.order').': ' . Controller::$DATA_INVALID,

            // Order Details
            'unit_ids.required' => __('messages.order_controller.unit').': ' . Controller::$ONE_LEAST,
            'unit_ids.array' => __('messages.order_controller.unit').': ' . Controller::$DATA_INVALID,
            'prices.required' => __('messages.order_controller.product_price').': ' . Controller::$ONE_LEAST,
            'prices.array' => __('messages.order_controller.product_price').': ' . Controller::$DATA_INVALID,
            'discounts.required' => __('messages.order_controller.product_discount').': ' . Controller::$ONE_LEAST,
            'discounts.array' => __('messages.order_controller.product_discount').': ' . Controller::$DATA_INVALID,
            'quantities.required' => __('messages.order_controller.product_quantity').': ' . Controller::$ONE_LEAST,
            'quantities.array' => __('messages.order_controller.product_quantity').': ' . Controller::$DATA_INVALID,
            'rates.required' => __('messages.order_controller.unit_rate').': ' . Controller::$ONE_LEAST,
            'rates.array' => __('messages.order_controller.unit_rate').': ' . Controller::$DATA_INVALID,
            'notes.array' => __('messages.order_controller.product_note').': ' . Controller::$DATA_INVALID,
            'ids.required' => __('messages.order_controller.order_detail').': ' . Controller::$ONE_LEAST,
            'ids.array' => __('messages.order_controller.order_detail').': ' . Controller::$DATA_INVALID,

            'unit_ids.*.required' => __('messages.order_controller.unit').': ' . Controller::$DATA_INVALID,
            'unit_ids.*.numeric' => __('messages.order_controller.unit').': ' . Controller::$DATA_INVALID,
            'prices.*.required' => __('messages.order_controller.product_price').': ' . Controller::$DATA_INVALID,
            'prices.*.numeric' => __('messages.order_controller.product_price').': ' . Controller::$DATA_INVALID,
            'discounts.*.numeric' => __('messages.order_controller.product_discount').': ' . Controller::$DATA_INVALID,
            'quantities.*.required' => __('messages.order_controller.product_quantity').': ' . Controller::$DATA_INVALID,
            'quantities.*.numeric' => __('messages.order_controller.product_quantity').': ' . Controller::$DATA_INVALID,
            'quantities.*.min' => __('messages.order.min_product'),
            'rates.*.required' => __('messages.order_controller.unit_rate').': ' . Controller::$DATA_INVALID,
            'rates.*.numeric' => __('messages.order_controller.unit_rate').': ' . Controller::$DATA_INVALID,
            'notes.*.string' => __('messages.order_controller.product_note').': ' . Controller::$DATA_INVALID,
            'ids.*.numeric' => __('messages.order_controller.order_detail').': ' . Controller::$DATA_INVALID,

            // Payment
            'transaction_payments.array' => __('messages.order_controller.payment_method').': ' . Controller::$DATA_INVALID,
            'transaction_amounts.array' => __('messages.order_controller.payment_amount').': ' . Controller::$DATA_INVALID,
            'transaction_refund.array' => __('messages.order_controller.status').': ' . Controller::$DATA_INVALID,

            'transaction_payments.*.required' => __('messages.order_controller.payment_method').': ' . Controller::$NOT_EMPTY,
            'transaction_refund.*.required' => __('messages.order_controller.status').': ' . Controller::$NOT_EMPTY,
            'transaction_refund.*.numeric' => __('messages.order_controller.status').': ' . Controller::$DATA_INVALID,
            'transaction_amounts.*.required' => __('messages.order_controller.payment_amount').': ' . Controller::$NOT_EMPTY,
            'transaction_amounts.*.numeric' => __('messages.order_controller.payment_amount').': ' . Controller::$DATA_INVALID,
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
            return response()->json(['errors' => ['role' => [__('messages.order.customer_required')]]], 422);
        }
        if (!empty($this->user->can(User::CREATE_ORDER))) {
            if ($this->user->branch) {
                if (!$request->has('id') && !$request->has('transaction_payments') && !$request->has('customer_id')) {
                    return response()->json(['errors' => ['customer_required' => [__('messages.order.customer_required')]]], 422);
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
                            'note' => 'Export for ' . $order->code,
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
                                        'note' => 'Export for ' . $order->code
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
                                'note' => 'Remaining money for order ' . $order->code,
                            ]);
                        }
                        $order->sync_scores($order->paid);

                        $response = array(
                            'id' => $order->id,
                            'status' => 'success',
                            'msg' => __('messages.created') .' '. $order->code
                        );
                        DB::commit();
                    } else {
                        return response()->json(['errors' => ['role' => [__('messages.msg')]]], 422);
                    }
                } catch (\Exception $e) {
                    DB::rollBack();
                    log_exception($e);
                    Controller::resetAutoIncrement(['orders', 'details', 'imports', 'import_details', 'stocks', 'transactions']);
                    return response()->json(['errors' => ['error' => [__('messages.error') . $e->getMessage()]]], 422);
                }
            } else {
                return response()->json(['errors' => ['branch_id' => [__('messages.role')]]], 422);
            }
        } else {
            return response()->json(['errors' => ['role' => [__('messages.role')]]], 422);
        }
        return response()->json($response, 200);
    }

    public function update(Request $request)
    {
        Controller::init();
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
            // Order
            'customer_id.numeric' => __('messages.order_controller.customer').': ' . Controller::$DATA_INVALID,
            'discount.numeric' => __('messages.order_controller.order_discount').': ' . Controller::$DATA_INVALID,
            'note.string' => __('messages.order_controller.order_note').': ' . Controller::$DATA_INVALID,
            'note.max' => __('messages.order_controller.order_note').': ' . Controller::$MAX,
            'id.numeric' =>  __('messages.order_controller.order').': ' . Controller::$DATA_INVALID,

            // Order Details
            'stock_ids.required' => __('messages.order_controller.product').': ' . Controller::$ONE_LEAST,
            'stock_ids.array' => __('messages.order_controller.product').': ' . Controller::$DATA_INVALID,
            'unit_ids.required' => __('messages.order_controller.unit') .': ' . Controller::$ONE_LEAST,
            'unit_ids.array' => __('messages.order_controller.unit') .': ' . Controller::$DATA_INVALID,
            'prices.required' => __('messages.order_controller.product_price') .': ' . Controller::$ONE_LEAST,
            'prices.array' => __('messages.order_controller.product_price') .': ' . Controller::$DATA_INVALID,
            'discounts.required' => __('messages.order_controller.product_discount') .': ' . Controller::$ONE_LEAST,
            'discounts.array' => __('messages.order_controller.product_discount') .': ' . Controller::$DATA_INVALID,
            'quantities.required' => __('messages.order_controller.product_quantity') .': ' . Controller::$ONE_LEAST,
            'quantities.array' => __('messages.order_controller.product_quantity') .': ' . Controller::$DATA_INVALID,
            'rates.required' => __('messages.order_controller.unit_rate') .': ' . Controller::$ONE_LEAST,
            'rates.array' => __('messages.order_controller.unit_rate') .': ' . Controller::$DATA_INVALID,
            'notes.array' => __('messages.order_controller.product_note').': ' . Controller::$DATA_INVALID,
            'ids.required' => __('messages.order_controller.order_detail') .': ' . Controller::$ONE_LEAST,
            'ids.array' => __('messages.order_controller.order_detail') .': ' . Controller::$DATA_INVALID,

            'stock_ids.*.required' => __('messages.order_controller.product').': ' . Controller::$DATA_INVALID,
            'stock_ids.*.numeric' => __('messages.order_controller.product').': ' . Controller::$DATA_INVALID,
            'unit_ids.*.required' => __('messages.order_controller.unit') .': ' . Controller::$DATA_INVALID,
            'unit_ids.*.numeric' => __('messages.order_controller.unit') .': ' . Controller::$DATA_INVALID,
            'prices.*.required' => __('messages.order_controller.product_price') .': ' . Controller::$DATA_INVALID,
            'prices.*.numeric' => __('messages.order_controller.product_price') .': ' . Controller::$DATA_INVALID,
            'discounts.*.numeric' => __('messages.order_controller.product_discount') .': ' . Controller::$DATA_INVALID,
            'quantities.*.required' => __('messages.order_controller.product_quantity') .': ' . Controller::$DATA_INVALID,
            'quantities.*.numeric' => __('messages.order_controller.product_quantity') .': ' . Controller::$DATA_INVALID,
            'quantities.*.min' => __('messages.order.min_product'),
            'rates.*.required' => __('messages.order_controller.unit_rate') .': ' . Controller::$DATA_INVALID,
            'rates.*.numeric' => __('messages.order_controller.unit_rate') .': ' . Controller::$DATA_INVALID,
            'notes.*.string' => __('messages.order_controller.product_note').': ' . Controller::$DATA_INVALID,
            'ids.*.numeric' => __('messages.order_controller.order_detail') .': ' . Controller::$DATA_INVALID,

            // Payment
            'transaction_payments.array' => __('messages.order_controller.payment_method').': ' . Controller::$DATA_INVALID,
            'transaction_amounts.array' => __('messages.order_controller.payment_amount').': ' . Controller::$DATA_INVALID,
            'transaction_refund.array' => __('messages.order_controller.status').': ' . Controller::$DATA_INVALID,

            'transaction_payments.*.required' => __('messages.order_controller.payment_method').': ' . Controller::$NOT_EMPTY,
            'transaction_refund.*.required' => __('messages.order_controller.status').': ' . Controller::$NOT_EMPTY,
            'transaction_refund.*.numeric' => __('messages.order_controller.status').': ' . Controller::$DATA_INVALID,
            'transaction_amounts.*.required' => __('messages.order_controller.payment_amount').': ' . Controller::$NOT_EMPTY,
            'transaction_amounts.*.numeric' => __('messages.order_controller.payment_amount').': ' . Controller::$DATA_INVALID,
        ];

        $request->validate($rules, $messages);
        if (!empty($this->user->can(User::UPDATE_ORDER))) {
            if ($request->has('id')) {
                if (!$request->has('id') && !$request->has('transaction_payments') && !$request->has('customer_id')) {
                    return response()->json(['errors' => ['customer_required' => [__('messages.order.customer_required')]]], 422);
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
                                    'note' => 'Export for ' . $order->code,
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
                                        'note' => 'Export for ' . $order->code,
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
                                    'note' => 'Export for ' . $order->id
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
                        LogController::create('2', self::NAME, $order->id);
                        $response = array(
                            'id' => $order->id,
                            'status' => 'success',
                            'msg' => __('messages.updated').' '  . $order->code
                        );
                        DB::commit();
                    } else {
                        DB::rollBack();
                        $response = [
                            'status' => 'error',
                            'msg' => __('messages.msg'),
                        ];
                    }
                } catch (\Exception $e) {
                    DB::rollBack();
                    log_exception($e);
                    Controller::resetAutoIncrement(['orders', 'details', 'imports', 'import_details', 'stocks']);
                    return response()->json(['errors' => ['error' => [__('messages.error') . $e]]], 422);
                }
            } else {
                $response = [
                    'status' => 'error',
                    'msg' => __('messages.msg'),
                ];
            }
        } else {
            return response()->json(['errors' => ['role' => [__('messages.role')]]], 422);
        }
        return response()->json($response, 200);
    }

    public function remove(Request $request)
    {
        Controller::init();
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
                    log_exception($e);
                    Controller::resetAutoIncrement(['imports', 'import_details', 'stocks', 'exports', 'export_details']);
                    return response()->json(['errors' => ['error' => [__('messages.error') . $e->getMessage()]]], 422);
                }
            } else {
                return response()->json(['errors' => ['message' => [__('messages.cannot_delete')]]], 422);
            }
        }
        $response = array(
            'status' => 'success',
            'msg' => __('messages.deleted') . implode(', ', $orders)
        );
        return  response()->json($response, 200);
    }
}
