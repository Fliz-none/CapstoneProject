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
            [1, 1, 1, 'Kho Nguyễn Văn Linh', 'Ninh Kiều, Cần Thơ', NULL, 2, NULL],
            [2, 2, 2, 'Kho Trần Hoàng Na', 'Ninh Kiều, Cần Thơ', NULL, 2, NULL],
            [3, 3, 3, 'Kho Ninh Kiều', 'Ninh Kiều, Cần Thơ', NULL, 2, NULL],
        ];

        foreach ($warehouses as $warehouse) {
            Warehouse::create([
                'id' => $warehouse[1],
                'branch_id' => $warehouse[2],
                'name' => $warehouse[3],
                'address' => $warehouse[4],
                'note' => $warehouse[5],
                'status' => $warehouse[6],
                'deleted_at' => $warehouse[7],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
