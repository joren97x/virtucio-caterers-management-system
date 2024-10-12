<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdminViewController extends Controller
{
    //
    public function dashboard()
    {
        return Inertia::render('Admin/Dashboard', [
            
        ]);
    }

    public function menu_management()
    {

        $categories = Category::with('products')->get();

        return Inertia::render('Admin/MenuManagement', [
            'categories' => $categories
        ]);
    }

    public function order_history()
    {
        return Inertia::render('Admin/OrderHistory', [
            
        ]);
    }

    public function sales()
    {
        return Inertia::render('Admin/Sales', [
            
        ]);
    }
}
