<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory()->create([
            'username' => 'npnextpremiereadmin',
            'name' => 'Admin',
            'email' => 'admin@premiere.com',
            'password' => Hash::make('npadminpremiere'),
        ]);
        
        // $this->call(DemoDataSeeder::class);

    }
}
