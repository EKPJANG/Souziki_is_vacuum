<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'プログラミング',
                'description' => 'プログラミングに関する話題'
            ],
            [
                'name' => '雑談',
                'description' => '日常的な雑談・おしゃべり'
            ],
            [
                'name' => '質問・相談',
                'description' => '技術的な質問や相談事'
            ],
            [
                'name' => 'ニュース',
                'description' => '最新のIT・技術ニュース'
            ],
            [
                'name' => '学習',
                'description' => '学習方法やコツ、体験談'
            ],
            [
                'name' => 'ツール・サービス',
                'description' => '便利なツールやサービスの紹介'
            ],
            [
                'name' => 'フリートーク',
                'description' => '自由に話せる場所'
            ]
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
} 