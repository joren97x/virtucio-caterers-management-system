<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    //
    public function store(Request $request)
    {
        $validated = $request->validate([
            'message' => 'required',
            'rating' => 'required'
        ]);
        Review::create([
            'message' => $validated['message'],
            'rating' => $validated['rating'],
            'user_id' => auth()->id()
        ]);

        return back();

    }



}
