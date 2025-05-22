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
            ['contact_map', '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d694.587161565341!2d105.80441073156558!3d10.0021233534269!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31a063c9138bf7a'],
            ['head_code', ''],
            ['bodytop_code', ''],
            ['bodybottom_code', ''],
            ['priority_interface', ''],
            ['bank_info', '[{"bank_id":"970436","bank_name":"Vietcombank","bank_account":"H\u1ea3i \u0110\u0103ng","bank_number":"1049448493"},{"bank_id":"970415","bank_name":"VietinBank","bank_account":"V\u00f5 Minh Qu\u00e2n","bank_number":"0111000192555"},{"bank_id":"970441","bank_name":"VIB","bank_account":"\u0110\u0103ng","bank_number":"10546434"}]'],
            ['print_invoice', '1'],
            ['symptom_group', '["Chế độ chăm sóc","Thể trạng chung","Lông da","Cơ xương","Tim mạch","Hô hấp","Tiêu hóa","Tiết niệu","Sinh dục","Tai","Mắt","Thần kinh","Hạch bạch huyết"]'],
            ['allow_expired_sale', '1'],
            ['expired_notification_before', '60'],
            ['inventory_manage', '1'],
            ['allow_negative_stock', '0'],
            ['work_info', '[]'],
            ['allow_self_register', '1'],
            ['require_attendance_on_company_wifi', '1'],
            ['scores_rate_exchange', '1'],
            ['expense_group', '[]'],
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
