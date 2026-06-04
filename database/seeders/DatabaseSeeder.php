<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{
    /**
        * Seed the application's database.
        */
    public function run(): void
    {
        // ---------------------------------------------------
        // 1. TẠO TÀI KHOẢN (1 Admin, 2 User)
        // ---------------------------------------------------
        User::create([
            'name' => 'Quản Trị Viên',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('12345678'),
            'role' => 'admin' // Quyền Admin
        ]);

        User::create([
            'name' => 'Khách Hàng 1',
            'email' => 'khach1@gmail.com',
            'password' => Hash::make('12345678'),
            'role' => 'user' // Quyền User thường
        ]);

        User::create([
            'name' => 'Khách Hàng 2',
            'email' => 'khach2@gmail.com',
            'password' => Hash::make('12345678'),
            'role' => 'user'
        ]);


        // ---------------------------------------------------
        // 2. TẠO DANH MỤC (4 Danh mục)
        // ---------------------------------------------------
        $categories = [
            ['name' => 'Chuột máy tính', 'description' => 'Chuột văn phòng và Gaming'],
            ['name' => 'Bàn phím', 'description' => 'Bàn phím cơ và giả cơ'],
            ['name' => 'Tai nghe', 'description' => 'Tai nghe chống ồn, tai nghe Gaming'],
            ['name' => 'Màn hình', 'description' => 'Màn hình độ phân giải cao']
        ];

        foreach ($categories as $cat) {
            Category::create($cat);
        }


        // ---------------------------------------------------
        // 3. TẠO 20 SẢN PHẨM NGẪU NHIÊN (Dùng Faker)
        // ---------------------------------------------------
        $faker = Faker::create('vi_VN'); // Khởi tạo Faker tiếng Việt

        for ($i = 1; $i <= 20; $i++) {
            Product::create([
                // Random category_id từ 1 đến 4 (vì mình vừa tạo 4 danh mục ở trên)
                'category_id' => rand(1, 4), 
                
                // Tên sản phẩm có chữ "Phụ kiện" + 2 từ ngẫu nhiên
                'name' => 'Phụ kiện ' . $faker->words(2, true) . ' Pro', 
                
                // Giá ngẫu nhiên từ 100.000 đến 3.000.000 VNĐ
                'price' => $faker->numberBetween(100, 3000) * 1000, 
                
                // Số lượng ngẫu nhiên từ 10 đến 100
                'quantity' => rand(10, 100), 
                
                // Mô tả ngẫu nhiên
                'description' => $faker->paragraph(3), 
                
                // Tạm thời để tên file ảnh mẫu (nhóm sẽ xử lý hiển thị ảnh thật sau)
                'image' => 'default.png', 
            ]);
        }
    }
}
