<?php

namespace App\Http\Controllers;

use App\Models\Order;
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
}
