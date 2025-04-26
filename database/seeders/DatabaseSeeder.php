<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $adminSeeder = new AdminSeeder;
        $adminSeeder->run();        
        $userSeeder = new UserSeeder;
        $userSeeder->run();
        $brands = new BrandsSeeder;
        $brands->run();
        $images = new ImagesSeeder;
        $images->run();
        $products = new ProductsSeeder;
        $products->run();
        $productsImages = new ProductImagesSeeder;
        $productsImages->run();
        $campaigns = new CampaignsSeeder;
        $campaigns->run();
        $campaignProducts = new CampaignProductsSeeder;
        $campaignProducts->run();
    }
}
