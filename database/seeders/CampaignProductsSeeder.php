<?php

namespace Database\Seeders;

use App\Models\CampaignProducts;
use Illuminate\Database\Seeder;

class CampaignProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        CampaignProducts::create([
            'campaign' => 1,
            'product' => 1,
        ]);
        CampaignProducts::create([
            'campaign' => 2,
            'product' => 1,
        ]);
        CampaignProducts::create([
            'campaign' => 2,
            'product' => 2,
        ]);

    }
}
