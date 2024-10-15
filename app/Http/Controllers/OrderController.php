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

    public function orders()
    {
        return Inertia::render('User/Orders', [
            'orders' => Order::with(['add_ons.add_on', 'products.product'])->where('user_id', auth()->id())->get()
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
        $order = $request->validate([
            'rate' => 'nullable|array', // Validate 'rate' as an array if it can have multiple values
            'foods' => 'required|array|min:1', // Ensure 'foods' is an array with at least one item
            'name' => 'required|string|max:255', // Validate 'name' as a string with a maximum length
            'contact_number' => 'required', // Validate as a numeric string (e.g., phone number)
            'date' => 'required|date', // Validate 'date' as a valid date
            'event_details' => 'required|string|max:500', // Validate 'event_details' with a max character length
            'message' => 'nullable|string|max:1000', // 'message' is optional but must be a string if present
            'status' => 'required', // Validate 'status' with specific allowed values
            'payment_method' => 'required', // Restrict 'payment_method' to specific values
            'contract_payments' => 'required', // Restrict 'contract_payments' values
        ]);

        return Inertia::render('User/Checkout', [
            'order' => $order
        ]);
    }

}
