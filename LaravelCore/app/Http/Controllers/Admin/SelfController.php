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
                'msg' => __('Successfully updated avatar'),
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
            'password' => [function ($attribute, $value, $fail) {
                if (!Hash::check($value, $this->user->password)) {
                    return $fail(__('Current password is incorrect'));
                }
            }],
            'name' => ['required', 'string', 'min:3', 'max:125'],
            'gender' => ['required', 'in:0,1,2'],
            'email' => ['required', 'email', 'min:5', 'max:125', Rule::unique('users')->ignore($request->id)],
            'phone' => ['required', 'numeric', 'digits:10', 'regex:/^(0|\+84)(\s|\.)?((3[2-9])|(5[689])|(7[06-9])|(8[1-689])|(9[0-46-9]))(\d)(\s|\.)?(\d{3})(\s|\.)?(\d{3})$/', Rule::unique('users')->ignore($request->id)],
            'address' => ['string', 'max:191']
        ];

        $messages = [
            'name.required' => 'This field is required.',
            'name.string' => 'Invalid format.',
            'name.min' => 'Minimum 3 characters.',
            'name.max' => 'Maximum 125 characters.',

            'phone.required' => 'This field is required.',
            'phone.numeric' => 'Invalid phone number.',
            'phone.digit' => 'Please enter a valid phone number.',
            'phone.regex' => 'Please enter a valid phone number.',
            'phone.unique' => 'Phone number already in use.',

            'address.string' => 'Invalid format.',
            'address.max' => 'Maximum 191 characters.',

            'gender.required' => 'This field is required.',
            'gender.in' => 'Invalid gender format.',

            'email.required' => 'This field is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.min' => 'Minimum 5 characters.',
            'email.max' => 'Maximum 125 characters.',
            'email.unique' => 'Email already exists.',

            'password.required' => 'This field is required.',
            'password.string' => 'Invalid format.',
            'password.min' => 'Minimum 8 characters.',
            'password.max' => 'Maximum 32 characters.',
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
                'msg' => __('Successfully updated profile information'),
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
            'current_password' => [function ($attribute, $value, $fail) {
                if (!Hash::check($value, $this->user->password)) {
                    return $fail(__('Current password is incorrect'));
                }
            }],
            'password' => ['required', 'min:8', 'max:32', 'different:current_password'],
            'password_confirmation' => ['required', 'min:8', 'max:32', 'same:password'],
        ];

        $messages = [
            'current_password.required' => 'This field is required.',
            'current_password.min' => 'Minimum 8 characters.',
            'current_password.max' => 'Maximum 32 characters.',

            'password.required' => 'This field is required.',
            'password.min' => 'Minimum 8 characters.',
            'password.max' => 'Maximum 32 characters.',
            'password.different' => 'New password must be different from the old one.',

            'password_confirmation.required' => 'This field is required.',
            'password_confirmation.min' => 'Minimum 8 characters.',
            'password_confirmation.max' => 'Maximum 32 characters.',
            'password_confirmation.same' => 'Password confirmation does not match.',
        ];

        $request->validate($rules, $messages);

        try {
            $user = User::find($request->id);
            $user->password = Hash::make($request->password);
            $user->save();

            return back()->with('response', [
                'status' => 'success',
                'msg' => __('Successfully updated password.'),
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
            'main_branch.required' => Controller::NOT_EMPTY,
            'main_branch.numeric' => Controller::DATA_INVALID,
        ];

        $request->validate($rules, $messages);

        try {
            $user = $this->user;
            $user->main_branch = $request->main_branch;
            $user->save();

            return response()->json([
                'main_branch' => $this->user->branch->name,
                'status' => 'success',
                'msg' => __('Default branch updated successfully.'),
            ], 200);
        } catch (\Exception $e) {
            log_exception($e);
            return back()->withErrors($e)->withInput();
        }
    }
}
