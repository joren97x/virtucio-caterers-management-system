<?php

namespace App\Http\Controllers;

use App\Models\AddOnCategory;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AddOnCategoryController extends Controller
{
    //
    public function index()
    {
        return Inertia::render('Admin/AddOns', [
            'add_ons' => AddOnCategory::get()
        ]);
    }

    public function store(Request $request)
    {
        // dd($request);
        $request->validate([
            'name' => 'required'
        ]);
        AddOnCategory::create([
            'name' => $request->name
        ]);
        return back();
    }
}
