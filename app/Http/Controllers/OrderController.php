<?php

namespace App\Http\Controllers;

use App\Models\AddOnCategory;
use App\Models\Category;
use App\Models\Order;
use App\Models\Rate;
use Illuminate\Http\Request;
use Inertia\Inertia;

class OrderController extends Controller
{
    //
    public function index()
    {
        return Inertia::render('Admin/OrderManagement', [
            'orders' => Order::get()
        ]);
    }

    // Route::prefix('order')->group(function () {
    //     Route::get('/pax', function () {
    //         
    //     })->name('order.pax');
    //     Route::get('/add-ons', function () {
    //         return Inertia::render('User/AddOns', [
    //             'add_on_categories' => AddOnCategory::with('add_ons')->get()
    //         ]);
    //     })->name('order.add_ons');
    //     Route::get('/foods', function () {
    //         return Inertia::render('User/Foods2', [
    //             'categories' => Category::with('products')->get()
    //         ]);
    //     })->name('order.foods');
    // });
    public function pax()
    {
        return Inertia::render('User/Pax', [
            'rates' => Rate::get()
        ]);
    }

    public function add_ons()
    {
        return Inertia::render('User/AddOns', [
            'add_on_categories' => AddOnCategory::with('add_ons')->get()
        ]);
    }

    public function foods()
    {
        return Inertia::render('User/Foods2', [
            'categories' => Category::with('products')->get()
        ]);
    }

    public function contact_form()
    {
        return Inertia::render('User/ContactForm');
    }

    public function checkout(Request $request)
    {


        $request->validate([
            'name' => 'required',
            'rate' => 'required',
            'contact_number' => 'required',
            'date' => 'required',
            'event_details' => 'required',
            'foods' => 'required|array|min:1'
        ]);

        // dd($request);

        return Inertia::render('User/Checkout');
    }

}
