<?php

namespace App\Http\Controllers;

use App\Models\AddOn;
use App\Models\AddOnCategory;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AddOnController extends Controller
{
    //
    public function index()
    {
        return Inertia::render('Admin/AddOns', [
            'add_ons' => AddOn::get(),
            'add_on_categories' => AddOnCategory::with('add_ons')->get()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required',
            'add_on_category' => 'required',
        ]);
        AddOn::create([
            'name' => $request->name,
            'price' => $request->price,
            'add_on_category_id' => $request->add_on_category
        ]);
        return back();
    }

}
