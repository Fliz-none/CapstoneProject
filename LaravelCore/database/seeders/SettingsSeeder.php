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
            [1, 'logo_square', ''],
            [1, 'logo_horizon', 'logo_horizon.png'],
            [1, 'logo_square_bw', 'logo_bw.svg'],
            [1, 'logo_horizon_bw', 'logo_horizon_bw.png'],
            [1, 'favicon', 'favicon.png'],
            [1, 'company_name', 'Công ty TNHH Thương mại Dịch vụ TruongDung Pet'],
            [1, 'company_address', 'H2-25, H-26, đường Bùi Quang Trinh, Phường Phú Thứ, Quận Cái Răng, Thành phố Cần Thơ, Việt Nam'],
            [1, 'company_website', 'truongdungpet.com'],
            [1, 'company_brandname', 'TruongDung Pet'],
            [1, 'company_hotline', '0344333586'],
            [1, 'company_phone', '0911677154'],
            [1, 'company_email', 'cskh@truongdungpet.com'],
            [1, 'company_tax_id', '1801756872'],
            [1, 'company_tax_meta', 'Issued on July 8, 2022 at Department of Planning and Investment of Cantho city,  Vietnam'],
            [1, 'social_facebook', 'https://www.facebook.com/profile.php?id=100009390873079'],
            [1, 'social_zalo', '0911677154'],
            [1, 'social_youtube', ''],
            [1, 'social_tiktok', ''],
            [1, 'social_telegram', ''],
            [1, 'contact_map', '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d694.587161565341!2d105.80441073156558!3d10.0021233534269!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31a063c9138bf7a'],
            [1, 'head_code', ''],
            [1, 'bodytop_code', ''],
            [1, 'bodybottom_code', ''],
            [1, 'priority_interface', ''],
            [1, 'bank_info', '[{"bank_id":"970436","bank_name":"Vietcombank","bank_account":"H\u1ea3i \u0110\u0103ng","bank_number":"1049448493"},{"bank_id":"970415","bank_name":"VietinBank","bank_account":"V\u00f5 Minh Qu\u00e2n","bank_number":"0111000192555"},{"bank_id":"970441","bank_name":"VIB","bank_account":"\u0110\u0103ng","bank_number":"10546434"}]'],
            [1, 'print_invoice', '1'],
            [1, 'symptom_group', '["Chế độ chăm sóc","Thể trạng chung","Lông da","Cơ xương","Tim mạch","Hô hấp","Tiêu hóa","Tiết niệu","Sinh dục","Tai","Mắt","Thần kinh","Hạch bạch huyết"]'],
            [1, 'allow_expired_sale', '1'],
            [1, 'expired_notification_before', '60'],
            [1, 'default_info_service', '554'],
            [1, 'inventory_manage', '1'],
            [1, 'allow_negative_stock', '0'],
            [2, 'logo_square', ''],
            [2, 'logo_horizon', 'logo_horizon.png'],
            [2, 'logo_square_bw', 'logo_bw.svg'],
            [2, 'logo_horizon_bw', 'logo_horizon_bw.png'],
            [2, 'favicon', 'favicon.png'],
            [2, 'company_name', 'SUBEO Shop'],
            [2, 'company_address', '74A, Đ. Mậu Thân/142 Đ. Nguyễn Việt Hồng, An Nghiệp, Ninh Kiều, Cần Thơ'],
            [2, 'company_website', 'subeoshop.petclinic.com'],
            [2, 'company_brandname', 'TruongDung Pet'],
            [2, 'company_hotline', '0907443370'],
            [2, 'company_phone', '0907443370'],
            [2, 'company_email', 'cskh@truongdungpet.com'],
            [2, 'company_tax_id', ''],
            [2, 'company_tax_meta', 'Issued on July 8, 2022 at Department of Planning and Investment of Cantho city,  Vietnam'],
            [2, 'social_facebook', 'https://www.facebook.com/p/Subeo-Qu%E1%BA%A7n-%C3%81o-Tr%E1%BA%BB-Em-100064510339147'],
            [2, 'social_zalo', '0907443370'],
            [2, 'social_youtube', ''],
            [2, 'social_tiktok', ''],
            [2, 'social_telegram', ''],
            [2, 'contact_map', '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d694.587161565341!2d105.80441073156558!3d10.0021233534269!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31a063c9138bf7a'],
            [2, 'head_code', ''],
            [2, 'bodytop_code', ''],
            [2, 'bodybottom_code', ''],
            [2, 'priority_interface', ''],
            [2, 'bank_info', '[{"bank_id":"970436","bank_name":"Vietcombank","bank_account":"H\u1ea3i \u0110\u0103ng","bank_number":"1049448493"},{"bank_id":"970415","bank_name":"VietinBank","bank_account":"V\u00f5 Minh Qu\u00e2n","bank_number":"0111000192555"},{"bank_id":"970441","bank_name":"VIB","bank_account":"\u0110\u0103ng","bank_number":"10546434"}]'],
            [2, 'print_invoice', '1'],
            [2, 'symptom_group', '["Chế độ chăm sóc","Thể trạng chung","Lông da","Cơ xương","Tim mạch","Hô hấp","Tiêu hóa","Tiết niệu","Sinh dục","Tai","Mắt","Thần kinh","Hạch bạch huyết"]'],
            [2, 'allow_expired_sale', '1'],
            [2, 'expired_notification_before', '60'],
            [2, 'default_info_service', '554'],
            [2, 'inventory_manage', '1'],
            [2, 'allow_negative_stock', '0'],
        ];

        foreach ($settings as $key => $setting) {
            DB::table('settings')->insert([
                'company_id' => $setting[0],
                'key' => $setting[1],
                'value' => $setting[2],
            ]);
        }
    }
}
