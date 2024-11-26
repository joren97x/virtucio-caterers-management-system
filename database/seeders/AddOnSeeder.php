<?php

namespace Database\Seeders;

use App\Models\AddOn;
use App\Models\AddOnCategory;
use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AddOnSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $categories = [
            [
                'name' => 'Styling',
                'add_ons' => [
                    ['name' => 'Basic Styling', 'price' => 7000],
                    ['name' => 'Basic Theme', 'price' => 10000],
                    ['name' => 'Wedding Styling', 'price' => 25000],
                    ['name' => 'Wedding Bouquet and Flowers', 'price' => 30000],
                ]
            ],
            [
                'name' => 'Light and Sounds',
                'add_ons' => [
                    ['name' => 'Basic Package', 'price' => 7000],
                    ['name' => 'Regular Package', 'price' => 10000],
                ]
            ],
            [
                'name' => 'Other Rentals',
                'add_ons' => [
                    ['name' => 'Projector Rental','price' => 3500]
                ]
            ]
        ];

        foreach($categories as $c) {
            $category = AddOnCategory::create(['name' => $c['name']]);
            foreach($c['add_ons'] as $a) {
                AddOn::create([
                    'name' => $a['name'],
                    'price' => $a['price'],
                    'add_on_category_id' => $category->id
                ]);
            }
        }

    }
}
