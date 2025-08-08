<?php

namespace Database\Seeders;

use App\Models\Warehouse;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class WarehouseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $warehouses = [
            [1, 'Kho Nguyễn Văn Linh', '{"address":"Nguyễn Văn Linh, Hưng Lợi, Ninh Kiều, Cần Thơ","lat":10.019989943143047,"lng":105.76784557495547}', NULL, 2],
            [1, 'Kho 2 Nguyễn Văn Linh', 'Ninh Kiều, Cần Thơ', NULL, 2],
            [2, 'Kho Trần Hoàng Na', '{"address":"Xã Nhơn Bình, Trà Ôn, Vĩnh Long","lat":10.044914220000067,"lng":106.00444928800005}', NULL, 2],
            [2, 'Kho 2 Trần Hoàng Na', '{"address":"Trần Hoàng Na, Hưng Lợi, Ninh Kiều, Cần Thơ","lat":10.015247677988205,"lng":105.76139139983431}', NULL, 2],
            [3, 'Kho Ninh Kiều', 'Ninh Kiều, Cần Thơ', NULL, 2],
        ];

        foreach ($warehouses as $warehouse) {
            Warehouse::create([
                'branch_id' => $warehouse[0],
                'name' => $warehouse[1],
                'address' => $warehouse[2],
                'note' => $warehouse[3],
                'status' => $warehouse[4],
                'deleted_at' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
