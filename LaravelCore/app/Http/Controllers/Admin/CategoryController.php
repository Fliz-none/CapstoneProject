<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class CategoryController extends Controller
{
    const NAME = 'chuyên mục',
        RULES = [
            'name' => ['required', 'string', 'min:2', 'max:125'],
            'note' => ['nullable', 'string', 'min:2', 'max:320']
        ],
        MESSAGES = [
            'name.required' => Controller::NOT_EMPTY,
            'name.string' => Controller::DATA_INVALID,
            'name.min' => Controller::MIN,
            'name.max' => Controller::MAX,
            'note.string' => Controller::DATA_INVALID,
            'note.min' => Controller::MIN,
            'note.max' => Controller::MAX,
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
                    $ids = json_decode($request->ids);
                    $obj = Category::orderBy('sort', 'ASC')->when(count($ids), function ($query) use ($ids) {
                        $query->whereIn('id', $ids);
                    })->get();
                    return response()->json($obj, 200);
                    break;

                default:
                    $category = Category::find($request->key);
                    if ($category) {
                        return response()->json($category, 200);
                    } else {
                        abort(404);
                    }
                    break;
            }
        } else {
            if ($request->ajax()) {
                $objs = Category::select('*');
                return DataTables::of($objs)
                    ->addColumn('checkboxes', function ($obj) {
                        return '<input class="form-check-input choice" type="checkbox" name="choices[]" value="' . $obj->id . '">';
                    })
                    ->editColumn('name', function ($obj) {
                        if (!empty($this->user->can(User::UPDATE_CATEGORY))) {
                            return '<a class="btn btn-link text-decoration-none text-start btn-update-category" data-id="' . $obj->id . '">' . $obj->name . '</a>';
                        } else {
                            return $obj->name;
                        }
                    })
                    ->editColumn('status', function ($obj) {
                        return '<span class="badge bg-' . ($obj->status ? 'success' : 'danger') . '">' . $obj->statusName() . '</span>';
                    })
                    ->orderColumn('status', function ($query, $order) {
                        $query->orderBy('status', $order);
                    })
                    ->addColumn('action', function ($obj) {
                        if (!empty($this->user->can(User::DELETE_CATEGORY))) {
                            return '
                            <form action="' . route('admin.category.remove') . '" method="post" class="save-form">
                                <input type="hidden" name="_token" value="' . csrf_token() . '"/>
                                <input type="hidden" name="choices[]" value="' . $obj->id . '" data-id="' . $obj->id . '"/>
                                <button type="submit" class="btn btn-link text-decoration-none btn-remove">
                                    <i class="bi bi-trash3"></i>
                                </button>
                            </form>';
                        }
                    })
                    ->rawColumns(['checkboxes', 'name', 'status', 'action'])
                    ->setTotalRecords($objs->count())
                    ->make(true);
            } else {
                $pageName = 'Quản lý ' . self::NAME;
                return view('admin.categories', compact('pageName'));
            }
        }
    }

    public function sort(Request $request)
    {
        $ids = $request->input('sort');
        if (count($ids) == Category::count()) {
            foreach ($ids as $index => $id) {
                Category::where('id', $id)->update(['sort' => $index + 1]);
            }
        } else {
            $sorts = Category::whereIn('id', $ids)->orderBy('sort', 'ASC')->pluck('sort');
            foreach ($sorts as $index => $sort) {
                Category::find($ids[$index])->update(['sort' => $index + 1]);
            }
        }
        return response()->json(['msg' => 'Thứ tự đã được cập nhật thành công']);
    }

    public function create(Request $request)
    {
        $request->validate(self::RULES, self::MESSAGES);
        if (!empty($this->user->can(User::CREATE_CATEGORY))) {
            try {
                $category = Category::create([
                    'name' => $request->name,
                    'slug' => Str::slug($request->name),
                    'note' => $request->note,
                    'status' => $request->has('status'),
                ]);

                LogController::create('tạo', self::NAME, $category->id);
                cache()->forget('categories');
                $response = array(
                    'status' => 'success',
                    'msg' => 'Đã tạo ' . self::NAME . ' ' . $category->name
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
            return response()->json(['errors' => ['branch_id' => ['Tài khoản chưa được thiết lập chi nhánh']]], 422);
        }
        return response()->json($response, 200);
    }

    public function update(Request $request)
    {
        $request->validate(self::RULES, self::MESSAGES);
        if (!empty($this->user->can(User::UPDATE_CATEGORY))) {
            if ($request->has('id')) {
                try {
                    $category = Category::find($request->id);
                    if ($category) {
                        $category->update([
                            'name' => $request->name,
                            'slug' => Str::slug($request->name),
                            'note' => $request->note,
                            'status' => $request->has('status'),
                        ]);

                        LogController::create('sửa', self::NAME, $category->id);
                        cache()->forget('categories');
                        $response = array(
                            'status' => 'success',
                            'msg' => 'Đã cập nhật ' . $category->name
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
            return response()->json(['errors' => ['branch_id' => ['Tài khoản chưa được thiết lập chi nhánh']]], 422);
        }
        return response()->json($response, 200);
    }

    public function remove(Request $request)
    {
        $success = [];
        $fail = [];
        $msg = '';

        if ($this->user->can(User::DELETE_CATEGORY)) {
            foreach ($request->choices as $key => $id) {
                $obj = Category::find($id);
                if ($obj->canRemove()) {
                    $obj->delete();
                    cache()->forget('categories');
                    LogController::create("xóa", self::NAME, $obj->id);
                    array_push($success, $obj->name);
                } else {
                    array_push($fail, $obj->name);
                }
            }
            if (count($success)) {
                $msg = 'Đã xóa ' . self::NAME . ' ' . implode(', ', $success) . '. ';
            }
            if (count($fail)) {
                $msg .= implode(', ', $fail) . ' đang sử dụng, không thể xóa!';
            }
            $response = array(
                'status' => 'success',
                'msg' => $msg
            );
        } else {
            return response()->json(['errors' => ['branch_id' => ['Tài khoản chưa được thiết lập chi nhánh']]], 422);
        }
        return response()->json($response, 200);
    }
}
