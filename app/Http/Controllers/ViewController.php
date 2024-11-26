<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class ViewController extends Controller
{
    //
    public function home()
    {
        return Inertia::render('Home');
    }

    public function menu()
    {
        return Inertia::render('User/Menu');
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
