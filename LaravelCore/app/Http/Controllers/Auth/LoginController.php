<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    //Admin login
    public function index()
    {
        $pageName = 'Đăng nhập';
        $settings = Setting::pluck('value', 'key');
        return view('auth.login', compact('pageName', 'settings'));
    }

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->middleware('guest')->except('logout');
    }

    public function auth(Request $request)
    {
        // Validate dữ liệu đầu vào
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Nếu validation thất bại, trả về lỗi
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'msg' => 'Xác thực dữ liệu thất bại',
                'errors' => $validator->errors()
            ], 422);
        }
        if(Auth::check()) {
            return response()->json([
                'token' => csrf_token(),
                'status' => 'success',
                'msg' => 'Đăng nhập thành công.'
            ], 200);
        }
        // Thử đăng nhập
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
            // Nếu đăng nhập thành công
            if($request->ajax()) {
                return response()->json([
                    'user' => Auth::user(),
                    'main_branch' => Auth::user()->branch,
                    'token' => csrf_token(),
                    'status' => 'success',
                    'msg' => 'Đăng nhập thành công.'
                ], 200);
            }
            return redirect()->intended($this->redirectPath());
        }

        if($request->ajax()) {
            // Nếu đăng nhập thất bại
            return response()->json([
                'status' => 'error',
                'msg' => 'Đăng nhập thất bại.'
            ], 401);
        }else{
            return back()->withInput()->withErrors([
                'password' => 'Thông tin đăng nhập không chính xác.',
            ]);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        if ($request->ajax()) {
            return response()->json([
                'token' => csrf_token(),
                'status' => 'success',
                'msg' => 'Đăng xuất tài khoản thành công!'
            ], 200);
        }

        return redirect('/');
    }

    /**
     * Attempt to log the user into the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function attemptLogin(Request $request)
    {
        $credentials = $this->credentials($request);
        $credentials['status'] = 1; // Thêm điều kiện kiểm tra status

        return Auth::attempt($credentials, $request->filled('remember'));
    }

    /**
     * Send the response after the user was authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();

        $this->clearLoginAttempts($request);

        // Cập nhật thời gian đăng nhập cuối cùng
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $user->last_login_at = Carbon::now();
        $user->save();

        if ($request->ajax()) {
            return response()->json(['message' => 'Logged in successfully.']);
        } else {
            return redirect()->intended($this->redirectPath());
        }
    }

    /**
     * Get the failed login response instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        if ($request->ajax()) {
            return response()->json(['message' => trans('auth.failed')], 422);
        } else {
            return back()
                ->withInput($request->only($this->username(), 'remember'))
                ->withErrors([
                    $this->username() => trans('auth.failed'),
                ]);
        }
    }
}
