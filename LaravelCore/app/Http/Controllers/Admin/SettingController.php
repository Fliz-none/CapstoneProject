<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\Work;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Session;

class SettingController extends Controller
{
    const NAME = 'Cài đặt';

    public function __construct()
    {
        parent::__construct();
        if ($this->user === null) {
            $this->user = Auth::user();
        }
        $this->middleware(['admin', 'auth']);
    }

    /**
     * Show the application setting.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $pageName = self::NAME;
        $settings = cache()->get('settings_' . Auth::user()->company_id);
        $banks = Http::get('https://api.vietqr.io/v2/banks')->json();
        return view('admin.settings', compact('pageName', 'settings', 'banks'));
    }

    public function updateSetting($key, $value)
    {
        $settings = Setting::whereNull('company_id')->orWhere('company_id', $this->user->company_id)->pluck('value', 'key');
        if (array_key_exists($key, $settings->toArray())) {
            if ($value != $settings[$key]) {
                Setting::where('company_id', Auth::user()->company_id)->where('key', $key)->update([
                    'value' => $value,
                    'company_id' => $this->user->company_id
                ]);
            }
        } else {
            Setting::create(['key' => $key, 'value' => $value]);
        }
        cache()->forget('settings_' . Auth::user()->company_id);
    }

    public function updateZalo(Request $request)
    {
        $rules = [
            'zalo_oa_id' => 'nullable|string|max:255',
            'zalo_app_id' => 'nullable|string|max:255',
            'zalo_app_secret' => 'nullable|string|max:255',
            'zalo_access_token' => 'nullable|string',
            'zalo_refresh_token' => 'nullable|string',
            'zalo_transaction_template' => 'nullable|string|max:255',
            'zalo_booking_template' => 'nullable|string|max:255',
            'zalo_report_template' => 'nullable|string|max:255',
            'zalo_comeout_template' => 'nullable|string|max:255',
        ];
        $request->validate($rules);
        try {
            $this->updateSetting('has_zalo', $request->has_zalo);
            $this->updateSetting('zalo_oa_id', $request->zalo_oa_id);
            $this->updateSetting('zalo_app_id', $request->zalo_app_id);
            $this->updateSetting('zalo_app_secret', $request->zalo_app_secret);
            $this->updateSetting('zalo_access_token', $request->zalo_access_token);
            $this->updateSetting('zalo_refresh_token', $request->zalo_refresh_token);
            $this->updateSetting('zalo_transaction_template', $request->zalo_transaction_template);
            $this->updateSetting('zalo_booking_template', $request->zalo_booking_template);
            $this->updateSetting('zalo_report_template', $request->zalo_report_template);
            $this->updateSetting('zalo_comeout_template', $request->zalo_comeout_template);
            cache()->forget('settings_' . Auth::user()->company_id);
            $response = [
                'status' => 'success',
                'msg' => 'Cập nhật thông tin Zalo thành công!'
            ];
        } catch (\Throwable $e) {
            Log::error(
                'Có lỗi xảy ra: ' . $e->getMessage() . ';' . PHP_EOL .
                    'URL truy vấn: "' . request()->fullUrl() . '";' . PHP_EOL .
                    'Dữ liệu nhận được: ' . json_encode(request()->all()) . ';' . PHP_EOL .
                    'User ID: ' . (Auth::check() ? Auth::id() : 'Khách') . ';' . PHP_EOL .
                    'Chi tiết lỗi: ' . $e->getTraceAsString()
            );
            $response = [
                'status' => 'error',
                'msg' => 'Đã có lỗi xảy ra.' . $e . ' Vui lòng thử lại sau!'
            ];
        }
        return redirect()->back()->with('response', $response);
    }

    public function updateSymptom_Disease(Request $request)
    {
        try {
            $this->updateSetting('autosave_info_disease', $request->autosave_info_disease);
            $this->updateSetting('autosave_info_symptom', $request->autosave_info_symptom);
            cache()->forget('settings_' . Auth::user()->company_id);
            $response = [
                'status' => 'success',
                'msg' => 'Cập nhật tự động lưu bệnh và triệu chứng thành công!'
            ];
        } catch (\Throwable $e) {
            Log::error(
                'Có lỗi xảy ra: ' . $e->getMessage() . ';' . PHP_EOL .
                    'URL truy vấn: "' . request()->fullUrl() . '";' . PHP_EOL .
                    'Dữ liệu nhận được: ' . json_encode(request()->all()) . ';' . PHP_EOL .
                    'User ID: ' . (Auth::check() ? Auth::id() : 'Khách') . ';' . PHP_EOL .
                    'Chi tiết lỗi: ' . $e->getTraceAsString()
            );
            $response = [
                'status' => 'error',
                'msg' => 'Đã có lỗi xảy ra. Vui lòng thử lại sau!'
            ];
        }
        return redirect()->back()->with('response', $response);
    }

    public function updatePrint(Request $request)
    {
        try {
            $this->updateSetting('print_order_bank_a5', $request->print_order_bank_a5);
            $this->updateSetting('print_order_bank_c80', $request->print_order_bank_c80);
            cache()->forget('settings_' . Auth::user()->company_id);
            $response = [
                'status' => 'success',
                'msg' => 'Cập nhật giấy in hóa đơn thành công!'
            ];
        } catch (\Throwable $e) {
            Log::error(
                'Có lỗi xảy ra: ' . $e->getMessage() . ';' . PHP_EOL .
                    'URL truy vấn: "' . request()->fullUrl() . '";' . PHP_EOL .
                    'Dữ liệu nhận được: ' . json_encode(request()->all()) . ';' . PHP_EOL .
                    'User ID: ' . (Auth::check() ? Auth::id() : 'Khách') . ';' . PHP_EOL .
                    'Chi tiết lỗi: ' . $e->getTraceAsString()
            );
            $response = [
                'status' => 'error',
                'msg' => 'Đã có lỗi xảy ra. Vui lòng thử lại sau!'
            ];
        }
        return redirect()->back()->with('response', $response);
    }

    public function updateImage(Request $request)
    {
        try {
            $this->updateSetting('favicon', $request->favicon);
            $this->updateSetting('logo_horizon', $request->logo_horizon);
            $this->updateSetting('logo_square', $request->logo_square);
            $this->updateSetting('logo_horizon_bw', $request->logo_horizon_bw);
            $this->updateSetting('logo_square_bw', $request->logo_square_bw);
            cache()->forget('settings_' . Auth::user()->company_id);

            $response = [
                'status' => 'success',
                'msg' => 'Cập nhật hình ảnh thành công'
            ];
        } catch (\Throwable $e) {
            Log::error(
                'Có lỗi xảy ra: ' . $e->getMessage() . ';' . PHP_EOL .
                    'URL truy vấn: "' . request()->fullUrl() . '";' . PHP_EOL .
                    'Dữ liệu nhận được: ' . json_encode(request()->all()) . ';' . PHP_EOL .
                    'User ID: ' . (Auth::check() ? Auth::id() : 'Khách') . ';' . PHP_EOL .
                    'Chi tiết lỗi: ' . $e->getTraceAsString()
            );
            $response = [
                'status' => 'error',
                'msg' => 'Đã có lỗi xảy ra. Vui lòng thử lại sau!'
            ];
        }
        return redirect()->back()->with('response', $response);
    }

    public static function setEnv(array $values)
    {
        $envFile = app()->environmentFilePath();
        $str = file_get_contents($envFile);
        if (count($values) > 0) {
            foreach ($values as $envKey => $envValue) {
                $keyPosition = strpos($str, "{$envKey}=");
                $endOfLinePosition = strpos($str, "\n", $keyPosition);
                $oldLine = substr($str, $keyPosition, $endOfLinePosition - $keyPosition);
                // If key does not exist, add it
                if (!$keyPosition || !$endOfLinePosition || !$oldLine) {
                    $str .= "{$envKey}='{$envValue}'\n";
                } else {
                    $str = str_replace($oldLine, "{$envKey}='{$envValue}'", $str);
                }
            }
        }
        $str = substr($str, 0, -1);
        $str .= "\n";
        if (!file_put_contents($envFile, $str)) {
            return false;
        }
        return true;
    }

    public function updateEmail(Request $request)
    {
        try {
            $this->setEnv(array(
                'APP_NAME' => $request->app_name,
                'MAIL_DRIVER' => $request->mail_driver,
                'MAIL_HOST' => $request->mail_host,
                'MAIL_PORT' => $request->mail_port,
                'MAIL_USERNAME' => $request->mail_username,
                'MAIL_PASSWORD' => $request->mail_password,
                'MAIL_ENCRYPTION' => $request->mail_encryption,
                'MAIL_FROM_ADDRESS' => $request->mail_from_address,
            ));
            $this->updateSetting('expired_notification_frequency', $request->expired_notification_frequency);
            $response = [
                'status' => 'success',
                'msg' => 'Đã lưu thiết lập gửi mail'
            ];
        } catch (\Throwable $e) {
            Log::error(
                'Có lỗi xảy ra: ' . $e->getMessage() . ';' . PHP_EOL .
                    'URL truy vấn: "' . request()->fullUrl() . '";' . PHP_EOL .
                    'Dữ liệu nhận được: ' . json_encode(request()->all()) . ';' . PHP_EOL .
                    'User ID: ' . (Auth::check() ? Auth::id() : 'Khách') . ';' . PHP_EOL .
                    'Chi tiết lỗi: ' . $e->getTraceAsString()
            );
            $response = [
                'status' => 'error',
                'msg' => 'Đã có lỗi xảy ra. Vui lòng thử lại sau!'
            ];
        }
        return redirect()->back()->with('response', $response);
    }

    public function updateSocial(Request $request)
    {
        $rules = [
            'social_facebook' => 'nullable|active_url',
            'social_youtube' => 'nullable|active_url',
            'social_zalo' => 'nullable|numeric',
            'social_tiktok' => 'nullable|active_url',
            'social_telegram' => 'nullable|active_url',
        ];
        $request->validate($rules);
        try {
            $this->updateSetting('social_facebook', $request->social_facebook);
            $this->updateSetting('social_zalo', $request->social_zalo);
            $this->updateSetting('social_youtube', $request->social_youtube);
            $this->updateSetting('social_tiktok', $request->social_tiktok);
            $this->updateSetting('social_telegram', $request->social_telegram);
            cache()->forget('settings_' . Auth::user()->company_id);
            $response = [
                'status' => 'success',
                'msg' => 'Đã lưu cài đặt đường dẫn mạng xã hội'
            ];
        } catch (\Throwable $e) {
            Log::error(
                'Có lỗi xảy ra: ' . $e->getMessage() . ';' . PHP_EOL .
                    'URL truy vấn: "' . request()->fullUrl() . '";' . PHP_EOL .
                    'Dữ liệu nhận được: ' . json_encode(request()->all()) . ';' . PHP_EOL .
                    'User ID: ' . (Auth::check() ? Auth::id() : 'Khách') . ';' . PHP_EOL .
                    'Chi tiết lỗi: ' . $e->getTraceAsString()
            );
            $response = [
                'status' => 'error',
                'msg' => 'Đã có lỗi xảy ra. Vui lòng thử lại sau!'
            ];
        }
        return redirect()->back()->with('response', $response);
    }



    public function updateExpense(Request $request)
    {
        $validated = $request->validate([
            'expense_group' => 'required|array',
            'expense_group.*' => 'required|string|max:255',
        ], [
            'expense_group.required' => 'Danh sách phiếu chi không được để trống.',
            'expense_group.array' => 'Danh sách phiếu chi không hợp lệ.',
            'expense_group.*.required' => 'Vui lòng nhập nội dung phiếu chi.',
            'expense_group.*.string' => 'Nội dung phiếu chi phải là chuỗi ký tự.',
            'expense_group.*.max' => 'Nội dung phiếu chi không được vượt quá 255 ký tự.',
        ]);

        try {
            $this->updateSetting('expense_group', json_encode($validated['expense_group']));

            cache()->forget('settings_' . Auth::user()->company_id);

            return redirect()->back()->with('response', [
                'status' => 'success',
                'msg' => 'Đã lưu danh sách phiếu chi thành công.',
            ]);
        } catch (\Throwable $e) {
            Log::error('Error saving expense groups: ' . $e->getMessage());

            return redirect()->back()->with('response', [
                'status' => 'error',
                'msg' => 'Đã có lỗi xảy ra. Vui lòng thử lại!',
            ]);
        }
    }



    public function updateShop(Request $request)
    {
        $request->validate([
            'inventory_manage' => 'required|numeric',
            'scores_rate_exchange' => 'required|numeric',
        ], [
            'inventory_manage.required' => 'Vui lòng chọn một dịch vụ khám mặc định.',
            'scores_rate_exchange.numeric' => 'Dịch vụ khám mặc định: Dữ liệu không hợp lệ.',
        ]);
        try {
            $this->updateSetting('inventory_manage', $request->inventory_manage);
            $this->updateSetting('scores_rate_exchange', $request->scores_rate_exchange);
            cache()->forget('settings_' . Auth::user()->company_id);
            $response = [
                'status' => 'success',
                'msg' => 'Đã lưu cài đặt cửa hàng'
            ];
        } catch (\Throwable $e) {
            Log::error(
                'Có lỗi xảy ra: ' . $e->getMessage() . ';' . PHP_EOL .
                    'URL truy vấn: "' . request()->fullUrl() . '";' . PHP_EOL .
                    'Dữ liệu nhận được: ' . json_encode(request()->all()) . ';' . PHP_EOL .
                    'User ID: ' . (Auth::check() ? Auth::id() : 'Khách') . ';' . PHP_EOL .
                    'Chi tiết lỗi: ' . $e->getTraceAsString()
            );
            $response = [
                'status' => 'error',
                'msg' => 'Đã có lỗi xảy ra. Vui lòng thử lại sau!'
            ];
        }
        return redirect()->back()->with('response', $response);
    }


    public function updateCompany(Request $request)
    {
        $rules = [
            'company_name' => ['nullable', 'string', 'min:2', 'max:125'],
            'company_address' => 'string|nullable',
            'company_website' => 'string|nullable',
            'company_brandname' => 'string|nullable',
            'company_hotline' => ['nullable', 'numeric', 'digits:10', 'regex:/^(0|\+84)(\s|\.)?((3[2-9])|(5[689])|(7[06-9])|(8[1-689])|(9[0-46-9]))(\d)(\s|\.)?(\d{3})(\s|\.)?(\d{3})$/'],
            'company_phone' => ['nullable', 'numeric', 'digits:10', 'regex:/^(0|\+84)(\s|\.)?((3[2-9])|(5[689])|(7[06-9])|(8[1-689])|(9[0-46-9]))(\d)(\s|\.)?(\d{3})(\s|\.)?(\d{3})$/'],
            'company_email' => ['nullable', 'string', 'min:5', 'email', 'max:125'],
            'company_tax_id' => 'numeric|nullable',
            'company_tax_meta' => ['nullable', 'string', 'min:2', 'max:125'],
        ];
        $request->validate($rules);
        try {
            $this->updateSetting('company_name', $request->company_name);
            $this->updateSetting('company_address', $request->company_address);
            $this->updateSetting('company_website', $request->company_website);
            $this->updateSetting('company_brandname', $request->company_brandname);
            $this->updateSetting('company_hotline', $request->company_hotline);
            $this->updateSetting('company_phone', $request->company_phone);
            $this->updateSetting('company_email', $request->company_email);
            $this->updateSetting('company_tax_id', $request->company_tax_id);
            $this->updateSetting('company_tax_meta', $request->company_tax_meta);
            cache()->forget('settings_' . Auth::user()->company_id);
            $response = [
                'status' => 'success',
                'msg' => 'Đã lưu cài đặt công ty'
            ];
        } catch (\Throwable $e) {
            Log::error(
                'Có lỗi xảy ra: ' . $e->getMessage() . ';' . PHP_EOL .
                    'URL truy vấn: "' . request()->fullUrl() . '";' . PHP_EOL .
                    'Dữ liệu nhận được: ' . json_encode(request()->all()) . ';' . PHP_EOL .
                    'User ID: ' . (Auth::check() ? Auth::id() : 'Khách') . ';' . PHP_EOL .
                    'Chi tiết lỗi: ' . $e->getTraceAsString()
            );
            $response = [
                'status' => 'error',
                'msg' => 'Đã có lỗi xảy ra. Vui lòng thử lại sau!'
            ];
        }
        return redirect()->back()->with('response', $response);
    }

    public function updatePay(Request $request)
    {
        $request->validate([
            'bank_ids' => 'required|array',
            'bank_numbers' => 'required|array',
            'bank_accounts' => 'required|array',
            'bank_ids.*' => 'required',
            'bank_accounts.*' => 'required|string|max:255',
            'bank_numbers.*' => 'required|numeric',
        ], [
            'bank_ids.required' => 'Vui lòng chọn ít nhất một ngân hàng.',
            'bank_ids.array' => 'Danh sách ngân hàng không hợp lệ.',
            'bank_numbers.required' => 'Vui lòng nhập ít nhất một số tài khoản.',
            'bank_numbers.array' => 'Danh sách số tài khoản không hợp lệ.',
            'bank_accounts.required' => 'Vui lòng nhập ít nhất một tên tài khoản.',
            'bank_accounts.array' => 'Danh sách tên tài khoản không hợp lệ.',

            'bank_ids.*.required' => 'Vui lòng chọn một ngân hàng.',
            'bank_accounts.*.required' => 'Vui lòng nhập tên tài khoản.',
            'bank_accounts.*.string' => 'Tên tài khoản phải là chuỗi ký tự.',
            'bank_accounts.*.max' => 'Tên tài khoản không được vượt quá 255 ký tự.',
            'bank_numbers.*.required' => 'Vui lòng nhập số tài khoản.',
            'bank_numbers.*.numeric' => 'Số tài khoản phải là số.',
        ]);
        try {
            $accounts = [];
            foreach ($request->bank_ids as $i => $value) {
                $accounts[] = [
                    'bank_id' => $value,
                    'bank_name' => $request->bank_names[$i],
                    'bank_account' => $request->bank_accounts[$i],
                    'bank_number' => $request->bank_numbers[$i],
                ];
            }
            $this->updateSetting('bank_info', json_encode($accounts));
            cache()->forget('settings_' . Auth::user()->company_id);
            $response = [
                'status' => 'success',
                'msg' => 'Đã lưu cài đặt thanh toán'
            ];
        } catch (\Throwable $e) {
            Log::error(
                'Có lỗi xảy ra: ' . $e->getMessage() . ';' . PHP_EOL .
                    'URL truy vấn: "' . request()->fullUrl() . '";' . PHP_EOL .
                    'Dữ liệu nhận được: ' . json_encode(request()->all()) . ';' . PHP_EOL .
                    'User ID: ' . (Auth::check() ? Auth::id() : 'Khách') . ';' . PHP_EOL .
                    'Chi tiết lỗi: ' . $e->getTraceAsString()
            );
            $response = [
                'status' => 'error',
                'msg' => 'Đã có lỗi xảy ra. Vui lòng thử lại sau!'
            ];
        }
        return redirect()->back()->with('response', $response);
    }

    public function updateClinic(Request $request)
    {
        $request->validate([
            'default_info_service' => 'required|numeric',
        ], [
            'default_info_service.required' => 'Vui lòng chọn một dịch vụ khám mặc định.',
            'default_info_service.numeric' => 'Dịch vụ khám mặc định: Dữ liệu không hợp lệ.',
        ]);
        try {
            $this->updateSetting('default_info_service', $request->default_info_service);
            cache()->forget('settings_' . Auth::user()->company_id);
            $response = [
                'status' => 'success',
                'msg' => 'Đã lưu cài đặt phòng khám'
            ];
        } catch (\Throwable $e) {
            Log::error(
                'Có lỗi xảy ra: ' . $e->getMessage() . ';' . PHP_EOL .
                    'URL truy vấn: "' . request()->fullUrl() . '";' . PHP_EOL .
                    'Dữ liệu nhận được: ' . json_encode(request()->all()) . ';' . PHP_EOL .
                    'User ID: ' . (Auth::check() ? Auth::id() : 'Khách') . ';' . PHP_EOL .
                    'Chi tiết lỗi: ' . $e->getTraceAsString()
            );
            $response = [
                'status' => 'error',
                'msg' => 'Đã có lỗi xảy ra. Vui lòng thử lại sau!'
            ];
        }
        return redirect()->back()->with('response', $response);
    }


    public function updateWork(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'shift_name' => [
                'required',
                'array',
                function ($attribute, $value, $fail) {
                    if (count($value) !== count(array_unique($value))) {
                        $fail('Tên ca không được trùng lặp!');
                    }
                },
            ],
            'sign_checkin' => 'required|array',
            'sign_checkout' => 'required|array',
            'staff_number' => 'required|array',

            'shift_name.*' => 'required|string|min:1',
            'sign_checkin.*' => 'required|date_format:H:i',
            'sign_checkout.*' => 'required|date_format:H:i|after:sign_checkin.*',
            'staff_number.*' => 'required|integer|min:1',
        ], [
            'shift_name.required' => 'Vui lòng thiết lập ít nhất một ca',
            'sign_checkin.required' => 'Vui lòng thiết lập ít nhất một ca',
            'sign_checkout.required' => 'Vui lòng thiết lập ít nhất một ca',
            'staff_number.required' => 'Vui lòng thiết lập ít nhất một ca',

            'shift_name.*.required' => 'Vui lòng nhập tên ca làm việc.',
            'shift_name.*.string' => 'Tên ca làm việc không hợp lệ.',
            'shift_name.*.min' => 'Tên ca làm việc không được để trống.',

            'sign_checkin.*.required' => 'Vui lòng chọn giờ vào.',
            'sign_checkout.*.required' => 'Vui lòng chọn giờ ra.',
            'sign_checkin.*.date_format' => 'Giờ vào không hợp lệ.',
            'sign_checkout.*.date_format' => 'Giờ ra không hợp lệ.',
            'sign_checkout.*.after' => 'Giờ ra phải sau giờ vào.',

            'staff_number.*.required' => 'Vui lòng nhập số nhân viên.',
            'staff_number.*.integer' => 'Số nhân viên phải là số nguyên.',
            'staff_number.*.min' => 'Số nhân viên phải lớn hơn hoặc bằng 1.',
        ]);
        try {
            $work_settings = json_decode(cache()->get('settings_' . $this->user->company_id)['work_info'], true);
            unset($work_settings["allow_self_register"]);
            // Lấy thời gian từ Thứ 2 đến Chủ Nhật tuần sau
            $next_monday = Carbon::now()->next(Carbon::MONDAY)->startOfDay();
            $next_sunday = $next_monday->copy()->addDays(6)->endOfDay();
            $works = Work::whereBetween('sign_checkin', [$next_monday, $next_sunday])
                ->where('company_id', $this->user->company_id)
                ->get();
            $has_conflict = false;

            foreach ($work_settings as $shift) {
                $shift_checkin = $shift['sign_checkin'];
                $shift_checkout = $shift['sign_checkout'];
                foreach ($works as $work) {
                    $workCheckin = Carbon::parse($work->sign_checkin)->format('H:i');
                    $workCheckout = Carbon::parse($work->sign_checkout)->format('H:i');
                    if ($workCheckin === $shift_checkin || $workCheckout === $shift_checkout) {
                        $has_conflict = true;
                        break 2;
                    }
                }
            }

            if ($has_conflict) {
                $response = [
                    'status' => 'error',
                    'msg' => 'Đã có nhân viên đăng ký ca làm! Không thể thay đổi thiết lập này.'
                ];
                return redirect()->back()->with('response', $response);
            }

            $work_info["allow_self_register"] = $request->has('allow_self_register');
            foreach ($request->shift_name as $i => $value) {
                $work_info[] = [
                    'shift_name' => $value,
                    'sign_checkin' => $request->sign_checkin[$i],
                    'sign_checkout' => $request->sign_checkout[$i],
                    'staff_number' => $request->staff_number[$i],
                ];
            }
            $this->updateSetting('work_info', json_encode($work_info));
            cache()->forget('settings_' . Auth::user()->company_id);
            $response = [
                'status' => 'success',
                'msg' => 'Đã lưu cài đặt ca làm việc'
            ];
        } catch (\Throwable $e) {
            Log::error(
                'Có lỗi xảy ra: ' . $e->getMessage() . ';' . PHP_EOL .
                    'URL truy vấn: "' . request()->fullUrl() . '";' . PHP_EOL .
                    'Dữ liệu nhận được: ' . json_encode(request()->all()) . ';' . PHP_EOL .
                    'User ID: ' . (Auth::check() ? Auth::id() : 'Khách') . ';' . PHP_EOL .
                    'Chi tiết lỗi: ' . $e->getTraceAsString()
            );
            $response = [
                'status' => 'error',
                'msg' => 'Đã có lỗi xảy ra. Vui lòng thử lại sau!'
            ];
        }
        return redirect()->back()->with('response', $response);
    }
}
