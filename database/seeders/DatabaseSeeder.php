<?php

namespace Database\Seeders;

use App\Models\Rate;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@email.com',
            'password' => Hash::make('asdasd'),
            'role' => 'admin'
        ]);

        User::factory()->create([
            'name' => 'John Doe',
            'email' => 'user@email.com',
            'password' => Hash::make('asdasd'),
            'role' => 'user'
        ]);

        Rate::create([
            'pax' => 50,
            'price' => 10000,
            'instructions' => '1 Soup wt FREE cruotions
5 Main Dishes
1 Dessert Or Salad
Package with rice and one round of softdrink',
        ]);

        Rate::create([
            'pax' => 80,
            'price' => 12400,
            'instructions' => '1 Soup wt FREE cruotions
5 Main Dishes
1 Dessert Or Salad
Package with rice and one round of softdrink',
        ]);

        Rate::create([
            'pax' => 100,
            'price' => 18000,
            'instructions' => '1 Soup wt FREE cruotions
5 Main Dishes
1 Dessert Or Salad
Package with rice and one round of softdrink',
        ]);

        Rate::create([
            'pax' => 120,
            'price' => 20000,
            'instructions' => '1 Soup wt FREE cruotions
5 Main Dishes
1 Dessert Or Salad
Package with rice and one round of softdrink',
        ]);

        $this->call(CategorySeeder::class);

    }
}
