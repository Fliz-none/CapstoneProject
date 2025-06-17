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
    public function __construct()
    {
        parent::__construct();
        if ($this->user === null) {
            $this->user = Auth::user();
        }
        $this->middleware(['admin', 'auth']);
    }

    /**
     * Display user profile or settings page.
     */
    public function index(Request $request)
    {
        $pageName = $this->user->name;
        switch ($request->key) {
            case 'settings':
                return view('admin.profile_settings', compact('pageName'));
            case 'password':
                return view('admin.profile_password', compact('pageName'));
            case '':
                return view('admin.profile', compact('pageName'));
            default:
                abort(404);
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

            return response()->json([
                'status' => 'success',
                'msg' => __('messages.msg_update_avatar'),
            ], 200);
        } catch (\Exception $e) {
            log_exception($e);
            return back()->withErrors($e)->withInput();
        }
    }

    public function change_settings(Request $request)
    {
        $rules = [
            'password' => ['required', 'min:8', 'max:32'],
            'password' => [
                function ($attribute, $value, $fail) {
                    if (!Hash::check($value, $this->user->password)) {
                        return $fail(__('messages.profile.error_current_password'));
                    }
                }
            ],
            'name' => ['required', 'string', 'min:3', 'max:125'],
            'gender' => ['required', 'in:0,1,2'],
            'email' => ['required', 'email', 'min:5', 'max:125', Rule::unique('users')->ignore($request->id)],
            'phone' => ['required', 'numeric', 'digits:10', 'regex:/^(0|\+84)(\s|\.)?((3[2-9])|(5[689])|(7[06-9])|(8[1-689])|(9[0-46-9]))(\d)(\s|\.)?(\d{3})(\s|\.)?(\d{3})$/', Rule::unique('users')->ignore($request->id)],
            'address' => ['string', 'max:191']
        ];

        $messages = [
            'name.required' => __('messages.profile.name_required'),
            'name.string' => __('messages.profile.name_string'),
            'name.min' => __('messages.profile.name_min'),
            'name.max' => __('messages.profile.name_max'),

            'phone.required' => __('messages.profile.phone_required'),
            'phone.numeric' => __('messages.profile.phone_numeric'),
            'phone.digit' => __('messages.profile.phone_digit'),
            'phone.regex' => __('messages.profile.phone_regex'),
            'phone.unique' => __('messages.profile.phone_unique'),

            'address.string' => __('messages.profile.address_string'),
            'address.max' => __('messages.profile.address_max'),

            'gender.required' => __('messages.profile.gender_required'),
            'gender.in' => __('messages.profile.gender_in'),

            'email.required' => __('messages.profile.email_required'),
            'email.email' => __('messages.profile.email_email'),
            'email.min' => __('messages.profile.email_min'),
            'email.max' => __('messages.profile.email_max'),
            'email.unique' => __('messages.profile.email_unique'),

            'password.required' => __('messages.profile.password_required'),
            'password.string' => __('messages.profile.password_string'),
            'password.min' => __('messages.profile.password_min'),
            'password.max' => __('messages.profile.password_max'),

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

            return back()->with('response', [
                'status' => 'success',
                'msg' => __('messages.profile.update_profile'),
            ]);
        } catch (\Exception $e) {
            log_exception($e);
            return back()->withErrors($e)->withInput();
        }
    }

    public function change_password(ChangePasswordRequest $request)
    {
        $rules = [
            'current_password' => ['required', 'min:8', 'max:32'],
            'current_password' => [
                function ($attribute, $value, $fail) {
                    if (!Hash::check($value, $this->user->password)) {
                        return $fail(__('messages.profile.error_current_password'));
                    }
                }
            ],
            'password' => ['required', 'min:8', 'max:32', 'different:current_password'],
            'password_confirmation' => ['required', 'min:8', 'max:32', 'same:password'],
        ];

        $messages = [
            'current_password.required' =>  __('messages.profile.password_required'),
            'current_password.min' => __('messages.profile.password_min'),
            'current_password.max' => __('messages.profile.password_max'),

            'password.required' => __('messages.profile.password_required'),
            'password.string' => __('messages.profile.password_string'),
            'password.min' => __('messages.profile.password_min'),
            'password.max' => __('messages.profile.password_max'),


            'password_confirmation.required' =>  __('messages.profile.password_required'),
            'password_confirmation.min' => __('messages.profile.password_min'),
            'password_confirmation.max' => __('messages.profile.password_max'),
            'password_confirmation.same' => __('messages.profile.password_confirmation_same'),
        ];

        $request->validate($rules, $messages);

        try {
            $user = User::find($request->id);
            $user->password = Hash::make($request->password);
            $user->save();

            return back()->with('response', [
                'status' => 'success',
                'msg' => __('messages.profile.password_success'),
            ]);
        } catch (\Exception $e) {
            log_exception($e);
            return back()->withErrors($e)->withInput();
        }
    }

    public function change_branch(Request $request)
    {
        $rules = [
            'main_branch' => ['required', 'numeric'],
        ];

        $messages = [
            'main_branch.required' => Controller::$NOT_EMPTY,
            'main_branch.numeric' => Controller::$DATA_INVALID,
        ];

        $request->validate($rules, $messages);

        try {
            $user = $this->user;
            $user->main_branch = $request->main_branch;
            $user->save();

            return response()->json([
                'main_branch' => $this->user->branch->name,
                'status' => 'success',
                'msg' => __('messages.profile.default_branch'),
            ], 200);
        } catch (\Exception $e) {
            log_exception($e);
            return back()->withErrors($e)->withInput();
        }
    }
}
