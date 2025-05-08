<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChangePasswordRequest;
use App\Models\Image;
use App\Models\Local;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;

class UserController extends Controller
{
    const NAME = 'tài khoản';

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
            $objs = User::whereStatus(1);
            switch ($request->key) {
                case 'find':
                    $result = $objs
                        ->where(function ($query) use ($request) {
                            $query->where('id', 'LIKE', '' . $request->q . '%')
                                ->orWhere('name', 'LIKE', '%' . $request->q . '%')
                                ->orWhere('phone', 'LIKE', '%' . $request->q . '%')
                                ->orWhere('email', 'LIKE', '%' . $request->q . '%');
                        })
                        ->orderByDesc('id')
                        ->distinct()
                        ->take(20)
                        ->get()
                        ->map(function ($obj, $index) {
                            return '<li class="list-group-item border border-0 pb-0">
                                        <input type="radio" name="user_id" id="user-' . $obj->id . '" class="form-check-input me-1" value="' . $obj->id . '">
                                        <label class="form-check-label d-inline" for="user-' . $obj->id . '">' . $obj->full_name . ($obj->phone ? ' - ' . $obj->phone : '') . '</label>
                                    </li>';
                        })->push('<li class="list-group-item border border-0 pb-0">
                                    <button class="btn btn-link text-decoration-none w-100 btn-create-user" ' . $this->parseQueryStr($request->q) . '>
                                        Tạo tài khoản mới cho ' . $request->q . '
                                    </button>
                                </li>');
                    break;
                case 'staff':
                    $result = $objs->permission(User::ACCESS_ADMIN)
                        ->where(function ($query) use ($request) {
                            $query->where('id', 'LIKE', '' . $request->q . '%')
                                ->orWhere('name', 'LIKE', '%' . $request->q . '%')
                                ->orWhere('phone', 'LIKE', '%' . $request->q . '%')
                                ->orWhere('email', 'LIKE', '%' . $request->q . '%');
                        })
                        ->orderByDesc('id')
                        ->distinct()
                        ->take(20)
                        ->get()
                        ->map(function ($obj, $index) {
                            return '<li class="list-group-item border border-0 pb-0">
                                                <input type="radio" name="doctor_id" id="doctor-' . $obj->id . '" class="form-check-input me-1" value="' . $obj->id . '">
                                                <label class="form-check-label d-inline" for="doctor-' . $obj->id . '">' . $obj->full_name . ($obj->phone ? ' - ' . $obj->phone : '') . '</label>
                                            </li>';
                        })->push('<li class="list-group-item border border-0 pb-0">
                                                    <div class="row p-0 mx-0">
                                                        <div class="col-12 py-3 text-center">
                                                            Không tìm thấy nhân viên nào khác
                                                        </div>
                                                    </div>
                                                </li>');
                    break;
                case 'list':
                    $result = $objs->get();
                case 'select2':
                    $result = $objs
                        ->where(function ($query) use ($request) {
                            $query->where('id', 'LIKE', '' . $request->q . '%')
                                ->orWhere('name', 'LIKE', '' . $request->q . '%')
                                ->orWhere('phone', 'LIKE', '%' . $request->q . '%')
                                ->orWhere('email', 'LIKE', '%' . $request->q . '%');
                        })->orderBy('id', 'DESC')
                        ->take(20)->get()
                        ->map(function ($obj) {
                            return [
                                'id' => $obj->id,
                                'text' => $obj->name . ($obj->phone ? ' - ' . $obj->phone : '')
                            ];
                        });
                    break;
                case 'search':
                    $result = $objs->where(function ($query) use ($request) {
                        $query
                        ->where('id', 'LIKE', '' . $request->q . '%')
                        ->orWhere('name', 'LIKE', '%' . $request->q . '%')
                        ->orWhere('phone', 'LIKE', '%' . $request->q . '%')
                        ->orWhere('email', 'LIKE', '%' . $request->q . '%');
                    })->orderBy('id', 'DESC')
                        ->take(20)->get()->map(function ($obj) {
                            // dd($obj);
                            $text = $obj->name . ($obj->phone ? ' - ' . $obj->phone : '');
                            return '<li class="list-group-item list-group-item-action border border-0 cursor-pointer btn-select-user" data-id="' . $obj->id . '" data-name="' . $text . '" aria-current="true">
                                            ' . $text . '
                                    </li>';
                        })->push('<li class="list-group-item border border-0">
                                    <button class="btn btn-link text-decoration-none w-100 btn-create-user" ' . $this->parseQueryStr($request->q) . '>
                                        Tạo khách hàng mới cho ' . $request->q . '
                                    </button>
                                </li>');
                    break;
                default:
                    $obj = User::with('local', 'roles', 'warehouses', 'branches')->find($request->key);
                    if ($obj) {
                        switch ($request->action) {
                            case 'suggestions':
                                $created_at = $obj->created_at;
                                $countOrders = $obj->orders->count();
                                $countAvgPayments = $countOrders ? $obj->customer_transactions->count() / $obj->orders->count() : 0;
                                $debt = $obj->getDebt();
                                $averagePaymentDelay = $obj->getAveragePaymentDelay();
                                $scores = $obj->scores;
                                $phone = $obj->phone;
                                $name = $obj->name;
                                $result = [
                                    'created_at' => $created_at,
                                    'countPayment' => $countAvgPayments,
                                    'countOrders' => $countOrders,
                                    'debt' => $debt,
                                    'averagePaymentDelay' => $averagePaymentDelay,
                                    'scores' => $scores,
                                    'phone' => $phone,
                                    'name' => $name,
                                ];
                                break;
                            default:
                                if ($this->user->can(User::READ_USER)) {
                                    $result = $obj;
                                } else {
                                    $result = null;
                                }
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
                $objs = User::with(['roles', 'local']);
                return DataTables::of($objs)
                    ->addColumn('checkboxes', function ($obj) {
                        return '<input class="form-check-input choice" type="checkbox" name="choices[]" value="' . $obj->id . '">';
                    })
                    ->addColumn('code', function ($obj) {
                        if ($this->user->can(User::UPDATE_USER)) {
                            $code = '<a class="cursor-pointer btn-update-user text-primary fw-bold" data-id="' . $obj->id . '">' . $obj->code . '</a>';
                        } else {
                            $code = '<span class="fw-bold">' . $obj->code . '</span>';
                        }
                        return $code . '<br/><small>' . optional($obj->created_at)->format('d/m/Y H:i') . '</small>';
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
                                $query->where('users.id', 'like', "%" . $numericKeyword . "%");
                            }
                        });
                    })
                    ->orderColumn('code', function ($query, $order) {
                        $query->orderBy('id', $order);
                    })
                    ->editColumn('phone', function ($obj) {
                        return '<a href="tel:' . $obj->phone . '" class="btn btn-link text-decoration-none">' . $obj->phone . '</a>';
                    })
                    ->editColumn('name', function ($obj) {
                        if (!empty($this->user->can(User::UPDATE_USER))) {
                            return '<a class="btn btn-update-user text-primary text-decoration-none text-start" data-id="' . $obj->id . '">' . $obj->name . '</a>';
                        } else {
                            return $obj->name;
                        }
                    })
                    ->filterColumn('name', function ($query, $keyword) {
                        $query->where('name', 'like', "%" . $keyword . "%")
                            ->orWhere('email', 'like', "%{$keyword}%");
                    })
                    ->addColumn('email', function ($obj) {
                        return $obj->email;
                    })
                    ->filterColumn('email', function ($query, $keyword) {
                        $query->where('email', 'like', "%" . $keyword . "%");
                    })
                    ->addColumn('role', function ($obj) {
                        return $obj->getRoleNames()->first();
                    })
                    ->filterColumn('role', function ($query, $keyword) {
                        $query->whereHas('roles', function ($query) use ($keyword) {
                            $query->where('name', 'like', "%" . $keyword . "%");
                        });
                    })
                    ->editColumn('local', function ($obj) {
                        return $obj->fullAddress;
                    })
                    ->filterColumn('local', function ($query, $keyword) {
                        $query->whereHas('local', function ($query) use ($keyword) {
                            $query->where('city', 'like', "%" . $keyword . "%")->orWhere('district', 'like', "%" . $keyword . "%");
                        });
                    })
                    ->editColumn('status', function ($obj) {
                        return '<span class="badge bg-' . ($obj->status ? 'success' : 'danger') . '">' . $obj->statusStr . '</span>';
                    })
                    ->orderColumn('status', function ($query, $order) {
                        $query->orderBy('status', $order);
                    })
                    ->filterColumn('status', function ($query, $keyword) {
                        $statusMap = [
                            'Kích hoạt' => 1,
                            'Đã khóa' => 0,
                        ];
                        if (isset($statusMap[$keyword])) {
                            $query->where('status', $statusMap[$keyword]);
                        }
                    })
                    ->addColumn('action', function ($obj) {
                        $str = '<div class="d-flex justify-content-end">';
                        if ($this->user->can(User::UPDATE_USER)) {
                            $str .= '<a class="btn text-primary btn-update-user_password" data-id="' . $obj->id . '">
                                <i class="bi bi-key" data-bs-toggle="tooltip" data-bs-title="Đổi mật khẩu"></i>
                            </a>
                            <a class="btn text-primary btn-update-user_role" data-id="' . $obj->id . '">
                                <i class="bi bi-person-lock" data-bs-toggle="tooltip" data-bs-title="Phân quyền"></i>
                            </a>';
                        }
                        if ($this->user->can(User::DELETE_USER)) {
                            $str .= '<form method="post" action="' . route('admin.user.remove') . '" class="save-form">
                                    <input type="hidden" name="choices[]" value="' . $obj->id . '"/>
                                    <button class="btn btn-link text-decoration-none btn-remove" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Xóa">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>';
                        }
                        return $str . '</div>';
                    })
                    ->rawColumns(['checkboxes', 'name', 'phone', 'code', 'status', 'action'])
                    ->setTotalRecords($objs->count())
                    ->make(true);
            } else {
                $pageName = 'Quản lý ' . self::NAME;
                return view('admin.users', compact('pageName'));
            }
        }
    }

