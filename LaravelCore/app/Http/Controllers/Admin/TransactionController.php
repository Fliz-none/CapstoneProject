<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TransactionController extends Controller
{
    const NAME = 'Transaction';
    const RULES = [
        'note' => ['required', 'string', 'min:2', 'max:125'],
        'customer_id' => ['required_without:order_id', 'numeric'],
        'order_id' => ['nullable', 'numeric'],
        'cashier_id' => ['required', 'numeric'],
        'payment' => ['required', 'numeric'],
        'amount' => ['required', 'numeric'],
        'status' => ['required', 'string'],
    ];

    public static array $MESSAGES = [];


    protected $zalo;
    public function __construct()
    {

        parent::__construct();
        if ($this->user === null) {
            $this->user = Auth::user();
        }

        $this->middleware(['admin', 'auth']);
        $this->middleware(function ($request, $next) {
        // Locale đã được set xong ở đây
        Controller::init(); // Gán các biến tĩnh ở đây

        self::$MESSAGES = [
            'note.required' => Controller::$NOT_EMPTY,
            'note.string' => Controller::$DATA_INVALID,
            'note.min' => Controller::$MIN,
            'note.max' => Controller::$MAX,
            'customer_id.required_without' => __('messages.transaction.required_without'),
            'cashier_id.required' => Controller::$NOT_EMPTY,
            'payment.required' => Controller::$NOT_EMPTY,
            'amount.required' => Controller::$NOT_EMPTY,
            'status.required' => Controller::$NOT_EMPTY,
            'customer_id.numeric' => Controller::$DATA_INVALID,
            'cashier_id.numeric' => Controller::$DATA_INVALID,
            'payment.numeric' => Controller::$DATA_INVALID,
            'amount.numeric' => Controller::$DATA_INVALID,
            'status.string' => Controller::$DATA_INVALID,
        ];

        return $next($request);
    });
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        Controller::init();
        if (isset($request->key)) {
            switch ($request->key) {
                case 'amountOfDate':
                    if ($request->date) {
                        $cash = Transaction::whereDate('date', $request->date)
                            ->where('payment', '<=', 1)
                            ->sum('amount');
                        $transfer = Transaction::whereDate('date', $request->date)
                            ->where('payment', '>', 1)
                            ->sum('amount');
                        $result = [$request->date, $cash, $transfer];
                    }
                    break;
                case 'list':
                    # code...
                    break;

                default:
                    $obj = Transaction::with('_customer')->find($request->key);
                    if ($obj) {
                        switch ($request->action) {
                            case 'print':
                                return view('admin.templates.prints.transaction_a5', ['transaction' => $obj]);
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
                $totalOrder = 0;
                if ($request->has('order_id')) {
                    $order = Order::find($request->order_id);
                    if ($order) {
                        $totalOrder = $order->total;
                    }
                }
                $objs = Transaction::with('_customer', '_cashier', '_order.details', '_order.transactions')
                    ->whereHas('order', function ($query) use ($request) {
                        $query->when($request->has('branch_id'), function ($query) use ($request) {
                            $query->where('branch_id', $request->branch_id);
                        }, function ($query) use ($request) {
                            $query->whereIn('branch_id', Auth::user()->branches->pluck('id'));
                        });
                    })->when($request->has('order_id'), function ($query) use ($request) {
                        $query->where('order_id', $request->order_id);
                    });

                return DataTables::of($objs)
                    ->addColumn('checkboxes', function ($obj) {
                        return '<input class="form-check-input choice" type="checkbox" name="choices[]" value="' . $obj->id . '">';
                    })
                    ->addColumn('code', function ($obj) {
                        if (!empty($this->user->can(User::READ_ORDER))) {
                            $code = '<a class="btn btn-update-transaction text-primary fw-bold p-0" data-id="' . $obj->id . '">' . $obj->code . '</a>';
                        } else {
                            $code =  '<span class="fw-bold">' . $obj->code . '</span>';
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
                                $query->where('transactions.id', 'like', "%" . $numericKeyword . "%");
                            }
                        });
                    })
                    ->orderColumn('code', function ($query, $order) {
                        $query->orderBy('id', $order);
                    })
                    ->editColumn('note', function ($obj) {
                        if (!empty($this->user->can(User::READ_TRANSACTION))) {
                            return '<a class="btn btn-link text-decoration-none text-start btn-update-transaction" data-id="' . $obj->id . '">' . $obj->note . '</a>';
                        } else {
                            return $obj->note;
                        }
                    })
                    ->addColumn('order', function ($obj) {
                        if (!empty($this->user->can(User::READ_ORDER))) {
                            return '<a class="btn btn-link text-decoration-none text-start btn-preview preview-order" data-url="' . getPath(route('admin.order')) . '" data-id="' . $obj->order_id . '">Order ' . $obj->order_id . '</a>';
                        } else {
                            return $obj->order_id;
                        }
                    })
                    ->filterColumn('order', function ($query, $keyword) {
                        $query->where('order_id', 'like', "%{$keyword}%");
                    })
                    ->editColumn('payment', function ($obj) {
                        return $obj->paymentStr;
                    })
                    ->addColumn('customer', function ($obj) {
                        if ($obj->customer_id) {
                            if (!empty($this->user->can(User::READ_USER))) {
                                return '<a class="btn btn-link text-decoration-none text-start btn-update-user" data-id="' . $obj->_customer->id . '">' . $obj->_customer->fullName . '</a>';
                            } else {
                                return $obj->_customer->fullName;
                            }
                        } else {
                            return __('messages.unknown');
                        }
                    })
                    ->filterColumn('customer', function ($query, $keyword) {
                        $query->whereHas('_customer', function ($query) use ($keyword) {
                            $query->where('name', 'like', "%" . $keyword . "%");
                        });
                    })
                    ->addColumn('cashier', function ($obj) {
                        if (!empty($this->user->can(User::READ_USER))) {
                            return '<a class="btn btn-link text-decoration-none text-start btn-update-user" data-id="' . $obj->_cashier->id . '">' . $obj->_cashier->fullName . '</a>';
                        } else {
                            return $obj->_cashier->fullName;
                        }
                    })
                    ->filterColumn('cashier', function ($query, $keyword) {
                        $query->whereHas('cashier', function ($query) use ($keyword) {
                            $query->where('users.name', 'like', "%" . $keyword . "%");
                        });
                    })
                    ->addColumn('amount', function ($obj) {
                        return number_format($obj->amount) . 'đ';
                    })
                    ->addColumn('cash', function ($obj) {
                        if ($obj->payment <= 1) {
                            $transaction_day = Carbon::parse($obj->created_at)->startOfDay();
                            $order_day = Carbon::parse($obj->_order->created_at)->startOfDay();
                            $result = $obj->fullAmount . '<br>
                            <input type="hidden" data-date="' . $obj->created_at->format('d/m/Y') . '" data-payment="' . $obj->payment . '" value="' . $obj->amount . '">';
                        } else {
                            $result = '';
                        }
                        return $result;
                    })
                    ->filterColumn('cash', function ($query, $keyword) {
                        $query->where('amount', 'like', "%" . $keyword . "%");
                    })
                    ->addColumn('transfer', function ($obj) {
                        if ($obj->payment > 1) {
                            $transaction_day = Carbon::parse($obj->created_at)->startOfDay();
                            $order_day = Carbon::parse($obj->_order->created_at)->startOfDay();
                            $result = $obj->fullAmount . '<br>
                            <input type="hidden" data-date="' . $obj->created_at->format('d/m/Y') . '" data-payment="' . $obj->payment . '" value="' . $obj->amount . '">';
                        } else {
                            $result = '';
                        }
                        return $result;
                    })
                    ->filterColumn('transfer', function ($query, $keyword) {
                        $query->where('amount', 'like', "%" . $keyword . "%");
                    })
                    ->editColumn('status', function ($obj) {
                        return $obj->statusStr;
                    })
                    ->filterColumn('status', function ($query, $keyword) {
                        $query->when(str_contains('payment', $keyword), function ($query) {
                            $query->where('amount', '>=', 0);
                        });
                        $query->when(str_contains('transfer', $keyword), function ($query) {
                            $query->where('amount', '<', 0);
                        });
                    })
                    ->addColumn('action', function ($obj) {
                        if (!empty($this->user->can(User::DELETE_TRANSACTION))) {
                            $str = '
                                <form action="' . route('admin.transaction.remove') . '" method="post" class="save-form">
                                    <input type="hidden" name="_token" value="' . csrf_token() . '"/>
                                    <input type="hidden" name="choices[]" value="' . $obj->id . '" data-id="'  . $obj->id . '"/>
                                    <button type="submit" class="btn btn-link text-decoration-none btn-remove">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </form>';
                            return $str;
                        }
                    })
                    ->rawColumns(['checkboxes', 'code', 'note', 'order', 'customer', 'cashier', 'cash', 'transfer', 'status', 'action'])
                    ->with('totalAmount', $objs->sum('amount'))
                    ->with('totalOrder', $totalOrder)
                    ->setTotalRecords($objs->count())
                    ->make(true);
            } else {
                $pageName = self::NAME . ' management';
                return view('admin.transactions', compact('pageName'));
            }
        }
    }

    public function create(Request $request)
    {
        //dd(app()->getLocale());
        Controller::init();
        $request->validate(self::RULES, self::$MESSAGES);
        if (!empty($this->user->can(User::CREATE_TRANSACTION))) {
            if ($request->has('order_id') && $request->order_id != null) {
                DB::beginTransaction();
                try {
                    $status = $request->status == 'pay' ? 1 : -1;
                    $transaction = Transaction::create([
                        'order_id' => $request->order_id,
                        'customer_id' => $request->customer_id,
                        'cashier_id' => $request->cashier_id,
                        'payment' => $request->payment,
                        'amount' => $request->amount * $status,
                        'note' => $request->note,
                        'date' => Carbon::now(),
                    ]);
                    $transaction->order->sync_scores($transaction->amount);

                    $response = array(
                        'status' => 'success',
                        'msg' => 'Transaction added successfully: ' . $transaction->id
                    );
                    DB::commit();
                } catch (\Exception $e) {
                    DB::rollBack();
                    log_exception($e);
                    return response()->json(['errors' => ['error' => ['An error occurred: ' . $e->getMessage()]]], 422);
                }
            } else {
                DB::beginTransaction();
                try {
                    $customer = User::find($request->customer_id);
                    if ($customer) {
                        $debtOrders = $customer->debtOrders();
                        $totalAmount = $request->amount;
                        $ids = [];
                        foreach ($debtOrders as $key => $order) {
                            if ($totalAmount > 0) {
                                $amount = $order->total - $order->paid < $totalAmount ? $order->total - $order->paid : $totalAmount;
                                $transaction = Transaction::create([
                                    'order_id' => $order->id,
                                    'customer_id' => $request->customer_id,
                                    'cashier_id' => $request->cashier_id,
                                    'payment' => $request->payment,
                                    'amount' => $amount,
                                    'date' => Carbon::now(),
                                    'note' => $request->note,
                                ]);
                                $order->sync_scores($transaction->amount);

                                $totalAmount -= $amount;
                                array_push($ids, $order->id);
                            }
                        }

                        $response = array(
                            'status' => 'success',
                            'msg' => __('messages.created') . implode(', ', $ids)
                        );
                        DB::commit();
                    } else {
                        return response()->json(['errors' => ['role' => ['User does not exist!']]], 422);
                    }
                } catch (\Exception $e) {
                    DB::rollBack();
                    log_exception($e);
                    Controller::resetAutoIncrement(['transactions']);
                    return response()->json(['errors' => ['error' => ['An error occurred: ' . $e->getMessage()]]], 422);
                }
            }
            return response()->json($response, 200);
        } else {
            return response()->json(['errors' => ['role' => ['You do not have permission!']]], 422);
        }
    }

    public function update(Request $request)
    {
         Controller::init();
        $request->validate(self::RULES, self::$MESSAGES);
        if (!empty($this->user->can(User::UPDATE_TRANSACTION))) {
            if ($request->has('id')) {
                try {
                    DB::beginTransaction();
                    $status = $request->status == 'pay' ? 1 : -1;
                    $transaction = Transaction::find($request->id);
                    $transaction->order->sync_scores($request->amount * $status - $transaction->amount);
                    if ($transaction) {
                        $transaction->update([
                            'order_id' => $request->order_id,
                            'customer_id' => $request->customer_id,
                            'cashier_id' => $request->cashier_id,
                            'payment' => $request->payment,
                            'amount' => $request->amount * $status,
                            'note' => $request->note,
                        ]);

                        $response = array(
                            'status' => 'success',
                            'msg' => 'Transaction updated successfully: ' . $transaction->id
                        );
                        DB::commit();
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
                    Controller::resetAutoIncrement(['transactions']);
                    return response()->json(['errors' => ['error' => ['An error occurred: ' . $e->getMessage()]]], 422);
                }
                return response()->json($response, 200);
            } else {
                return response()->json(['errors' => ['role' => ['An error occurred, please reload the page and try again!']]], 422);
            }
        } else {
            return response()->json(['errors' => ['role' => ['You do not have permission!']]], 422);
        }
    }

    public function remove(Request $request)
    {
        $success = [];
        if ($this->user->can(User::DELETE_SUPPLIER)) {
            foreach ($request->choices as $key => $id) {
                $obj = Transaction::with('order')->find($id);
                $obj->order->sync_scores($obj->amount * -1);
                $obj->delete();
                array_push($success, $obj->name);
            }
            $msg = '';
            if (count($success)) {
                $msg .= 'Deleted ' . self::NAME . ' ' . implode(', ', $success) . '. ';
            }
            $response = array(
                'status' => 'success',
                'msg' => $msg
            );
        } else {
            return response()->json(['errors' => ['role' => ['You do not have permission!']]], 422);
        }
        return response()->json($response, 200);
    }
}
