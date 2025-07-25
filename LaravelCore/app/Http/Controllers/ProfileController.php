<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        // $this->middleware(['verified','auth']);

        $this->middleware(function ($request, $next) {
            Controller::init();
            return $next($request);
        });
    }

    public function profile()
    {
        $pageName = 'Account ' . Auth::user()->name;
        $settings = cache()->get('settings');
        return view('web.profile', compact('pageName', 'settings'));
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


    public function change_infor(Request $request)
    {
        $rules = [
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

            ];
            $request->validate($rules, $messages);
        try {
            $user = User::find($request->id);

            if ($request->hasFile('avatar') && $request->file('avatar')->isValid()) {
                $imageInfo = pathinfo($request->file('avatar')->getClientOriginalName());
                $extension = $imageInfo['extension'];
                $filename = $user->code . '.' . $extension;

                // Lưu file vào storage/app/public/user/
                $request->file('avatar')->storeAs('public/user/', $filename);

                // Cập nhật tên file vào DB
                $user->avatar = $filename;
            }


            $user->fill($request->only('name', 'email', 'phone', 'gender', 'address'))->save();
            $response = array(
                'status' => 'success',
                'msg' => __('messages.profile.update_profile')
            );
        } catch (\Exception $e) {
                log_exception($e);
                return response()->json(['errors' => ['error' => [__('messages.error') . $e->getMessage()]]], 422);
            }
        return response()->json($response, 200);
    }
}
