<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $categories = [
            'soup',
            'salad',
            'dessert',
            'pork',
            'beef',
            'poultry',
            'vegetable',
            'meat combo',
            'miscellaneous',
            'seafood',
            'noodle'
        ];

        foreach($categories as $c) {
            Category::create([
                'name' => $c
            ]);
        }

    }
}
