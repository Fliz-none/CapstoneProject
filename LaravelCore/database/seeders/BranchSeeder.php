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
                'address' => '{"address":"Nguyễn Văn Linh, Hưng Lợi, Ninh Kiều, Cần Thơ","lat":10.019989943143047,"lng":105.76784557495547}',
                'note' => null,
                'status' => 1,
                'deleted_at' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'CN Trần Hoàng Na',
                'phone' => '090203001516',
                'address' => '{"address":"Trần Hoàng Na, Hưng Lợi, Ninh Kiều, Cần Thơ","lat":10.015247677988205,"lng":105.76139139983431}',
                'note' => null,
                'status' => 1,
                'deleted_at' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'CN Ninh Kiều',
                'phone' => '0123456789',
                'address' => '{"address":"600 Nguyễn Văn Cừ Nối Dài, An Bình, Bình Thủy, Cần Thơ","lat":10.0124518,"lng":105.7324316}',
                'note' => null,
                'status' => 1,
                'deleted_at' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
