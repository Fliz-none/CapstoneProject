<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AttributeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $attributes = [
            [
                'key' => 'Khối lượng',
                'value' => '30g',
            ],
            [
                'key' => 'Khối lượng',
                'value' => '50g',
            ],
            [
                'key' => 'Khối lượng',
                'value' => '100g',
            ],
            [
                'key' => 'Khối lượng',
                'value' => '200g',
            ],
            [
                'key' => 'Khối lượng',
                'value' => '300g',
            ],
            [
                'key' => 'Khối lượng',
                'value' => '400g',
            ],
            [
                'key' => 'Khối lượng',
                'value' => '500g',
            ],
            [
                'key' => 'Khối lượng',
                'value' => '600g',
            ],
            [
                'key' => 'Khối lượng',
                'value' => '700g',
            ],
            [
                'key' => 'Khối lượng',
                'value' => '800g',
            ],
            [
                'key' => 'Khối lượng',
                'value' => '900g',
            ],
            [
                'key' => 'Khối lượng',
                'value' => '1kg',
            ],
            [
                'key' => 'Kích cỡ',
                'value' => 'S',
            ],
            [
                'key' => 'Kích cỡ',
                'value' => 'M',
            ],
            [
                'key' => 'Kích cỡ',
                'value' => 'L',
            ],
            [
                'key' => 'Kích cỡ',
                'value' => 'XL',
            ],
            [
                'key' => 'Kích cỡ',
                'value' => 'XXL',
            ],
            [
                'key' => 'Size',
                'value' => 'Số 1',
            ],
            [
                'key' => 'Size',
                'value' => 'Số 2',
            ],
            [
                'key' => 'Size',
                'value' => 'Số 3',
            ],
            [
                'key' => 'Size',
                'value' => 'Số 4',
            ],
            [
                'key' => 'Size',
                'value' => 'Số 5',
            ],
            [
                'key' => 'Size',
                'value' => 'Số 6',
            ],
            [
                'key' => 'Quy cách',
                'value' => 'Nhỏ',
            ],
            [
                'key' => 'Quy cách',
                'value' => 'Vừa',
            ],
            [
                'key' => 'Quy cách',
                'value' => 'Lớn',
            ],
            [
                'key' => 'Dung tích',
                'value' => '5cc',
            ],
            [
                'key' => 'Dung tích',
                'value' => '10cc',
            ],
            [
                'key' => 'Dung tích',
                'value' => '15cc',
            ],
            [
                'key' => 'Dung tích',
                'value' => '20cc',
            ],
            [
                'key' => 'Dung tích',
                'value' => '50ml',
            ],
            [
                'key' => 'Dung tích',
                'value' => '100ml',
            ],
            [
                'key' => 'Dung tích',
                'value' => '200ml',
            ],
            [
                'key' => 'Dung tích',
                'value' => '500ml',
            ],
            [
                'key' => 'Dạng bào chế',
                'value' => 'viên nén',
            ],
            [
                'key' => 'Dạng bào chế',
                'value' => 'viên nang',
            ],
            [
                'key' => 'Dạng bào chế',
                'value' => 'dạng bột',
            ],
            [
                'key' => 'Dạng bào chế',
                'value' => 'dạng nước',
            ],
            [
                'key' => 'Dạng bào chế',
                'value' => 'dạng kem',
            ],
            [
                'key' => 'Dạng bào chế',
                'value' => 'dạng gel',
            ],
            [
                'key' => 'Dạng bào chế',
                'value' => 'dạng cốm',
            ],
        ];
        DB::table('attributes')->insert($attributes);
    }
}
