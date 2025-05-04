<?php

namespace Database\Seeders;

use App\Models\Major;
use Illuminate\Database\Seeder;

class MajorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $majors = [
            [1, 'kit-test-nhanh', 'Kit Test Nhanh', NULL, 'pink', 'quicktest', 5, 0, 1, 'test bệnh', NULL, '2024-06-09 17:09:33', '2024-09-24 15:52:06'],
            [2, 'sieu-am', 'Siêu Âm', NULL, 'orange', 'ultrasound', 6, 0, 1, 'chẩn đoán hình ảnh', NULL, '2024-06-09 17:09:33', '2024-09-24 15:52:06'],
            [3, 'xntb-mau', 'XNTB Máu', NULL, 'yellow', 'bloodcell', 7, 0, 1, NULL, NULL, '2024-06-09 17:09:33', '2024-09-24 15:52:06'],
            [4, 'xnsh-mau', 'XNSH Máu', NULL, 'green', 'biochemical', 8, 0, 1, NULL, NULL, '2024-06-09 17:09:33', '2024-09-24 15:52:06'],
            [5, 'soi-khv', 'Soi KHV', NULL, 'green', 'microscope', 9, 0, 1, NULL, NULL, '2024-06-09 17:09:33', '2024-09-24 15:52:06'],
            [6, 'x-quang', 'X-Quang', NULL, 'teal', 'xray', 10, 0, 1, NULL, NULL, '2024-06-09 17:09:33', '2024-09-24 15:52:06'],
            [7, 'phau-thuat', 'Phẫu thuật', NULL, 'cyan', 'surgery', 11, 0, 1, NULL, NULL, '2024-06-09 17:09:33', '2024-09-24 15:52:06'],
            [8, 'dieu-tri-noi-tru', 'Điều Trị Nội Trú', NULL, 'accommodation', 'purple', 12, 0, 1, NULL, NULL, '2024-06-09 17:09:33', '2024-09-24 15:52:06'],
            [9, 'don-thuoc', 'Đơn Thuốc', NULL, 'pink', NULL, 13, 0, 1, NULL, NULL, '2024-06-09 17:09:33', '2024-09-24 15:52:06'],
            [10, 'spa-grooming', 'Spa-Grooming', NULL, 'purple', 'beauty', 4, 0, 1, 'làm đẹp và cắt tỉa cho thú cưng', NULL, '2024-07-23 19:47:20', '2024-09-24 15:52:06'],
            [11, 'kham-lam-sang', 'Khám lâm sàng', NULL, 'blue', NULL, 3, 0, 1, NULL, NULL, '2024-09-11 08:01:14', '2024-09-24 15:52:06'],
            [12, 'tiem-phong', 'Tiêm phòng', NULL, 'indigo', NULL, 2, 0, 1, NULL, NULL, '2024-09-11 09:32:47', '2024-09-24 15:52:06'],
            [13, 'cap-cuu', 'Cấp cứu', NULL, 'red', NULL, 1, 0, 1, NULL, NULL, '2024-09-11 10:42:49', '2024-09-24 15:52:06'],
        ];

        foreach ($majors as $major) {
            Major::create([
                'company_id' => 1,
                'id' => $major[0],
                'slug' => $major[1],
                'name' => $major[2],
                'avatar' => $major[3],
                'color' => $major[4],
                'ticket' => $major[5],
                'sort' => $major[6],
                'type' => $major[7],
                'status' => $major[8],
                'note' => $major[9],
                'deleted_at' => $major[10],
                'created_at' => $major[11],
                'updated_at' => $major[12],
            ]);
        }
    }
}
