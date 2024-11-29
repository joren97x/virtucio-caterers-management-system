<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use App\Models\Order;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SalesController extends Controller
{
    //
    public function sales(Request $request)
    {
        $start_date = $request->start_date ?? now()->startOfMonth()->toDateString();
        $end_date = $request->end_date ?? now()->endOfMonth()->toDateString();
        // Completed Orders
        $orders = Order::with(['rate', 'user', 'order_items.product', 'add_ons.add_on'])
            ->whereIn('status', [Order::STATUS_COMPLETE, Order::STATUS_FULLY_PAID])
            ->whereBetween('event_date', [$start_date, $end_date])
            ->get();

        $total_revenue = $orders->sum('total_amount');

        // Expenses
        $expenses = Expense::whereBetween('date', [$start_date, $end_date])->get();
        $total_expenses = $expenses->reduce(function ($carry, $expense) {
            return $carry + ($expense->amount * $expense->quantity);
        }, 0);

        // Net Profit
        $profit = $total_revenue - $total_expenses;

        return Inertia::render('Admin/Sales', [
            'orders' => $orders,
            'expenses' => $expenses,
            'total_revenue' => $total_revenue,
            'total_expenses' => $total_expenses,
            'profit' => $profit,
            'start_date' => $start_date,
            'end_date' => $end_date
        ]);
    }

    public function dashboard(Request $request)
{
    // Default date range: current month
    $start_date = $request->start_date ?? now()->startOfMonth()->toDateString();
    $end_date = $request->end_date ?? now()->endOfMonth()->toDateString();

    // Total Revenue: Sum of total_amount for completed and fully paid orders
    $total_revenue = Order::whereIn('status', [
        Order::STATUS_COMPLETE,
        Order::STATUS_FULLY_PAID,
    ])
        ->whereBetween('created_at', [$start_date, $end_date])
        ->sum('total_amount');

    // Total Expenses: Sum of (amount * quantity) for expenses
    $expenses = Expense::whereBetween('date', [$start_date, $end_date])->get();
    $total_expenses = $expenses->sum(fn ($expense) => $expense->amount * $expense->quantity);

    // Net Profit: Revenue - Expenses
    $profit = $total_revenue - $total_expenses;

    // Orders Overview
    $total_orders = Order::count();
    $completed_orders = Order::whereIn('status', [Order::STATUS_COMPLETE, Order::STATUS_FULLY_PAID])->count();
    $processing_orders = Order::whereIn('status', [
            Order::STATUS_DOWN_PAYMENT_PAID, 
            Order::STATUS_DOWN_PAYMENT_PENDING, 
            Order::STATUS_FULLY_PAID_PENDING,
            Order::STATUS_PENDING,
            Order::STATUS_RESERVATION_FEE_PAID,
            Order::STATUS_RESERVATION_FEE_PENDING  
    ])->count();
    $cancelled_orders = Order::where('status', Order::STATUS_CANCELLED)->count();

    // Recent Orders: Latest 5 orders
    $recent_orders = Order::with(['rate', 'user', 'order_items.product', 'add_ons.add_on']) // Assume orders have a relation to the users table
        ->orderBy('created_at', 'desc')
        ->limit(5)
        ->get()
        ->map(function ($order) {
            // Add remaining balance to each order
            $order->remaining_balance = $order->calculateRemainingBalance();
            if ($order->event_type === 'wedding') {
                $add_ons_price = $order->add_ons->sum(fn($addon) => $addon->add_on->price ?? 0);
                // Calculate base amount and service charge
                $base_amount = $order->rate->price + $add_ons_price;
                $order->service_charge = $base_amount * 0.20;
            }
            return $order;
        });

    // Expense Breakdown: Total expenses by category
    $expense_breakdown = Expense::select('category')
        ->selectRaw('SUM(amount * quantity) as total')
        ->groupBy('category')
        ->get();

    $metrics = [
        'total_revenue' => $total_revenue,
        'total_expenses' => $total_expenses,
        'profit' => $profit,
        'total_orders' => $total_orders,
        'completed_orders' => $completed_orders,
        'processing_orders' => $processing_orders,
        'cancelled_orders' => $cancelled_orders,
    ];
    // Return data to the frontend using Inertia
    return Inertia::render('Admin/Dashboard', [
        'metrics' => $metrics,
        'recent_orders' => $recent_orders,
        'expense_breakdown' => $expense_breakdown,
    ]);
}

}


// public function sales(Request $request)
//     {

//         // $orders = Order::with(['rate', 'user', 'order_items.product'])->whereIn('status', [
//         //     Order::STATUS_COMPLETE, Order::STATUS_FULLY_PAID])
//         //     ->get()
//         //     ->map(function ($order) {
//         //         // Add remaining balance to each order
//         //         $order->remaining_balance = $order->calculateRemainingBalance();
//         //         return $order;
//         //     });

//         // Default values for start and end date
//         $startDate = $request->start_date ?? now()->startOfMonth()->toDateString(); // First day of the current month
//         $endDate = $request->end_date ?? now()->endOfMonth()->toDateString(); // Last day of the current month

//         // Filter by order status (e.g., 'Completed', 'Pending', etc.)
//         $status = $request->status; // Optional parameter

//         // Query the orders
//         $orders = Order::query()
//             ->whereBetween('created_at', [$startDate, $endDate]) // Filter by date range
//             ->when($status, function ($query, $status) {
//                 return $query->where('status', $status); // Filter by status if provided
//             })
//             ->get(); // Or use paginate() if you want paginated results

//         // Optionally, calculate additional metrics like total sales, number of orders, etc.
//         $totalSales = $orders->sum('total_amount');
//         $averageOrderValue = $orders->avg('total_amount');
//         $numberOfOrders = $orders->count();


//         return Inertia::render('Admin/Sales', [
//             'orders' => Order::with(['rate', 'user', 'order_items.product'])->whereIn('status', [
//                 Order::STATUS_COMPLETE, Order::STATUS_FULLY_PAID])
//                 ->get()
//                 ->map(function ($order) {
//                     // Add remaining balance to each order
//                     $order->remaining_balance = $order->calculateRemainingBalance();
//                     return $order;
//                 })
//         ]);
//     }