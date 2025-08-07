<?php

namespace App\Http\Controllers;

use App\Models\Order;
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

    public function index(Request $request)
    {
        if (isset($request->key)) {
            $objs = Order::query();
            switch ($request->key) {
                default:
                    $relationships = [
                        '_dealer',
                        '_branch',
                        '_customer',
                        'transactions._cashier',
                        'transactions._customer',
                        'details.export_detail',
                        'details._unit',
                        'details._stock.import_detail._variable._product',
                        'details._stock.import_detail._import._warehouse',
                    ];
                    $obj = $objs
                        ->with($relationships)
                        ->where('customer_id', Auth::id())
                        ->where('id', $request->key)
                        ->first();
                    if ($obj) {
                        switch ($request->action) {
                            default:
                                $result = $obj;
                                break;
                        }
                    } else {
                        abort(404);
                    }
                    break;
            }
            return response()->json($result, 200);
        }
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
        $id = Auth::user()->id;
        $rules = [
            'name' => ['required', 'string', 'min:3', 'max:125'],
            'gender' => ['required', 'in:0,1,2'],
            'email' => ['required', 'email', 'min:5', 'max:125', Rule::unique('users')->ignore($id)],
            'phone' => ['required', 'numeric', 'digits:10', 'regex:/^(0|\+84)(\s|\.)?((3[2-9])|(5[689])|(7[06-9])|(8[1-689])|(9[0-46-9]))(\d)(\s|\.)?(\d{3})(\s|\.)?(\d{3})$/', Rule::unique('users')->ignore($id)],
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
            $user = User::find($id);

            if ($request->hasFile('avatar') && $request->file('avatar')->isValid()) {
                $imageInfo = pathinfo($request->file('avatar')->getClientOriginalName());
                $extension = $imageInfo['extension'];
                $filename = $user->code . '.' . $extension;

                // Lưu file vào storage/app/public/user/
                $request->file('avatar')->storeAs('public/user/', $filename);

                // Cập nhật tên file vào DB
                $user->avatar = $filename;
            }


            $user->fill($request->only('name', 'email', 'phone', 'gender'))->save();
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

    public function update_address(Request $request)
    {
        $rules = [
            'address' => ['required'],
            'recipient_name' => ['required',],
            'recipient_phone' => [
                'required',
                'numeric',
                'digits:10',
                'regex:/^0[0-9]{9,10}$/'
            ],
        ];
        $messages = [
            'address.required' => __('lang_web.profile.address_required'),
            'recipient_name.required' => __('lang_web.profile.recipient_name_required'),
            'recipient_phone.required' => __('lang_web.profile.recipient_phone_required'),
            'recipient_phone.numeric' => Controller::$DATA_INVALID,
            'recipient_phone.digits' => __('messages.user.digits'),
            'recipient_phone.unique' =>  __('messages.user.unique'),
            'recipient_phone.regex' =>  __('messages.user.regex'),
        ];
        $request->validate($rules, $messages);

        try {
            $user = User::find(Auth::user()->id);
            $arr_address = $user->address ? json_decode($user->address, true) : [];
            $address = json_decode($request->address, true);
            $address['recipient_name'] = $request->recipient_name;
            $address['recipient_phone'] = $request->recipient_phone;
            $address['default'] = $request->has('address_default') ? 'yes' : 'no';

            if ($address['default'] === 'yes' && !empty($arr_address)) {
                foreach ($arr_address as &$addr) {
                    $addr['default'] = 'no';
                }
                unset($addr);
            }

            if ($request->old_address) {
                $old = json_decode($request->old_address, true);

                $found = false;
                foreach ($arr_address as $i => $addr) {
                    if (
                        $addr['address'] === $old['address'] &&
                        $addr['lat'] == $old['lat'] &&
                        $addr['lng'] == $old['lng'] &&
                        $addr['recipient_phone'] == $old['recipient_phone'] &&
                        $addr['recipient_name'] == $old['recipient_name']
                    ) {
                        $arr_address[$i] = $address;
                        $found = true;
                        break;
                    }
                }

                if (!$found) {
                    $arr_address[] = $address;
                }
            } else {
                $arr_address[] = $address;
            }
            // dd($arr_address);
            // dd('ok');

            $user->update([
                'address' => json_encode($arr_address)
            ]);
            Auth::setUser($user->fresh());
            return response()->json(array(
                'status' => 'success',
                'address' => $address,
                'msg' => $request->old_address ? __('lang_web.profile.update_address_success') : __('lang_web.profile.add_address_success')
            ), 200);
        } catch (\Exception $e) {
            log_exception($e);
            return response()->json(['errors' => ['error' => [__('messages.error') . $e->getMessage()]]], 422);
        }
    }

    public function remove_address(Request $request)
    {
        $user = User::find(Auth::user()->id);
        $arr_address = $user->address ? json_decode($user->address, true) : [];
        $address = json_decode($request->address, true);
        $found = false;
        foreach ($arr_address as $i => $addr) {
            if (
                $addr['address'] === $address['address'] &&
                $addr['lat'] == $address['lat'] &&
                $addr['lng'] == $address['lng'] &&
                $addr['recipient_phone'] == $address['recipient_phone'] &&
                $addr['recipient_name'] == $address['recipient_name']
            ) {
                unset($arr_address[$i]);
                $found = true;
                break;
            }
        }
        $arr_address = array_values($arr_address);

        $user->update([
            'address' => json_encode($arr_address)
        ]);
        return response()->json(array(
            'status' => $found ? 'success' : 'error',
            'msg' => $found ? 'Xóa địa chỉ thành công!' : 'Không tìm thấy địa chỉ cần xóa'
        ), 200);
    }

    public function order_rate(Request $request)
    {
        $user = Auth::user();
        $order = Order::with('details')->where('id', $request->id)->where('customer_id', $user->id)->first();
        if ($order) {
            foreach ($request->detail_ids as $index => $detail_id) {
                $reviews = [
                    'rating' => $request->order_rating[$index],
                    'comment' => $request->order_comment[$index],
                ];

                $order->details->where('id', $detail_id)->first()->update([
                    'reviews' => json_encode($reviews),
                ]);
            }
            return response()->json(array(
                'status' => 'success',
                'order_id' => $order->id,
                'msg' => 'Đã đánh giá thành công đơn hàng ' . $order->code
            ), 200);
        } else {
            return response()->json(array(
                'status' => 'error',
                'msg' => 'Đơn hàng được chọn không hợp lệ!'
            ), 200);
        }
    }

    public function order_cancel(Request $request)
    {
        $order = Order::where('id', $request->order_id)->where('customer_id', Auth::id())->first();
        if ($order) {
            $order->update([
                'status' => 0
            ]);
            return response()->json(array(
                'status' => 'success',
                'msg' => 'Đã hủy đơn hàng thành công!'
            ), 200);
        } else {
            return response()->json(array(
                'status' => 'error',
                'msg' => 'Đơn hàng được chọn không hợp lệ!'
            ), 200);
        }
    }
}
