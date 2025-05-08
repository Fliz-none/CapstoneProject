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
    const NAME = 'chức vụ';
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
                        return $obj->permissions->count() ? implode(' ', json_decode($obj->permissions->take(15)->map(function ($permission) {
                            return '<span class="badge bg-primary">' . $permission->name . '</span>';
                        }))) . ' và còn nhiều quyền khác' : 'Chưa được cấp quyền';
                    })
                    ->rawColumns(['name', 'permissions', 'action'])
                    ->make(true);
            } else {
                $pageName = 'Quản lý ' . self::NAME;
                return view('admin.roles', compact('pageName'));
            }
        }
    }

    public function create(Request $request)
    {
        $rules = [
            'name' => ['required', 'string', 'min: 3', 'max:125', 
            function ($attribute, $value, $fail) use ($request) {
                if(Role::where('name', $value)->count()){
                    $fail('Vai trò này đã được tạo trước đó');
                }
            }],
        ];
        $messages = [
            'name.unique' => 'Tên này đã tồn tại.',
            'name.required' => 'Thông tin này không thể trống.',
            'name.string' => 'Thông tin không hợp lệ.',
            'name.min' => 'Tối thiểu 3 kí tự',
            'name.max' => 'Tối đa 125 kí tự.',
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
                LogController::create('tạo', self::NAME, $role->id);
                $response = [
                    'status' => 'success',
                    'msg' => 'Đã tạo ' . self::NAME . ' ' . $role->name,
                ];
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error('Có lỗi xảy ra: ' . $e->getMessage() . ';' . PHP_EOL .
                        'URL truy vấn: "' . request()->fullUrl() . '";' . PHP_EOL .
                        'Dữ liệu nhận được: ' . json_encode(request()->all()) . ';' . PHP_EOL .
                        'User ID: ' . (Auth::check() ? Auth::id() : 'Khách') . ';' . PHP_EOL .
                        'Chi tiết lỗi: ' . $e->getTraceAsString()
                    );
                Controller::resetAutoIncrement(['roles', 'permissions']);
                return response()->json(['errors' => ['error' => ['Đã xảy ra lỗi: ' . $e->getMessage()]]], 422);
            }
        } else {
            return response()->json(['errors' => ['role' => ['Thao tác chưa được cấp quyền!']]], 422);
        }
        return response()->json($response, 200);
    }

    public function update(Request $request)
    {
        $rules = [
            'name' => ['required', 'string', 'min: 3', 'max:125', 
            function ($attribute, $value, $fail) use ($request) {
                if(Role::where('name', $value)->where('id', '!=', $request->id)->count()){
                    $fail('Vai trò này đã được tạo trước đó');
                }
            }],
        ];
        $messages = [
            'name.required' => 'Thông tin này không thể trống.',
            'name.string' => 'Thông tin không hợp lệ.',
            'name.min' => 'Tối thiểu 3 kí tự',
            'name.max' => 'Tối đa 125 kí tự.',
            'name.unique' => 'Chức vụ đã được tạo.',
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

                        LogController::create('sửa', self::NAME, $role->id);
                        DB::commit();
                        $response = [
                            'status' => 'success',
                            'msg' => 'Đã sửa ' . self::NAME . ' ' . $role->name,
                        ];
                    } else {
                        DB::rollBack();
                        $response = array(
                            'status' => 'error',
                            'msg' => 'Đã có lỗi xảy ra, vui lòng tải lại trang và thử lại!'
                        );
                    }
                } catch (\Exception $e) {
                    DB::rollBack();
                    Log::error('Có lỗi xảy ra: ' . $e->getMessage() . ';' . PHP_EOL .
                        'URL truy vấn: "' . request()->fullUrl() . '";' . PHP_EOL .
                        'Dữ liệu nhận được: ' . json_encode(request()->all()) . ';' . PHP_EOL .
                        'User ID: ' . (Auth::check() ? Auth::id() : 'Khách') . ';' . PHP_EOL .
                        'Chi tiết lỗi: ' . $e->getTraceAsString()
                    );
                    Controller::resetAutoIncrement(['roles', 'permissions']);
                    return response()->json(['errors' => ['error' => ['Đã xảy ra lỗi: ' . $e->getMessage()]]], 422);
                }
            } else {
            }
        } else {
            return response()->json(['errors' => ['role' => ['Thao tác chưa được cấp quyền!']]], 422);
        }
        return response()->json($response, 200);
    }

    public function remove(Request $request)
    {
        $names = [];
        foreach ($request->choices as $key => $id) {
            $role = Role::find($id);
            $role->delete();
            array_push($names, $role->name);
            LogController::create("xóa", "nhóm quyền", $role->id);
        }
        cache()->forget('roles');
        return response()->json([
            'status' => 'success',
            'msg' => 'Đã xóa ' . self::NAME . ' ' . $role->name,
        ], 200);
    }
}