    public function create(Request $request)
    {
        $rules = [
            'name' => ['required', 'string', 'min:2', 'max:125'],
            'phone' => [
                'nullable',
                'numeric',
                'digits:10',
                'regex:/^0[0-9]{9,10}$/',
                function ($attribute, $value, $fail) use ($request) {
                    if (User::where('phone', $value)->count()) {
                        $fail('Số điện thoại không được trùng với một tài khoản khác');
                    }
                }
            ],
            'gender' => ['required', 'integer', 'between:0,2'],
            'local_id' => ['nullable', 'numeric'],
            'email' => [
                'nullable',
                'string',
                'min:5',
                'email',
                'max:125',
                function ($attribute, $value, $fail) use ($request) {
                    if (User::where('email', $value)->count()) {
                        $fail('Email không được trùng với một tài khoản khác');
                    }
                }
            ],
            'birthday' => ['nullable', 'date', 'date_format:Y-m-d'],
            'address' => ['nullable', 'string', 'min:2', 'max:125'],
            'note' => ['nullable', 'string', 'min:2', 'max:125'],
        ];
        $messages = [
            'name.required' => Controller::NOT_EMPTY,
            'name.string' => Controller::DATA_INVALID,
            'name.min' => Controller::MIN,
            'name.max' => Controller::MAX,
            'phone.numeric' => Controller::DATA_INVALID,
            'phone.digits' => 'Số điện thoại phải có 10 số!',
            'phone.unique' => 'Số điện thoại đã được sử dụng!',
            'phone.regex' => 'Số điện thoại không đúng định dạng!',
            'gender.required' => 'Vui lòng chọn giới tính!',
            'gender.integer' => 'Giới tính: ' . Controller::DATA_INVALID,
            'gender.between' => 'Giới tính: ' . Controller::DATA_INVALID,
            'email.required' => Controller::NOT_EMPTY,
            'email.string' => Controller::DATA_INVALID,
            'email.max' => Controller::MAX,
            'email.min' => 'Tối thiểu phải từ 2 ký tự',
            'email.unique' => 'Email bạn nhập không khả dụng!',
            'birthday.date' => Controller::DATA_INVALID,
            'birthday.date_format' => Controller::DATA_INVALID,
            'address.string' => Controller::DATA_INVALID,
            'address.min' => Controller::MIN,
            'address.max' => Controller::MAX,
            // 'role_id.required' => 'Vui lòng chọn 1 vai trò',
            'local_id.numeric' => Controller::DATA_INVALID,
            'note.string' => Controller::DATA_INVALID,
            'note.min' => Controller::MIN,
            'note.max' => Controller::MAX,
        ];
        $request->validate($rules, $messages);
        if (!empty($this->user->can(User::CREATE_USER))) {
            try {
                $user = User::create([
                    'name' => $request->name,
                    'phone' => $request->phone,
                    'email' => $request->email,
                    'birthday' => $request->birthday,
                    'address' => $request->address,
                    'scores' => $request->scores,
                    'gender' => $request->gender,
                    'local_id' => $request->local_id,
                    'note' => $request->note,
                    'status' => $request->has('status'),
                ]);

                if ($request->avatar) {
                    $imageInfo = pathinfo($request->avatar->getClientOriginalName());
                    $filename = $user->code . '.' . $imageInfo['extension'];
                    $request->avatar->storeAs('public/user/', $filename);
                    $user->update(['avatar' => $filename]);
                }

                LogController::create('tạo', self::NAME, $user->id);
                $response = array(
                    'user' => $user,
                    'status' => 'success',
                    'msg' => 'Đã tạo ' . self::NAME . ' ' . $user->name
                );
                cache()->forget('users');
            } catch (\Exception $e) {
                Log::error(
                    'Có lỗi xảy ra: ' . $e->getMessage() . ';' . PHP_EOL .
                        'URL truy vấn: "' . request()->fullUrl() . '";' . PHP_EOL .
                        'Dữ liệu nhận được: ' . json_encode(request()->all()) . ';' . PHP_EOL .
                        'User ID: ' . (Auth::check() ? Auth::id() : 'Khách') . ';' . PHP_EOL .
                        'Chi tiết lỗi: ' . $e->getTraceAsString()
                );
                return response()->json(['errors' => ['error' => ['Đã xảy ra lỗi: ' . $e->getMessage()]]], 422);
            }
        } else {
            return response()->json(['errors' => ['role' => ['Thao tác chưa được cấp quyền!']]], 422);
        }
        return response()->json($response, 200);
    }

