<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductController extends Controller
{
    //
    public function index()
    {
        return Inertia::render('User/Foods', [
            'foods' => Product::get()
        ]);
    }

    public function show(string $id)
    {
        return Inertia::render('User/ShowFood', [
            'food' => Product::find($id)
        ]);
    }
}
