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
use Illuminate\Support\Facades\Log;
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
        $settings = cache()->get('settings');
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
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Nếu đã đăng nhập rồi
        if (Auth::check()) {
            return $this->redirectAfterLogin(Auth::user());
        }

        // Thử đăng nhập
        if ($this->attemptLogin($request) && Auth::check()) {
            return $this->redirectAfterLogin(Auth::user());
        }

        // Đăng nhập thất bại
        return back()
            ->withInput()
            ->withErrors(['password' => 'Invalid login information.']);
    }

    /**
     * Xác định route redirect sau khi login
     */
    protected function redirectAfterLogin(User $user)
    {
        // Map quyền -> route
        $redirectMap = [
            User::READ_DASHBOARD => route('admin.home'),
            User::CREATE_ORDER   => route('admin.order', ['key' => 'new']),
            User::READ_IMPORTS   => route('admin.import'),
        ];

        // Ưu tiên URL cũ nếu có
        if (session()->has('url.intended')) {
            return redirect()->intended();
        }

        // Tìm route theo quyền
        foreach ($redirectMap as $permission => $route) {
            if ($user->hasAnyPermission($permission)) {
                return redirect()->to($route);
            }
        }

        // Mặc định
        return redirect()->route('home');
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
                'msg' => 'Logout successful.'
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
     * @return \Illuminate\Http\RedirectResponse
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
