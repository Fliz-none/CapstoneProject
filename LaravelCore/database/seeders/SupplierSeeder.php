<?php

namespace Database\Seeders;

use App\Models\Supplier;
use Illuminate\Database\Seeder;
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
            [1, 'BOSS', '0369124871', 'boss@gmail.com', 'Nguyễn Văn Linh', NULL, 1, NULL, NULL, '2024-06-09 17:09:32', '2024-06-09 17:09:32'],
            [2, 'GFB PHARMA', '0348124872', 'gfbpharma@gmail.com', 'Nguyễn Văn Cừ nối dài', NULL, 1, NULL, NULL, '2024-06-09 17:09:32', '2024-06-09 17:09:32'],
            [3, 'Pedigree', '0369124873', 'tddiamonds@gmail.com', '30/4', NULL, 1, NULL, NULL, '2024-06-09 17:09:32', '2024-06-09 17:09:32'],
            [4, 'T&D Diamonds', '0369124874', 'diamond@gmail.com', '3/2', NULL, 1, NULL, NULL, '2024-06-09 17:09:32', '2024-07-09 16:21:21'],
            [5, 'PRO-PET', '0369124875', 'propet@gmail.com', 'Hùng Vương', NULL, 1, NULL, NULL, '2024-06-09 17:09:32', '2024-06-09 17:09:32'],
            [6, 'Cát LaPaw', '0369124876', 'lapaw@gmail.com', 'Cách Mạng Tháng 8', NULL, 1, NULL, NULL, '2024-06-09 17:09:32', '2024-06-09 17:09:32'],
            [7, 'Nhà cung cấp Cà Mau', '0939463469', 'keydigital@gmail.com', 'Cà Mau', 'DOOKL', 1, NULL, '2024-07-09 16:24:44', '2024-07-09 16:23:08', '2024-07-09 16:24:44'],
            [8, 'Nhà cung cấp HCM', '0376378379', 'hcmct@gmail.com', '13 Nguyễn Trãi P13 Q.GÒ Vấp Tp HCM', 'PETRUM', 1, NULL, '2024-07-09 16:24:44', '2024-07-09 16:24:34', '2024-07-09 16:24:44'],
            [9, 'Nước Lọc', '0979639763', 'nuoclocngon@gmail.com', '27 Ngô Gia Tự', 'AQUAFINA', 1, NULL, NULL, '2024-07-09 16:26:55', '2024-07-10 22:32:05'],
            [10, 'TRUONGDUNGPET', '0911677154', NULL, NULL, NULL, 1, NULL, NULL, '2024-09-18 07:56:10', '2024-09-18 07:56:10'],
            [11, 'Phan Thanh', NULL, NULL, NULL, NULL, 1, NULL, NULL, '2024-09-18 07:57:19', '2024-09-18 07:57:19'],
            [12, 'Thè Boss', NULL, NULL, NULL, NULL, 1, NULL, NULL, '2024-09-18 07:57:28', '2024-09-18 07:57:28'],
        ];

        foreach ($suppliers as $supplier) {
            Supplier::create([
                'company_id' => 1,
                'id' => $supplier[0],
                'name' => $supplier[1],
                'phone' => $supplier[2],
                'email' => $supplier[3],
                'address' => $supplier[4],
                'organ' => $supplier[5],
                'status' => $supplier[6],
                'note' => $supplier[7],
                'deleted_at' => $supplier[8],
                'created_at' => $supplier[9],
                'updated_at' => $supplier[10],
            ]);
        }
    }
}
