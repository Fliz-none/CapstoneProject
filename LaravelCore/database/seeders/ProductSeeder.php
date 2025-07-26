<?php

namespace Database\Seeders;

use App\Models\Catalogue;
use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = [
            [1, 'Gạo thơm Jasmine', 'Gạo thơm Jasmine', 'gao-thom-jasmine', 'Gạo dẻo, thơm ngon', 'Gạo chất lượng cao cho bữa cơm gia đình.', null, 'gạo, jasmine, thơm', null, 1, 1, null, null, now()->subDays(19), now()],
            [2, 'Nước khoáng Lavie 500ml', 'Nước khoáng Lavie 500ml', 'nuoc-khoang-lavie-500ml', 'Nước khoáng thiên nhiên', 'Chai nước khoáng Lavie nhỏ tiện dụng.', null, 'nước, khoáng, lavie', null, 2, 1, null, null, now()->subDays(18), now()],
            [3, 'Bộ nồi inox 5 chiếc', 'Bộ nồi inox 5 chiếc', 'bo-noi-inox-5-chiec', 'Bộ nồi gia dụng cao cấp', 'Bộ nồi inox không gỉ dùng cho bếp gas và điện.', null, 'nồi, inox, gia dụng', null, 3, 1, null, null, now()->subDays(17), now()],
            [4, 'Sữa rửa mặt Senka', 'Sữa rửa mặt Senka', 'sua-rua-mat-senka', 'Làm sạch sâu', 'Sữa rửa mặt chiết xuất tơ tằm trắng cho da sáng mịn.', null, 'sữa rửa mặt, senka', null, 4, 1, null, null, now()->subDays(16), now()],
            [5, 'Thịt heo ba rọi', 'Thịt heo ba rọi', 'thit-heo-ba-roi', 'Thịt tươi ngon mỗi ngày', 'Thịt ba rọi heo tươi đóng khay hút chân không.', null, 'thịt heo, tươi sống', null, 5, 1, null, null, now()->subDays(15), now()],
            [6, 'Bút bi Thiên Long TL-08', 'Bút bi Thiên Long TL-08', 'but-bi-thien-long-tl08', 'Bút viết trơn mượt', 'Bút bi Thiên Long đầu nhỏ, mực xanh.', null, 'bút bi, văn phòng phẩm', null, 6, 1, null, null, now()->subDays(14), now()],
            [7, 'Tai nghe Bluetooth Baseus', 'Tai nghe Bluetooth Baseus', 'tai-nghe-bluetooth-baseus', 'Tai nghe không dây', 'Chất lượng âm thanh cao, kết nối Bluetooth ổn định.', null, 'tai nghe, bluetooth, baseus', null, 7, 1, null, null, now()->subDays(13), now()],
            [8, 'Nước lau sàn Sunlight', 'Nước lau sàn Sunlight', 'nuoc-lau-san-sunlight', 'Hương thơm dịu nhẹ', 'Làm sạch sàn, khử khuẩn, an toàn cho trẻ nhỏ.', null, 'nước lau sàn, sunlight', null, 8, 1, null, null, now()->subDays(12), now()],
            [9, 'Dầu gội Clear Men 650g', 'Dầu gội Clear Men 650g', 'dau-goi-clear-men-650g', 'Sạch gàu, mát lạnh', 'Sản phẩm chăm sóc tóc cho nam giới.', null, 'dầu gội, clear', null, 9, 1, null, null, now()->subDays(11), now()],
            [10, 'Áo thun cotton nam', 'Áo thun cotton nam', 'ao-thun-cotton-nam', 'Thấm hút mồ hôi tốt', 'Áo thun trơn cổ tròn, nhiều màu.', null, 'áo thun, thời trang nam', null, 10, 1, null, null, now()->subDays(10), now()],
            [11, 'Đầm hoa xòe nữ tính', 'Đầm hoa xòe nữ tính', 'dam-hoa-xoe-nu-tinh', 'Thiết kế trẻ trung', 'Đầm hoa dáng xòe cho mùa hè năng động.', null, 'đầm, thời trang nữ', null, 11, 1, null, null, now()->subDays(9), now()],
            [12, 'Nhẫn bạc S925 đơn giản', 'Nhẫn bạc S925 đơn giản', 'nhan-bac-s925-don-gian', 'Trang sức tinh tế', 'Nhẫn bạc nữ phong cách Hàn Quốc.', null, 'nhẫn, bạc, trang sức', null, 12, 1, null, null, now()->subDays(8), now()],
            [13, 'Dao gọt trái cây inox', 'Dao gọt trái cây inox', 'dao-got-trai-cay-inox', 'Tiện lợi, dễ dùng', 'Dao gọt inox sắc bén, tay cầm nhựa.', null, 'dao, dụng cụ nhà bếp', null, 13, 1, null, null, now()->subDays(7), now()],
            [14, 'Cá hộp Vissan 150g', 'Cá hộp Vissan 150g', 'ca-hop-vissan-150g', 'Đậm đà hương vị', 'Cá nục kho cà chua đóng hộp tiện lợi.', null, 'cá hộp, vissan', null, 14, 1, null, null, now()->subDays(6), now()],
            [15, 'Tã dán Bobby size M', 'Tã dán Bobby size M', 'ta-dan-bobby-size-m', 'Khô thoáng, thấm hút tốt', 'Tã dán cho bé từ 6-11kg.', null, 'tã, bobby, trẻ em', null, 15, 1, null, null, now()->subDays(5), now()],
            [16, 'Socola nhập khẩu Ferrero Rocher', 'Socola nhập khẩu Ferrero Rocher', 'socola-ferrero-rocher', 'Hộp 16 viên', 'Socola hạt dẻ cao cấp từ Ý.', null, 'socola, nhập khẩu', null, 16, 1, null, null, now()->subDays(4), now()],
            [17, 'Combo chăm sóc da', 'Combo chăm sóc da', 'combo-cham-soc-da', 'Tiết kiệm chi phí', 'Bao gồm sữa rửa mặt, toner, kem dưỡng.', null, 'combo, mỹ phẩm', null, 17, 1, null, null, now()->subDays(3), now()],
            [18, 'Dịch vụ giao hàng nhanh', 'Dịch vụ giao hàng nhanh', 'dich-vu-giao-hang-nhanh', 'Nhanh - Đúng hẹn', 'Giao hàng nội thành trong 2 giờ.', null, 'giao hàng, nhanh', null, 18, 1, null, null, now()->subDays(2), now()],
            [19, 'Sữa đặc ông thọ 380g', 'Sữa đặc ông thọ 380g', 'sua-dac-ong-tho-380g', 'Đậm đặc, béo ngậy', 'Sữa đặc dùng pha chế hoặc ăn kèm bánh mì.', null, 'sữa đặc, ông thọ', null, 19, 1, null, null, now()->subDays(1), now()],
            [20, 'Snack rong biển Oishi', 'Snack rong biển Oishi', 'snack-rong-bien-oishi', 'Vị rong biển giòn tan', 'Snack ăn liền giòn ngon, đóng gói tiện lợi.', null, 'snack, rong biển, ăn vặt', null, 20, 1, null, null, now(), now()],
        ];

        foreach ($products as $key => $product) {
            Product::create([
                'id' => $product[0],
                // Random sku by name
                'sku' => Str::slug($product[1]),
                'name' => $product[2],
                'slug' => $product[3],
                'excerpt' => $product[4],
                'description' => $product[5],
                'specs' => $product[6],
                'keyword' => $product[7],
                'gallery' => $product[8],
                'sort' => $product[9],
                'allow_review' => $product[10],
                'status' => rand(1, 4), //Radom 1, 2, 3, 4, 0
                'deleted_at' => $product[12],
                'created_at' => $product[13],
                'updated_at' => $product[14],
            ]);
        }

        DB::statement("
            INSERT INTO catalogue_product (catalogue_id, product_id) VALUES
            (2, 1),  -- Thực phẩm khô
            (3, 2),  -- Đồ uống
            (4, 3),  -- Đồ gia dụng
            (5, 4),  -- Mỹ phẩm
            (6, 5),  -- Thực phẩm tươi sống
            (7, 6),  -- Đồ dùng văn phòng
            (8, 7),  -- Đồ điện tử
            (9, 8),  -- Chăm sóc nhà cửa
            (10, 9), -- Chăm sóc cá nhân
            (11, 10),-- Thời trang nam
            (12, 11),-- Thời trang nữ
            (13, 12),-- Trang sức
            (14, 13),-- Dụng cụ nhà bếp
            (15, 14),-- Thực phẩm đóng hộp
            (16, 15),-- Đồ dùng trẻ em
            (17, 16),-- Hàng nhập khẩu
            (18, 17),-- Combo khuyến mãi
            (19, 18),-- Dịch vụ giao hàng
            (20, 19),-- Sản phẩm bán chạy
            (2, 20); -- Thực phẩm khô (sản phẩm bổ sung)
        ");
    }
}
