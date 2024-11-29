<?php

namespace App\Http\Controllers\Admin;

use App\Models\Rate;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Http\Controllers\Controller;

class RateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return Inertia::render('Admin/Rates', [
            'rates' => Rate::get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'pax' => 'required', 
            'price' => 'required', 
            'instructions' => 'required'
        ]);

        Rate::create([
            'pax' => $request->pax,
            'price' => $request->price,
            'instructions' => $request->instructions,
        ]);
        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Rate $rate)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Rate $rate)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Rate $rate)
    {
        //
        $validated =  $request->validate([
            'pax' => 'required', 
            'price' => 'required', 
            'instructions' => 'required'
        ]);

        $rate->update($validated);
        return back();
    }   

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Rate $rate)
    {
        //
        $rate->delete();
        return back();
    }
}
