<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Local;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class LocalController extends Controller
{
    const NAME = 'Địa phương',
        RULES = [
            'city' => ['required', 'string', 'min:2', 'max:125'],
            'district' => ['required', 'string', 'min:2', 'max:125'],
        ],
        MESSAGES = [
            'city.required' => Controller::NOT_EMPTY,
            'city.string' => Controller::DATA_INVALID,
            'city.min' => Controller::MIN,
            'city.max' => Controller::MAX,
            'district.required' => Controller::NOT_EMPTY,
            'district.string' => Controller::DATA_INVALID,
            'district.min' => Controller::MIN,
            'district.max' => Controller::MAX,
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
            $result = [];
            switch ($request->key) {
                case 'cities':
                    $locals = Local::where('city', 'LIKE', '%' . $request->q . '%')->distinct()->pluck('city');
                    foreach ($locals as $local) {
                        array_push($result, ['id' => $local, 'text' => $local]);
                    }
                    break;
                case 'districts':
                    $locals = Local::query();
                    $locals->where(function ($query) use ($request) {
                        $query->where('city', 'LIKE', '%' . $request->q . '%')
                            ->orWhere('district', 'LIKE', '%' . $request->q . '%');
                    });
                    $locals->when(isset($request->city), function ($query) use ($request) {
                        return $query->where('city', $request->city);
                    });
                    $locals = $locals->get();
                    foreach ($locals as $local) {
                        array_push($result, ['id' => $local->id, 'text' => $local->district . ', ' . $local->city]);
                    }
                    break;

                default:
                    $local = Local::find($request->key);
                    if ($local) {
                        $result = $local;
                    } else {
                        abort(404);
                    }
                    break;
            }
            return response()->json($result, 200);
        } else {
            if ($request->ajax()) {
                $locals = Local::latest();
                return DataTables::of($locals)
                    ->addColumn('checkboxes', function ($obj) {
                        return '<input class="form-check-input choice" type="checkbox" name="choices[]" value="' . $obj->id . '">';
                    })
                    ->editColumn('city', function ($obj) {
                        if (!empty($this->user->can(User::UPDATE_LOCAL))) {
                            return '<a class="btn btn-link text-decoration-none text-start btn-update-local" data-id="' . $obj->id . '">' . $obj->city . '</a>';
                        } else {
                            return $obj->city;
                        }
                    })
                    ->editColumn('district', function ($obj) {
                        if (!empty($this->user->can(User::UPDATE_LOCAL))) {
                            return '<a class="btn btn-link text-decoration-none text-start btn-update-local" data-id="' . $obj->id . '">' . $obj->district . '</a>';
                        } else {
                            return $obj->district;
                        }
                    })
                    ->addColumn('action', function ($obj) {
                        if (!empty($this->user->can(User::DELETE_LOCAL))) {
                            return '
                        <form action="' . route('admin.local.remove') . '" method="post" class="save-form">
                            <input type="hidden" name="_token" value="' . csrf_token() . '"/>
                            <input type="hidden" name="choices[]" value="' . $obj->id . '" data-id="'  . $obj->id . '"/>
                            <button type="submit" class="btn btn-link text-decoration-none btn-remove">
                                <i class="bi bi-trash3"></i>
                            </button>
                        </form>';
                        }
                    })
                    ->rawColumns(['checkboxes', 'city', 'district', 'action'])
                    ->make(true);
            } else {
                $pageName = 'Quản lý ' . self::NAME;
                return view('admin.locals', compact('pageName'));
            }
        }
    }

    public function sort(Request $request)
    {
        $sort = $request->input('sort');
        foreach ($sort as $index => $id) {
            Local::where('id', $id)->update(['sort' => $index + 1]);
        }
        return response()->json(['msg' => 'Thứ tự đã được cập nhật thành công']);
    }

    public function create(Request $request)
    {
        $request->validate(self::RULES, self::MESSAGES);
        if (!empty($this->user->can(User::CREATE_LOCAL))) {
            try {
                $local = Local::create([
                    'city' => $request->city,
                    'district' => $request->district,
                ]);

                LogController::create('tạo', self::NAME, $local->id);
                $response = array(
                    'status' => 'success',
                    'msg' => 'Đã tạo ' . self::NAME . ': ' . $local->city . ' ' . $local->district
                );
            } catch (\Exception $e) {
                Log::error('Có lỗi xảy ra: ' . $e->getMessage() . ';' . PHP_EOL .
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
        $request->validate(self::RULES, self::MESSAGES);
        if (!empty($this->user->can(User::UPDATE_LOCAL))) {
            if ($request->has('id')) {
                try {
                    $local = Local::find($request->id);
                    if ($local) {
                        $local->update([
                            'city' => $request->city,
                            'district' => $request->district,
                        ]);

                        LogController::create('sửa', self::NAME, $local->id);
                        $response = array(
                            'status' => 'success',
                            'msg' => 'Đã cập nhật ' . self::NAME . ': ' . $local->city . ' ' . $local->district
                        );
                    } else {
                        $response = array(
                            'status' => 'error',
                            'msg' => 'Đã có lỗi xảy ra, vui lòng tải lại trang và thử lại!'
                        );
                    }
                } catch (\Exception $e) {
                    Log::error('Có lỗi xảy ra: ' . $e->getMessage() . ';' . PHP_EOL .
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
        $msg = [];
        foreach ($request->choices as $key => $id) {
            $obj = Local::find($id);
            $obj->delete();
            LogController::create("xóa", self::NAME, $obj->id);
            array_push($msg, $obj->city . ' ' . $obj->district);
        }
        $response = array(
            'status' => 'success',
            'msg' => 'Đã xóa ' . self::NAME . ' ' . implode(', ', $msg)
        );
        return  response()->json($response, 200);
    }
}
