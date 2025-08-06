<?php

namespace Database\Seeders;

use App\Models\Unit;
use App\Models\Variable;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class VariableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $variables = [
            // [id, product_id, name, description, stock_limit, status, deleted_at, created_at, updated_at]
            [1, 1, '5kg', null, 50, 1, null, now()->subDays(10), now()],
            [2, 1, '10kg', null, 30, 1, null, now()->subDays(10), now()],

            [3, 2, '500ml', null, 100, 1, null, now()->subDays(9), now()],
            [4, 2, '1.5L', null, 60, 1, null, now()->subDays(9), now()],

            [5, 3, 'Bộ 5 nồi', null, 20, 1, null, now()->subDays(8), now()],
            [6, 3, 'Bộ 6 nồi + xửng', null, 10, 1, null, now()->subDays(8), now()],

            [7, 4, '100g', null, 40, 1, null, now()->subDays(7), now()],
            [8, 4, '150g', null, 25, 1, null, now()->subDays(7), now()],

            [9, 5, '300g', null, 60, 1, null, now()->subDays(6), now()],
            [10, 5, '500g', null, 45, 1, null, now()->subDays(6), now()],

            [11, 6, 'Xanh', null, 80, 1, null, now()->subDays(5), now()],
            [12, 6, 'Đen', null, 70, 1, null, now()->subDays(5), now()],

            [13, 7, 'A1 trắng', null, 15, 1, null, now()->subDays(4), now()],
            [14, 7, 'A1 đen', null, 18, 1, null, now()->subDays(4), now()],

            [15, 8, '1L chanh', null, 100, 1, null, now()->subDays(3), now()],
            [16, 8, '1L lavender', null, 90, 1, null, now()->subDays(3), now()],

            [17, 9, '650g', null, 70, 1, null, now()->subDays(2), now()],
            [18, 9, 'Mát lạnh 650g', null, 60, 1, null, now()->subDays(2), now()],

            [19, 10, 'Size M', null, 25, 1, null, now()->subDay(), now()],
            [20, 10, 'Size L', null, 30, 1, null, now()->subDay(), now()],
        ];


        $units = [
            [1, 'Gói', 1, 12000, '8930000000011'],
            [1, 'Bao', 10, 115000, '8930000000012'],

            [2, 'Chai', 1, 6000, '8930000000021'],
            [2, 'Bao', 20, 110000, '8930000000022'],

            [3, 'Chai', 1, 7000, '8930000000031'],
            [3, 'Thùng', 10, 70000, '8930000000032'],

            [4, 'Chai', 1, 10000, '8930000000041'],
            [4, 'Thùng', 10, 100000, '8930000000042'],

            [5, 'Combo', 1, 140000, '8930000000051'],

            [6, 'Combo', 1, 16000, '8930000000061'],

            [7, 'Chai', 1, 12000, '8930000000071'],
            [7, 'Thùng', 12, 135000, '8930000000072'],

            [8, 'Chai', 1, 13000, '8930000000081'],
            [8, 'Lốc 6 chai', 6, 89000, '8930000000082'],

            [9, 'Bịch', 1, 30000, '8930000000091'],

            [10, 'Bịch', 1, 45000, '8930000000101'],

            [11, 'Cái', 1, 8500, '8930000000111'],
            [11, 'Hộp 2 cái', 2, 16000, '8930000000112'],

            [12, 'Cái', 1, 8800, '8930000000121'],
            [12, 'Hộp 2 cái', 10, 19000, '8930000000122'],

            [13, 'Cái', 1, 19000, '8930000000131'],
            [13, 'Thùng 10 cái', 10, 108000, '8930000000132'],

            [14, 'Cái', 1, 19000, '8930000000141'],
            [14, 'Thùng 10 cái', 10, 108000, '8930000000142'],

            [15, 'Chai', 1, 10000, '8930000000151'],
            [15, 'Lốc 12 chai', 12, 110000, '8930000000152'],

            [16, 'Chai', 1, 11000, '8930000000161'],
            [16, 'Thùng', 10, 250000, '8930000000162'],

            [17, 'Chai', 1, 13000, '8930000000171'],
            [17, 'Thùng', 10, 125000, '8930000000172'],

            [18, 'Chai', 1, 14000, '8930000000181'],
            [18, 'Thùng', 15, 195000, '8930000000182'],

            [19, 'Cái', 1, 200000, '8930000000191'],
            [19, 'Bộ 2 cái', 2, 390000, '8930000000192'],

            [20, 'Cái', 1, 210000, '8930000000201'],
            [20, 'Bộ 2 cái', 2, 410000, '8930000000202'],
        ];

        foreach ($variables as $key => $variable) {
            Variable::create([
                'id' => $variable[0],
                'product_id' => $variable[1],
                'name' => $variable[2],
                'description' => $variable[3],
                'stock_limit' => $variable[4],
                'status' => $variable[5],
                'deleted_at' => $variable[6],
                'created_at' => $variable[7],
                'updated_at' => $variable[8]
            ]);
        }

        foreach ($units as $unit) {
            Unit::create([
                'variable_id' => $unit[0],
                'term' => $unit[1],
                'rate' => $unit[2],
                'price' => $unit[3],
                'barcode' => $unit[4],
            ]);
        }


        DB::statement("
                INSERT INTO `attribute_variable` (`attribute_id`, `variable_id`) VALUES
                (1, 1),  -- Gạo Jasmine 5kg => Khối lượng
                (1, 2),  -- Lavie 500ml => Khối lượng
                (4, 3),  -- Bộ nồi 5 chiếc => Quy cách
                (1, 4),  -- SRM Senka 100g => Khối lượng
                (1, 5),  -- Thịt ba rọi 500g => Khối lượng
                (4, 6),  -- Bút TL-08 Xanh => Quy cách
                (4, 7),  -- Tai nghe Baseus A1 => Quy cách
                (5, 8),  -- Sunlight 1L => Dung tích
                (1, 9),  -- Clear Men 650g => Khối lượng
                (2, 10), -- Áo cotton size M => Kích cỡ
                (2, 11), -- Đầm hoa size S => Kích cỡ
                (4, 12), -- Nhẫn bạc nữ => Quy cách
                (4, 13), -- Dao inox mini => Quy cách
                (1, 14), -- Cá hộp 150g => Khối lượng
                (2, 15), -- Tã Bobby M20 => Kích cỡ
                (1, 16), -- Ferrero Rocher 16v => Khối lượng
                (4, 17), -- Combo skincare => Quy cách
                (4, 18), -- Gói giao hàng 2H => Quy cách
                (1, 19), -- Sữa đặc 380g => Khối lượng
                (1, 20)  -- Snack rong biển Oishi => Khối lượng
            ;");
    }
}
