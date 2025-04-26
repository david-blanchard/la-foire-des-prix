<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'email' => 'dblanchard1@bbox.fr',
            'name' => 'David Blanchard',
            'password' => Hash::make('demo'),
            'role' => User::USER_ROLE,
        ]);
    }
}
