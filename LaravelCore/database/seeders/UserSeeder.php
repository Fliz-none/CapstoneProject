<?php

namespace Database\Seeders;

use App\Models\Animal;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
          [1, 'Super Admin', '0939403090', 'admin@gmail.com', 'TKH000001.jpg', 0, Hash::make('Admin@123'), NULL, NULL, NULL, NULL, 2, NULL, NULL, 1, '2024-08-01 22:53:25', NULL, NULL, 'hABlHJTDSbQVvS9NEyflTinlj0yCNja5KgsXmHeb9mZlQiOdfG9siF3C5uyW', NULL, '2024-01-15 13:12:15', '2024-09-14 17:25:57'],
            [2, 'Lê Hải Đăng', '0942852755', 'lhd4388@gmail.com', NULL, 0, Hash::make('haidang1210'), NULL, NULL, NULL, NULL, 2, NULL, NULL, 1, '2024-08-16 09:12:54', NULL, NULL, NULL, NULL, '2024-06-09 10:09:31', '2024-09-14 06:52:10'],
            [3, 'Lê Hoàng Thắng', '0358351262', 'thangle2003ss@gmail.com', 'TKH00003.webp', 0, Hash::make('Admin@123'), NULL, NULL, NULL, NULL, NULL, 2, NULL, 1, NULL, NULL, NULL, NULL, NULL, '2024-06-09 10:09:31', '2024-08-15 05:00:00'],
            [4, 'Test', '0939550105', 'test@gmail.com', NULL, 1, Hash::make('Admin@123'), NULL, 'Hưng Phú', '20', NULL, 1, NULL, NULL, 1, '2024-04-27 19:02:00', NULL, NULL, NULL, NULL, '2024-04-25 18:01:40', NULL],
            [5, 'chị Thy', NULL, NULL, NULL, 1, NULL, NULL, NULL, '301', NULL, NULL, NULL, NULL, 1, '2024-04-27 19:19:00', NULL, NULL, NULL, NULL, '2024-04-25 17:54:13', NULL],
            [6, 'anh Phong', NULL, NULL, NULL, 1, NULL, NULL, NULL, '411', NULL, NULL, NULL, NULL, 1, '2024-04-27 17:58:00', NULL, NULL, NULL, NULL, '2024-04-25 16:57:19', NULL],
            [7, 'Như', '0911286647', NULL, NULL, 2, NULL, NULL, NULL, '260', NULL, NULL, NULL, NULL, 1, '2024-04-27 15:58:00', NULL, NULL, NULL, NULL, '2024-04-25 14:57:13', NULL],
            [8, 'Chú Vĩnh (Chị Như: 0787947356)', '0913971884', NULL, NULL, 1, NULL, NULL, 'Cái Khế', '515', NULL, NULL, NULL, NULL, 1, '2024-04-27 15:25:00', NULL, NULL, NULL, NULL, '2024-04-25 14:22:58', NULL],
            [9, 'Nguyên', '0775868597', NULL, NULL, 1, NULL, NULL, NULL, '120', NULL, NULL, NULL, NULL, 1, '2024-04-27 14:21:00', NULL, NULL, NULL, NULL, '2024-04-25 13:19:14', NULL],
            [10, 'Tính', '0345406270', NULL, NULL, 1, NULL, NULL, NULL, '133', NULL, NULL, NULL, NULL, 1, '2024-04-27 11:32:00', NULL, NULL, NULL, NULL, '2024-04-25 10:31:35', NULL],
            [11, 'Chú Thảo', '0902613797', NULL, NULL, 1, NULL, NULL, 'nam long, Quận Ninh Kiều, Cần Thơ', '270', NULL, NULL, NULL, NULL, 1, '2024-04-26 21:00:00', NULL, NULL, NULL, NULL, '2024-04-24 19:59:16', NULL],
            [12, 'anh Sang', '0931887612', NULL, NULL, 1, NULL, NULL, NULL, '238', NULL, NULL, NULL, NULL, 1, '2024-04-26 18:35:00', NULL, NULL, NULL, NULL, '2024-04-24 17:35:28', NULL],
            [13, 'Chị Dung', '0948434235', NULL, NULL, 1, NULL, NULL, 'Phú Thứ', '400', NULL, NULL, NULL, NULL, 1, '2024-04-26 18:36:00', NULL, NULL, NULL, NULL, '2024-04-24 17:33:41', NULL],
            [14, 'CHỊ THẢO', '0985451016', NULL, NULL, 2, NULL, NULL, NULL, '100', NULL, NULL, NULL, NULL, 1, '2024-04-26 18:34:00', NULL, NULL, NULL, NULL, '2024-04-24 17:32:41', NULL],
            [15, 'chị Tú', '0862305615', NULL, NULL, 2, NULL, NULL, NULL, '76', NULL, NULL, NULL, NULL, 1, '2024-04-26 18:29:00', NULL, NULL, NULL, NULL, '2024-04-24 17:28:58', NULL],
            [16, 'DUY', '0387029805', NULL, NULL, 1, NULL, NULL, NULL, '24', NULL, NULL, NULL, NULL, 1, '2024-04-26 14:05:00', NULL, NULL, NULL, NULL, '2024-04-24 13:03:45', NULL],
            [17, 'THU', '0395009399', NULL, NULL, 2, NULL, NULL, NULL, '76', NULL, NULL, NULL, NULL, 1, '2024-04-26 11:05:00', NULL, NULL, NULL, NULL, '2024-04-24 10:05:07', NULL],
            [18, 'Vy', '0913991141', NULL, NULL, 2, NULL, NULL, NULL, '1132', NULL, NULL, NULL, NULL, 1, '2024-04-26 14:23:00', NULL, NULL, NULL, NULL, '2024-04-24 07:16:49', NULL],
            [19, 'Anh Tới', '0779147862', NULL, NULL, 1, NULL, NULL, NULL, '615', NULL, NULL, NULL, NULL, 1, '2024-04-26 20:34:00', NULL, NULL, NULL, NULL, '2024-04-23 20:25:00', NULL],
            [20, 'chị Ngân', '0813454624', NULL, NULL, 2, NULL, NULL, NULL, '73', NULL, NULL, NULL, NULL, 1, '2024-04-25 20:01:00', NULL, NULL, NULL, NULL, '2024-04-23 19:01:23', NULL],
            [21, 'BĂNG', '0369107292', NULL, NULL, 2, NULL, NULL, NULL, '90', NULL, NULL, NULL, NULL, 1, '2024-04-25 18:49:00', NULL, NULL, NULL, NULL, '2024-04-23 17:48:45', NULL],
            [22, 'anh Bình', '0949317777', NULL, NULL, 1, NULL, NULL, NULL, '15', NULL, NULL, NULL, NULL, 1, '2024-04-25 19:23:00', NULL, NULL, NULL, NULL, '2024-04-23 17:47:35', NULL],
            [23, 'anh Phước', '0915699353', NULL, NULL, 1, NULL, NULL, NULL, '618', NULL, NULL, NULL, NULL, 1, '2024-04-25 18:50:00', NULL, NULL, NULL, NULL, '2024-04-23 17:17:01', NULL],
            [24, 'Yên', '0939001900', NULL, NULL, 1, NULL, NULL, NULL, '0', NULL, NULL, NULL, NULL, 1, '2024-04-25 16:47:00', NULL, NULL, NULL, NULL, '2024-04-23 15:36:11', NULL],
            [25, 'Chị Tiên', '0939473736', NULL, NULL, 1, NULL, NULL, NULL, '230', NULL, NULL, NULL, NULL, 1, '2024-04-25 15:38:00', NULL, NULL, NULL, NULL, '2024-04-23 14:36:24', NULL],
            [26, 'Chị Ngân-Gấu (HG)', '0789002451', NULL, NULL, 2, NULL, NULL, NULL, '665', NULL, NULL, NULL, NULL, 1, '2024-04-25 21:12:00', NULL, NULL, NULL, NULL, '2024-04-23 09:50:07', NULL],
            [27, 'BẰNG', '0362357616', NULL, NULL, 1, NULL, NULL, NULL, '180', NULL, NULL, NULL, NULL, 1, '2024-04-24 19:29:00', NULL, NULL, NULL, NULL, '2024-04-22 18:28:17', NULL],
            [28, 'Nhi', '0795804394', NULL, NULL, 2, NULL, NULL, NULL, '260', NULL, NULL, NULL, NULL, 1, '2024-04-24 19:21:00', NULL, NULL, NULL, NULL, '2024-04-22 18:17:07', NULL],
            [29, 'QUYÊN', '0866869052', NULL, NULL, 1, NULL, NULL, NULL, '687', NULL, NULL, NULL, NULL, 1, '2024-04-26 18:44:00', NULL, NULL, NULL, NULL, '2024-04-22 17:59:27', NULL],
            [30, 'YẾN QUỲNH', '0938236964', NULL, NULL, 2, NULL, NULL, NULL, '230', NULL, NULL, NULL, NULL, 1, '2024-04-25 19:55:00', NULL, NULL, NULL, NULL, '2024-04-22 17:29:15', NULL],
            [31, 'chị Trang', '0986453854', NULL, NULL, 2, NULL, NULL, NULL, '175', NULL, NULL, NULL, NULL, 1, '2024-04-24 18:14:00', NULL, NULL, NULL, NULL, '2024-04-22 17:14:05', NULL],
            [32, 'chị Oanh', '0778819613', NULL, NULL, 2, NULL, NULL, NULL, '102', NULL, NULL, NULL, NULL, 1, '2024-04-24 17:53:00', NULL, NULL, NULL, NULL, '2024-04-22 16:53:31', NULL],
            [33, 'Ngọc Hân', '0901211005', NULL, NULL, 1, NULL, NULL, NULL, '320', NULL, NULL, NULL, NULL, 1, '2024-04-24 15:24:00', NULL, NULL, NULL, NULL, '2024-04-22 14:21:36', NULL],
            [34, 'Chú Huy', '0918208324', NULL, NULL, 1, NULL, NULL, NULL, '70', NULL, NULL, NULL, NULL, 1, '2024-04-23 19:44:00', NULL, NULL, NULL, NULL, '2024-04-21 18:39:50', NULL],
            [35, 'CHỊ HÂN', '0899494851', NULL, NULL, 2, NULL, NULL, NULL, '200', NULL, NULL, NULL, NULL, 1, '2024-04-24 18:24:00', NULL, NULL, NULL, NULL, '2024-04-21 18:11:06', NULL],
            [36, 'chị Vân', '0939435319', NULL, NULL, 1, NULL, NULL, NULL, '180', NULL, NULL, NULL, NULL, 1, '2024-04-23 18:48:00', NULL, NULL, NULL, NULL, '2024-04-21 16:25:36', NULL],
            [37, 'Ý Xuân', '0365264055', NULL, NULL, 1, NULL, NULL, NULL, '60', NULL, NULL, NULL, NULL, 1, '2024-04-23 12:26:00', NULL, NULL, NULL, NULL, '2024-04-21 11:25:25', NULL],
            [38, 'Thoa', '0339345127', NULL, NULL, 1, NULL, NULL, NULL, '160', NULL, NULL, NULL, NULL, 1, '2024-04-23 11:40:00', NULL, NULL, NULL, NULL, '2024-04-21 10:40:08', NULL],
            [39, 'Gia Huy', '0939482373', NULL, NULL, 1, NULL, NULL, NULL, '215', NULL, NULL, NULL, NULL, 1, '2024-04-23 11:03:00', NULL, NULL, NULL, NULL, '2024-04-21 10:01:24', NULL],
            [40, 'A.KHANG', '0342689568', NULL, NULL, 1, NULL, NULL, NULL, '85', NULL, NULL, NULL, NULL, 1, '2024-04-26 19:25:00', NULL, NULL, NULL, NULL, '2024-04-20 18:13:40', NULL],
            [41, 'ĐỨC CÔNG', '0862830194', NULL, NULL, 1, NULL, NULL, NULL, '300', NULL, NULL, NULL, NULL, 1, '2024-04-27 18:45:00', NULL, NULL, NULL, NULL, '2024-04-20 17:10:59', NULL],
            [42, 'CHÚ MINH', '0977448270', NULL, NULL, 1, NULL, NULL, NULL, '224', NULL, NULL, NULL, NULL, 1, '2024-04-23 19:09:00', NULL, NULL, NULL, NULL, '2024-04-20 17:06:04', NULL],
            [43, 'Anh Quyết', '0987033434', NULL, NULL, 1, NULL, NULL, NULL, '350', NULL, NULL, NULL, NULL, 1, '2024-04-22 19:15:00', NULL, NULL, NULL, NULL, '2024-04-20 12:39:49', NULL],
            [44, 'Cô Trúc', '0939125116', NULL, NULL, 2, NULL, NULL, NULL, '55', NULL, NULL, NULL, NULL, 1, '2024-04-22 10:43:00', NULL, NULL, NULL, NULL, '2024-04-20 09:43:35', NULL],
            [45, 'Đào', '0336364817', NULL, NULL, 2, NULL, NULL, NULL, '150', NULL, NULL, NULL, NULL, 1, '2024-04-22 10:00:00', NULL, NULL, NULL, NULL, '2024-04-20 09:00:07', NULL],
            [46, 'nhựt anh', '0939111180', NULL, NULL, 1, NULL, NULL, NULL, '170', NULL, NULL, NULL, NULL, 1, '2024-04-21 19:29:00', NULL, NULL, NULL, NULL, '2024-04-19 18:28:54', NULL],
            [47, 'Thanh Ngân', '0333373401', NULL, NULL, 1, NULL, NULL, NULL, '190', NULL, NULL, NULL, NULL, 1, '2024-04-21 18:31:00', NULL, NULL, NULL, NULL, '2024-04-19 17:31:00', NULL],
            [48, 'Minh Trí', '0388433500', NULL, NULL, 1, NULL, NULL, NULL, '60', NULL, NULL, NULL, NULL, 1, '2024-04-21 18:11:00', NULL, NULL, NULL, NULL, '2024-04-19 17:10:39', NULL],
            [49, 'anh Quý', '0939395732', NULL, NULL, 1, NULL, NULL, NULL, '460', NULL, NULL, NULL, NULL, 1, '2024-04-21 18:06:00', NULL, NULL, NULL, NULL, '2024-04-19 17:05:14', NULL],
            [50, 'Anh Giáp', '0869279447', NULL, NULL, 1, NULL, NULL, NULL, '270', NULL, NULL, NULL, NULL, 1, '2024-04-22 18:40:00', NULL, NULL, NULL, NULL, '2024-04-19 12:35:06', NULL],
            [51, 'Kim Anh', '0988829545', NULL, NULL, 2, NULL, NULL, NULL, '110', NULL, NULL, NULL, NULL, 1, '2024-04-21 13:20:00', NULL, NULL, NULL, NULL, '2024-04-19 12:19:00', NULL],
            [52, 'chị Kim Anh', NULL, NULL, NULL, 1, NULL, NULL, NULL, '130', NULL, NULL, NULL, NULL, 1, '2024-04-21 10:58:00', NULL, NULL, NULL, NULL, '2024-04-19 09:55:01', NULL],
            [53, 'anh Tâm', NULL, NULL, NULL, 1, NULL, NULL, NULL, '545', NULL, NULL, NULL, NULL, 1, '2024-04-21 07:59:00', NULL, NULL, NULL, NULL, '2024-04-19 06:59:27', NULL],
            [54, 'chị Hoa', NULL, NULL, NULL, 1, NULL, NULL, NULL, '35', NULL, NULL, NULL, NULL, 1, '2024-04-21 07:24:00', NULL, NULL, NULL, NULL, '2024-04-19 06:24:27', NULL],
            [55, 'TIỂU MẪN', '0979134499', NULL, NULL, 2, NULL, NULL, NULL, '288', NULL, NULL, NULL, NULL, 1, '2024-04-25 17:45:00', NULL, NULL, NULL, NULL, '2024-04-18 14:56:26', NULL],
            [56, 'DIỄM HÂN', '0828729336', NULL, NULL, 2, NULL, NULL, NULL, '204', NULL, NULL, NULL, NULL, 1, '2024-04-22 18:05:00', NULL, NULL, NULL, NULL, '2024-04-18 14:42:42', NULL],
            [57, 'Em Thế', '0365641862', NULL, NULL, 1, NULL, NULL, NULL, '430', NULL, NULL, NULL, NULL, 1, '2024-04-20 17:40:00', NULL, NULL, NULL, NULL, '2024-04-18 11:58:32', NULL],
            [58, 'Tuyết Mai', '0985813751', NULL, NULL, 1, NULL, NULL, NULL, '316', NULL, NULL, NULL, NULL, 1, '2024-04-27 14:16:00', NULL, NULL, NULL, NULL, '2024-04-18 11:49:39', NULL],
            [59, 'chị My', '0582898290', NULL, NULL, 2, NULL, NULL, NULL, '638', NULL, NULL, NULL, NULL, 1, '2024-04-22 18:03:00', NULL, NULL, NULL, NULL, '2024-04-17 18:12:48', NULL],
            [60, 'chị Châu', '0385787077', NULL, NULL, 1, NULL, NULL, 'Long tuyền -Bình thủy', '50', NULL, NULL, NULL, NULL, 1, '2024-04-21 18:48:00', NULL, NULL, NULL, NULL, '2024-04-17 18:11:52', NULL],
            [61, 'NHƯ QUỲNH', '0766899913', NULL, NULL, 1, NULL, NULL, NULL, '24', NULL, NULL, NULL, NULL, 1, '2024-04-19 18:41:00', NULL, NULL, NULL, NULL, '2024-04-17 17:40:13', NULL],
            [62, 'chị Tú', NULL, NULL, NULL, 1, NULL, NULL, NULL, '197', NULL, NULL, NULL, NULL, 1, '2024-04-19 18:33:00', NULL, NULL, NULL, NULL, '2024-04-17 17:32:55', NULL],
            [63, 'Thái Trân', '0907378435', NULL, NULL, 2, NULL, NULL, NULL, '120', NULL, NULL, NULL, NULL, 1, '2024-04-19 19:34:00', NULL, NULL, NULL, NULL, '2024-04-17 17:17:31', NULL],
            [64, 'Anh Hà', '0898899226', NULL, NULL, 1, NULL, NULL, NULL, '315', NULL, NULL, NULL, NULL, 1, '2024-04-19 16:50:00', NULL, NULL, NULL, NULL, '2024-04-17 15:48:06', NULL],
            [65, 'Chị Đào', '0377591410', NULL, NULL, 2, NULL, NULL, NULL, '110', NULL, NULL, NULL, NULL, 1, '2024-04-27 19:05:00', NULL, NULL, NULL, NULL, '2024-04-16 19:44:00', NULL],
            [66, 'Chị Liên', '0962692644', NULL, NULL, 2, NULL, NULL, NULL, '20', NULL, NULL, NULL, NULL, 1, '2024-04-18 20:29:00', NULL, NULL, NULL, NULL, '2024-04-16 19:28:00', NULL],
            [67, 'Em Loan', '0985481743', NULL, NULL, 1, NULL, NULL, '586', '190', NULL, NULL, NULL, NULL, 1, '2024-04-19 17:25:00', NULL, NULL, NULL, NULL, '2024-04-16 18:12:49', NULL],
            [68, 'Cô Linh', '0907088190', NULL, NULL, 2, NULL, NULL, NULL, '150', NULL, NULL, NULL, NULL, 1, '2024-04-19 16:36:00', NULL, NULL, NULL, NULL, '2024-04-16 17:29:48', NULL],
            [69, 'chị Liên', NULL, NULL, NULL, 1, NULL, NULL, NULL, '45', NULL, NULL, NULL, NULL, 1, '2024-04-18 17:41:00', NULL, NULL, NULL, NULL, '2024-04-16 16:40:37', NULL],
            [70, 'Chị Quyên', '0896481886', NULL, NULL, 2, NULL, NULL, 'Phú An', '507', NULL, NULL, NULL, NULL, 1, '2024-04-25 15:42:00', NULL, NULL, NULL, NULL, '2024-04-16 16:29:26', NULL],
            [71, 'ANH HUY', '0914308452', NULL, NULL, 1, NULL, NULL, NULL, '205', NULL, NULL, NULL, NULL, 1, '2024-04-19 18:56:00', NULL, NULL, NULL, NULL, '2024-04-16 15:30:35', NULL],
            [72, 'CHỊ KIỀU TIÊN', '0766984477', NULL, NULL, 2, NULL, NULL, NULL, '106', NULL, NULL, NULL, NULL, 1, '2024-04-18 16:28:00', NULL, NULL, NULL, NULL, '2024-04-16 15:23:48', NULL],
            [73, 'CHỊ LOAN', '0982387183', NULL, NULL, 2, NULL, NULL, NULL, '20', NULL, NULL, NULL, NULL, 1, '2024-04-18 16:22:00', NULL, NULL, NULL, NULL, '2024-04-16 15:21:03', NULL],
            [74, 'Huỳnh Như', '0335523404', NULL, NULL, 2, NULL, NULL, NULL, '215', NULL, NULL, NULL, NULL, 1, '2024-04-18 14:26:00', NULL, NULL, NULL, NULL, '2024-04-16 13:26:17', NULL],
            [75, 'Vỹ', '0966414368', NULL, NULL, 1, NULL, NULL, NULL, '659', NULL, NULL, NULL, NULL, 1, '2024-04-18 19:08:00', NULL, NULL, NULL, NULL, '2024-04-16 10:51:01', NULL],
            [76, 'chị Ngân', '0907373457', NULL, NULL, 2, NULL, NULL, NULL, '80', NULL, NULL, NULL, NULL, 1, '2024-04-18 10:48:00', NULL, NULL, NULL, NULL, '2024-04-16 09:48:20', NULL],
            [77, 'Chi', '0907694714', NULL, NULL, 2, NULL, NULL, NULL, '100', NULL, NULL, NULL, NULL, 1, '2024-04-18 09:02:00', NULL, NULL, NULL, NULL, '2024-04-16 08:02:02', NULL],
            [78, 'chị Liên', '0913563019', NULL, NULL, 2, NULL, NULL, NULL, '70', NULL, NULL, NULL, NULL, 1, '2024-04-17 19:55:00', NULL, NULL, NULL, NULL, '2024-04-15 18:54:01', NULL],
            [79, 'chú Quang', NULL, NULL, NULL, 1, NULL, NULL, NULL, '40', NULL, NULL, NULL, NULL, 1, '2024-04-17 18:53:00', NULL, NULL, NULL, NULL, '2024-04-15 17:53:06', NULL],
            [80, 'CHÚ TIẾN', '0903334377', NULL, NULL, 1, NULL, NULL, NULL, '842', NULL, NULL, NULL, NULL, 1, '2024-04-24 18:27:00', NULL, NULL, NULL, NULL, '2024-04-15 17:01:05', NULL],
            [81, 'a Đạt', NULL, NULL, NULL, 1, NULL, NULL, NULL, '120', NULL, NULL, NULL, NULL, 1, '2024-04-17 17:52:00', NULL, NULL, NULL, NULL, '2024-04-15 16:52:18', NULL],
            [82, 'HẬU', '0377889516', NULL, NULL, 1, NULL, NULL, NULL, '455', NULL, NULL, NULL, NULL, 1, '2024-04-27 18:53:00', NULL, NULL, NULL, NULL, '2024-04-15 16:47:37', NULL],
            [83, 'Anh Tín', '0766992699', NULL, NULL, 1, NULL, NULL, NULL, '770', NULL, NULL, NULL, NULL, 1, '2024-04-18 09:11:00', NULL, NULL, NULL, NULL, '2024-04-15 15:37:40', NULL],
            [84, 'Chị Diễm', '0795400324', NULL, NULL, 2, NULL, NULL, NULL, '55', NULL, NULL, NULL, NULL, 1, '2024-04-17 15:25:00', NULL, NULL, NULL, NULL, '2024-04-15 14:24:49', NULL],
            [85, 'Anh Minh', '0939298185', NULL, NULL, 1, NULL, NULL, NULL, '68', NULL, NULL, NULL, NULL, 1, '2024-04-17 12:22:00', NULL, NULL, NULL, NULL, '2024-04-15 11:21:57', NULL],
            [86, 'anh Văn', NULL, NULL, NULL, 1, NULL, NULL, NULL, '27', NULL, NULL, NULL, NULL, 1, '2024-04-16 19:50:00', NULL, NULL, NULL, NULL, '2024-04-14 18:50:43', NULL],
            [87, 'CHỊ TÂM', '0349258560', NULL, NULL, 1, NULL, NULL, NULL, '210', NULL, NULL, NULL, NULL, 1, '2024-04-23 19:46:00', NULL, NULL, NULL, NULL, '2024-04-14 18:50:29', NULL],
            [88, 'YẾN', '0704916468', NULL, NULL, 1, NULL, NULL, NULL, '120', NULL, NULL, NULL, NULL, 1, '2024-04-16 19:48:00', NULL, NULL, NULL, NULL, '2024-04-14 18:41:39', NULL],
            [89, 'CHỊ BÍCH', '0704556296', NULL, NULL, 1, NULL, NULL, NULL, '553', NULL, NULL, NULL, NULL, 1, '2024-04-26 18:31:00', NULL, NULL, NULL, NULL, '2024-04-14 17:58:05', NULL],
            [90, 'CHỊ THÙY', '0939852774', NULL, NULL, 2, NULL, NULL, NULL, '325', NULL, NULL, NULL, NULL, 1, '2024-04-16 18:51:00', NULL, NULL, NULL, NULL, '2024-04-14 17:50:09', NULL],
            [91, 'chị Tâm', NULL, NULL, NULL, 1, NULL, NULL, NULL, '89', NULL, NULL, NULL, NULL, 1, '2024-04-16 18:17:00', NULL, NULL, NULL, NULL, '2024-04-14 17:16:56', NULL],
            [92, 'anh Phương', NULL, NULL, NULL, 1, NULL, NULL, NULL, '85', NULL, NULL, NULL, NULL, 1, '2024-04-16 16:22:00', NULL, NULL, NULL, NULL, '2024-04-14 15:22:09', NULL],
            [93, 'chị Khương Mỹ', NULL, NULL, NULL, 1, NULL, NULL, NULL, '264', NULL, NULL, NULL, NULL, 1, '2024-04-15 20:55:00', NULL, NULL, NULL, NULL, '2024-04-13 19:55:24', NULL],
            [94, 'ANH TOÀN', '0332555666', NULL, NULL, 1, NULL, NULL, NULL, '610', NULL, NULL, NULL, NULL, 1, '2024-04-17 19:23:00', NULL, NULL, NULL, NULL, '2024-04-13 18:47:00', NULL],
            [95, 'cô Út', '0848548944', NULL, NULL, 2, NULL, NULL, NULL, '280', NULL, NULL, NULL, NULL, 1, '2024-04-15 18:04:00', NULL, NULL, NULL, NULL, '2024-04-13 17:00:43', NULL],
            [96, 'anh Hoàng', NULL, NULL, NULL, 1, NULL, NULL, NULL, '128', NULL, NULL, NULL, NULL, 1, '2024-04-15 16:57:00', NULL, NULL, NULL, NULL, '2024-04-13 15:57:23', NULL],
            [97, 'anh Thanh', NULL, NULL, NULL, 1, NULL, NULL, NULL, '38', NULL, NULL, NULL, NULL, 1, '2024-04-15 16:01:00', NULL, NULL, NULL, NULL, '2024-04-13 15:00:53', NULL],
            [98, 'Thương', '0907769763', NULL, NULL, 1, NULL, NULL, NULL, '90', NULL, NULL, NULL, NULL, 1, '2024-04-15 15:16:00', NULL, NULL, NULL, NULL, '2024-04-12 20:02:01', NULL],
            [99, 'Anh Tân', '0933806908', NULL, NULL, 1, NULL, NULL, NULL, '105', NULL, NULL, NULL, NULL, 1, '2024-04-21 14:13:00', NULL, NULL, NULL, NULL, '2024-04-12 19:55:35', NULL],
            [100, 'nít', '0888657967', NULL, NULL, 1, NULL, NULL, NULL, '190', NULL, NULL, NULL, NULL, 1, '2024-04-14 19:31:00', NULL, NULL, NULL, NULL, '2024-04-12 18:28:52', NULL],
            [101, 'khánh linh', '0896411299', NULL, NULL, 2, NULL, NULL, NULL, '204', NULL, NULL, NULL, NULL, 1, '2024-04-14 17:20:00', NULL, NULL, NULL, NULL, '2024-04-12 16:18:02', NULL],
            [102, 'lộc', '070675064', NULL, NULL, 1, NULL, NULL, NULL, '27', NULL, NULL, NULL, NULL, 1, '2024-04-14 17:16:00', NULL, NULL, NULL, NULL, '2024-04-12 16:16:42', NULL],
            [103, 'chị My', '0777895599', NULL, NULL, 1, NULL, NULL, NULL, '90', NULL, NULL, NULL, NULL, 1, '2024-04-14 16:38:00', NULL, NULL, NULL, NULL, '2024-04-12 15:36:03', NULL],
            [104, 'Thanh Trúc', '0385288924', NULL, NULL, 1, NULL, NULL, NULL, '120', NULL, NULL, NULL, NULL, 1, '2024-04-14 11:17:00', NULL, NULL, NULL, NULL, '2024-04-12 10:16:06', NULL],
            [105, 'Anh Đông', '0943435565', NULL, NULL, 1, NULL, NULL, NULL, '80', NULL, NULL, NULL, NULL, 1, '2024-04-14 10:34:00', NULL, NULL, NULL, NULL, '2024-04-12 09:33:35', NULL],
            [106, 'Anh Tình', '0937570975', NULL, NULL, 1, NULL, NULL, NULL, '133', NULL, NULL, NULL, NULL, 1, '2024-04-14 10:16:00', NULL, NULL, NULL, NULL, '2024-04-12 09:16:20', NULL],
            [107, 'Anh Nhã', '0939381225', NULL, NULL, 1, NULL, NULL, NULL, '180', NULL, NULL, NULL, NULL, 1, '2024-04-13 15:42:00', NULL, NULL, NULL, NULL, '2024-04-11 14:39:21', NULL],
            [108, 'Tuyết Nhi', '0971746329', NULL, NULL, 1, NULL, NULL, NULL, '40', NULL, NULL, NULL, NULL, 1, '2024-04-13 15:37:00', NULL, NULL, NULL, NULL, '2024-04-11 14:35:55', NULL],
            [109, 'Chị Tuyền', '0907933924', NULL, NULL, 2, NULL, NULL, NULL, '100', NULL, NULL, NULL, NULL, 1, '2024-04-12 20:29:00', NULL, NULL, NULL, NULL, '2024-04-10 19:26:44', NULL],
            [110, 'Chị Tú Anh', '0916625141', NULL, NULL, 1, NULL, NULL, NULL, '30', NULL, NULL, NULL, NULL, 1, '2024-04-12 20:25:00', NULL, NULL, NULL, NULL, '2024-04-10 19:24:06', NULL],
            [111, 'TRƯỜNG', '0857933666', NULL, NULL, 1, NULL, NULL, NULL, '270', NULL, NULL, NULL, NULL, 1, '2024-04-12 17:29:00', NULL, NULL, NULL, NULL, '2024-04-10 16:28:19', NULL],
            [112, 'anh Hùng', '0931069328', NULL, NULL, 1, NULL, NULL, NULL, '95', NULL, NULL, NULL, NULL, 1, '2024-04-12 17:26:00', NULL, NULL, NULL, NULL, '2024-04-10 16:26:15', NULL],
            [113, 'CHỊ TUYỀN', '0909774712', NULL, NULL, 1, NULL, NULL, NULL, '316', NULL, NULL, NULL, NULL, 1, '2024-04-20 19:41:00', NULL, NULL, NULL, NULL, '2024-04-10 16:23:46', NULL],
            [114, 'PHÚ', '0866486833', NULL, NULL, 1, NULL, NULL, NULL, '60', NULL, NULL, NULL, NULL, 1, '2024-04-12 17:21:00', NULL, NULL, NULL, NULL, '2024-04-10 16:19:07', NULL],
            [115, 'NHƯ', '0837789409', NULL, NULL, 2, NULL, NULL, NULL, '110', NULL, NULL, NULL, NULL, 1, '2024-04-12 17:14:00', NULL, NULL, NULL, NULL, '2024-04-10 16:11:32', NULL],
            [116, 'Hiếu', '0939437917', NULL, NULL, 1, NULL, NULL, NULL, '429', NULL, NULL, NULL, NULL, 1, '2024-04-26 17:17:00', NULL, NULL, NULL, NULL, '2024-04-10 15:39:18', NULL],
            [117, 'chị Quý', '0706878083', NULL, NULL, 2, NULL, NULL, NULL, '135', NULL, NULL, NULL, NULL, 1, '2024-04-12 09:33:00', NULL, NULL, NULL, NULL, '2024-04-10 08:33:36', NULL],
            [118, 'Anh Huấn', '0901029586', NULL, NULL, 1, NULL, NULL, NULL, '170', NULL, NULL, NULL, NULL, 1, '2024-04-13 19:37:00', NULL, NULL, NULL, NULL, '2024-04-10 08:16:49', NULL],
            [119, 'Kim Thoại', '0702954003', NULL, NULL, 2, NULL, NULL, NULL, '60', NULL, NULL, NULL, NULL, 1, '2024-04-11 19:17:00', NULL, NULL, NULL, NULL, '2024-04-09 18:15:32', NULL],
            [120, 'CHỊ TRÚC', '0772702960', NULL, NULL, 1, NULL, NULL, NULL, '70', NULL, NULL, NULL, NULL, 1, '2024-04-11 18:56:00', NULL, NULL, NULL, NULL, '2024-04-09 17:55:03', NULL],
            [121, 'Anh Khoa', '0796999687', NULL, NULL, 1, NULL, NULL, NULL, '235', NULL, NULL, NULL, NULL, 1, '2024-04-11 18:14:00', NULL, NULL, NULL, NULL, '2024-04-09 17:13:58', NULL],
            [122, 'Anh Thanh', '0937275777', NULL, NULL, 1, NULL, NULL, NULL, '210', NULL, NULL, NULL, NULL, 1, '2024-04-11 14:48:00', NULL, NULL, NULL, NULL, '2024-04-09 13:45:21', NULL],
            [123, 'Sang', '0706739046', NULL, NULL, 1, NULL, NULL, NULL, '38', NULL, NULL, NULL, NULL, 1, '2024-04-11 14:23:00', NULL, NULL, NULL, NULL, '2024-04-09 13:22:29', NULL],
            [124, 'Anh Tín', '0834756759', NULL, NULL, 1, NULL, NULL, NULL, '20', NULL, NULL, NULL, NULL, 1, '2024-04-11 11:19:00', NULL, NULL, NULL, NULL, '2024-04-09 10:18:59', NULL],
            [125, 'PHÚC', '0981248754', NULL, NULL, 1, NULL, NULL, NULL, '350', NULL, NULL, NULL, NULL, 1, '2024-04-27 14:14:00', NULL, NULL, NULL, NULL, '2024-04-08 18:23:33', NULL],
            [126, 'Anh Luyện', '0907074422', NULL, NULL, 1, NULL, NULL, NULL, '915', NULL, NULL, NULL, NULL, 1, '2024-04-11 19:44:00', NULL, NULL, NULL, NULL, '2024-04-08 17:35:25', NULL],
            [127, 'anh Quận', '0939602377', NULL, NULL, 1, NULL, NULL, NULL, '132', NULL, NULL, NULL, NULL, 1, '2024-04-19 16:48:00', NULL, NULL, NULL, NULL, '2024-04-08 17:14:50', NULL],
            [128, 'Anh Toại', '0919235304', NULL, NULL, 1, NULL, NULL, NULL, '110', NULL, NULL, NULL, NULL, 1, '2024-04-10 17:45:00', NULL, NULL, NULL, NULL, '2024-04-08 16:42:03', NULL],
            [129, 'Anh Thư', '0868907530', NULL, NULL, 2, NULL, NULL, NULL, '195', NULL, NULL, NULL, NULL, 1, '2024-04-10 14:01:00', NULL, NULL, NULL, NULL, '2024-04-08 13:01:12', NULL],
            [130, 'Anh Đồng', '0772144285', NULL, NULL, 1, NULL, NULL, 'TX Ngã Bảy, Hậu Giang', '866', NULL, NULL, NULL, NULL, 1, '2024-04-21 19:43:00', NULL, NULL, NULL, NULL, '2024-04-08 10:26:49', NULL],
            [131, 'Chị Phương', '0788755692', NULL, NULL, 2, NULL, NULL, NULL, '506', NULL, NULL, NULL, NULL, 1, '2024-04-10 18:29:00', NULL, NULL, NULL, NULL, '2024-04-08 10:11:14', NULL],
            [132, 'van', '0764071927', NULL, NULL, 2, NULL, NULL, NULL, '168', NULL, NULL, NULL, NULL, 1, '2024-04-10 09:13:00', NULL, NULL, NULL, NULL, '2024-04-08 07:37:51', NULL],
            [133, 'Sữa', '0377144174', NULL, NULL, 1, NULL, NULL, 'Hưng Lợi, Cần Thơ', '280', NULL, NULL, NULL, NULL, 1, '2024-04-10 18:27:00', NULL, NULL, NULL, NULL, '2024-04-07 21:12:11', NULL],
            [134, 'chị Hoàng Anh', NULL, NULL, NULL, 1, NULL, NULL, NULL, '250', NULL, NULL, NULL, NULL, 1, '2024-04-09 18:52:00', NULL, NULL, NULL, NULL, '2024-04-07 17:52:40', NULL],
            [135, 'chú Hùng', NULL, NULL, NULL, 1, NULL, NULL, NULL, '29', NULL, NULL, NULL, NULL, 1, '2024-04-09 18:33:00', NULL, NULL, NULL, NULL, '2024-04-07 17:33:04', NULL],
            [136, 'QUỲNH', '0923603027', NULL, NULL, 1, NULL, NULL, NULL, '90', NULL, NULL, NULL, NULL, 1, '2024-04-09 18:33:00', NULL, NULL, NULL, NULL, '2024-04-07 17:32:13', NULL],
            [137, 'YẾN VY', '0944678966', NULL, NULL, 2, NULL, NULL, NULL, '850', NULL, NULL, NULL, NULL, 1, '2024-04-12 17:27:00', NULL, NULL, NULL, NULL, '2024-04-07 17:29:51', NULL],
            [138, 'Anh Cảnh', '0939722208', NULL, NULL, 1, NULL, NULL, NULL, '160', NULL, NULL, NULL, NULL, 1, '2024-04-09 17:56:00', NULL, NULL, NULL, NULL, '2024-04-07 16:55:35', NULL],
            [139, 'anh Tuấn', '0909456055', NULL, NULL, 1, NULL, NULL, NULL, '380', NULL, NULL, NULL, NULL, 1, '2024-04-09 17:54:00', NULL, NULL, NULL, NULL, '2024-04-07 16:53:49', NULL],
            [140, 'chị Loan', NULL, NULL, NULL, 1, NULL, NULL, NULL, '24', NULL, NULL, NULL, NULL, 1, '2024-04-09 17:26:00', NULL, NULL, NULL, NULL, '2024-04-07 16:25:24', NULL],
            [141, 'Anh Tín', '0973005101', NULL, NULL, 1, NULL, NULL, NULL, '230', NULL, NULL, NULL, NULL, 1, '2024-04-09 17:18:00', NULL, NULL, NULL, NULL, '2024-04-07 16:16:02', NULL],
            [142, 'chị Trân', NULL, NULL, NULL, 1, NULL, NULL, NULL, '76', NULL, NULL, NULL, NULL, 1, '2024-04-09 17:10:00', NULL, NULL, NULL, NULL, '2024-04-07 16:09:59', NULL],
            [143, 'Chị Tiên - Cái Tắc - Hậu Giang', '0906785679', NULL, NULL, 2, NULL, NULL, 'Kinh Cùng - Cái Tắc - Hậu Giang', '540', NULL, NULL, NULL, NULL, 1, '2024-04-09 16:45:00', NULL, NULL, NULL, NULL, '2024-04-07 15:39:55', NULL],
            [144, 'Anh Sơn', '0901005990', NULL, NULL, 1, NULL, NULL, NULL, '461', NULL, NULL, NULL, NULL, 1, '2024-04-09 12:18:00', NULL, NULL, NULL, NULL, '2024-04-07 11:18:14', NULL],
            [145, 'Cô Hồng', '0336135143', NULL, NULL, 1, NULL, NULL, NULL, '50', NULL, NULL, NULL, NULL, 1, '2024-04-08 22:25:00', NULL, NULL, NULL, NULL, '2024-04-06 21:25:06', NULL],
            [146, 'Chị Hương', '0907611708', NULL, NULL, 1, NULL, NULL, NULL, '795', NULL, NULL, NULL, NULL, 1, '2024-04-09 21:30:00', NULL, NULL, NULL, NULL, '2024-04-06 18:30:04', NULL],
            [147, 'Hà Giang', '0913158637', NULL, NULL, 2, NULL, NULL, NULL, '331', NULL, NULL, NULL, NULL, 1, '2024-04-17 19:59:00', NULL, NULL, NULL, NULL, '2024-04-06 17:03:47', NULL],
            [148, 'Dung', '0909515546', NULL, NULL, 2, NULL, NULL, NULL, '1287', NULL, NULL, NULL, NULL, 1, '2024-04-18 17:13:00', NULL, NULL, NULL, NULL, '2024-04-06 16:25:35', NULL],
            [150, 'ĐỨC', '0364005239', NULL, NULL, 1, NULL, NULL, NULL, '124', NULL, NULL, NULL, NULL, 1, '2024-04-23 19:32:00', NULL, NULL, NULL, NULL, '2024-04-06 14:47:15', NULL],
            [151, 'ANH VƯƠNG', '0939681535', NULL, NULL, 1, NULL, NULL, NULL, '550', NULL, NULL, NULL, NULL, 1, '2024-04-08 15:45:00', NULL, NULL, NULL, NULL, '2024-04-06 14:43:14', NULL],
            [152, 'NGỌC', '0902339730', NULL, NULL, 2, NULL, NULL, NULL, '305', NULL, NULL, NULL, NULL, 1, '2024-04-25 15:38:00', NULL, NULL, NULL, NULL, '2024-04-06 08:11:18', NULL],
            [153, 'Chị Hồng', '0839423288', NULL, NULL, 2, NULL, NULL, NULL, '118', NULL, NULL, NULL, NULL, 1, '2024-04-08 08:36:00', NULL, NULL, NULL, NULL, '2024-04-06 07:36:02', NULL],
            [154, 'Phương Thảo', '0988630639', NULL, NULL, 1, NULL, NULL, NULL, '50', NULL, NULL, NULL, NULL, 1, '2024-04-07 19:03:00', NULL, NULL, NULL, NULL, '2024-04-05 18:02:22', NULL],
            [155, 'Anh Hoài', '0878179277', NULL, NULL, 1, NULL, NULL, NULL, '337', NULL, NULL, NULL, NULL, 1, '2024-04-24 17:27:00', NULL, NULL, NULL, NULL, '2024-04-05 17:53:42', NULL],
            [156, 'NAM', '0378194135', NULL, NULL, 1, NULL, NULL, NULL, '130', NULL, NULL, NULL, NULL, 1, '2024-04-07 18:24:00', NULL, NULL, NULL, NULL, '2024-04-05 17:15:30', NULL],
            [157, 'A. THUẬN', '0977114808', NULL, NULL, 1, NULL, NULL, NULL, '290', NULL, NULL, NULL, NULL, 1, '2024-04-07 18:14:00', NULL, NULL, NULL, NULL, '2024-04-05 17:13:54', NULL],
            [158, 'A. THỨC', '0939423662', NULL, NULL, 1, NULL, NULL, NULL, '305', NULL, NULL, NULL, NULL, 1, '2024-04-07 18:09:00', NULL, NULL, NULL, NULL, '2024-04-05 17:08:58', NULL],
            [159, 'CHƯƠNG', '0983826033', NULL, NULL, 1, NULL, NULL, NULL, '20', NULL, NULL, NULL, NULL, 1, '2024-04-07 18:06:00', NULL, NULL, NULL, NULL, '2024-04-05 17:06:02', NULL],
            [160, 'Tùng', '0335282694', NULL, NULL, 1, NULL, NULL, NULL, '135', NULL, NULL, NULL, NULL, 1, '2024-04-07 14:54:00', NULL, NULL, NULL, NULL, '2024-04-05 13:52:51', NULL],
            [161, 'CHIÊM HOÀNG PHÚC', '0941088115', NULL, NULL, 1, NULL, NULL, NULL, '221', NULL, NULL, NULL, NULL, 1, '2024-04-12 19:07:00', NULL, NULL, NULL, NULL, '2024-04-05 12:46:46', NULL],
            [162, 'chị Xuân', '0839979899', NULL, NULL, 2, NULL, NULL, NULL, '4174', NULL, NULL, NULL, NULL, 1, '2024-04-26 18:02:00', NULL, NULL, NULL, NULL, '2024-04-05 10:59:07', NULL],
            [163, 'chị Yến', '0328567447', NULL, NULL, 2, NULL, NULL, NULL, '140', NULL, NULL, NULL, NULL, 1, '2024-04-07 11:10:00', NULL, NULL, NULL, NULL, '2024-04-05 10:10:09', NULL],
            [164, 'Anh Long', '0979104434', NULL, NULL, 1, NULL, NULL, NULL, '50', NULL, NULL, NULL, NULL, 1, '2024-04-06 18:52:00', NULL, NULL, NULL, NULL, '2024-04-04 17:51:59', NULL],
            [165, 'HUY', '0939510248', NULL, NULL, 1, NULL, NULL, NULL, '120', NULL, NULL, NULL, NULL, 1, '2024-04-06 17:47:00', NULL, NULL, NULL, NULL, '2024-04-04 16:46:38', NULL],
            [166, 'chị Tú', NULL, NULL, NULL, 1, NULL, NULL, NULL, '195', NULL, NULL, NULL, NULL, 1, '2024-04-06 17:08:00', NULL, NULL, NULL, NULL, '2024-04-04 16:07:38', NULL],
            [167, 'BẢO NGÂN', '0769384058', NULL, NULL, 1, NULL, NULL, NULL, '996', NULL, NULL, NULL, NULL, 1, '2024-04-07 19:51:00', NULL, NULL, NULL, NULL, '2024-04-04 15:02:02', NULL],
            [168, 'KHÔNG TÊN', '0939178689', NULL, NULL, 1, NULL, NULL, NULL, '90', NULL, NULL, NULL, NULL, 1, '2024-04-06 16:00:00', NULL, NULL, NULL, NULL, '2024-04-04 14:59:22', NULL],
            [169, 'CHỊ OANH', '0907851549', NULL, NULL, 2, NULL, NULL, NULL, '80', NULL, NULL, NULL, NULL, 1, '2024-04-06 15:55:00', NULL, NULL, NULL, NULL, '2024-04-04 14:48:43', NULL],
            [170, 'chị Vy', '0582954251', NULL, NULL, 2, NULL, NULL, NULL, '100', NULL, NULL, NULL, NULL, 1, '2024-04-06 15:26:00', NULL, NULL, NULL, NULL, '2024-04-04 14:25:51', NULL],
            [171, 'cô Thơm', NULL, NULL, NULL, 1, NULL, NULL, NULL, '97', NULL, NULL, NULL, NULL, 1, '2024-04-05 17:40:00', NULL, NULL, NULL, NULL, '2024-04-03 16:40:29', NULL],
            [172, 'cô Thơm', NULL, NULL, NULL, 1, NULL, NULL, NULL, '104', NULL, NULL, NULL, NULL, 1, '2024-04-11 16:58:00', NULL, NULL, NULL, NULL, '2024-04-03 16:40:28', NULL],
            [173, 'Anh Tín', '0795999586', NULL, NULL, 1, NULL, NULL, NULL, '450', NULL, NULL, NULL, NULL, 1, '2024-04-05 17:22:00', NULL, NULL, NULL, NULL, '2024-04-03 15:39:02', NULL],
            [174, 'CHị Tiên', '0877488680', NULL, NULL, 1, NULL, NULL, NULL, '230', NULL, NULL, NULL, NULL, 1, '2024-04-05 20:07:00', NULL, NULL, NULL, NULL, '2024-04-03 14:27:15', NULL],
            [175, 'Anh Thắng', '0977151223', NULL, NULL, 1, NULL, NULL, NULL, '80', NULL, NULL, NULL, NULL, 1, '2024-04-05 14:25:00', NULL, NULL, NULL, NULL, '2024-04-03 13:23:53', NULL],
            [176, 'Nhàn', '0785187730', NULL, NULL, 1, NULL, NULL, NULL, '10', NULL, NULL, NULL, NULL, 1, '2024-04-05 12:30:00', NULL, NULL, NULL, NULL, '2024-04-03 11:28:03', NULL],
            [177, 'Chú Việt', '0936561311', NULL, NULL, 2, NULL, NULL, NULL, '54', NULL, NULL, NULL, NULL, 1, '2024-04-05 11:32:00', NULL, NULL, NULL, NULL, '2024-04-03 10:31:13', NULL],
            [178, 'Chị Bé Nhỏ', '0372379954', NULL, NULL, 2, NULL, NULL, NULL, '215', NULL, NULL, NULL, NULL, 1, '2024-04-05 11:20:00', NULL, NULL, NULL, NULL, '2024-04-03 10:18:13', NULL],
            [179, 'Chị Kiều', '0878950800', NULL, NULL, 2, NULL, NULL, NULL, '230', NULL, NULL, NULL, NULL, 1, '2024-04-04 22:00:00', NULL, NULL, NULL, NULL, '2024-04-02 20:57:55', NULL],
            [180, 'Chị Hậu', '0766952892', NULL, NULL, 2, NULL, NULL, NULL, '220', NULL, NULL, NULL, NULL, 1, '2024-04-04 21:54:00', NULL, NULL, NULL, NULL, '2024-04-02 20:51:37', NULL],
            [181, 'Tài', '0778620314', NULL, NULL, 1, NULL, NULL, NULL, '50', NULL, NULL, NULL, NULL, 1, '2024-04-04 21:44:00', NULL, NULL, NULL, NULL, '2024-04-02 20:42:41', NULL],
            [182, 'Hoàng Anh', '0569994224', NULL, NULL, 1, NULL, NULL, NULL, '280', NULL, NULL, NULL, NULL, 1, '2024-04-04 21:41:00', NULL, NULL, NULL, NULL, '2024-04-02 20:39:19', NULL],
            [183, 'Chị Như', '0818239339', NULL, NULL, 2, NULL, NULL, NULL, '45', NULL, NULL, NULL, NULL, 1, '2024-04-04 21:24:00', NULL, NULL, NULL, NULL, '2024-04-02 20:23:12', NULL],
            [184, 'CHỊ SA', '0898683616', NULL, NULL, 1, NULL, NULL, NULL, '50', NULL, NULL, NULL, NULL, 1, '2024-04-04 17:44:00', NULL, NULL, NULL, NULL, '2024-04-02 16:43:21', NULL],
            [185, 'chị Thủy', '0907916797', NULL, NULL, 2, NULL, NULL, NULL, '54', NULL, NULL, NULL, NULL, 1, '2024-04-04 16:50:00', NULL, NULL, NULL, NULL, '2024-04-02 15:50:18', NULL],
            [186, 'Trân', '0898997471', NULL, NULL, 2, NULL, NULL, NULL, '115', NULL, NULL, NULL, NULL, 1, '2024-04-04 14:27:00', NULL, NULL, NULL, NULL, '2024-04-02 13:27:01', NULL],
            [187, 'chị Phương', '0907779127', NULL, NULL, 2, NULL, NULL, NULL, '120', NULL, NULL, NULL, NULL, 1, '2024-04-04 14:00:00', NULL, NULL, NULL, NULL, '2024-04-02 13:00:26', NULL],
            [188, 'Anh Thật', '0922552221', NULL, NULL, 1, NULL, NULL, NULL, '76', NULL, NULL, NULL, NULL, 1, '2024-04-04 12:42:00', NULL, NULL, NULL, NULL, '2024-04-02 11:42:20', NULL],
            [189, 'Châu', '0942815105', NULL, NULL, 2, NULL, NULL, NULL, '270', NULL, NULL, NULL, NULL, 1, '2024-04-04 11:10:00', NULL, NULL, NULL, NULL, '2024-04-02 10:09:46', NULL],
            [190, 'Chị Nương', '0935222041', NULL, NULL, 2, NULL, NULL, NULL, '210', NULL, NULL, NULL, NULL, 1, '2024-04-04 09:45:00', NULL, NULL, NULL, NULL, '2024-04-02 08:44:55', NULL],
            [191, 'anh Tính', '0942777655', NULL, NULL, 1, NULL, NULL, NULL, '215', NULL, NULL, NULL, NULL, 1, '2024-04-04 09:20:00', NULL, NULL, NULL, NULL, '2024-04-02 08:19:59', NULL],
            [192, 'chị Tiên', '0773836615', NULL, NULL, 2, NULL, NULL, NULL, '814', NULL, NULL, NULL, NULL, 1, '2024-04-14 19:54:00', NULL, NULL, NULL, NULL, '2024-04-01 19:54:04', NULL],
            [193, 'anh Thắng', '0974074551', NULL, NULL, 1, NULL, NULL, NULL, '350', NULL, NULL, NULL, NULL, 1, '2024-04-03 20:48:00', NULL, NULL, NULL, NULL, '2024-04-01 19:46:54', NULL],
            [194, 'Kiều My', '0969197964', NULL, NULL, 1, NULL, NULL, NULL, '296', NULL, NULL, NULL, NULL, 1, '2024-04-04 22:03:00', NULL, NULL, NULL, NULL, '2024-04-01 18:47:37', NULL],
            [195, 'Chị Phương', '0774995333', NULL, NULL, 2, NULL, NULL, NULL, '70', NULL, NULL, NULL, NULL, 1, '2024-04-03 18:54:00', NULL, NULL, NULL, NULL, '2024-04-01 17:51:06', NULL],
            [196, 'Chị Vân', '0939536151', NULL, NULL, 2, NULL, NULL, NULL, '555', NULL, NULL, NULL, NULL, 1, '2024-04-03 20:52:00', NULL, NULL, NULL, NULL, '2024-04-01 17:12:58', NULL],
            [197, 'KIỆT', '0774867863', NULL, NULL, 1, NULL, NULL, NULL, '590', NULL, NULL, NULL, NULL, 1, '2024-04-18 19:28:00', NULL, NULL, NULL, NULL, '2024-04-01 16:42:21', NULL],
            [198, 'Chị Lạc', '0788877189', NULL, NULL, 1, NULL, NULL, NULL, '10', NULL, NULL, NULL, NULL, 1, '2024-04-03 14:10:00', NULL, NULL, NULL, NULL, '2024-04-01 13:08:53', NULL],
            [199, 'anh Nghĩa', '0939515038', NULL, NULL, 1, NULL, NULL, NULL, '185', NULL, NULL, NULL, NULL, 1, '2024-04-03 14:00:00', NULL, NULL, NULL, NULL, '2024-04-01 12:55:23', NULL],
            [200, 'khánh', '0934441434', NULL, NULL, 1, NULL, NULL, NULL, '255', NULL, NULL, NULL, NULL, 1, '2024-04-03 13:55:00', NULL, NULL, NULL, NULL, '2024-04-01 12:53:48', NULL],

        ];

        foreach ($users as $user) {
            User::create([
                'id' => $user[0],
                'name' => $user[1],
                'phone' => $user[2],
                'email' => $user[3],
                'avatar' => $user[4],
                'gender' => $user[5],
                'password' => $user[6],

                'address' => $user[8],
                'scores' => $user[9],
                // 'local_id' => $user[10],
                'main_branch' => $user[11],
                'status' => $user[14],
                //'last_login_at' => $user[15],
                'note' => $user[16],
                'email_verified_at' => $user[17],
                'remember_token' => $user[18],
                'deleted_at' => $user[19],
                'created_at' => $user[20],
                'updated_at' => $user[21],
            ]);
        }

         DB::statement("
        INSERT INTO `branch_user` (`user_id`, `branch_id`) VALUES
        (1, 1),
        (1, 2),
        (2, 2),
        (2, 1),
        (4, 1),
        (4, 2);");

        DB::statement("
        INSERT INTO `user_warehouse` (`user_id`, `warehouse_id`) VALUES
        (1, 4),
        (1, 5),
        (1, 6),
        (1, 7),
        (2, 4),
        (2, 5),
        (2, 6),
        (2, 7);");
    }
}
