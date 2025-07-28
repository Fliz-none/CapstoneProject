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
                'name' => 'CN Nguyễn Văn Linh',
                'phone' => '0939510249',
                'address' => 'Nguyễn Văn Linh, An Bình, Ninh Kiều, Cần Thơ',
                'note' => null,
                'status' => 1,
                'deleted_at' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'CN Trần Hoàng Na',
                'phone' => '090203001516',
                'address' => 'TRẦN HOÀNG NA, AN BÌNH, NINH KIỀU, CẦN THƠ',
                'note' => null,
                'status' => 1,
                'deleted_at' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'CN Ninh Kiều',
                'phone' => '0123456789',
                'address' => 'Ninh Kiều, Cần Thơ',
                'note' => null,
                'status' => 1,
                'deleted_at' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
