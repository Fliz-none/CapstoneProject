<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class BranchController extends Controller
{
    const NAME = 'chi nhánh',
        MESSAGES = [
            'name.required' => Controller::NOT_EMPTY,
            'name.string' => Controller::DATA_INVALID,
            'name.max' => Controller::MAX,
            'phone.required' => Controller::NOT_EMPTY,
            'phone.numeric' => Controller::DATA_INVALID,
            'phone.digits' => 'Số điện thoại phải có 10 số!',
            'phone.regex' => Controller::DATA_INVALID,
            'phone.unique' => 'Số điện thoại không khả dụng!',
            'address.required' => Controller::NOT_EMPTY,
            'address.string' => Controller::DATA_INVALID,
            'address.min' => Controller::MIN,
            'address.max' => Controller::MAX,
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
        $company_id = $this->user->company_id;
        $objs = Branch::where('branches.company_id', $company_id);
        if (isset($request->key)) {
            switch ($request->key) {
                case 'list':
                    $result = $objs->orderBy('sort', 'ASC')->get();
                    break;
                case 'select2':
                    $result = $objs->whereStatus(1)
                        ->where('name', 'LIKE', '%' . $request->q . '%')
                        ->orderByDesc('id')
                        ->distinct()
                        ->get()
                        ->map(function ($obj) {
                            return [
                                'id' => $obj->id,
                                'text' => $obj->name
                            ];
                        })
                        ->push([
                            'id' => '',
                            'text' => 'Không chọn chi nhánh'
                        ]);
                    break;
                default:
                    $obj = $objs->withTrashed()->find($request->key);
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
                return DataTables::of($objs)
                    ->addColumn('checkboxes', function ($obj) {
                        return '<input class="form-check-input choice" type="checkbox" name="choices[]" value="' . $obj->id . '">';
                    })
                    ->addColumn('code', function ($obj) {
                        if ($this->user->can(User::UPDATE_BRANCH)) {
                            $code = '<a class="btn btn-update-branch fw-bold text-center text-primary" data-id="' . $obj->id . '">' . $obj->code . '</a>';
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
                            $numericKeyword = ltrim(preg_replace('/[^0-9]/', '', $keyword), '0');
                            if (!empty($numericKeyword)) {
                                $query->where('branches.id', 'like', "%" . $numericKeyword . "%");
                            }
                        });
                    })
                    ->orderColumn('code', function ($query, $order) {
                        $query->orderBy('id', $order);
                    })
                    ->addColumn('name', function ($obj) {
                        if ($this->user->can(User::UPDATE_BRANCH)) {
                            return '<a class="btn btn-update-branch text-center text-primary" data-id="' . $obj->id . '">' . $obj->name . '</a>';
                        }
                        return '<span class="fw-bold">' . $obj->name . '</span>';
                    })
                    ->filterColumn('name', function ($query, $keyword) {
                        $query->where('name', 'like', "%" . $keyword . "%");
                    })
                    ->orderColumn('name', function ($query, $order) {
                        $query->orderBy('name', $order);
                    })
                    ->editColumn('address', function ($obj) {
                        return '<div class="text-start">' . $obj->address . '</div>';
                    })
                    ->filterColumn('address', function ($query, $keyword) {
                        $query->where('address', 'like', "%" . $keyword . "%")
                            ->orWhere('phone', 'like', "%" . $keyword . "%");
                    })
                    ->editColumn('status', function ($obj) {
                        return '<span class="badge bg-' . ($obj->status ? 'success' : 'danger') . '">' . $obj->statusStr . '</span>';
                    })
                    ->orderColumn('status', function ($query, $order) {
                        $query->orderBy('status', $order);
                    })
                    ->filterColumn('status', function ($query, $keyword) {
                        $statusMap = [
                            'hoatdong' => 1,
                            'bikhoa' => 0,
                        ];
                        if (isset($statusMap[$keyword])) {
                            $query->where('status', $statusMap[$keyword]);
                        }
                    })
                    ->addColumn('action', function ($obj) {
                        if (!empty($this->user->can(User::DELETE_BRANCH))) {
                            return '
                                <form action="' . route('admin.branch.remove') . '" method="post" class="save-form">
                                    <input type="hidden" name="_token" value="' . csrf_token() . '"/>
                                    <input type="hidden" name="choices[]" value="' . $obj->id . '" data-id="' . $obj->id . '"/>
                                    <button class="btn btn-link text-decoration-none btn-remove">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </form>';
                        }
                    })
                    ->rawColumns(['checkboxes', 'code', 'name', 'address', 'status', 'action'])
                    ->make(true);
            } else {
                $pageName = 'Quản lý ' . self::NAME;
                return view('admin.branches', compact('pageName'));
            }
        }
    }

    public function create(Request $request)
    {
        $rules = [
            'name' => ['required', 'string', 'max:125'],
            'phone' => ['required', 'numeric', 'digits:10', 'regex:/^(0|\+84)(\s|\.)?((3[2-9])|(5[689])|(7[06-9])|(8[1-689])|(9[0-46-9]))(\d)(\s|\.)?(\d{3})(\s|\.)?(\d{3})$/', 'unique:branches'],
            'address' => ['required', 'string', 'min:2', 'max:125'],
        ];
        $request->validate($rules, self::MESSAGES);

        if (!empty($this->user->can(User::CREATE_BRANCH))) {
            try {
                $branch = Branch::create([
                    'name' => $request->name,
                    'phone' => $request->phone,
                    'address' => $request->address,
                    'note' => $request->note,
                    'status' => $request->has('status'),
                    'company_id' => $this->user->company_id,
                ]);

                LogController::create('tạo', self::NAME, $branch->id);
                cache()->forget('branches_' . Auth::user()->company_id);
                $response = array(
                    'status' => 'success',
                    'msg' => 'Đã tạo ' . self::NAME . ' ' . $branch->name
                );
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
            'name' => ['required', 'string', 'max:125'],
            'phone' => ['required', 'numeric', 'digits:10', 'regex:/^(0|\+84)(\s|\.)?((3[2-9])|(5[689])|(7[06-9])|(8[1-689])|(9[0-46-9]))(\d)(\s|\.)?(\d{3})(\s|\.)?(\d{3})$/', Rule::unique('suppliers')->ignore($request->id)],
            'address' => ['required', 'string', 'min:2', 'max:125'],
        ];
        $request->validate($rules, self::MESSAGES);

        if (!empty($this->user->can(User::UPDATE_BRANCH))) {
            if ($request->has('id')) {
                try {
                    $branch = Branch::find($request->id);
                    if ($branch) {
                        $branch->update([
                            'name' => $request->name,
                            'phone' => $request->phone,
                            'address' => $request->address,
                            'note' => $request->note,
                            'status' => $request->has('status'),
                            'company_id' => $this->user->company_id,
                        ]);

                        LogController::create('sửa', self::NAME, $branch->id);
                        cache()->forget('branches_' . Auth::user()->company_id);
                        $response = array(
                            'status' => 'success',
                            'msg' => 'Đã cập nhật ' . self::NAME . ' ' . $branch->name
                        );
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

    public function remove(Request $request)
    {
        $success = [];
        if ($this->user->can(User::DELETE_BRANCH)) {
            foreach ($request->choices as $key => $id) {
                $obj = Branch::find($id);
                $obj->delete();
                cache()->forget('branches_' . Auth::user()->company_id);
                LogController::create("xóa", self::NAME, $obj->id);
                array_push($success, $obj->name);
            }
            $msg = '';
            if (count($success)) {
                $msg .= 'Đã xóa ' . self::NAME . ' ' . implode(', ', $success) . '. ';
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
}
