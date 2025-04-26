<?php

namespace Database\Seeders;

use App\Models\Campaigns;
use Illuminate\Database\Seeder;

class CampaignsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Campaigns::create([
            'name' => "Les Promos Printanières",
            'start' => "2021-03-21",
            'end' => "2021-06-20",
            'discount' => 15,
        ]);
        Campaigns::create([
            'name' => "C'est l'Êté sur les Prix !",
            'start' => "2021-06-21",
            'end' => "2021-09-20",
            'discount' => 25,
        ]);
    }
}
