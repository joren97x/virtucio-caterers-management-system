<?php

namespace App\Http\Controllers;

use App\Models\AddOnCategory;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderAddOn;
use App\Models\OrderItem;
use App\Models\Rate;
use App\Services\OrderService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

class OrderController extends Controller
{
    //
    public function index()
    {
        $orders = Order::with(['user', 'rate', 'add_ons.add_on.add_on_category', 'order_items.product'])
        ->where('user_id', auth()->id())
        ->latest()
        ->get()
        ->map(function ($order) {
            // Add remaining balance to each order
            $order->remaining_balance = $order->calculateRemainingBalance();
            return $order;
        });

        return Inertia::render('User/Orders', compact('orders'));
    }

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
        $orders = Order::with(['rate', 'user', 'order_items.product'])->where('user_id', auth()->id())->get();
        dd($orders);
      
        return Inertia::render('User/Orders', [
            'orders' => $orders
        ]);
    }

    public function update(Order $order)
    {
        $order->update([
            'status' => Order::STATUS_CANCELLED
        ]);

        return back();

    }

    public function show(string $id)
    {

        $order = Order::with(['rate', 'order_items.product', 'add_ons.add_on'])
        ->where('user_id', auth()->id())
        ->findOrFail($id);

        $order->remaining_balance = $order->calculateRemainingBalance();

        // foreach($orders as $order) {
        //     $order->total_amount = $orderService->getTotalAmount($order);
        // }
        return Inertia::render('User/ShowOrder', [
            'order' => $order
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
        return Inertia::render('User/SelectPax', [
            'rates' => Rate::get()
        ]);
    }

    public function add_ons()
    {
        return Inertia::render('User/ChooseAddOns', [
            'add_on_categories' => AddOnCategory::with('add_ons')->get()
        ]);
    }

    public function soups()
    {
        return Inertia::render('User/ChooseSoup', [
            'categories' => Category::with('products')->whereIn('name', ['soup'])->get()   
        ]);
    }

    public function main_dishes()
    {
        return Inertia::render('User/ChooseMainDishes', [
            'categories' => Category::with('products')->whereIn('name', ['main_dish'])->get()   
        ]);
    }

    public function desserts()
    {
        return Inertia::render('User/ChooseDessert', [
            'categories' => Category::with('products')->whereIn('name', ['dessert'])->get()   
        ]);
    }

    public function foods()
    {
        return Inertia::render('User/Foods2', [
            'categories' => Category::with('products')->get()
        ]);
    }

    public function contact_details()
    {
        return Inertia::render('User/ContactDetails');
    }

    public function store(Request $request)
    {
        $request->validate([
            'rate' => 'required', 
            'name' => 'required|string|max:255', 
            'contact_number' => 'required',
            'venue' => 'required',
            'event_type' => 'required',
            'event_date' => 'required|date|after:today', 
            'message' => 'nullable|string|max:1000', 
            'main_dishes' => 'required|array|size:5',
            'soup' => 'required',
            'dessert' => 'required',
        ]);
        
        // dd($request->add_ons);

        $base_rate = $request->rate['price'];
        $add_ons_total = collect($request->add_ons)->sum('price');
        $service_charge = $request->event_type === 'wedding' ? ($base_rate + $add_ons_total) * 0.2 : 0;
    
        $total_amount = $base_rate + $add_ons_total + $service_charge;
    
        // Payment type logic
        $reservation_fee_due = Carbon::parse($request->event_date)->diffInMonths(Carbon::now()) >= 1;
    
        $order = Order::create([
            'rate_id' => $request->rate['id'],
            'user_id' => auth()->id(),
            'name' => $request->name,
            'contact_number' => $request->contact_number,
            'venue' => $request->venue,
            'event_date' => $request->event_date,
            'event_type' => $request->event_type,
            'message' => $request->message,
            'payment_type' => $request->payment_type,
            'total_amount' => $total_amount,
            'reservation_fee' => $reservation_fee_due ? 3000 : 0,
            'reservation_fee_paid' => $reservation_fee_due ? false : null,
        ]);

        foreach($request->main_dishes as $dish) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $dish['id'],
                'category' => OrderItem::CATEGORY_MAIN_DISH
            ]);
        }

        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $request->soup['id'],
            'category' => OrderItem::CATEGORY_SOUP
        ]);

        OrderItem::create([
            'order_id' => $order['id'],
            'product_id' => $request->dessert['id'],
            'category' => OrderItem::CATEGORY_DESSERT
        ]);

        if($request->add_ons) {
            foreach($request->add_ons as $add_on) {
                OrderAddOn::create([
                    'add_on_id' => $add_on['id'],
                    'order_id' => $order->id
                ]);
            }
        }

        return redirect(route('checkout', $order));
    }

}
