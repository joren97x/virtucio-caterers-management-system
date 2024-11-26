<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
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
            'main_dish' => [
                'Beef Burgundy with Roasted Garlic',
                'Beef Filipino Arroz Caldo',
                'Beef with Mushroom and Mashed Potato',
                'Beef with Mushroom in Oyster Sauce',
                'Chicken Flambe',
                'Chicken Hawaiian',
                'Chicken Roasted in Mushroom Sauce',
                'Chicken Wings Sweet and Spicy Sriracha',
                'Pasta Baked Spaghetti',
                'Pasta Lasagna',
                'Pasta Pancit Bam I Vegetarian',
                'Pork Crispy Spring Rolls',
                'Pork Embutido',
                'Pork Steak Yummy',
                'Porkchinese',
                'Seafood Boil',
                'Seafood Fish Puttanesca',
                'Seafood Steamed Fish Fillet in Ginger Sauce',
                'Seafood Sweet and Sour Fish Fillet',
                'Vegetables Buttered',
                'Vegetables Chopsuey',
                'Vegetables Grilled',
                'Vegetables Mixed in Oyster Sauce'
            ],
            'soup' => [
                'Soup Cream Broccoli',
                'Soup Mushroom',
                'Soup Chunky Shrimp'
            ],
            'dessert' => [
                'Desserts Buko Pandan',
                'Desserts Fruit Salad',
                'Desserts Mango Cathedral'
            ],
        ];

        // Insert categories
        foreach ($categories as $categoryName => $products) {
            $category = Category::create(['name' => $categoryName]);
            // Insert products for this category
            foreach ($products as $productName) {
                Product::create([
                    'name' => $productName,
                    'description' => 'A delicious ' . strtolower($productName) . ' that is perfect for any occasion.',
                    'image_path' => 'foods/' . $productName . '.jpg', // Convert spaces to underscores for image path
                    'category_id' => $category->id,
                ]);
            }
        }

    }
}
