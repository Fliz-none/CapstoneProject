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
    const NAME = 'Attribute',
        RULES = [
            'key' => ['required', 'string', 'min: 3', 'max:125'],
            'value' => ['required', 'string', 'min: 3', 'max:125'],
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
            'key.required' => Controller::$NOT_EMPTY,
            'key.string' => Controller::$DATA_INVALID,
            'key.min' => Controller::$MIN,
            'key.max' => Controller::$MAX,
            'value.required' => Controller::$NOT_EMPTY,
            'value.string' => Controller::$DATA_INVALID,
            'value.min' => Controller::$MIN,
            'value.max' => Controller::$MAX,
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
                $pageName = self::NAME . ' management';
                return view('admin.attributes', compact('pageName'));
            }
        }
    }

    public function create(Request $request)
    {
        $request->validate(self::RULES, self::$MESSAGES);
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
                    'msg' => __('messages.created') . ' '. __('messages.attribute' )
                );
            } catch (\Exception $e) {
                DB::rollBack();
                Controller::resetAutoIncrement(['attributes', 'logs']);
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
        $request->validate(self::RULES, self::$MESSAGES);
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
                        $response = array(
                            'status' => 'success',
                            'msg' => __('messages.updated') . $attribute->key
                        );
                    } else {
                        $response = array(
                            'status' => 'error',
                            'msg' => __('messages.msg')
                        );
                    }
                } catch (\Exception $e) {
                    Controller::resetAutoIncrement(['attributes', 'logs']);
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
            return response()->json(['errors' => ['role' => [__('messages.role')]]], 403);
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
        $response = array(
            'status' => 'success',
            'msg' => __('messages.deleted') . ' '.__('messages.attribute') . ' ' . implode(', ', $msg)
        );
        return response()->json($response, 200);
    }
}
