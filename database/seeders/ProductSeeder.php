<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        Product::create([
            'name' => 'Белое платье',
            'description' => 'Минималистичное белое платье для повседневного ношения.',
            'price' => 1500.00,
            'image' => 'path/to/image1.jpg'  // Замените, если есть изображения в public
        ]);

        Product::create([
            'name' => 'Черная юбка',
            'description' => 'Простая черная юбка в минималистичном стиле.',
            'price' => 800.00,
            'image' => 'path/to/image2.jpg'
        ]);

        Product::create([
            'name' => 'Белая блузка',
            'description' => 'Легкая белая блузка с белым фоном в дизайне.',
            'price' => 1000.00,
            'image' => 'path/to/image3.jpg'
        ]);
    }
}