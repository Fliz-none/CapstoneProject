<?php

namespace Database\Seeders;

use App\Models\Supplier;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $suppliers = [
                [1, 'Công ty TNHH Minh Phúc', '0369124871', 'minhphuc.co@gmail.com', '12 Nguyễn Trãi, Q.1, TP.HCM', NULL, 1, NULL],
                [2, 'Công ty TNHH Lam Sơn', '0348124872', 'lamson.group@gmail.com', '85 Hoàng Văn Thụ, Q.Phú Nhuận, TP.HCM', NULL, 1, NULL],
                [3, 'Công ty TNHH Hưng Thịnh Phát', '0369124873', 'hungthinhphat.ltd@gmail.com', '102 Lê Lợi, TP.Cần Thơ', NULL, 1, NULL],
                [4, 'Công ty TNHH Thái Minh', '0369124874', 'thaiminh.jsc@gmail.com', '64 Hai Bà Trưng, Q.1, TP.HCM', NULL, 1, NULL],
                [5, 'Công ty TNHH Thành Đạt', '0369124875', 'thanhdat.corp@gmail.com', '19 Lê Văn Việt, Q.9, TP.HCM', NULL, 1, NULL],
                [6, 'Công ty CP Gia An', '0369124876', 'giaan.group@gmail.com', '47 Nguyễn Văn Linh, TP.Đà Nẵng', NULL, 1, NULL],
                [7, 'Công ty TNHH Phương Nam', '0939463469', 'phuongnam.biz@gmail.com', 'Số 3 Trần Hưng Đạo, TP.Cà Mau', 'DOOKL', 1, NULL],
                [8, 'Công ty TNHH Tân Đại Phát', '0376378379', 'tandaiphat.vn@gmail.com', '222 Pasteur, Q.3, TP.HCM', 'PETRUM', 1, NULL],
                [9, 'Công ty CP Minh Tâm', '0979639763', 'minhtam.ct@gmail.com', '88 Phạm Ngũ Lão, TP.Cần Thơ', 'AQUAFINA', 1, NULL],
                [10, 'Công ty TNHH Đông Phong', '0911677154', 'dongphong.dev@gmail.com', '10B Phan Đăng Lưu, Q.Bình Thạnh, TP.HCM', NULL, 1, NULL],
        ];

        foreach ($suppliers as $supplier) {
            Supplier::create([
                'id' => $supplier[0],
                'name' => $supplier[1],
                'phone' => $supplier[2],
                'email' => $supplier[3],
                'address' => $supplier[4],
                'organ' => $supplier[5],
                'status' => $supplier[6],
                'note' => $supplier[7],
                'deleted_at' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
