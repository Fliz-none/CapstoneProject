<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('vi_VN');
        $users = [
            [1, 'Super Admin', '0939403090', 'admin@gmail.com', 'TKH000001.jpg', 0, Hash::make('Admin@123'), null, null, null, null, 2, null, null, 1, '2024-08-01 22:53:25', null, null, 'token1', null, '2024-01-15 13:12:15', '2024-09-14 17:25:57'],
            [2, 'Lê Hải Đăng', '0942852755', 'lhd4388@gmail.com', null, 0, Hash::make('haidang1210'), null, null, null, null, 2, null, null, 1, '2024-08-16 09:12:54', null, null, null, null, '2024-06-09 10:09:31', '2024-09-14 06:52:10'],
            [3, 'Lê Hoàng Thắng', '0358351262', 'thangle2003ss@gmail.com', 'TKH00003.webp', 0, Hash::make('Admin@123'), null, null, null, null, 2, null, null, 1, null, null, null, null, null, '2024-06-09 10:09:31', '2024-08-15 05:00:00'],
            [4, 'Test', '0939550105', 'test@gmail.com', null, 1, Hash::make('Admin@123'), null, 'Hưng Phú', '20', null, 1, null, null, 1, '2024-04-27 19:02:00', null, null, null, null, '2024-04-25 18:01:40', null],
        ];

        // Thêm 50 user giả
        for ($i = 5; $i <= 54; $i++) {
            $users[] = [
                $i,
                $faker->name,
                '09' . rand(10000000, 99999999),
                "user{$i}@example.com",
                null,
                rand(0, 1),
                null,
                null,
                null,
                null,
                null,
                rand(1, 3),
                null,
                null,
                1,
                Carbon::now()->subDays(rand(1, 300)),
                null,
                null,
                null,
                null,
                Carbon::now()->subDays(rand(1, 100)),
                Carbon::now()->subDays(rand(0, 10)),
            ];
        }

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
                'main_branch' => $user[11],
                'status' => $user[14],
                'note' => $user[16],
                'email_verified_at' => $user[17],
                'remember_token' => $user[18] ?? Str::random(60),
                'deleted_at' => $user[19],
                'created_at' => $user[20],
                'updated_at' => $user[21],
            ]);
        }

        DB::statement("
            INSERT INTO `branch_user` (`user_id`, `branch_id`) VALUES
            (1, 1), (1, 2), (2, 2), (2, 1), (4, 1), (4, 2);
        ");

        DB::statement("
            INSERT INTO `user_warehouse` (`user_id`, `warehouse_id`) VALUES
            (1, 1), (2, 1), (3, 1);
        ");
    }
}
