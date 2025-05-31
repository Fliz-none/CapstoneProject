<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class ExpenseController extends Controller
{
    const NAME = 'Expense',
        MESSAGES = [
            'avatar.image' => Controller::DATA_INVALID,
            'avatar.max' => 'The image may not be greater than 3 MB.',

            'receiver_id.required' => 'Please select a receiver.',
            'receiver_id.numeric' => Controller::DATA_INVALID,
            'receiver_id.exists' => 'Receiver does not exist.',

            'payment.required' => 'Please select a payment method.',
            'payment.numeric' => Controller::DATA_INVALID,
            'payment.between' => Controller::DATA_INVALID,

            'amount.required' => 'Please enter an amount.',
            'amount.numeric' => 'The amount must be a number.',
            'amount.min' => 'The amount must be greater than or equal to 0.',
            'amount.max' => 'The amount of the voucher is too large.',
            'note.required' => 'Please enter a note',
            'note.max' => 'Minimum 255 characters',

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
        $this->middleware(['auth']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        if (isset($request->key)) {
            $objs = Expense::query();
            switch ($request->key) {
                case 'select2':
                    $result = $objs->get()->map(function ($expense) {
                        return [
                            'id' => $expense->id,
                            'text' => $expense->code,
                        ];
                    });
                    break;
                default:
                    $obj = $objs->with('receiver', 'user')->find($request->key);
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
                $expenses = Expense::with('branch', 'user', 'receiver')
                    ->when($request->has('branch_id'), function ($query) use ($request) {
                        $query->where('branch_id', $request->branch_id);
                    }, function ($query) {
                        $query->whereIn('branch_id', Auth::user()->branches->pluck('id'));
                    });
                $can_update_expense = $this->user->can(User::UPDATE_EXPENSE);
                $can_update_user = $this->user->can(User::UPDATE_USER);
                $can_update_branch = $this->user->can(User::UPDATE_BRANCH);
                return DataTables::of($expenses)
                    ->addColumn('checkboxes', function ($obj) {
                        return '<input class="form-check-input choice" type="checkbox" name="choices[]" value="' . $obj->id . '">';
                    })
                    ->editColumn('code', function ($obj) use ($can_update_expense) {
                        if ($can_update_expense) {
                            $code = '<a class="btn btn-link text-decoration-none fw-bold text-start btn-update-expense" data-id="' . $obj->id . '">' . $obj->code . '</a>';
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
                            $query->where('expenses.id', $keyword);
                        });
                    })
                    ->orderColumn('code', function ($query, $order) {
                        $query->orderBy('id', $order);
                    })
                    ->addColumn('avatar', function ($obj) {
                        return '<img src="' . $obj->avatarUrl . '" class="thumb cursor-pointer object-fit-cover" alt="Ảnh ' . $obj->name . '" width="60px" height="60px">';
                    })
                    ->addColumn('user', function ($obj) use ($can_update_user, $can_update_branch) {
                        if ($obj->user_id) {
                            if ($can_update_user) {
                                $str = '<a class="btn btn-link text-decoration-none text-start btn-update-user p-0" data-id="' . $obj->user_id . '">' . $obj->user->fullName . '</a>';
                            } else {
                                $str = $obj->user->fullName;
                            }
                        } else {
                            $str = 'N/A';
                        }
                        if($obj->branch_id) {
                            if($can_update_branch) {
                                $str .= '</br><small class="badge bg-light-info"><a class="cursor-pointer text-decoration-none text-start btn-update-branch" data-id="' . $obj->branch_id . '">' . $obj->branch->fullName . '</a></small>';
                            } else {
                                $str .= '</br><small class="badge bg-light-info">' . $obj->branch->fullName . '</small>';
                            }
                        }
                        return $str;
                    })
                    ->filterColumn('user', function ($query, $keyword) {
                        $query->whereHas('user', function ($query) use ($keyword) {
                            $query->where('name', 'like', "%" . $keyword . "%");
                        });
                    })
                    ->orderColumn('user', function ($query, $order) {
                        $query->join('users', 'expenses.user_id', '=', 'users.id')
                            ->orderBy('users.name', $order);
                    })
                    ->editColumn('note', function ($obj) {
                        return $obj->note . '<br/>  <small class="badge bg-' . ($obj->status ? 'success' : 'danger') . '">' . $obj->statusStr . '</small> <small class="badge bg-light-info ms-2">' . $obj->group . '</small>';
                    })

                    ->filterColumn('note', function ($query, $keyword) {
                        $query->where('note', 'like', "%" . $keyword . "%")->orWhere('group', 'like', "%" . $keyword . "%");
                    })
                    ->orderColumn('note', function ($query, $order) {
                        $query->orderBy('group', $order);
                    })
                    ->addColumn('receiver', function ($obj) use ($can_update_user) {
                        if ($obj->receiver_id) {
                            if ($can_update_user) {
                                return '<a class="btn btn-link text-decoration-none text-start btn-update-user" data-id="' . $obj->receiver_id . '">' . $obj->receiver->fullName . '</a>';
                            } else {
                                return $obj->receiver->fullName;
                            }
                        } else {
                            return 'N/A';
                        }
                    })
                    ->filterColumn('receiver', function ($query, $keyword) {
                        $query->whereHas('receiver', function ($query) use ($keyword) {
                            $query->where('name', 'like', "%" . $keyword . "%");
                        });
                    })
                    ->orderColumn('receiver', function ($query, $order) {
                        $query->join('users', 'expenses.receiver_id', '=', 'users.id')
                            ->orderBy('users.name', $order);
                    })
                    ->addColumn('amount', function ($obj) {
                        return number_format($obj->amount, 0, ',', '.') . ' đ<br>
                        <input type="hidden" data-date="' . $obj->created_at->format('d/m/Y') . '" value="' . $obj->amount . '">
                        <small>' . $obj->paymentStr . '</small>';
                    })
                    ->filterColumn('amount', function ($query, $keyword) {
                        $query->where('amount', 'like', "%" . $keyword . "%");
                    })
                    ->orderColumn('amount', function ($query, $order) {
                        $query->orderBy('amount', $order);
                    })
                    ->editColumn('status', function ($obj) {
                        return $obj->statusStr;
                    })
                    ->orderColumn('status', function ($query, $expense) {
                        $query->orderBy('status', $expense);
                    })
                    ->addColumn('action', function ($obj) {
                        if (!empty($this->user->can(User::DELETE_EXPENSE))) {
                            return '<form method="post" action="' . route('admin.expense.remove') . '" class="save-form">
                                <input type="hidden" name="choices[]" value="' . $obj->id . '"/>
                                <button type="submit" class="btn btn-link text-decoration-none btn-remove cursor-pointer">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>';
                        }
                    })
                    ->rawColumns(['checkboxes', 'code', 'note', 'amount', 'avatar','status', 'user', 'receiver', 'action'])
                    ->make(true);
            } else {
                $pageName = self::NAME . ' management';
                return view('admin.expenses', compact('pageName'));
            }
        }
    }

    public function create(Request $request)
    {
        $rules = [
            'avatar' => ['image', 'max:3072'],
            'receiver_id' => ['required', 'numeric', 'exists:users,id'],
            'payment' => ['required', 'numeric', 'between:0,2'],
            'amount' => ['required', 'numeric', 'min:0', 'max:100000000'],
            'note' => ['required', 'string', 'min:0', 'max:255'],
        ];
        $request->validate($rules, self::MESSAGES);
        $settings = cache()->get('settings');
        if (isset($settings['expense_image_required']) && $settings['expense_image_required'] == 1 && !$request->hasFile('avatar')) {
            return response()->json(['errors' => ['avatar' => ['Hãy bổ sung thêm hình ảnh hóa đơn']]], 422);
        }
        if (!empty($this->user->can(User::CREATE_EXPENSE))) {
            try {
                $expense = Expense::create([
                    'user_id' => Auth::id(),
                    'receiver_id' => $request->receiver_id,
                    'payment' => $request->payment,
                    'amount' => $request->amount,
                    'note' => $request->note,
                    'status' => $request->has('status'),
                    'group' => $request->group,
                    'branch_id' => $this->user->main_branch,
                ]);

                if ($request->avatar) {
                    $imageInfo = pathinfo($request->avatar->getClientOriginalName());
                    $filename = $expense->code . '.' . $imageInfo['extension'];
                    $request->avatar->storeAs('public/expense/', $filename);
                    Expense::find($expense->id)->update(['avatar' => $filename]);
                }

                LogController::create("create", self::NAME, $expense->id);
                $response = [
                    'status' => 'success',
                    'msg' => 'Created ' . self::NAME . ' ' . $expense->code,
                ];
            } catch (\Exception $e) {
                log_exception($e);
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
            'avatar' => ['image', 'max:3072'],
            'receiver_id' => ['required', 'numeric', 'exists:users,id'],
            'payment' => ['required', 'numeric', 'between:0,2'],
            'amount' => ['required', 'numeric', 'min:0', 'max:100000000'],
            'note' => ['required', 'string', 'min:0', 'max:255'],
        ];
        $request->validate($rules, self::MESSAGES);

        if (!empty($this->user->can(User::UPDATE_EXPENSE))) {
            if ($request->has('id')) {
                try {
                    if (!$this->user->can(User::APPROVE_EXPENSE) && $request->has('status')) {
                        return response()->json(['errors' => ['role' => ['You do not have permission or this expense has been approved!']]], 422);
                    }
                    $expense = Expense::find($request->id);
                    if ($expense) {
                        $expense->update([
                            'receiver_id' => $request->receiver_id,
                            'payment' => $request->payment,
                            'amount' => $request->amount,
                            'note' => $request->note,
                            'status' => $request->has('status'),
                            'group' => $request->group,
                        ]);

                        if ($request->avatar) {
                            $imageInfo = pathinfo($request->avatar->getClientOriginalName());
                            $filename = $expense->code . '.' . $imageInfo['extension'];
                            $request->avatar->storeAs('public/expense/', $filename);
                            $expense->update(['avatar' => $filename]);
                        }

                        LogController::create("update", self::NAME, $expense->id);
                        $response = [
                            'status' => 'success',
                            'msg' => 'Updated ' . self::NAME . ' ' . $expense->code,
                        ];
                    } else {
                        $response = array(
                            'status' => 'error',
                            'msg' => 'An error occurred, please reload the page and try again!'
                        );
                    }
                } catch (\Exception $e) {
                    log_exception($e);
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
        $names = [];
        foreach ($request->choices as $key => $id) {
            $expense = Expense::find($id);
            $expense->delete();
            array_push($names, $expense->name);
            LogController::create("delete", self::NAME, $expense->id);
        }
        return response()->json([
            'status' => 'success',
            'msg' => 'Deleted ' . self::NAME . ' ' . $expense->code,
        ], 200);
    }
}
