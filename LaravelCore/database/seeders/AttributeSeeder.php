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
                'company_id' => 1
            ],
            [
                'key' => 'Khối lượng',
                'value' => '50g',
                'company_id' => 1
            ],
            [
                'key' => 'Khối lượng',
                'value' => '100g',
                'company_id' => 1
            ],
            [
                'key' => 'Khối lượng',
                'value' => '200g',
                'company_id' => 1
            ],
            [
                'key' => 'Khối lượng',
                'value' => '300g',
                'company_id' => 1
            ],
            [
                'key' => 'Khối lượng',
                'value' => '400g',
                'company_id' => 1
            ],
            [
                'key' => 'Khối lượng',
                'value' => '500g',
                'company_id' => 1
            ],
            [
                'key' => 'Khối lượng',
                'value' => '600g',
                'company_id' => 1
            ],
            [
                'key' => 'Khối lượng',
                'value' => '700g',
                'company_id' => 1
            ],
            [
                'key' => 'Khối lượng',
                'value' => '800g',
                'company_id' => 1
            ],
            [
                'key' => 'Khối lượng',
                'value' => '900g',
                'company_id' => 1
            ],
            [
                'key' => 'Khối lượng',
                'value' => '1kg',
                'company_id' => 1
            ],
            [
                'key' => 'Kích cỡ',
                'value' => 'S',
                'company_id' => 1
            ],
            [
                'key' => 'Kích cỡ',
                'value' => 'M',
                'company_id' => 1
            ],
            [
                'key' => 'Kích cỡ',
                'value' => 'L',
                'company_id' => 1
            ],
            [
                'key' => 'Kích cỡ',
                'value' => 'XL',
                'company_id' => 1
            ],
            [
                'key' => 'Kích cỡ',
                'value' => 'XXL',
                'company_id' => 1
            ],
            [
                'key' => 'Size',
                'value' => 'Số 1',
                'company_id' => 1
            ],
            [
                'key' => 'Size',
                'value' => 'Số 2',
                'company_id' => 1
            ],
            [
                'key' => 'Size',
                'value' => 'Số 3',
                'company_id' => 1
            ],
            [
                'key' => 'Size',
                'value' => 'Số 4',
                'company_id' => 1
            ],
            [
                'key' => 'Size',
                'value' => 'Số 5',
                'company_id' => 1
            ],
            [
                'key' => 'Size',
                'value' => 'Số 6',
                'company_id' => 1
            ],
            [
                'key' => 'Quy cách',
                'value' => 'Nhỏ',
                'company_id' => 1
            ],
            [
                'key' => 'Quy cách',
                'value' => 'Vừa',
                'company_id' => 1
            ],
            [
                'key' => 'Quy cách',
                'value' => 'Lớn',
                'company_id' => 1
            ],
            [
                'key' => 'Dung tích',
                'value' => '5cc',
                'company_id' => 1
            ],
            [
                'key' => 'Dung tích',
                'value' => '10cc',
                'company_id' => 1
            ],
            [
                'key' => 'Dung tích',
                'value' => '15cc',
                'company_id' => 1
            ],
            [
                'key' => 'Dung tích',
                'value' => '20cc',
                'company_id' => 1
            ],
            [
                'key' => 'Dung tích',
                'value' => '50ml',
                'company_id' => 1
            ],
            [
                'key' => 'Dung tích',
                'value' => '100ml',
                'company_id' => 1
            ],
            [
                'key' => 'Dung tích',
                'value' => '200ml',
                'company_id' => 1
            ],
            [
                'key' => 'Dung tích',
                'value' => '500ml',
                'company_id' => 1
            ],
            [
                'key' => 'Dạng bào chế',
                'value' => 'viên nén',
                'company_id' => 1
            ],
            [
                'key' => 'Dạng bào chế',
                'value' => 'viên nang',
                'company_id' => 1
            ],
            [
                'key' => 'Dạng bào chế',
                'value' => 'dạng bột',
                'company_id' => 1
            ],
            [
                'key' => 'Dạng bào chế',
                'value' => 'dạng nước',
                'company_id' => 1
            ],
            [
                'key' => 'Dạng bào chế',
                'value' => 'dạng kem',
                'company_id' => 1
            ],
            [
                'key' => 'Dạng bào chế',
                'value' => 'dạng gel',
                'company_id' => 1
            ],
            [
                'key' => 'Dạng bào chế',
                'value' => 'dạng cốm',
                'company_id' => 1
            ],
        ];
        DB::table('attributes')->insert($attributes);
    }
}
