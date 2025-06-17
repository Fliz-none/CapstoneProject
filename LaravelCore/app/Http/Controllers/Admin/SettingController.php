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
    const NAME = 'Setting';

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
        try {
            $pageName = self::NAME;
            $settings = cache()->get('settings');
            $banks = Http::get('https://api.vietqr.io/v2/banks')->json();
            return view('admin.settings', compact('pageName', 'settings', 'banks'));
        } catch (\Throwable $e) {
            log_exception($e);
            return redirect()->back()->with('response', [
                'status' => 'error',
                'msg' => __('messages.msg')
            ]);
        }
    }

    public function updateSetting($key, $value)
    {
        $settings = Setting::pluck('value', 'key');
        if (array_key_exists($key, $settings->toArray())) {
            if ($value != $settings[$key]) {
                Setting::where('key', $key)->update([
                    'value' => $value,
                ]);
            }
        } else {
            Setting::create(['key' => $key, 'value' => $value]);
        }
        cache()->forget('settings');
    }

    public function updatePrint(Request $request)
    {
        try {
            $this->updateSetting('print_order_bank_a5', $request->print_order_bank_a5);
            $this->updateSetting('print_order_bank_c80', $request->print_order_bank_c80);
            cache()->forget('settings');

            $response = [
                'status' => 'success',
                'msg' => __('messages.shop_setting.print_success')
            ];
        } catch (\Throwable $e) {
            log_exception($e);

            $response = [
                'status' => 'error',
                'msg' => __('messages.msg')
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
            cache()->forget('settings');

            $response = [
                'status' => 'success',
                'msg' => __('messages.images.image') . ' ' . __('messages.updated')
            ];
        } catch (\Throwable $e) {
            log_exception($e);
            $response = [
                'status' => 'error',
                'msg' => __('messages.msg')
            ];
        }
        return redirect()->back()->with('response', $response);
    }
    public static function setEnv(array $values)
    {
        try {
            $envFile = app()->environmentFilePath(); // Get the path to the .env file
            $str = file_get_contents($envFile); // Read the content of the .env file

            if (count($values) > 0) {
                foreach ($values as $envKey => $envValue) {
                    $keyPosition = strpos($str, "{$envKey}=");
                    $endOfLinePosition = strpos($str, "\n", $keyPosition);
                    $oldLine = substr($str, $keyPosition, $endOfLinePosition - $keyPosition);
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
        } catch (\Throwable $e) {
            log_exception($e);
            return false;
        }
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
                'msg' => __('messages.setting_controller.setting_email')
            ];
        } catch (\Throwable $e) {
            log_exception(($e));
            $response = [
                'status' => 'error',
                'msg' => __('messages.msg')
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
            cache()->forget('settings');
            $response = [
                'status' => 'success',
                'msg' => __('messages.setting_controller.setting_social')
            ];
        } catch (\Throwable $e) {
            log_exception($e);
            $response = [
                'status' => 'error',
                'msg' => __('messages.msg')
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
            'expense_group.required' => __('messages.setting_controller.expense_group_required'),
            'expense_group.array' => __('messages.setting_controller.expense_group_array'),
            'expense_group.*.required' => __('messages.setting_controller.expense_group__required'),
            'expense_group.*.string' => __('messages.setting_controller.expense_group__string'),
            'expense_group.*.max' => __('messages.setting_controller.expense_group__max'),
        ]);

        try {
            $this->updateSetting('expense_group', json_encode($validated['expense_group']));

            cache()->forget('settings');

            return redirect()->back()->with('response', [
                'status' => 'success',
                'msg' => __('messages.setting_controller.expense_group__list_saved_successfully'),
            ]);
        } catch (\Throwable $e) {
            log_exception($e);
            return redirect()->back()->with('response', [
                'status' => 'error',
                'msg' => __('messages.msg'),
            ]);
        }
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
            'bank_ids.required' => __('messages.setting_controller.bank_ids__required'),
            'bank_ids.array' => __('messages.setting_controller.bank_ids__array'),
            'bank_numbers.required' => __('messages.setting_controller.bank_numbers__required'),
            'bank_numbers.array' => __('messages.setting_controller.bank_numbers__array'),
            'bank_accounts.required' => __('messages.setting_controller.bank_accounts__required'),
            'bank_accounts.array' => __('messages.setting_controller.bank_accounts__array'),

            'bank_ids.*.required' => __('messages.setting_controller.bank_ids__*__required'),
            'bank_accounts.*.required' => __('messages.setting_controller.bank_accounts__*__required'),
            'bank_accounts.*.string' => __('messages.setting_controller.bank_accounts__*__string'),
            'bank_accounts.*.max' => __('messages.setting_controller.bank_accounts__*__max'),
            'bank_numbers.*.required' => __('messages.setting_controller.bank_numbers__*__required'),
            'bank_numbers.*.numeric' => __('messages.setting_controller.bank_numbers__*__numeric'),
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
            cache()->forget('settings');

            $response = [
                'status' => 'success',
                'msg' => __('messages.setting_controller.payment_setting'),
            ];
        } catch (\Throwable $e) {
            log_exception($e);
            $response = [
                'status' => 'error',
                'msg' => __('messages.msg'),
            ];
        }

        return redirect()->back()->with('response', $response);
    }


    public function updateWork(Request $request)
    {
        $request->validate([
            'shift_name' => [
                'required',
                'array',
                function ($attribute, $value, $fail) {
                    if (count($value) !== count(array_unique($value))) {
                        $fail(__('messages.shift_setting.shift_unique'));
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
            'currency' => 'required',
            'hourly_salary' => 'required|numeric'
        ], [
            'shift_name.required' => __('messages.setting_controller.shift_name__required'),
            'sign_checkin.required' => __('messages.setting_controller.sign_checkin__required'),
            'sign_checkout.required' => __('messages.setting_controller.sign_checkout__required'),
            'staff_number.required' => __('messages.setting_controller.staff_number__required'),

            'shift_name.*.required' => __('messages.setting_controller.shift_name__*__required'),
            'shift_name.*.string' => __('messages.setting_controller.shift_name__*__string'),
            'shift_name.*.min' => __('messages.setting_controller.shift_name__*__min'),

            'sign_checkin.*.required' => __('messages.setting_controller.sign_checkin__*__required'),
            'sign_checkout.*.required' => __('messages.setting_controller.sign_checkout__*__required'),
            'sign_checkin.*.date_format' => __('messages.setting_controller.sign_checkin__*__date_format'),
            'sign_checkout.*.date_format' => __('messages.setting_controller.sign_checkout__*__date_format'),
            'sign_checkout.*.after' => __('messages.setting_controller.sign_checkout__*__after'),

            'staff_number.*.required' => __('messages.setting_controller.staff_number__*__required'),
            'staff_number.*.integer' => __('messages.setting_controller.staff_number__*__integer'),
            'staff_number.*.min' => __('messages.setting_controller.staff_number__*__min'),

              'currency.required' => 'Please enter a currency.',
            'hourly_salary.required' => 'Please enter the hourly salary.',
            'hourly_salary.numeric' => 'Hourly salary must be numeric.',

        ]);

        try {
            $work_settings = json_decode(cache()->get('settings')['work_info'] ?? '[]', true);
            // Get the period from next Monday to next Sunday
            $next_monday = Carbon::now()->next(Carbon::MONDAY)->startOfDay();
            $next_sunday = $next_monday->copy()->addDays(6)->endOfDay();
            $works = Work::whereBetween('sign_checkin', [$next_monday, $next_sunday])->get();

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
                    'msg' => __('messages.setting_controller.shift_setting'),
                ];
                return redirect()->back()->with('response', $response);
            }
            $work_info = [];
            foreach ($request->shift_name as $i => $value) {
                $work_info[] = [
                    'shift_name' => $value,
                    'sign_checkin' => $request->sign_checkin[$i],
                    'sign_checkout' => $request->sign_checkout[$i],
                    'staff_number' => $request->staff_number[$i],
                ];
            }
            $this->updateSetting('require_attendance_on_company_wifi', $request->require_attendance_on_company_wifi);
            $this->updateSetting('allow_self_register', $request->allow_self_register);
            $this->updateSetting('work_info', json_encode($work_info));
            $this->updateSetting('currency', $request->currency);
            $this->updateSetting('hourly_salary', $request->hourly_salary);
            cache()->forget('settings');

            $response = [
                'status' => 'success',
                'msg' => __('messages.setting_controller.work_setting'),
            ];
        } catch (\Throwable $e) {
            log_exception($e);
            $response = [
                'status' => 'error',
                'msg' => __('messages.msg'),
            ];
        }

        return redirect()->back()->with('response', $response);
    }
}
