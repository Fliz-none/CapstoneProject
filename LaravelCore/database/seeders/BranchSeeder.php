<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('branches')->insert([
            [
                'company_id' => 1,
                'name' => 'TRƯƠNGDUNG PET 586',
                'phone' => '0344333586',
                'address' => 'H2-25,26 Bùi Quang Trinh, Phú Thứ, Cần Thơ',
                'note' => 'Quản Lý:\r\nPhó Quản Lý:\r\nGiám Sát:',
                'status' => 1,
                'deleted_at' => null,
                'created_at' => Carbon::create('2024', '06', '10', '14', '09', '32'),
                'updated_at' => Carbon::create('2024', '07', '05', '17', '37', '58'),
            ],
            [
                'company_id' => 1,
                'name' => 'TRƯƠNGDUNG PET THN',
                'phone' => '0344333586',
                'address' => '97B, TRẦN HOÀNG NA, AN BÌNH, NINH KIỀU, CẦN THƠ',
                'note' => null,
                'status' => 1,
                'deleted_at' => null,
                'created_at' => Carbon::create('2024', '06', '09', '14', '09', '32'),
                'updated_at' => Carbon::create('2024', '06', '09', '14', '09', '32'),
            ],
            [
                'company_id' => 2,
                'name' => 'Mậu Thân',
                'phone' => '0907443370',
                'address' => '74A, Đ. Mậu Thân/142 Đ. Nguyễn Việt Hồng, An Nghiệp, Ninh Kiều, Cần Thơ',
                'note' => null,
                'status' => 1,
                'deleted_at' => null,
                'created_at' => Carbon::create('2024', '06', '10', '14', '09', '32'),
                'updated_at' => Carbon::create('2024', '06', '10', '14', '09', '32'),
            ],
        ]);
    }
}
