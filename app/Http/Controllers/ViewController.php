<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ViewController extends Controller
{
    //
    public function home()
    {
        return Inertia::render('Home', [
            'reviews' => Review::with('user')->latest()->get()
        ]);
    }

    public function menu()
    {

        $soups = Category::with('products')->whereIn('name', ['soup'])->first();
        $desserts = Category::with('products')->whereIn('name', ['dessert'])->first();
        $main_dishes = Category::with('products')->whereIn('name', ['main_dish'])->first();
        
        return Inertia::render('User/Menu', compact('soups', 'desserts', 'main_dishes'));
    }

    public function about()
    {
        return Inertia::render('AboutUs');
    }

    public function blog()
    {
        return Inertia::render('Blog');
    }

    public function contact()
    {
        return Inertia::render('Contact');
    }

}
