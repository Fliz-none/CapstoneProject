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
            [1, 1, 'Gạo Jasmine 5kg', null, 120000, 1, null, now()->subDays(19), now()],
            [2, 2, 'Lavie 500ml', null, 6000, 1, null, now()->subDays(18), now()],
            [3, 3, 'Bộ nồi 5 chiếc', null, 750000, 1, null, now()->subDays(17), now()],
            [4, 4, 'SRM Senka 100g', null, 95000, 1, null, now()->subDays(16), now()],
            [5, 5, 'Thịt ba rọi 500g', null, 85000, 1, null, now()->subDays(15), now()],
            [6, 6, 'Bút TL-08 Xanh', null, 4000, 1, null, now()->subDays(14), now()],
            [7, 7, 'Tai nghe Baseus A1', null, 490000, 1, null, now()->subDays(13), now()],
            [8, 8, 'Sunlight 1L', null, 45000, 1, null, now()->subDays(12), now()],
            [9, 9, 'Clear Men 650g', null, 120000, 1, null, now()->subDays(11), now()],
            [10, 10, 'Áo cotton size M', null, 75000, 1, null, now()->subDays(10), now()],
            [11, 11, 'Đầm hoa size S', null, 145000, 1, null, now()->subDays(9), now()],
            [12, 12, 'Nhẫn bạc nữ', null, 110000, 1, null, now()->subDays(8), now()],
            [13, 13, 'Dao inox mini', null, 25000, 1, null, now()->subDays(7), now()],
            [14, 14, 'Cá hộp 150g', null, 27000, 1, null, now()->subDays(6), now()],
            [15, 15, 'Tã Bobby M20', null, 115000, 1, null, now()->subDays(5), now()],
            [16, 16, 'Ferrero Rocher 16v', null, 175000, 1, null, now()->subDays(4), now()],
            [17, 17, 'Combo skincare', null, 320000, 1, null, now()->subDays(3), now()],
            [18, 18, 'Gói giao hàng 2H', null, 25000, 1, null, now()->subDays(2), now()],
            [19, 19, 'Sữa đặc 380g', null, 27000, 1, null, now()->subDays(1), now()],
            [20, 20, 'Snack rong biển Oishi', null, 15000, 1, null, now(), now()],
            [21, 1, 'Gạo Jasmine túi 5kg', null, 1, 1, null, now()->subDays(3), now()],
            [22, 1, 'Gạo Jasmine túi 10kg', null, 0, 1, null, now()->subDays(2), now()],
            [23, 2, 'Lavie 500ml lốc 6 chai', null, 1, 1, null, now()->subDays(4), now()],
            [24, 2, 'Lavie 500ml lốc 24 chai', null, 0, 1, null, now()->subDays(2), now()],
            [25, 3, 'Bộ nồi 5 chiếc inox cao cấp', null, 1, 1, null, now()->subDays(5), now()],
            [26, 3, 'Bộ nồi kèm xửng hấp', null, 0, 1, null, now()->subDays(2), now()],
            [27, 4, 'SRM Senka 120g', null, 1, 1, null, now()->subDays(2), now()],
            [28, 4, 'SRM Senka mini 50g', null, 0, 1, null, now()->subDays(1), now()],
            [29, 5, 'Thịt ba rọi 300g', null, 1, 1, null, now()->subDays(1), now()],
            [30, 5, 'Thịt ba rọi 1kg', null, 1, 1, null, now(), now()],
            [31, 6, 'Bút TL-08 xanh', null, 0, 1, null, now()->subDays(3), now()],
            [32, 6, 'Bút TL-08 đen', null, 1, 1, null, now()->subDays(2), now()],
            [33, 7, 'Tai nghe Baseus A1 đen', null, 1, 1, null, now()->subDays(2), now()],
            [34, 7, 'Tai nghe Baseus A1 trắng', null, 0, 1, null, now()->subDays(1), now()],
            [35, 8, 'Sunlight 1L hương chanh', null, 1, 1, null, now()->subDays(1), now()],
            [36, 8, 'Sunlight 1L lavender', null, 0, 1, null, now(), now()],
            [37, 9, 'Clear Men bạc hà 650g', null, 1, 1, null, now()->subDays(1), now()],
            [38, 9, 'Clear Men mát lạnh 650g', null, 1, 1, null, now(), now()],
            [39, 10, 'Áo cotton M đen', null, 0, 1, null, now(), now()],
            [40, 10, 'Áo cotton M trắng', null, 1, 1, null, now(), now()],
            [41, 11, 'Đầm hoa S cổ tim', null, 1, 1, null, now()->subDays(2), now()],
            [42, 11, 'Đầm hoa S kẻ caro', null, 0, 1, null, now(), now()],
            [43, 12, 'Nhẫn bạc nữ S925 size 6', null, 1, 1, null, now(), now()],
            [44, 12, 'Nhẫn bạc nữ S925 size 7', null, 0, 1, null, now(), now()],
            [45, 13, 'Dao inox dài 12cm', null, 1, 1, null, now(), now()],
            [46, 13, 'Dao inox tay cầm gỗ', null, 0, 1, null, now(), now()],
            [47, 14, 'Cá hộp 150g sốt cà', null, 1, 1, null, now(), now()],
            [48, 14, 'Cá hộp 150g tiêu đen', null, 1, 1, null, now(), now()],
            [49, 15, 'Tã Bobby M62', null, 1, 1, null, now(), now()],
            [50, 15, 'Tã Bobby M28', null, 0, 1, null, now(), now()],
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
            
            Unit::create([
                'variable_id' => $variable[0],
                'term' => Arr::random(['Cái', 'Gói', 'Thùng', 'Hộp', 'Chai']),
                'rate' => 1,
                'price' => Arr::random([10000, 20000, 50000, 100000, 200000, 70000, 5000]),
                'barcode' => strtoupper(Str::random(10)), 
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
