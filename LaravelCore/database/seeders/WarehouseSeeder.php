<?php

namespace Database\Seeders;

use App\Models\Warehouse;
use Illuminate\Database\Seeder;
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
            [1, 1, 1, 'Kho Nguyễn Văn Linh', 'Ninh Kiều, Cần Thơ', NULL, 2, NULL, '2024-06-09 17:09:32', '2024-08-31 19:54:55'],
            [2, 2, 2, 'Kho Trần Hoàng Na', 'Ninh Kiều, Cần Thơ', NULL, 2, NULL, '2024-06-09 17:09:32', '2024-09-11 05:09:37'],
            [3, 3, 3, 'Kho Nguyễn Văn Cừ', 'Ninh Kiều, Cần Thơ', NULL, 2, NULL, '2024-06-09 17:09:32', '2024-09-11 05:09:27'],
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
                'created_at' => $warehouse[8],
                'updated_at' => $warehouse[9],
            ]);
        }
    }
}
