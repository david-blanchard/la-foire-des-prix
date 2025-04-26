<?php

namespace Database\Seeders;

use App\Models\Brands;
use Illuminate\Database\Seeder;

class BrandsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Brands::create([
            "name" => "Venca"
        ]);
        Brands::create([
            "name" => "Jodie"
        ]);
        Brands::create([
            "name" => "Le Vestiaire"
        ]);
    }
}
