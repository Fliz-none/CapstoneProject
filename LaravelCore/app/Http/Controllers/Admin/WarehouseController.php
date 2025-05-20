<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class WarehouseController extends Controller
{
    const NAME = 'Warehouse',
        RULES = [
            'name' => ['required', 'string', 'min:2', 'max:125'],
            'branch_id' => ['nullable', 'numeric',],
            'note' => ['nullable', 'string', 'min:2', 'max:125'],
            'address' => ['nullable', 'string', 'min:2', 'max:125'],
        ],
        MESSAGES = [
            'name.required' => Controller::NOT_EMPTY,
            'name.string' => Controller::DATA_INVALID,
            'name.min' => Controller::MIN,
            'name.max' => Controller::MAX,
            'note.string' => Controller::DATA_INVALID,
            'note.min' => Controller::MIN,
            'note.max' => Controller::MAX,
            'address.string' => Controller::DATA_INVALID,
            'address.min' => Controller::MIN,
            'address.max' => Controller::MAX,
            'branch_id.numeric' => Controller::DATA_INVALID,
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
            $objs = Warehouse::query();
            switch ($request->key) {
                case 'list':
                    $result = $objs->orderBy('sort', 'ASC')->get();
                    break;
                case 'select2':
                    $result = $objs->where('status', '>', 0)
                        ->when($request->has('user_id'), function ($query) use ($request) {
                            $query->whereIn('id', User::find($request->user_id)->warehouses->pluck('id'));
                        })
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
                        ->prepend([
                            'id' => '',
                            'text' => 'Do not choose!'
                        ])->toArray();
                    break;
                default:
                    $obj = $objs->with('_branch')->find($request->key);
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
                $warehouses = Warehouse::with('_branch');
                return DataTables::of($warehouses)
                    ->addColumn('checkboxes', function ($obj) {
                        return '<input class="form-check-input choice" type="checkbox" name="choices[]" value="' . $obj->id . '">';
                    })
                    ->addColumn('code', function ($obj) {
                        if ($this->user->can(User::UPDATE_WAREHOUSE)) {
                            $code = '<a class="btn btn-update-warehouse fw-bold text-center text-primary" data-id="' . $obj->id . '">' . $obj->code . '</a>';
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
                                $query->where('warehouses.id', 'like', "%" . $numericKeyword . "%");
                            }
                        });
                    })
                    ->orderColumn('code', function ($query, $order) {
                        $query->orderBy('id', $order);
                    })
                    ->editColumn('name', function ($obj) {
                        if (!empty($this->user->can(User::UPDATE_WAREHOUSE))) {
                            return '<a class="btn btn-link text-decoration-none text-start btn-update-warehouse" data-id="' . $obj->id . '">' . $obj->name . '</a>';
                        } else {
                            return $obj->name;
                        }
                    })
                    ->editColumn('branch', function ($obj) {
                        if ($obj->branch_id) {
                            if (!empty($this->user->can(User::UPDATE_BRANCH))) {
                                $branch = '<a class="btn btn-link text-decoration-none text-start btn-update-branch" data-id="' . $obj->branch_id . '">' . $obj->_branch->fullName . '</a>';
                            } else {
                                $branch = $obj->_branch->fullName;
                            }
                        } else {
                            $branch = 'N/A';
                        }
                        return $branch;
                    })
                    ->editColumn('status', function ($obj) {
                        return '<span class="badge bg-' . ($obj->status ? 'success' : 'danger') . '">' . $obj->statusStr . '</span>';
                    })
                    ->orderColumn('status', function ($query, $order) {
                        $query->orderBy('status', $order);
                    })
                    ->addColumn('action', function ($obj) {
                        if (!empty($this->user->can(User::DELETE_WAREHOUSE))) {
                            return '
                                <form action="' . route('admin.warehouse.remove') . '" method="post" class="save-form">
                                    <input type="hidden" name="_token" value="' . csrf_token() . '"/>
                                    <input type="hidden" name="choices[]" value="' . $obj->id . '" data-id="' . $obj->id . '"/>
                                    <button type="submit" class="btn btn-link text-decoration-none btn-remove">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </form>';
                        }
                    })
                    ->rawColumns(['checkboxes', 'code', 'name', 'branch', 'status', 'action'])
                    ->make(true);
            } else {
                $pageName = self::NAME . ' management';
                return view('admin.warehouses', compact('pageName'));
            }
        }
    }

    public function sort(Request $request)
    {
        $sort = $request->input('sort');
        foreach ($sort as $index => $id) {
            Warehouse::where('id', $id)->update(['sort' => $index + 1]);
        }
        return response()->json(['msg' => 'The sort order has been updated!'], 200);
    }

    public function create(Request $request)
    {
        $request->validate(self::RULES, self::MESSAGES);
        if (!empty($this->user->can(User::CREATE_WAREHOUSE))) {
            try {
                $warehouse = Warehouse::create([
                    'name' => $request->name,
                    'branch_id' => $request->branch_id,
                    'address' => $request->address,
                    'note' => $request->note,
                    'status' => $request->status,
                ]);

                LogController::create('create', self::NAME, $warehouse->id);
                cache()->forget('warehouses');
                $response = array(
                    'status' => 'success',
                    'msg' => 'Created ' . self::NAME . ' ' . $warehouse->name
                );
            } catch (\Exception $e) {
                log_exception($e);
                return response()->json(['errors' => ['error' => ['An error occurred: ' . $e->getMessage()]]], 422);
            }
        } else {
            return response()->json(['errors' => ['role' => ['Action not authorized!']]], 422);
        }
        return response()->json($response, 200);
    }

    public function update(Request $request)
    {
        $request->validate(self::RULES, self::MESSAGES);
        if (!empty($this->user->can(User::UPDATE_WAREHOUSE))) {
            if ($request->has('id')) {
                try {
                    $warehouse = Warehouse::find($request->id);
                    if ($warehouse) {
                        $warehouse->update([
                            'name' => $request->name,
                            'branch_id' => $request->branch_id,
                            'address' => $request->address,
                            'note' => $request->note,
                            'status' => $request->status,
                        ]);

                        LogController::create('update', self::NAME, $warehouse->id);
                        cache()->forget('warehouses');
                        $response = array(
                            'status' => 'success',
                            'msg' => 'Updated ' . self::NAME . ' ' . $warehouse->name
                        );
                    } else {
                        $response = array(
                            'status' => 'error',
                            'msg' => 'An error occurred, please reload the page and try again!'
                        );
                    }
                } catch (\Exception $e) {
                    log_exception($e);
                    return response()->json(['errors' => ['error' => ['An error occurred: ' . $e->getMessage()]]], 422);
                }
            } else {
                $response = array(
                    'status' => 'error',
                    'msg' => 'An error occurred, please reload the page and try again!'
                );
            }
        } else {
            return response()->json(['errors' => ['role' => ['Action not authorized!']]], 422);
        }
        return response()->json($response, 200);
    }

    public function remove(Request $request)
    {
        $success = [];
        $fail = [];
        $msg = '';

        if ($this->user->can(User::DELETE_WAREHOUSE)) {
            foreach ($request->choices as $key => $id) {
                $obj = Warehouse::find($id);
                if ($obj->canRemove()) {
                    $obj->delete();
                    cache()->forget('warehouses');
                    LogController::create("delete", self::NAME, $obj->id);
                    array_push($success, $obj->name);
                } else {
                    array_push($fail, $obj->name);
                }
            }
            if (count($success)) {
                $msg = 'Deleted ' . self::NAME . ' ' . implode(', ', $success) . '. ';
            }
            if (count($fail)) {
                $msg .= implode(', ', $fail) . ', could not be deleted!';
            }
            $response = array(
                'status' => 'success',
                'msg' => $msg
            );
        } else {
            return response()->json(['errors' => ['role' => ['Action not authorized!']]], 422);
        }
        return response()->json($response, 200);
    }
}
