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
    const NAME = 'Category',
        RULES = [
            'name' => ['required', 'string', 'min:2', 'max:125'],
            'note' => ['nullable', 'string', 'min:2', 'max:320']
        ];
    public static array $MESSAGES = [];


    public function __construct()
    {
        parent::__construct();
        if ($this->user === null) {
            $this->user = Auth::user();
        }
        $this->middleware(['admin', 'auth']);

        $this->middleware(function ($request, $next) {
            // Locale đã được set xong ở đây
            Controller::init();
            self::$MESSAGES = [
                'name.required' => Controller::$NOT_EMPTY,
                'name.string' => Controller::$DATA_INVALID,
                'name.min' => Controller::$MIN,
                'name.max' => Controller::$MAX,
                'note.string' => Controller::$DATA_INVALID,
                'note.min' => Controller::$MIN,
                'note.max' => Controller::$MAX,
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
                        return '<span class="badge bg-' . ($obj->status ? 'success' : 'danger') . '">' . $obj->statusStr . '</span>';
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
                $pageName = self::NAME . ' management';
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
        return response()->json(['msg' => __('messages.sort.sort_success')], 200);
    }

    public function create(Request $request)
    {
        $request->validate(self::RULES, self::$MESSAGES);
        if (!empty($this->user->can(User::CREATE_CATEGORY))) {
            try {
                $category = Category::create([
                    'name' => $request->name,
                    'slug' => Str::slug($request->name),
                    'note' => $request->note,
                    'status' => $request->has('status'),
                ]);

                cache()->forget('categories');
                $response = array(
                    'status' => 'success',
                    'msg' => __('messages.created') . ' ' . __('messages.category.category') . ' ' . $category->name
                );
            } catch (\Exception $e) {
                log_exception($e);
                return response()->json(['errors' => ['error' => [__('messages.error') . $e->getMessage()]]], 422);
            }
        } else {
            return response()->json(['errors' => ['error' => [__('messages.role')]]], 403);
        }
        return response()->json($response, 200);
    }

    public function update(Request $request)
    {
        $request->validate(self::RULES, self::$MESSAGES);
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

                        cache()->forget('categories');
                        $response = array(
                            'status' => 'success',
                            'msg' => __('messages.updated') . ' ' . __('messages.category.category') . ' ' . $category->name
                        );
                    } else {
                        $response = array(
                            'status' => 'error',
                            'msg' => __('messages.msg')
                        );
                    }
                } catch (\Exception $e) {
                    log_exception($e);
                    return response()->json(['errors' => ['error' => [__('messages.error') . $e->getMessage()]]], 422);
                }
            } else {
                $response = array(
                    'status' => 'error',
                    'msg' => __('messages.msg')
                );
            }
        } else {
            return response()->json(['errors' => ['error' => [__('messages.role')]]], 403);
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
                    array_push($success, $obj->name);
                } else {
                    array_push($fail, $obj->name);
                }
            }
            if (count($success)) {
                $msg = __('messages.deleted') . ' ' . __('messages.category.category') . ' ' . implode(', ', $success) . '. ';
            }
            if (count($fail)) {
                $msg .= implode(', ', $fail) . __('messages.categories.being_used');
            }
            $response = array(
                'status' => 'success',
                'msg' => $msg
            );
        } else {
            return response()->json(['errors' => ['error' => [__('messages.role')]]], 422);
        }
        return response()->json($response, 200);
    }
}
