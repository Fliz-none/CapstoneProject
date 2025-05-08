<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class DebtController extends Controller
{
    const NAME = 'đối soát';

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
            switch ($request->key) {
                case 'list':
                    # code...
                    break;

                default:
                    # code...
                    break;
            }
        } else {
            if ($request->ajax()) {
                $debts = User::with(['orders.details', 'orders.transactions'])
                    ->whereHas('orders', function ($query) use ($request) {
                        $query->when($request->has('branch_id'), function ($query) use ($request) {
                            $query->where('branch_id', $request->branch_id);
                        }, function ($query) {
                            $query->whereIn('branch_id', $this->user->branches->pluck('id'));
                        });
                    })->get()
                    ->filter(function ($user) {
                        $totalOrderValue = $user->orders->sum('total');
                        $totalPaid = $user->orders->sum('paid');
                        return $totalOrderValue != $totalPaid;
                    });
                return DataTables::of($debts)
                    ->addColumn('customer', function ($obj) {
                        if (!empty($this->user->can(User::READ_ORDER))) {
                            return '<a class="btn btn-link text-decoration-none text-start btn-update-user" data-id="' . $obj->id . '">' . $obj->fullName . '</a>';
                        } else {
                            return $obj->name;
                        }
                    })
                    ->editColumn('debt', function ($obj) {
                        $debt = $obj->getDebt();
                        return $debt < 0 ? '<span class="text-success fw-bold">+' . number_format(abs($debt)) . 'đ</span>' : '<span class="text-danger fw-bold">' . number_format(abs($debt)) . 'đ</span>';
                    })
                    ->editColumn('first_debt_order', function ($obj) {
                        $first_debt_order = $obj->orders->filter(function ($order) {
                            return $order->paid != $order->total;
                        })->sortByDesc('created_at')->first();
                        if ($first_debt_order) {
                            $result = '<a class="btn btn-link text-decoration-none text-start btn-preview preview-order" data-url="' . getPath(route('admin.order')) . '" data-id="' . $first_debt_order->id . '">' . $first_debt_order->created_at->format('d/m/Y') . ' - Đơn hàng ' . $first_debt_order->id . '</a>';
                        } else {
                            $result = 'Không xác định';
                        }
                        return $result;
                    })
                    ->addColumn('action', function ($obj) {
                        $amount = $obj->orders->sum('total') - $obj->orders->sum('discount') - $obj->orders->sum('paid');
                        $str = $obj->getDebt() > 0 ? '
                                <a class="btn btn-info text-start btn-create-transaction" data-customer="' . $obj->id . '" data-amount="' . $amount . '">
                                    <i class="bi bi-cash-coin"></i> Thanh toán
                                </a>' : '';
                        $str .= $this->user->can(User::READ_ORDERS) ? '
                                <a class="btn btn-outline-info text-start" href="' . route('admin.order', ['customer_id' => $obj->id]) . '">
                                    <i class="bi bi-receipt-cutoff"></i> Đơn hàng
                                </a>' : '';
                        return $str;
                    })
                    ->rawColumns(['customer', 'debt', 'first_debt_order', 'action'])
                    ->make(true);
            } else {
                $pageName = 'Danh sách ' . self::NAME . ' thanh toán';
                return view('admin.debts', compact('pageName'));
            }
        }
    }
}
