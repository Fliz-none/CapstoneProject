<?php

namespace Database\Seeders;

use App\Models\Catalogue;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Nette\Utils\Random;

class CatalogueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $catalogues = [
            [1, 'tieu-dung', 'Tiêu dùng', NULL, 1, NULL, 1, 'Các sản phẩm mang đặc tính tiêu hao, cạn dần theo thời gian sử dụng. VD: Thức ăn, cát, dầu gội, nước hoa, xà bông, kem v.v...', NULL, '2024-06-10 14:09:32', '2024-07-23 15:12:34'],
            [2, 'thuc-pham-kho', 'Thực phẩm khô', null, 2, 1, 1, 'Các loại mì, gạo, ngũ cốc, hạt khô bảo quản dài hạn.', null, now()->subDays(19), now()],
            [3, 'do-uong', 'Đồ uống', null, 3, 1, 1, 'Nước ngọt, nước khoáng, sữa, nước ép trái cây.', null, now()->subDays(18), now()],
            [4, 'do-gia-dung', 'Đồ gia dụng', null, 4, 1, 1, 'Các vật dụng cần thiết cho gia đình như xoong nồi, dao kéo, chén đĩa.', null, now()->subDays(17), now()],
            [5, 'my-pham', 'Mỹ phẩm', null, 5, 1, 1, 'Sản phẩm chăm sóc cá nhân như sữa rửa mặt, kem chống nắng, lotion.', null, now()->subDays(16), now()],
            [6, 'thuc-pham-tuoi', 'Thực phẩm tươi sống', null, 6, 1, 1, 'Rau củ, thịt, cá, trứng tươi mỗi ngày.', null, now()->subDays(15), now()],
            [7, 'do-dung-van-phong', 'Đồ dùng văn phòng', null, 7, 1, 1, 'Giấy in, bút viết, ghim, hồ dán, dụng cụ văn phòng phẩm.', null, now()->subDays(14), now()],
            [8, 'do-dien-tu', 'Đồ điện tử', null, 8, 1, 1, 'Tai nghe, sạc dự phòng, dây cáp, chuột, bàn phím.', null, now()->subDays(13), now()],
            [9, 'cham-soc-nha-cua', 'Chăm sóc nhà cửa', null, 9, 1, 1, 'Nước lau sàn, nước rửa chén, xịt phòng, khăn lau.', null, now()->subDays(12), now()],
            [10, 'cham-soc-ca-nhan', 'Chăm sóc cá nhân', null, 10, 1, 1, 'Dầu gội, xà phòng, bàn chải, kem đánh răng.', null, now()->subDays(11), now()],
            [11, 'thoi-trang-nam', 'Thời trang nam', null, 11, null, 1, 'Áo thun, áo sơ mi, quần jean, giày dép cho nam.', null, now()->subDays(10), now()],
            [12, 'thoi-trang-nu', 'Thời trang nữ', null, 12, null, 1, 'Đầm, váy, áo kiểu, phụ kiện dành cho nữ.', null, now()->subDays(9), now()],
            [13, 'trang-suc', 'Trang sức', null, 13, null, 1, 'Vòng tay, nhẫn, dây chuyền, bông tai thời trang.', null, now()->subDays(8), now()],
            [14, 'dung-cu-nha-bep', 'Dụng cụ nhà bếp', null, 14, 4, 1, 'Chảo, nồi, máy xay, bếp điện, dao thớt.', null, now()->subDays(7), now()],
            [15, 'thuc-pham-dong-hop', 'Thực phẩm đóng hộp', null, 15, 2, 1, 'Cá hộp, pate, thịt hộp, rau củ đóng hộp.', null, now()->subDays(6), now()],
            [16, 'do-dung-tre-em', 'Đồ dùng trẻ em', null, 16, null, 1, 'Tã, sữa, đồ chơi, xe đẩy, quần áo cho bé.', null, now()->subDays(5), now()],
            [17, 'hang-nhap-khau', 'Hàng nhập khẩu', null, 17, null, 1, 'Sản phẩm tiêu dùng từ Mỹ, Nhật, Hàn Quốc...', null, now()->subDays(4), now()],
            [18, 'combo-khuyen-mai', 'Combo khuyến mãi', null, 18, null, 1, 'Bộ sản phẩm trọn gói tiết kiệm chi phí.', null, now()->subDays(3), now()],
            [19, 'dich-vu-giao-hang', 'Dịch vụ giao hàng', null, 19, null, 1, 'Giao hàng nhanh, giao hàng tiết kiệm, COD.', null, now()->subDays(2), now()],
            [20, 'san-pham-ban-chay', 'Sản phẩm bán chạy', null, 20, null, 1, 'Danh sách sản phẩm được mua nhiều nhất trong tháng.', null, now()->subDays(1), now()],
        ];
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        foreach ($catalogues as $key => $catalogue) {
            Catalogue::create([
                'id' => $catalogue[0],
                'slug' => $catalogue[1],
                'name' => $catalogue[2],
                'avatar' => $catalogue[3],
                'sort' => $catalogue[4],
                'parent_id' => $catalogue[5],
                'status' => $catalogue[6],
                'is_featured' => 1,
                'note' => $catalogue[7],
                'deleted_at' => $catalogue[8],
                'created_at' => $catalogue[9],
                'updated_at' => $catalogue[10],
            ]);
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
