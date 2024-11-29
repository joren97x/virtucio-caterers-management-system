<?php

namespace App\Http\Controllers\Admin;

use App\Models\AddOn;
use App\Models\AddOnCategory;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Http\Controllers\Controller;

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
            'add_on_category_id' => 'required',
        ]);
        AddOn::create([
            'name' => $request->name,
            'price' => $request->price,
            'add_on_category_id' => $request->add_on_category_id
        ]);
        return back();
    }

    public function update(Request $request, AddOn $addOn)
    {
        $validated = $request->validate([
            'name' => 'required',
            'price' => 'required',
            'add_on_category_id' => 'required',
        ]);

        $addOn->update($validated);

        return back();
    }

    public function destroy(AddOn $add_on)
    {
        //
        $add_on->delete();
        return back();
    }

}
