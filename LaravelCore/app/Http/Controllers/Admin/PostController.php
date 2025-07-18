<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;

class PostController extends Controller
{
    const NAME = 'Post';

    public static array $MESSAGES;

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
           'title.required' => __('messages.post.post').': '. Controller::$NOT_EMPTY,
            'title.string' => __('messages.post.post').': '. Controller::$DATA_INVALID,
            'title.max' => __('messages.post.post').': '. Controller::$MAX,
            'excerpt.string' =>  Controller::$DATA_INVALID,
            'excerpt.max' =>  Controller::$MAX,
            'status.numeric' => __('messages.post.status') .': '. Controller::$NOT_EMPTY,
            'status.required' => __('messages.post.status') .': '. Controller::$DATA_INVALID,
            'category_id.numeric' => __('messages.post.category') .': '. Controller::$DATA_INVALID,
            'category_id.required' => __('messages.post.category') .': '. Controller::$NOT_EMPTY,
            'image.string' => __('messages.post.image') .': '. Controller::$DATA_INVALID,
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
        $categories = cache()->get('categories')->whereNull('parent_id');
        if (isset($request->key)) {
            switch ($request->key) {
                case 'new':
                    $pageName = __('messages.post.new_post');
                    return view('admin.post', compact('pageName', 'categories'));
                case 'list':
                    $ids = json_decode($request->ids);
                    $obj = Post::orderBy('sort', 'ASC')->when(count($ids), function ($query) use ($ids) {
                        $query->whereIn('id', $ids);
                    })->get();
                    return response()->json($obj, 200);
                default:
                    $post = Post::find($request->key);
                    if ($post) {
                        if ($request->ajax()) {
                            return response()->json($post, 200);
                        } else {
                            $pageName = $post->title;
                            return view('admin.post', compact('pageName', 'post'));
                        }
                    } else {
                        return redirect()->route('admin.post', ['key' => 'new'],);
                    }
            }
        } else {
            $objs = Post::with('category');
            if ($request->ajax()) {
                return DataTables::of($objs)
                    ->addColumn('checkboxes', function ($obj) {
                        return '<input class="form-check-input choice" type="checkbox" name="choices[]" value="' . $obj->id . '">';
                    })
                    ->addColumn('code', function ($obj) {
                        if ($this->user->can(User::UPDATE_POST)) {
                            $code = '<a class="btn btn-link text-decoration-none btn-update-post fw-bold p-0" data-id="' . $obj->id . '">' . $obj->code . '</a>';
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
                                $query->where('posts.id', 'like', "%" . $numericKeyword . "%");
                            }
                        });
                    })
                    ->orderColumn('code', function ($query, $order) {
                        $query->orderBy('id', $order);
                    })
                    ->editColumn('title', function ($obj) {
                        if (!empty($this->user->can(User::UPDATE_POST))) {
                            return (!empty($this->user->can(User::READ_POST))) ? '<a href="' . route('admin.post', ['key' => $obj->id]) . '" class="btn btn-link text-decoration-none text-start">' . $obj->title . '</a>' : $obj->title;
                        } else {
                            return $obj->title;
                        }
                    })
                    ->filterColumn('title', function ($query, $keyword) {
                        $query->where('posts.title', 'like', "%" . $keyword . "%");
                    })
                    ->orderColumn('title', function ($query, $order) {
                        $query->orderBy('title', $order);
                    })
                    ->editColumn('content', function ($obj) {
                        // nếu quá dài thì hiện ...
                        return Str::limit($obj->content, 200, '...');
                    })
                    ->editColumn('author', function ($obj) {
                        if (!empty($this->user->can(User::UPDATE_POST))) {
                            return '<a class="btn btn-link text-decoration-none text-start btn-update-user" data-id="' . $obj->author->id . '">' . $obj->author->fullName . '</a>';
                        } else {
                            return $obj->author->fullName;
                        }
                    })
                    ->orderColumn('author', function ($query, $order) {
                        $query->orderBy('author_id', $order);
                    })
                    ->editColumn('image', function ($obj) {
                        return '<img src="' . $obj->imageUrl . '" class="thumb cursor-pointer object-fit-cover" alt="Ảnh ' . $obj->name . '" width="60px" height="60px">';
                    })
                    ->editColumn('category', function ($obj) {
                        if (!empty($this->user->can(User::UPDATE_POST))) {
                            return '<a class="btn btn-link text-decoration-none text-start btn-update-category" data-id="' . $obj->category->id . '">' . $obj->category->fullName . '</a>';
                        } else {
                            return $obj->category->fullName;
                        }
                    })
                    ->orderColumn('category', function ($query, $order) {
                        $query->orderBy('category_id', $order);
                    })
                    ->editColumn('type', function ($obj) {
                        return $obj->typeStr;
                    })
                    ->editColumn('status', function ($obj) {
                        return $obj->statusStr;
                    })
                    ->orderColumn('status', function ($query, $order) {
                        $query->orderBy('status', $order);
                    })
                    ->addColumn('action', function ($obj) {
                        $str = '';
                        if ($this->user->can(User::DELETE_POST)) {
                            $str .= '<div class="d-flex justify-content-center">
                            <form method="post" action="' . route('admin.post.remove') . '" class="save-form">
                                    <input type="hidden" name="choices[]" value="' . $obj->id . '"/>
                                    <button class="btn btn-link text-decoration-none btn-remove" data-bs-toggle="tooltip" data-bs-placement="top"
                                    data-bs-title="Xóa">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>';
                        }
                        return $str;
                    })
                    ->rawColumns(['checkboxes', 'title', 'author', 'category', 'image', 'status', 'action', 'content'])
                    ->setTotalRecords($objs->count())
                    ->make(true);
            } else {
                $pageName = self::NAME . ' management';
                return view('admin.posts', compact('pageName'));
            }
        }
    }

    public function save(Request $request)
    {
        $rules = [
            'title' => ['required', 'string', 'max:125'],
            'excerpt' => ['nullable', 'string', 'max:191'],
            'status' => ['required', 'numeric'],
            'image' => ['nullable', 'string'],
            'category_id' => ['required', 'numeric'],
            'description' => ['nullable'],
        ];

        $request->validate($rules, self::$MESSAGES);
        if (!empty($this->user->can(User::UPDATE_POST)) || !empty($this->user->can(User::CREATE_POST))) {
            try {
                $post = Post::updateOrCreate(
                    ['id' => $request->id],
                    [
                        'title' => $request->title,
                        'slug' => Str::slug($request->title),
                        'excerpt' => $request->excerpt,
                        'content' => $request->input('content'),
                        'category_id' => $request->category_id,
                        'status' => $request->status,
                        'author_id' => Auth::user()->id,
                    ]
                );
                if (isset($request->image)) {
                    $post->image = $request->image;
                    $post->save();
                }
                $action = ($request->id) ? __('messages.update') : __('messages.add');
                $response = array(
                    'status' => 'success',
                    'msg' => __('messages.post.success').' ' . $action . ' ' . __('messages.post.post') . ' ' . $post->title
                );
            } catch (\Exception $e) {
                log_exception($e);
                DB::rollBack();
                return response()->json(['errors' => ['error' => [__('messages.error') . $e->getMessage()]]], 422);
            }
        } else {
            return response()->json(['errors' => ['role' => [__('messages.post.role')]]], 422);
        }
        return redirect()->route('admin.post', ['key' => $post->id])->with('response', $response);
    }

    public function remove(Request $request)
    {
        $success = [];
        $fail = [];
        if ($this->user->can(User::DELETE_POST)) {
            foreach ($request->choices as $key => $id) {
                $obj = Post::find($id);
                if ($obj->canRemove()) {
                    $obj->delete();
                    array_push($success, $obj->name);
                } else {
                    array_push($fail, $obj->name);
                }
            }
            if (count($success)) {
                $msg = __('messages.deleted') . ' ' . __('messages.post.post') . ' ' . implode(', ', $success);
            }
            if (count($fail) && count($success)) {
                $msg .= ' except ' . implode(', ', $fail) . '!';
            } else if (count($fail)) {
                $msg = __('messages.cannot_delete') . ' ' . __('messages.post.post') . ' ' . implode(', ', $fail) . '!';
            }
            $response = array(
                'status' => 'success',
                'msg' => $msg
            );
        } else {
            return response()->json(['errors' => ['role' => [__('messages.post.role')]]], 422);
        }
        return response()->json($response, 200);
    }
}
