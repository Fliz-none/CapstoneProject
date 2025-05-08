<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class AttributeController extends Controller
{
    const NAME = 'thuộc tính',
        RULES = [
            'key' => ['required', 'string', 'min: 3', 'max:125'],
            'value' => ['required', 'string', 'min: 3', 'max:125'],
        ],
        MESSAGES = [
            'key.required' => 'Thông tin này không thể trống.',
            'key.string' => 'Dữ liệu không hợp lệ',
            'key.min' => 'Tối thiểu từ 3 ký tự',
            'key.max' => 'Tối đa 125 ký tự',
            'value.required' => 'Thông tin này không thể trống.',
            'value.string' => 'Dữ liệu không hợp lệ',
            'value.min' => 'Tối thiểu từ 3 ký tự',
            'value.max' => 'Tối đa 125 ký tự',
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
            switch ($request->key) {
                case 'list':
                    $result = Attribute::get();
                    break;
                default:
                    $obj = Attribute::find($request->key);
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
                $attributes = Attribute::get();
                return DataTables::of($attributes)
                    ->addColumn('checkboxes', function ($obj) {
                        return '<input class="form-check-input choice" type="checkbox" name="choices[]" value="' . $obj->id . '">';
                    })
                    ->editColumn('name', function ($obj) {
                        if (!empty($this->user->can(User::UPDATE_ATTRIBUTE))) {
                            return '<a class="btn btn-link text-decoration-none text-start btn-update-attribute" data-id="' . $obj->id . '">' . $obj->key . '</a>';
                        } else {
                            return $obj->key;
                        }
                    })
                    ->addColumn('action', function ($obj) {
                        if (!empty($this->user->can(User::DELETE_ATTRIBUTE))) {
                            return '
                        <form action="' . route('admin.attribute.remove') . '" method="post" class="save-form">
                            <input type="hidden" name="_token" value="' . csrf_token() . '"/>
                            <input type="hidden" name="choices[]" value="' . $obj->id . '" data-id="' . $obj->id . '"/>
                            <button type="submit" class="btn btn-link text-decoration-none btn-remove">
                                <i class="bi bi-trash3"></i>
                            </button>
                        </form>';
                        }
                    })
                    ->rawColumns(['checkboxes', 'name', 'action'])
                    ->make(true);
            } else {
                $pageName = 'Quản lý ' . self::NAME;
                return view('admin.attributes', compact('pageName'));
            }
        }
    }

    public function create(Request $request)
    {
        $request->validate(self::RULES, self::MESSAGES);
        if (!empty($this->user->can(User::CREATE_ATTRIBUTE))) {
            $values = explode(',', $request->value);
            DB::beginTransaction();
            try {
                $attrs = [];
                foreach ($values as $key => $value) {
                    $attrs[] = [
                        'key' => $request->key,
                        'value' => $value,
                    ];
                }
                DB::table('attributes')->insert($attrs);
                DB::commit();
                cache()->forget('attributes');
                $response = array(
                    'status' => 'success',
                    'msg' => 'Đã tạo ' . self::NAME
                );
            } catch (\Exception $e) {
                DB::rollBack();
                Controller::resetAutoIncrement(['attributes', 'logs']);
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
        if (!empty($this->user->can(User::UPDATE_ATTRIBUTE))) {
            if ($request->has('id')) {
                try {
                    $attribute = Attribute::find($request->id);
                    if ($attribute) {
                        $attribute->update([
                            'key' => $request->key,
                            'value' => $request->value,
                        ]);

                        cache()->forget('attributes');
                        LogController::create('sửa', self::NAME, $attribute->id);
                        $response = array(
                            'status' => 'success',
                            'msg' => 'Đã cập nhật ' . $attribute->key
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
            $obj = Attribute::find($id);
            $obj->delete();
            array_push($msg, $obj->key . ': ' . $obj->value);
        }
        LogController::create("xóa", self::NAME, $obj->id);
        $response = array(
            'status' => 'success',
            'msg' => 'Đã xóa ' . self::NAME . ' ' . implode(', ', $msg)
        );
        return response()->json($response, 200);
    }
}
