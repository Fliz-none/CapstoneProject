<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use App\Models\Role;
use Illuminate\Support\Facades\Log;
use Yajra\Datatables\Datatables;
use Illuminate\Validation\Rule;

class RoleController extends Controller
{
    const NAME = 'Role';
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct()
    {
        parent::__construct();
        if ($this->user === null) {
            $this->user = Auth::user();
        }
        $this->middleware(['auth']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        if (isset($request->key)) {
            $objs = Role::query();
            switch ($request->key) {
                case 'select2':
                    if ($this->user->hasRole('Super Admin')) {
                        $objs->orWhere('roles.id', 1);
                    }
                    $result = $objs->get()->map(function ($role) {
                        return [
                            'id' => $role->id,
                            'text' => $role->name,
                        ];
                    });
                    break;
                default:
                    $obj = $objs->with('permissions')->find($request->key);
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
                $roles = Role::query();
                if ($this->user->hasRole('Super Admin')) {
                    $roles->orWhere('roles.id', 1);
                }
                return Datatables::of($roles)
                    ->editColumn('name', function ($obj) {
                        if (!empty($this->user->can(User::READ_ROLES))) {
                            return '<a class="btn btn-link text-decoration-none text-start btn-update-role" data-id="' . $obj->id . '">' . $obj->name . '</a>';
                        } else {
                            return $obj->name;
                        }
                    })
                    ->addColumn('action', function ($obj) {
                        if (!empty($this->user->can(User::DELETE_ROLE))) {
                            return '<form method="post" action="' . route('admin.role.remove') . '" class="save-form">
                                <input type="hidden" name="choices[]" value="' . $obj->id . '"/>
                                <button type="submit" class="btn btn-link text-decoration-none btn-remove cursor-pointer">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>';
                        }
                    })
                    ->editColumn('permissions', function ($obj) {
                        return count($obj->permissions) ? implode(' ', json_decode($obj->permissions->take(15)->map(function ($permission) {
                            return '<span class="badge bg-primary">' . $permission->name . '</span>';
                        }))) . ' and ' . (count($obj->permissions) - 15) . ' more permissions' : 'No permissions assigned';
                    })
                    ->rawColumns(['name', 'permissions', 'action'])
                    ->make(true);
            } else {
                $pageName = self::NAME . ' management';
                return view('admin.roles', compact('pageName'));
            }
        }
    }

    public function create(Request $request)
    {
        $rules = [
            'name' => [
                'required',
                'string',
                'min: 3',
                'max:125',
                function ($attribute, $value, $fail) use ($request) {
                    if (Role::where('name', $value)->count()) {
                        $fail('This role has already been created.');
                    }
                }
            ],
        ];
        $messages = [
            'name.unique' => __('messages.roles.unique'),
            'name.required' => __('messages.roles.required'),
            'name.string' => __('messages.roles.string'),
            'name.min' => __('messages.roles.min'),
            'name.max' => __('messages.roles.max'),
        ];
        $request->validate($rules, $messages);

        if (!empty($this->user->can(User::CREATE_ROLE))) {
            DB::beginTransaction();
            try {
                $role = Role::create([
                    'name' => $request->name,
                    'guard_name' => 'web',
                ]);

                if ($request->permissions != null) {
                    foreach ($request->permissions as $key => $id) {
                        $permission = Permission::find($id);
                        $role->givePermissionTo($permission);
                    }
                }

                cache()->forget('roles');
                cache()->forget('dealers');
                cache()->forget('cashiers');

                DB::commit();
                $response = [
                    'status' => 'success',
                    'msg' =>  __('messages.created') . __('messages.roles.role') . ' ' . $role->name,
                ];
            } catch (\Exception $e) {
                DB::rollBack();
                log_exception($e);
                Controller::resetAutoIncrement(['roles', 'permissions']);
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
            'name' => [
                'required',
                'string',
                'min: 3',
                'max:125',
                function ($attribute, $value, $fail) use ($request) {
                    if (Role::where('name', $value)->where('id', '!=', $request->id)->count()) {
                        $fail(__('messages.roles.role') . ' ' . __('messages.created'));
                    }
                }
            ],
        ];

        $messages = [
            'name.unique' => __('messages.roles.unique'),
            'name.required' => __('messages.roles.required'),
            'name.string' => __('messages.roles.string'),
            'name.min' => __('messages.roles.min'),
            'name.max' => __('messages.roles.max'),
        ];

        $request->validate($rules, $messages);
        if (!empty($this->user->can(User::UPDATE_ROLE))) {
            if ($request->has('id')) {
                DB::beginTransaction();
                try {
                    $role = Role::find($request->id);
                    if ($role) {
                        $role->update([
                            'name' => $request->name,
                        ]);

                        // $permissions = Permission::all();
                        // foreach ($permissions as $key => $permission) {
                        //     $role->revokePermissionTo($permission);
                        // }
                        DB::table('role_has_permissions')->where('role_id', $role->id)->delete();
                        $arr_permissions = [];
                        if ($request->permissions != null) {
                            foreach ($request->permissions as $key => $permission) {
                                $arr_permissions[] = ['role_id' => $role->id, 'permission_id' => $permission];
                                // $role->givePermissionTo($permission);
                            }
                        }
                        DB::table('role_has_permissions')->insert($arr_permissions);

                        cache()->forget('roles');
                        cache()->forget('dealers');
                        cache()->forget('cashiers');

                        DB::commit();
                        $response = [
                            'status' => 'success',
                            'msg' => __('messages.updated') . __('messages.roles.role') . ' ' . $role->name,
                        ];
                    } else {
                        DB::rollBack();
                        $response = array(
                            'status' => 'error',
                            'msg' => __('messages.msg'),
                        );
                    }
                } catch (\Exception $e) {
                    DB::rollBack();
                    log_exception($e);
                    Controller::resetAutoIncrement(['roles', 'permissions']);
                    return response()->json(['errors' => ['error' => [__('messages.error') . $e->getMessage()]]], 422);
                }
            } else {
            }
        } else {
            return response()->json(['errors' => ['role' => [__('messages.role')]]], 422);
        }
        return response()->json($response, 200);
    }

    public function remove(Request $request)
    {
        $names = [];

        DB::beginTransaction();
        try {
            foreach ($request->choices as $key => $id) {
                $role = Role::find($id);
                if ($id == 1 || $role->users) {
                    DB::rollBack();
                    return response()->json([
                        'status' => 'danger',
                        'msg' => __('messages.roles.error'),
                    ], 200);
                }
                $role->delete();
                array_push($names, $role->name);
            }
            DB::commit();
            cache()->forget('roles');
            return response()->json([
                'status' => 'success',
                'msg' => __('messages.deleted') . __('messages.roles.role') . ' ' . implode(', ', $names),
            ], 200);
        } catch (\Throwable $e) {
            DB::rollBack();
            log_exception($e);
            Controller::resetAutoIncrement(['roles', 'permissions']);
            return response()->json(['errors' => ['error' => [__('messages.error') . $e->getMessage()]]], 422);
        }
    }
}
