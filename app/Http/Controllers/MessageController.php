<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MessageController extends Controller
{
    //
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'message' => 'required',
            'email' => 'required',
        ]);

        Message::create($validated);

        return back();

    }

    public function index()
    {
        return Inertia::render('Admin/Messages', [
            'messages' => Message::latest()->get()
        ]);
    }

}
