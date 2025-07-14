<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Discount;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class DiscountController extends Controller
{
    const NAME = 'Discount',
        RULES = [
            'name' => ['required', 'string', 'min:1', 'max:125'],
            'branch_id' => ['required', 'numeric',],
            'type' => ['required', 'numeric'],
            'start_date' => ['required'],
            'end_date' => ['required'],
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
                'branch_id.numeric' => Controller::$DATA_INVALID,
                'branch_id.required' => __('messages.discount_.select_branch').'!',
                'type.required' => Controller::$NOT_EMPTY,
                'type.numeric' => Controller::$DATA_INVALID,
                'start_date.required' => Controller::$NOT_EMPTY,
                'end_date.required' => Controller::$NOT_EMPTY,
            ];

            return $next($request);
        });
    }
    public function index(Request $request)
    {
        if (isset($request->key)) {
            $objs = Discount::query();
            switch ($request->key) {
                case 'list':
                    $result = $objs->get();
                    break;
                default:
                    $obj = $objs->with('units._variable._product', 'branch')->find($request->key);
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
                $objs = Discount::with('units')
                    ->when($request->has('branch_id'), function ($query) use ($request) {
                        $query->where('branch_id', $request->branch_id);
                    }, function ($query) {
                        $query->whereIn('branch_id', $this->user->branches->pluck('id'));
                    });
                return DataTables::of($objs)
                    ->addColumn('checkboxes', function ($obj) {
                        return '<input class="form-check-input choice" type="checkbox" name="choices[]" value="' . $obj->id . '">';
                    })
                    ->addColumn('code', function ($obj) {
                        if ($this->user->can(User::UPDATE_DISCOUNT)) {
                            $code = '<a class="btn btn-update-discount fw-bold text-center text-primary" data-id="' . $obj->id . '">' . $obj->code . '</a>';
                        } else {
                            $code = '<span class="fw-bold">' . $obj->code . '</span>';
                        }
                        return $code;
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
                                $query->where('id', 'like', "%" . $numericKeyword . "%");
                            }
                        });
                    })
                    ->orderColumn('code', function ($query, $order) {
                        $query->orderBy('id', $order);
                    })
                    ->editColumn('name', function ($obj) {
                        if (!empty($this->user->can(User::UPDATE_DISCOUNT))) {
                            return '<a class="btn btn-link text-decoration-none text-start btn-update-discount" data-id="' . $obj->id . '">' . $obj->name . '</a>';
                        } else {
                            return $obj->name;
                        }
                    })
                    ->editColumn('branch', function ($obj) {
                        if ($obj->branch_id) {
                            if (!empty($this->user->can(User::UPDATE_BRANCH))) {
                                $branch = '<a class="btn btn-link text-decoration-none text-start btn-update-branch" data-id="' . $obj->branch_id . '">' . $obj->branch->fullName . '</a>';
                            } else {
                                $branch = $obj->_branch->fullName;
                            }
                        } else {
                            $branch = 'N/A';
                        }
                        return $branch;
                    })
                    ->editColumn('type', function ($obj) {
                        return $obj->typeStr;
                    })
                    ->orderColumn('type', function ($query, $order) {
                        $query->orderBy('type', $order);
                    })
                    ->editColumn('validity', function ($obj) {
                        return $obj->start_date->format('d/m/Y') . ' - ' . $obj->end_date->format('d/m/Y');
                    })
                    ->editColumn('status', function ($obj) {
                        return '<span class="badge bg-' . ($obj->status ? 'success' : 'danger') . '">' . $obj->statusStr . '</span>';
                    })
                    ->orderColumn('status', function ($query, $order) {
                        $query->orderBy('status', $order);
                    })
                    ->addColumn('action', function ($obj) {
                        if (!empty($this->user->can(User::DELETE_DISCOUNT))) {
                            return '
                                <form action="' . route('admin.discount.remove') . '" method="post" class="save-form">
                                    <input type="hidden" name="_token" value="' . csrf_token() . '"/>
                                    <input type="hidden" name="choices[]" value="' . $obj->id . '" data-id="' . $obj->id . '"/>
                                    <button type="submit" class="btn btn-link text-decoration-none btn-remove">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </form>';
                        }
                    })
                    ->rawColumns(['checkboxes', 'code', 'name', 'branch', 'validity', 'status', 'action'])
                    ->make(true);
            } else {
                $pageName = self::NAME . ' management';
                return view('admin.discounts', compact('pageName'));
            }
        }
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), self::RULES, self::$MESSAGES);

        $validator->after(function ($validator) use ($request) {
            $type = (int) $request->type;

            if ($request->has('type')) {
                if (in_array($type, [0, 1])) {
                    if (is_null($request->value)) {
                        $validator->errors()->add('', __('messages.discount_.required'));
                    }
                    if (is_null($request->min_quantity)) {
                        $validator->errors()->add('min_quantity', __('messages.discount_.not_empty'));
                    }
                    if ($type == 0 && $request->value > 100) {
                        $validator->errors()->add('', __('messages.discount_.not_full'));
                    }
                }
            }

            if ($type === 2 && (is_null($request->buy_quantity) || is_null($request->get_quantity))) {
                $validator->errors()->add('', __('messages.discount_.needed'));
            }

            // Check date logic
            try {
                $start = Carbon::createFromFormat('Y-m-d', $request->start_date);
                $end = Carbon::createFromFormat('Y-m-d', $request->end_date);

                if ($end->lt($start)) {
                    $validator->errors()->add('end_date', __('messages.discount_.end_required'));
                }
            } catch (\Exception $e) {
                $validator->errors()->add('start_date', __('messages.discount_.date_required'));
            }
        });

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        if ($this->user->can(User::CREATE_DISCOUNT)) {
            try {
                $discount = Discount::create([
                    'name' => $request->name,
                    'branch_id' => $request->branch_id,
                    'type' => $request->type,
                    'apply_type' => $request->apply_type,
                    'value' => $request->type != 2 ? $request->value : null,
                    'min_quantity' => $request->type != 2 ? $request->min_quantity : 1,
                    'buy_quantity' => $request->type == 2 ? $request->buy_quantity : null,
                    'get_quantity' => $request->type == 2 ? $request->get_quantity : null,
                    'start_date' => Carbon::createFromFormat('Y-m-d', $request->start_date),
                    'end_date' => Carbon::createFromFormat('Y-m-d', $request->end_date),
                    'status' => $request->boolean('status'),
                ]);

                if ($discount) {
                    $discount->syncUnit($request->unit_ids ?? []);
                }

                $response = array(
                    'status' => 'success',
                    'msg' => __('messages.created').' '. __('messages.discount_.discount') . ' ' . $discount->name
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
        $validator = Validator::make($request->all(), self::RULES, self::$MESSAGES);

        $validator->after(function ($validator) use ($request) {
            $type = (int) $request->type;
            if ($request->has('type')) {
                if (in_array($type, [0, 1])) {
                    if (is_null($request->value)) {
                        $validator->errors()->add('',  __('messages.discount_.required'));
                    }
                    if (is_null($request->min_quantity)) {
                        $validator->errors()->add('min_quantity',  __('messages.discount_.not_empty'));
                    }
                    if ($type === 0 && (float) $request->value > 100) {
                        $validator->errors()->add('',  __('messages.discount_.not_full'));
                    }
                }
            }

            if ($type === 2 && (is_null($request->buy_quantity) || is_null($request->get_quantity))) {
                $validator->errors()->add('',  __('messages.discount_.needed'));
            }

            // Check date logic
            try {
                $start = Carbon::createFromFormat('Y-m-d', $request->start_date);
                $end = Carbon::createFromFormat('Y-m-d', $request->end_date);

                if ($end->lt($start)) {
                    $validator->errors()->add('end_date',  __('messages.discount_.end_required'));
                }
            } catch (\Exception $e) {
                $validator->errors()->add('start_date',  __('messages.discount_.date_required'));
            }
        });

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        if ($this->user->can(User::UPDATE_DISCOUNT)) {
            if ($request->has('id')) {
                try {
                    $discount = Discount::find($request->id);
                    if ($discount) {
                        $discount->update([
                            'name' => $request->name,
                            'branch_id' => $request->branch_id,
                            'type' => $request->type,
                            'apply_type' => $request->apply_type,
                            'value' => $request->type != 2 ? $request->value : null,
                            'min_quantity' => $request->type != 2 ? $request->min_quantity : 1,
                            'buy_quantity' => $request->type == 2 ? $request->buy_quantity : null,
                            'get_quantity' => $request->type == 2 ? $request->get_quantity : null,
                            'start_date' => Carbon::createFromFormat('Y-m-d', $request->start_date),
                            'end_date' => Carbon::createFromFormat('Y-m-d', $request->end_date),
                            'status' => $request->boolean('status'),
                        ]);

                        if ($discount) {
                            $discount->syncUnit($request->unit_ids ?? []);
                        }

                        $response = array(
                            'status' => 'success',
                            'msg' => __('messages.updated').' '. __('messages.discount_.discount') . ' ' . $discount->name
                        );
                    } else {
                        $response = array(
                            'status' => 'error',
                            'msg' => __('messages.discount_.msg')
                        );
                    }
                } catch (\Exception $e) {
                    log_exception($e);
                    return response()->json(['errors' => ['error' => [__('messages.error') . $e->getMessage()]]], 422);
                }
            } else {
                $response = array(
                    'status' => 'error',
                    'msg' => __('messages.discount_.msg')
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

        if ($this->user->can(User::DELETE_DISCOUNT)) {
            foreach ($request->choices as $key => $id) {
                $obj = Discount::find($id);
                $obj->delete();
                array_push($success, $obj->name);
            }
            if (count($success)) {
                $msg = __('messages.deleted').' '. __('messages.discount_.discount') . ' ' . implode(', ', $success) . '. ';
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
