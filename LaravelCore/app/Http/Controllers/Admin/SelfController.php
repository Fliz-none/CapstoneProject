<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChangePasswordRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class SelfController extends Controller
{
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
        $this->middleware(['admin','auth']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $pageName = $this->user->name;
        switch ($request->key) {
            case 'settings':
                return view('admin.profile_settings', compact('pageName'));
                break;
            case 'password':
                return view('admin.profile_password', compact('pageName'));
                break;
            case '':
                return view('admin.profile', compact('pageName'));
                break;
            default:
                abort(404);
                break;
        }
    }

    public function change_avatar(Request $request)
    {
        try {
            $user = User::find($request->id);
            $imageInfo = pathinfo($request->avatar->getClientOriginalName());
            $filename = $user->code . '.' . $imageInfo['extension'];
            $request->avatar->storeAs('public/user/', $filename);
            $user->avatar = $filename;
            $user->save();

            $response = array(
                'status' => 'success',
                'msg' => __('Successfully updated avatar'),
            );
            return response()->json($response, 200);
        } catch (\Exception $e) {
            Log::error('Có lỗi xảy ra: ' . $e->getMessage() . ';' . PHP_EOL .
                        'URL truy vấn: "' . request()->fullUrl() . '";' . PHP_EOL .
                        'Dữ liệu nhận được: ' . json_encode(request()->all()) . ';' . PHP_EOL .
                        'User ID: ' . (Auth::check() ? Auth::id() : 'Khách') . ';' . PHP_EOL .
                        'Chi tiết lỗi: ' . $e->getTraceAsString()
                    );
            return back()->withErrors($e)->withInput();
        }
    }

    public function change_settings(Request $request)
    {
        $rules = [
            'password' => ['required', 'min: 8', 'max: 32'],
            'password' => [function ($attribute, $value, $fail) {
                if (!Hash::check($value, $this->user->password)) {
                    return $fail(__('Mật khẩu hiện tại không đúng'));
                }
            }],
            'name' => ['required', 'string', 'min: 3', 'max:125'],
            'gender' => ['required', 'in:0,1,2'],
            'email' => ['required', 'email', 'min: 5', 'max:125', Rule::unique('users')->ignore($request->id)],
            'phone' => ['required', 'numeric', 'digits:10', 'regex:/^(0|\+84)(\s|\.)?((3[2-9])|(5[689])|(7[06-9])|(8[1-689])|(9[0-46-9]))(\d)(\s|\.)?(\d{3})(\s|\.)?(\d{3})$/', Rule::unique('users')->ignore($request->id)],
            'address' => ['string', 'max:191']
        ];
        $messages = [
            'name.required' => 'Thông tin này không thể trống.',
            'name.string' => 'Thông tin không hợp lệ.',
            'name.min' => 'Tối thiểu 3 kí tự',
            'name.max' => 'Tối đa 125 kí tự.',

            'phone.required' => 'Thông tin này không thể trống.',
            'phone.numeric' => 'Số điện thoại không đúng.',
            'phone.digit' => 'Vui lòng nhập đúng số điện thoại',
            'phone.regex' => 'Vui lòng nhập đúng số điện thoại',
            'phone.unique' => 'Số điện thoại đã được đăng kí',

            'address.string' => 'Thông tin không hợp lệ.',
            'address.max' => 'Tối đa 191 kí tự.',

            'gender.required' => 'Không được thiếu thông tin này',
            'gender.in' => 'Không đúng định dạng',

            'email.required' => 'Thông tin này không thể trống.',
            'email.email' => 'Vui lòng nhập đúng định dạng email',
            'email.min' => 'Tối thiểu 5 kí tự',
            'email.max' => 'Tối đa 125 kí tự.',
            'email.unique' => 'Email đã tồn tại.',
            'password.required' => 'Thông tin này không thể trống.',
            'password.string' => 'Thông tin không hợp lệ.',
            'password.min' => 'Tối thiểu 8 kí tự',
            'password.max' => 'Mật khẩu tối đa dưới 32 kí tự',
        ];
        $request->validate($rules, $messages);
        try {
            $user = User::find($request->id);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->gender = $request->gender;
            $user->address = $request->address;
            $user->save();
            $response = array(
                'status' => 'success',
                'msg' => __('Successfully updated profile information'),
            );
            return back()->with('response', $response);
        } catch (\Exception $e) {
            return back()->withErrors($e)->withInput();
        }
    }

    public function change_password(ChangePasswordRequest $request)
    {
        $rules = [
            'current_password' => ['required', 'min: 8', 'max: 32'],
            'current_password' => [function ($attribute, $value, $fail) {
                if (!Hash::check($value, $this->user->password)) {
                    return $fail(__('Mật khẩu hiện tại không đúng'));
                }
            }],
            'password' => ['required', 'min:8', 'max:32', 'different:current_password'],
            'password_confirmation' => ['required', 'min:8', 'max:32', 'same:password'],
        ];

        $messages = [
            'current_password.required' => 'Thông tin này không thể trống',
            'current_password.min' => 'Mật khẩu tối đa 8 ký tự',
            'current_password.max' => 'Mật khẩu tối đa 32 ký tự',

            'password.required' => 'Thông tin này không thể trống',
            'password.min' => 'Tối thiểu 8 kí tự',
            'password.max' => 'Mật khẩu tối đa dưới 32 kí tự',
            'password.different' => 'Mật khẩu mới khác với mật khẩu ban đầu',

            'password_confirmation.required' => 'Thông tin này không thể trống',
            'password_confirmation.min' => 'Tối thiểu 8 kí tự',
            'password_confirmation.max' => 'Mật khẩu tối đa dưới 32 kí tự',
            'password_confirmation.same' => 'Mật khẩu mới phải trùng khớp với mật bạn đặt'
        ];
        $request->validate($rules, $messages);

        try {
            $user = User::find($request->id);
            $user->password = Hash::make($request->password);
            $user->save();

            $response = [
                'status' => 'success',
                'msg' => __('Successfully updated password.'),
            ];
            return back()->with('response', $response);
        } catch (\Exception $e) {
            Log::error('Có lỗi xảy ra: ' . $e->getMessage() . ';' . PHP_EOL .
                        'URL truy vấn: "' . request()->fullUrl() . '";' . PHP_EOL .
                        'Dữ liệu nhận được: ' . json_encode(request()->all()) . ';' . PHP_EOL .
                        'User ID: ' . (Auth::check() ? Auth::id() : 'Khách') . ';' . PHP_EOL .
                        'Chi tiết lỗi: ' . $e->getTraceAsString()
                    );
            return back()->withErrors($e)->withInput();
        }
    }

    public function change_branch(Request $request)
    {
        $rules = [
            'main_branch' => ['required', 'numeric'],
        ];
        $messages = [
            'main_branch.required' => Controller::NOT_EMPTY,
            'main_branch.numeric' => Controller::DATA_INVALID,
        ];
        $request->validate($rules, $messages);

        try {
            $user = $this->user;
            $user->main_branch = $request->main_branch;
            $user->save();

            $response = [
                'main_branch' => $this->user->branch->name,
                'status' => 'success',
                'msg' => __('Đã cập nhật chi nhánh mặc định thành công.'),
            ];
            return response()->json($response, 200);
        } catch (\Exception $e) {
            Log::error('Có lỗi xảy ra: ' . $e->getMessage() . ';' . PHP_EOL .
                        'URL truy vấn: "' . request()->fullUrl() . '";' . PHP_EOL .
                        'Dữ liệu nhận được: ' . json_encode(request()->all()) . ';' . PHP_EOL .
                        'User ID: ' . (Auth::check() ? Auth::id() : 'Khách') . ';' . PHP_EOL .
                        'Chi tiết lỗi: ' . $e->getTraceAsString()
                    );
            return back()->withErrors($e)->withInput();
        }
    }
}
