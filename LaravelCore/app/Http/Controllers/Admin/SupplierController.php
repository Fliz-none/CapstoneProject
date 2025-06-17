<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class SupplierController extends Controller
{
    const NAME = 'Supplier';

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
                'name.max' => Controller::$MAX,
                'phone.required' => Controller::$NOT_EMPTY,
                'phone.numeric' => Controller::$DATA_INVALID,
                'phone.digits' => __('messages.supplier.phone_regex'),
                'phone.regex' => Controller::$DATA_INVALID,
                'phone.unique' => __('messages.supplier.phone_unique'),
                'email.required' => Controller::$NOT_EMPTY,
                'email.string' => Controller::$DATA_INVALID,
                'email.min' => Controller::$MIN,
                'email.max' => Controller::$MAX,
                'email.email' => Controller::$DATA_INVALID,
                'email.unique' => __('messages.supplier.email_unique'),
                'address.required' => Controller::$NOT_EMPTY,
                'address.string' => Controller::$DATA_INVALID,
                'address.min' => Controller::$MIN,
                'address.max' => Controller::$MAX,
                'organ.string' => Controller::$DATA_INVALID,
                'organ.min' => Controller::$MIN,
                'organ.max' => Controller::$MAX,
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
                    $result = Supplier::whereStatus(1)->get();
                    break;
                case 'select2':
                    $result = Supplier::where('status', '>', 0)
                        ->where(function ($query) use ($request) {
                            $query->where('name', 'LIKE', '%' . $request->q . '%')
                                ->orWhere('phone', 'LIKE', '%' . $request->q . '%')
                                ->orWhere('email', 'LIKE', '%' . $request->q . '%')
                                ->orWhere('organ', 'LIKE', '%' . $request->q . '%');
                        })
                        ->orderByDesc('id')
                        ->distinct()
                        ->get()
                        ->map(function ($obj) {
                            return [
                                'id' => $obj->id,
                                'text' => $obj->name . ($obj->organ != null ? ' - ' . $obj->organ : '')
                            ];
                        });
                    break;
                default:
                    $supplier = Supplier::find($request->key);
                    if ($supplier) {
                        $result = $supplier;
                    } else {
                        abort(404);
                    }
                    break;
            }
            return response()->json($result, 200);
        } else {
            if ($request->ajax()) {
                $objs = Supplier::select('*');
                return DataTables::of($objs)
                    ->addColumn('checkboxes', function ($obj) {
                        return '<input class="form-check-input choice" type="checkbox" name="choices[]" value="' . $obj->id . '">';
                    })
                    ->addColumn('code', function ($obj) {
                        if ($this->user->can(User::UPDATE_SUPPLIER)) {
                            $code = '<a class="btn btn-link text-decoration-none btn-update-supplier fw-bold p-0" data-id="' . $obj->id . '">' . $obj->code . '</a>';
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
                                $query->where('suppliers.id', 'like', "%" . $numericKeyword . "%");
                            }
                        });
                    })
                    ->orderColumn('code', function ($query, $order) {
                        $query->orderBy('id', $order);
                    })
                    ->editColumn('address', function ($obj) {
                        return '<div class="text-start">' . $obj->address . '</div>';
                    })
                    ->editColumn('status', function ($obj) {
                        return '<span class="badge bg-' . ($obj->status ? 'success' : 'danger') . '">' . $obj->statusStr . '</span>';
                    })
                    ->orderColumn('status', function ($query, $order) {
                        $query->orderBy('status', $order);
                    })
                    ->addColumn('action', function ($obj) {
                        if (!empty($this->user->can(User::DELETE_SUPPLIER))) {
                            return '
                                <form action="' . route('admin.supplier.remove') . '" method="post" class="save-form">
                                    <input type="hidden" name="_token" value="' . csrf_token() . '"/>
                                    <input type="hidden" name="choices[]" value="' . $obj->id . '" data-id="' . $obj->id . '"/>
                                    <button class="btn btn-link text-decoration-none btn-remove">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </form>';
                        }
                    })
                    ->rawColumns(['checkboxes', 'code', 'address', 'status', 'action'])
                    ->make(true);
            } else {
                $pageName = self::NAME . ' management';
                return view('admin.suppliers', compact('pageName'));
            }
        }
    }

    public function create(Request $request)
    {
        $rules = [
            'name' => ['required', 'string', 'max:125'],
            'phone' => ['nullable', 'numeric', 'digits:10', 'regex:/^(0|\+84)(\s|\.)?((3[2-9])|(5[689])|(7[06-9])|(8[1-689])|(9[0-46-9]))(\d)(\s|\.)?(\d{3})(\s|\.)?(\d{3})$/'],
            'email' => ['nullable', 'string', 'min:5', 'email', 'max:125', 'unique:suppliers'],
            'address' => ['nullable', 'string', 'min:2', 'max:125'],
            'organ' => ['nullable', 'string', 'min:2', 'max:125'],
        ];
        $request->validate($rules, self::$MESSAGES);

        if (!empty($this->user->can(User::CREATE_SUPPLIER))) {
            try {
                $supplier = Supplier::create([
                    'name' => $request->name,
                    'phone' => $request->phone,
                    'email' => $request->email,
                    'address' => $request->address,
                    'organ' => $request->organ,
                    'status' => $request->has('status'),
                    'note' => $request->note
                ]);
                $response = array(
                    'status' => 'success',
                    'msg' => __('messages.created') . __('messages.supplier.supplier') . ' ' . $supplier->name
                );
            } catch (\Exception $e) {
                log_exception($e);
                return response()->json(['errors' => ['error' => [__('messages.error') . $e->getMessage()]]], 422);
            }
        } else {
            return response()->json(['errors' => ['role' => [__('messages.role')]]], 422);
        }
        return response()->json($response, 200);
    }

    public function update(Request $request)
    {
        $rules = [
            'name' => ['required', 'string', 'max:125'],
            'phone' => ['required', 'numeric', 'digits:10', 'regex:/^(0|\+84)(\s|\.)?((3[2-9])|(5[689])|(7[06-9])|(8[1-689])|(9[0-46-9]))(\d)(\s|\.)?(\d{3})(\s|\.)?(\d{3})$/', Rule::unique('suppliers')->ignore($request->id)],
            'email' => ['required', 'string', 'min:5', 'email', 'max:125', Rule::unique('suppliers')->ignore($request->id)],
            'address' => ['required', 'string', 'min:2', 'max:125'],
            'organ' => ['nullable', 'string', 'min:2', 'max:125'],
        ];
        $request->validate($rules, self::$MESSAGES);

        if (!empty($this->user->can(User::UPDATE_SUPPLIER))) {
            if ($request->has('id')) {
                try {
                    $supplier = Supplier::find($request->id);
                    if ($supplier) {
                        $supplier->update([
                            'name' => $request->name,
                            'phone' => $request->phone,
                            'email' => $request->email,
                            'address' => $request->address,
                            'organ' => $request->organ,
                            'note' => $request->note,
                            'status' => $request->has('status'),
                        ]);

                        LogController::create('2', self::NAME, $supplier->id);
                        $response = array(
                            'status' => 'success',
                            'msg' => __('messages.updated') . __('messages.supplier.supplier') . ' ' . $supplier->name
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
            return response()->json(['errors' => ['role' => [__('messages.role')]]], 422);
        }
        return response()->json($response, 200);
    }

    public function remove(Request $request)
    {
        $success = [];
        $fail = [];
        if ($this->user->can(User::DELETE_SUPPLIER)) {
            foreach ($request->choices as $key => $id) {
                $obj = Supplier::find($id);
                if (!count($obj->imports)) {
                    $obj->delete();
                    LogController::create("3", self::NAME, $obj->id);
                    array_push($success, $obj->name);
                } else {
                    array_push($fail, $obj->name);
                }
            }
            $msg = '';
            if (count($success)) {
                $msg .= __('messages.deleted') . __('messages.supplier.supplier'). ' ' . implode(', ', $success) . '. ';
            }
            if (count($fail)) {
                $msg .= implode(', ', $fail) . __('messages.being_used');
            }
            $response = array(
                'status' => 'success',
                'msg' => $msg
            );
        } else {
            return response()->json(['errors' => ['role' => [__('messages.role')]]], 422);
        }
        return response()->json($response, 200);
    }
}
