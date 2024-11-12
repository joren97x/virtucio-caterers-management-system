<?php

namespace App\Http\Controllers;

use App\Models\AddOnCategory;
use App\Models\Category;
use App\Models\Order;
use App\Models\Rate;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class OrderController extends Controller
{
    //
    // public function index()
    // {
    //     return Inertia::render('Admin/OrderManagement', [
    //         'orders' => Order::with(['user', 'rate', 'add_ons.add_on.add_on_category', 'products.product'])
    //             ->where('status')
    //             ->get()
    //     ]);
    // }

    public function pending()
    {
        return Inertia::render('Admin/OrderManagement', [
            'orders' => Order::with(['user', 'rate', 'add_ons.add_on.add_on_category', 'products.product'])
                ->where('status', 'pending')
                ->get()
        ]);
    }

    public function confirmed()
    {
        return Inertia::render('Admin/OrderManagement', [
            'orders' => Order::with(['user', 'rate', 'add_ons.add_on.add_on_category', 'products.product'])
                ->whereIn('status', ['confirmed', 'book_and_sealed', 'delivered'])
                ->get()
        ]);
    }
    
    public function history()
    {
        return Inertia::render('Admin/OrderHistory', [
            'orders' => Order::with(['user', 'rate', 'add_ons.add_on.add_on_category', 'products.product'])
                ->whereIn('status', ['cancelled', 'compeleted', 'out_of_delivery'])
                ->get()
        ]);
    }

    public function orders(OrderService $orderService)
    {
        $orders = Order::with(['rate', 'order_items.product'])->where('user_id', auth()->id())->get();
        // foreach($orders as $order) {
        //     $order->total_amount = $orderService->getTotalAmount($order);
        // }
        return Inertia::render('User/Orders', [
            'orders' => $orders
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

    public function soups()
    {
        return Inertia::render('User/SoupSelection', [
            'categories' => Category::with('products')->whereIn('name', ['soup'])->get()   
        ]);
    }

    public function main_dishes()
    {
        return Inertia::render('User/MainDishSelection', [
            'categories' => Category::with('products')->whereIn('name', ['beef', 'pork', 'chicken', 'vegetable', 'meat combo', 'miscellaneous', 'seafood', 'noodle'])->get()   
        ]);
    }

    public function desserts()
    {
        return Inertia::render('User/DessertSelection', [
            'categories' => Category::with('products')->whereIn('name', ['salad', 'dessert'])->get()   
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
            'name' => 'required|string|max:255', // Validate 'name' as a string with a maximum length
            'contact_number' => 'required', // Validate as a numeric string (e.g., phone number)
            'date' => 'required|date', // Validate 'date' as a valid date
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
