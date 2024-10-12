<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductController extends Controller
{
    //
    public function index()
    {
        return Inertia::render('User/Foods', [
            'categories' => Category::with('products')->get()
        ]);
    }

    public function show(string $id)
    {
        return Inertia::render('User/ShowFood', [
            'food' => Product::find($id)
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'category' => 'required',
            'price' => 'required',
            'desc' => 'required',
            'image_path' => 'required',
        ]);

        $image_path = $request->file('image_path')->store('products', 'public');

        Product::create([
            'name' => $request->name,
            'category_id' => $request->category,
            'price' => $request->price,
            'desc' => $request->desc,
            'image_path' => $image_path,
        ]);

        return back();
        // dd($request);
    }

}
