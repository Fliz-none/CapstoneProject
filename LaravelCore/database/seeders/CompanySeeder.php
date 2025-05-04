<?php

namespace Database\Seeders;

use App\Models\Animal;
use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $companies = [
            [
                'name' => 'Trương Dung PET', 
                'deadline' => '2025-12-31',
                'domain' => 'truongdungpet.com',
                'contract_total' => '1000000',
                'has_website' => 1,
                'has_shop' => 1,
                'has_warehouse' => 1,
                'has_clinic' => 1,
                'has_attendance' => 1,
                'has_beauty' => 1,
                'has_booking' => 1,
                'address' => 'Địa chỉ 123 THN',
                'phone' => '0123456789',
                'email' => 'contact@truongdungpet.com',
                'tax_id' => '123456789',
                'status' => 1,
                'note' => 'Ghi chú TDP',
                'created_at' => '2024-10-04 07:43:11.000000',
                'updated_at' => '2024-10-04 07:43:11.000000'
            ],
            [
                'name' => 'shop SUBEO', 
                'deadline' => '2025-10-31',
                'contract_total' => '2700000',
                'has_website' => 0,
                'has_shop' => 1,
                'has_warehouse' => 1,
                'has_clinic' => 0,
                'has_attendance' => 0,
                'has_beauty' => 0,
                'has_booking' => 0,
                'address' => '74A, Đ. Mậu Thân/142 Đ. Nguyễn Việt Hồng, An Nghiệp, Ninh Kiều, Cần Thơ',
                'domain' => 'subeoshop.com',
                'phone' => '0907443370',
                'email' => 'nhaphuongtrinh@gmail.com',
                'tax_id' => null,
                'status' => 1,
                'note' => null,
                'created_at' => '2024-10-04 07:43:11.000000',
                'updated_at' => '2024-10-04 07:43:11.000000'
            ],
        ];

        DB::table('companies')->insert($companies);
    }
}
