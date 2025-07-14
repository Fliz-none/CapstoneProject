<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Catalogue;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class CatalogueController extends Controller
{
    const NAME = 'Catalogue';
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
                'parent_id.numeric' => Controller::$DATA_INVALID,
                'avatar.string' => Controller::$DATA_INVALID,
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
        $objs = Catalogue::whereStatus(1)->with('_parent');
        if (isset($request->key)) {
            switch ($request->key) {
                case 'list':
                    $ids = json_decode($request->ids);
                    $result = $objs->orderBy('sort', 'ASC')->when(count($ids), function ($query) use ($ids) {
                        $query->whereIn('id', $ids);
                    })->get();
                    break;
                case 'select2':
                    $result = $objs->where('name', 'LIKE', '%' . $request->q . '%')
                        ->orderByDesc('id')
                        ->distinct()
                        ->get()
                        ->map(function ($obj) {
                            return [
                                'id' => $obj->id,
                                'text' => $obj->name
                            ];
                        })->push(['id' => 0, 'text' => 'Do not choose']);
                    break;
                case 'tree':
                    $catalogues = $objs->whereNull('parent_id')->with('children')->get();
                    return view('admin.includes.catalogue_recursion', ['catalogues' => $catalogues]);
                    break;
                default:
                    $obj = Catalogue::with('_parent')->find($request->key);
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
                        if ($this->user->can(User::UPDATE_CATALOGUE)) {
                            $code = '<a class="btn btn-link text-decoration-none btn-update-catalogue fw-bold p-0" data-id="' . $obj->id . '">' . $obj->code . '</a>';
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
                                $query->where('catalogues.id', 'like', "%" . $numericKeyword . "%");
                            }
                        });
                    })
                    ->orderColumn('code', function ($query, $order) {
                        $query->orderBy('id', $order);
                    })
                    ->editColumn('name', function ($obj) {
                        if (!empty($this->user->can(User::UPDATE_CATALOGUE))) {
                            return '<a class="btn btn-link text-decoration-none text-start btn-update-catalogue" data-id="' . $obj->id . '">' . $obj->name . '</a>';
                        } else {
                            return $obj->name;
                        }
                    })
                    ->editColumn('avatar', function ($obj) {
                        return '<img src="' . $obj->avatarUrl . '" class="thumb cursor-pointer object-fit-cover" style="width: 60px; height: 60px">';
                    })
                    ->editColumn('status', function ($obj) {
                        return '<span class="badge bg-' . ($obj->status ? 'success' : 'danger') . '">' . $obj->statusStr . '</span>';
                    })
                    ->orderColumn('status', function ($query, $order) {
                        $query->orderBy('status', $order);
                    })
                    ->addColumn('parent', function ($obj) {
                        return $obj->_parent ? $obj->_parent->name : __('messages.unknown');
                    })
                    ->filterColumn('parent', function ($query, $keyword) {
                        $query->whereHas('parent', function ($parentQuery) use ($keyword) {
                            $parentQuery->where('name', 'like', '%' . $keyword . '%');
                        });
                    })
                    ->addColumn('action', function ($obj) {
                        if (!empty($this->user->can(User::DELETE_CATALOGUE))) {
                            return '
                        <form action="' . route('admin.catalogue.remove') . '" method="post" class="save-form">
                            <input type="hidden" name="_token" value="' . csrf_token() . '"/>
                            <input type="hidden" name="choices[]" value="' . $obj->id . '" data-id="' . $obj->id . '"/>
                            <button type="submit" class="btn btn-link text-decoration-none btn-remove">
                                <i class="bi bi-trash3"></i>
                            </button>
                        </form>';
                        }
                    })
                    ->rawColumns(['checkboxes', 'code', 'name', 'avatar', 'status', 'action'])
                    ->setTotalRecords($objs->count())
                    ->make(true);
            } else {
                $pageName = self::NAME . ' management';
                return view('admin.catalogues', compact('pageName'));
            }
        }
    }

    public function sort(Request $request)
    {
        $ids = $request->input('sort');
        if (count($ids) == Catalogue::count()) {
            foreach ($ids as $index => $id) {
                Catalogue::where('id', $id)->update(['sort' => $index + 1]);
            }
        } else {
            $sorts = Catalogue::whereIn('id', $ids)->orderBy('sort', 'ASC')->pluck('sort');
            foreach ($sorts as $index => $sort) {
                Catalogue::find($ids[$index])->update(['sort' => $index + 1]);
            }
        }
        return response()->json(['msg' => __('messages.category.sort_success')], 200);
    }

    public function create(Request $request)
    {
        $rules = [
            'name' => ['required', 'string', 'min:2', 'max:125'],
            'note' => ['nullable', 'string', 'min:2', 'max:320'],
            'parent_id' => ['nullable', 'numeric'],
            'avatar' => ['nullable', 'string'],
        ];
        $request->validate($rules, self::$MESSAGES);
        if (!empty($this->user->can(User::CREATE_CATALOGUE))) {
            try {
                $catalogue = Catalogue::create([
                    'name' => $request->name,
                    'slug' => Str::slug($request->name),
                    'parent_id' => $request->parent_id ? $request->parent_id : null,
                    'note' => $request->note,
                    'status' => $request->has('status'),
                    'avatar' => $request->avatar,
                ]);
                cache()->forget('catalogues');
                $response = array(
                    'status' => 'success',
                    'msg' => __('messages.created') . ' ' . __('messages.category.category') . ' ' . $catalogue->name
                );
            } catch (\Exception $e) {
                log_exception($e);
                return response()->json(['errors' => ['error' => [__('messages.error') . $e->getMessage()]]], 422);
            }
        } else {
            return response()->json(['errors' => ['role' => [__('messages.role')]]], 403);
        }
        return response()->json($response, 200);
    }

    public function update(Request $request)
    {
        $rules = [
            'name' => ['required', 'string', 'min:2', 'max:125'],
            'note' => ['nullable', 'string', 'min:2', 'max:320'],
            'parent_id' => [
                'nullable',
                'numeric',
                function ($attribute, $value, $fail) use ($request) {
                    if ($request->has('id') && $value > $request->id) {
                        $fail(__('messages.category.parent_error'));
                    }
                }
            ],
            'avatar' => ['nullable', 'string'],
        ];
        $request->validate($rules, self::$MESSAGES);
        if (!empty($this->user->can(User::UPDATE_CATALOGUE))) {
            if ($request->has('id')) {
                try {
                    $catalogue = Catalogue::find($request->id);
                    if ($request->id == $request->parent_id) {
                        $response = array(
                            'status' => 'error',
                            'msg' => __('messages.category.parent_diffirent')
                        );
                        return response()->json($response, 200);
                    }
                    if ($catalogue) {
                        $catalogue->update([
                            'name' => $request->name,
                            'slug' => Str::slug($request->name),
                            'parent_id' => $request->parent_id ? $request->parent_id : null,
                            'note' => $request->note,
                            'status' => $request->has('status'),
                            'avatar' => $request->avatar,
                        ]);
                    } else {
                        $response = array(
                            'status' => 'error',
                            'msg' => __('messages.category.msg')
                        );
                    }

                    cache()->forget('catalogues');
                    $response = array(
                        'status' => 'success',
                        'msg' => __('messages.updated') . ' ' . __('messages.category.category') . ' ' . $catalogue->name
                    );
                } catch (\Exception $e) {
                    log_exception($e);
                    return response()->json(['errors' => ['error' => [__('messages.error') . $e->getMessage()]]], 422);
                }
            } else {
            }
        } else {
            return response()->json(['errors' => ['role' => [__('messages.role')]]], 403);
        }
        return response()->json($response, 200);
    }

    public function remove(Request $request)
    {
        $msg = [];
        foreach ($request->choices as $key => $id) {
            $obj = Catalogue::find($id);
            $obj->delete();
            cache()->forget('catalogues');
            array_push($msg, $obj->name);
        }
        $response = array(
            'status' => 'success',
            'msg' => __('messages.deleted') . ' ' . __('messages.category.category') . ' ' . implode(', ', $msg)
        );
        return response()->json($response, 200);
    }
}
