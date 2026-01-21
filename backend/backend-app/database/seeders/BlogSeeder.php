<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BlogSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('blog_comments')->truncate();
        DB::table('blogs')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        DB::table('blogs')->insert([
            [
                'title' => 'Review Bún Chả Hàng Quạt – Hương Vị Hà Nội Xưa',
                'excerpt' => 'Quán bún chả lâu đời nằm trong ngõ nhỏ phố Hàng Quạt.',
                'content' => '
                    <p><strong>Bún chả Hàng Quạt</strong> là một trong những quán ăn lâu đời tại Hà Nội.</p>

                    <h3>📍 Vị trí</h3>
                    <p>Nằm trong ngõ nhỏ phố Hàng Quạt, quán lúc nào cũng đông khách.</p>

                    <h3>🍖 Món ăn nổi bật</h3>
                    <ul>
                        <li>Chả nướng than hoa thơm lừng</li>
                        <li>Nước mắm pha đậm vị truyền thống</li>
                        <li>Bún tươi, rau sống sạch</li>
                    </ul>

                    <blockquote>Ăn một lần là nhớ mãi hương vị Hà Nội xưa</blockquote>
                ',
                'image' => 'blogs/bun-cha-hang-quat.jpg',
                'user_id' => 1,
                'category_id' => 1,
                'status' => 'Approved',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Top 5 Quán Phở Ngon Nhất Hà Nội',
                'excerpt' => 'Danh sách 5 quán phở nổi tiếng với nước dùng ngọt thanh.',
                'content' => '
                    <p>Phở Hà Nội nổi tiếng với nước dùng trong, ngọt từ xương.</p>

                    <ol>
                        <li>Phở Thìn Lò Đúc</li>
                        <li>Phở Bát Đàn</li>
                        <li>Phở Lý Quốc Sư</li>
                        <li>Phở Sướng</li>
                        <li>Phở Khôi Hói</li>
                    </ol>
                ',
                'image' => 'blogs/top-5-pho-ha-noi.jpg',
                'user_id' => 1,
                'category_id' => 1,
                'status' => 'Approved',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

