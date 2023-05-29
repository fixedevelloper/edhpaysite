<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
         //\App\Models\User::factory(10)->create();

         \App\Models\User::factory()->create([
            'name' => 'Administrateur',
            'email' => 'test@example.com',
             'password' => bcrypt('123456789'),
                'phone' => '+12398190255',
                'user_type'=>0,//user administrateur
                'email_verified_at' => now(),
                'role' => 'ROLE_ADMIN',
                'activate' => true,
        ]);
    }
}
