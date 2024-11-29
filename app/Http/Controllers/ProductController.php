<?php

namespace App\Http\Controllers;

use App\Models\AddOnCategory;
use App\Models\Category;
use App\Models\Product;
use App\Models\Rate;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductController extends Controller
{
    //
    public function index()
    {
        return Inertia::render('User/Foods', [
            'categories' => Category::with('products')->get(),
            'rates' => Rate::get(),
            'add_on_categories' => AddOnCategory::with('add_ons')->get()
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
            'description' => 'required',
            'image_path' => 'required',
        ]);

        $image_path = $request->file('image_path')->store('products', 'public');

        Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'category_id' => $request->category,
            'image_path' => $image_path,
        ]);

        return back();
        // dd($request);
    }

    public function update(Request $request, Product $product)
    {

        $validated = $request->validate([
            'name' => 'required',
            'category' => 'required',
            'description' => 'required',
            'image_path' => 'required'
        ]);
        if($request->file('image_path')) {
            $validated['image_path'] = $request->file('image_path')->store('products', 'public');
        }
        $product->update([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'category_id' => $validated['category'],
            'image_path' => $validated['image_path']
        ]);
        return back();
        // dd($request);
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return back();
        // dd($request);
    }

}
