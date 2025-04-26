<?php

namespace Database\Seeders;

use App\Models\ProductImages;
use Illuminate\Database\Seeder;

class ProductImagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        ProductImages::create([
            'product' => 1,
            'image' => 1,
        ]);
        ProductImages::create([
            'product' => 1,
            'image' => 2,
        ]);
        ProductImages::create([
            'product' => 1,
            'image' => 3,
        ]);
        ProductImages::create([
            'product' => 1,
            'image' => 4,
        ]);
    }
}
