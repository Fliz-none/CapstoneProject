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
            [1, 1, NULL, 'Kho vật tư y tế', 'Cái Răng, Cần Thơ', NULL, 0, '2024-08-31 02:41:55', '2024-06-09 17:09:32', '2024-08-31 02:41:55'],
            [1, 2, NULL, 'Kho thuốc', NULL, NULL, 0, '2024-08-31 02:41:50', '2024-06-09 17:09:32', '2024-08-31 02:41:50'],
            [1, 3, NULL, 'Kho đồ ăn & đồ dùng', NULL, NULL, 0, '2024-08-31 02:41:45', '2024-06-09 17:09:32', '2024-08-31 02:41:45'],
            [1, 4, 1, 'Kho nội bộ 586', 'Cái Răng, Cần Thơ', NULL, 1, NULL, '2024-06-09 17:09:32', '2024-08-31 19:54:55'],
            [1, 5, 1, 'Kho bán 586', 'Cái Răng, Cần Thơ', NULL, 2, NULL, '2024-06-09 17:09:32', '2024-09-11 05:09:37'],
            [1, 6, 2, 'Kho bán THN', 'Ninh Kiều, Cần Thơ', NULL, 2, NULL, '2024-06-09 17:09:32', '2024-09-11 05:09:27'],
            [1, 7, 2, 'Kho nội bộ THN', 'Ninh Kiều, Cần Thơ', NULL, 1, NULL, '2024-06-09 17:09:32', '2024-08-31 19:54:33'],
            [2, 8, 3, 'Kho Mậu Thân', 'Ninh Kiều, Cần Thơ', NULL, 1, NULL, '2024-06-10 17:09:32', '2024-06-10 19:54:33'],
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