    public function update(Request $request)
    {
        $rules = [
            'name' => ['required', 'string', 'min:2', 'max:125'],
            'phone' => [
                'nullable',
                'numeric',
                'digits:10',
                'regex:/^(0|\+84)(\s|\.)?((3[2-9])|(5[689])|(7[06-9])|(8[1-689])|(9[0-46-9]))(\d)(\s|\.)?(\d{3})(\s|\.)?(\d{3})$/',
                function ($attribute, $value, $fail) use ($request) {
                    if (User::where('phone', $value)->where('id', '!=', $request->id)->count()) {
                        $fail('Số điện thoại không được trùng với một tài khoản khác');
                    }
                }
            ],
            'gender' => ['required', 'integer', 'between:0,2'],
            'local_id' => ['nullable', 'numeric'],
            'email' => [
                'nullable',
                'string',
                'min:5',
                'email',
                'max:125',
                function ($attribute, $value, $fail) use ($request) {
                    if (User::where('email', $value)->where('id', '!=', $request->id)->count()) {
                        $fail('Email không được trùng với một tài khoản khác');
                    }
                }
            ],
            'birthday' => ['nullable', 'date', 'date_format:Y-m-d'],
            'address' => ['nullable', 'string', 'min:2', 'max:125'],
            'note' => ['nullable', 'string', 'min:2', 'max:125'],
        ];
        $messages = [
            'name.required' => Controller::NOT_EMPTY,
            'name.string' => Controller::DATA_INVALID,
            'name.min' => Controller::MIN,
            'name.max' => Controller::MAX,
            'phone.numeric' => Controller::DATA_INVALID,
            'phone.digits' => 'Số điện thoại phải có 10 số!',
            'phone.unique' => 'Số điện thoại đã được sử dụng!',
            'phone.regex' => 'Số điện thoại không đúng định dạng!',
            'gender.required' => 'Vui lòng chọn giới tính!',
            'gender.integer' => 'Giới tính: ' . Controller::DATA_INVALID,
            'gender.between' => 'Giới tính: ' . Controller::DATA_INVALID,
            'email.required' => Controller::NOT_EMPTY,
            'email.string' => Controller::DATA_INVALID,
            'email.max' => Controller::MAX,
            'email.min' => 'Tối thiểu phải từ 2 ký tự',
            'email.unique' => 'Email bạn nhập không khả dụng!',
            'birthday.date' => Controller::DATA_INVALID,
            'birthday.date_format' => Controller::DATA_INVALID,
            'address.string' => Controller::DATA_INVALID,
            'address.min' => Controller::MIN,
            'address.max' => Controller::MAX,
            'local_id.numeric' => Controller::DATA_INVALID,
            'note.string' => Controller::DATA_INVALID,
            'note.min' => Controller::MIN,
            'note.max' => Controller::MAX,
        ];
        $request->validate($rules, $messages);
        if (!empty($this->user->can(User::UPDATE_USER))) {
            if ($request->has('id')) {
                try {
                    $user = User::find($request->id);
                    if ($user) {
                        $user->update([
                            'name' => $request->name,
                            'phone' => $request->phone,
                            'email' => $request->email,
                            'birthday' => $request->birthday,
                            'address' => $request->address,
                            'scores' => $request->scores,
                            'gender' => $request->gender,
                            'local_id' => $request->local_id,
                            'note' => $request->note,
                            'status' => $request->has('status'),
                        ]);

                        if ($request->avatar) {
                            $imageInfo = pathinfo($request->avatar->getClientOriginalName());
                            $filename = $user->code . '.' . $imageInfo['extension'];
                            $request->avatar->storeAs('public/user/', $filename);
                            User::find($user->id)->update(['avatar' => $filename]);
                        }


                        LogController::create('sửa', self::NAME, $user->id);
                        $response = array(
                            'status' => 'success',
                            'msg' => 'Đã cập nhật ' . $user->name
                        );
                        cache()->forget('users');
                    } else {
                        $response = array(
                            'status' => 'error',
                            'msg' => 'Đã có lỗi xảy ra, vui lòng tải lại trang và thử lại!'
                        );
                    }
                } catch (\Exception $e) {
                    Log::error(
                        'Có lỗi xảy ra: ' . $e->getMessage() . ';' . PHP_EOL .
                            'URL truy vấn: "' . request()->fullUrl() . '";' . PHP_EOL .
                            'Dữ liệu nhận được: ' . json_encode(request()->all()) . ';' . PHP_EOL .
                            'User ID: ' . (Auth::check() ? Auth::id() : 'Khách') . ';' . PHP_EOL .
                            'Chi tiết lỗi: ' . $e->getTraceAsString()
                    );
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

    public function updateRole(Request $request)
    {
        $rules = [
            'id' => ['required', 'numeric'],
            'role_id' => ['required', 'array'],
            'role_id.*' => ['numeric'],
            'warehouse_id' => ['nullable', 'array'],
            'warehouse_id.*' => ['numeric'],
            'branch_id' => ['nullable', 'array'],
            'branch_id.*' => ['numeric'],
        ];
        $request->validate($rules);

        $user = User::find($request->id);
        $user->main_branch = null;
        $user->save();
        if (count($request->role_id)) {
            $user->syncRoles($request->role_id);
        }
        $user->syncWarehouses($request->warehouse_id);
        $user->syncBranches($request->branch_id);
        cache()->forget('dealers');
        cache()->forget('cashiers');
        $roles = $user->getRoleNames()->implode(', ');
        LogController::create('cập nhật vai trò ' . $roles, "tài khoản", $user->id);
        $response = array(
            'status' => 'success',
            'msg' => 'Đã cập nhật vai trò ' . $roles . ' cho ' . $user->name . '!'
        );
        cache()->forget('users');
        return response()->json($response, 200);
    }

    public function updatePassword(ChangePasswordRequest $request)
    {
        $rules = [
            'id' => ['required', 'numeric'],
            'password' => ['required'],
        ];
        $request->validate($rules);

        $user = User::find($request->id);
        if (!$user) {
            return back()->withErrors(['user_id' => 'User không tồn tại']);
        }
        $user->password = Hash::make($request->password);
        $user->save();

        LogController::create('cập nhật mật khẩu', "tài khoản", $user->id);
        $response = array(
            'status' => 'success',
            'msg' => 'Đã cập nhật mật khẩu cho ' . $user->name . '!'
        );
        return response()->json($response, 200);
    }

    public function remove(Request $request)
    {
        $success = [];
        $fail = [];
        $msg = '';
        if ($this->user->can(User::DELETE_USER)) {
            foreach ($request->choices as $key => $id) {
                $obj = User::find($id);
                if ($obj->id == Auth::id()) {
                    return response()->json(['errors' => ['role' => ['Bạn không thể tự xóa tài khoản của chính mình!']]], 422);
                }
                if ($obj->getRoleNames()->contains('Super Admin')) {
                    return response()->json(['errors' => ['role' => ['Bạn không thể xóa tài khoản này!']]], 422);
                }
                if ($obj->canRemove()) {
                    $obj->delete();
                    LogController::create("xóa", self::NAME, $obj->id);
                    array_push($success, $obj->name);
                } else {
                    array_push($fail, $obj->name);
                }
            }
            if (count($success)) {
                $msg = 'Đã xóa ' . self::NAME . ' ' . implode(', ', $success) . '. ';
                cache()->forget('users');
            }
            if (count($fail)) {
                $msg .= implode(', ', $fail) . ' không thể xóa!';
            }
            $response = array(
                'status' => 'success',
                'msg' => $msg
            );
        } else {
            return response()->json(['errors' => ['role' => ['Thao tác chưa được cấp quyền!']]], 422);
        }
        return response()->json($response, 200);
    }

    public function uploadAvatar($image)
    {
        $imageName = $image->getClientOriginalName();
        $tmp = explode('.', $imageName);
        $path = 'public/' . Str::slug($tmp[0]) . '.' . $tmp[count($tmp) - 1];
        $imageName = Str::slug($tmp[0]) . ((Storage::exists($path)) ? Carbon::now()->format('-YmdHis.') : '.') . $tmp[count($tmp) - 1];
        $image->storeAs('public/', $imageName);
        $image = Image::create([
            'name' => $imageName,
            'author_id' => $this->user->id
        ]);
        LogController::create('tạo', self::NAME . ' ' . $image->name, $image->id);
    }

    static function parseQueryStr($q)
    {
        switch (true) {
            case filter_var($q, FILTER_VALIDATE_EMAIL):
                $acc_str = 'data-email="' . $q . '"';
                break;

            case is_numeric($q) && strlen($q) > 5:
                $acc_str = 'data-phone="' . $q . '"';
                break;

            default:
                $acc_str = 'data-name="' . $q . '"';
                break;
        }
        return $acc_str;
    }
}
