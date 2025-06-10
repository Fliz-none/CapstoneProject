<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $settings = [
            ['logo_square', ''],
            ['logo_horizon', 'logo_horizon.png'],
            ['logo_square_bw', 'logo_bw.svg'],
            ['logo_horizon_bw', 'logo_horizon_bw.png'],
            ['favicon', 'favicon.png'],

            ['social_facebook', 'https://www.facebook.com/profile.php?id=100009390873079'],
            ['social_zalo', '0911677154'],
            ['social_youtube', ''],
            ['social_tiktok', ''],
            ['social_telegram', ''],

            ['head_code', ''],
            ['bodytop_code', ''],
            ['bodybottom_code', ''],
            ['priority_interface', ''],
            ['bank_info', '[{"bank_id":"970436","bank_name":"Vietcombank","bank_account":"H\u1ea3i \u0110\u0103ng","bank_number":"1049448493"},{"bank_id":"970415","bank_name":"VietinBank","bank_account":"V\u00f5 Minh Qu\u00e2n","bank_number":"0111000192555"},{"bank_id":"970441","bank_name":"VIB","bank_account":"\u0110\u0103ng","bank_number":"10546434"}]'],
            ['print_invoice', '1'],
            ['allow_expired_sale', '1'],
            ['expired_notification_before', '30'],
            ['inventory_manage', '1'],
            ['allow_negative_stock', '0'],

            ['work_info', '[]'],
            ['allow_self_register', '1'],
            ['require_attendance_on_company_wifi', '1'],
            ['scores_rate_exchange', '1'],
            ['expense_group', '[]'],
            ['currency', 'VND'],
            ['hourly_salary', '0'],

            ['company_name', 'Sales Management Solution'],
            ['company_hotline', '0942852755'],
            ['company_address', 'An Khanh, Ninh Kieu, Can Tho'],
            ['company_tax_id', ''],
            ['company_email', 'lhd4388@gmail.com'],
            ['company_description', 'SMS - Sales Management Solution is a software that helps you manage your sales, employees, inventory and more. SMS is designed to offer a focused and flexible tool that addresses operational gaps in small and medium-sized retail businesses. By emphasizing usability, centralized data, and intelligent automation, SMS aims to enhance retail efficiency while maintaining compatibility with current workflows and business needs.'],
        ];

        foreach ($settings as $key => $setting) {
            DB::table('settings')->insert([
                'key' => $setting[0],
                'value' => $setting[1],
            ]);
        }
        
        // 'name',
        // 'description',
        // 'user_id',
        DB::table('versions')->insert([
            'name' => '1.0.0',
            'description' => 'The first version',
            'user_id' => 1,
        ]);
    }
}
