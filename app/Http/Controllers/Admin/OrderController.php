<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Inertia\Inertia;

class OrderController extends Controller
{
    //
    public function pending()
    {
        return Inertia::render('Admin/PendingOrders', [
            'orders' => Order::with(['rate', 'user', 'order_items.product'])->whereIn('status', [
                Order::STATUS_DOWN_PAYMENT_PENDING, 
                Order::STATUS_FULLY_PAID_PENDING, 
                Order::STATUS_RESERVATION_FEE_PENDING, 
                Order::STATUS_PENDING])
                ->get()
                ->map(function ($order) {
                    // Add remaining balance to each order
                    $order->remaining_balance = $order->calculateRemainingBalance();
                    return $order;
                })
        ]);
    }

    public function cancelled()
    {
        return Inertia::render('Admin/CancelledOrders', [
            'orders' => Order::with(['rate', 'user', 'order_items.product'])->whereIn('status', [
                Order::STATUS_CANCELLED])
                ->get()
                ->map(function ($order) {
                    // Add remaining balance to each order
                    $order->remaining_balance = $order->calculateRemainingBalance();
                    return $order;
                })
        ]);
    }

    public function confirmed()
    {
        return Inertia::render('Admin/ConfirmedOrders', [
            'orders' => Order::with(['rate', 'user', 'order_items.product'])->whereIn('status', [
                Order::STATUS_DOWN_PAYMENT_PAID, Order::STATUS_RESERVATION_FEE_PAID])
                ->get()
                ->map(function ($order) {
                    // Add remaining balance to each order
                    $order->remaining_balance = $order->calculateRemainingBalance();
                    return $order;
                })
        ]);
    }

    public function history()
    {
        return Inertia::render('Admin/CancelledOrders', [
            'orders' => Order::with(['rate', 'user', 'order_items.product'])->whereIn('status', [
                Order::STATUS_CANCELLED, Order::STATUS_FULLY_PAID, Order::STATUS_COMPLETE])
                ->get()
                ->map(function ($order) {
                    // Add remaining balance to each order
                    $order->remaining_balance = $order->calculateRemainingBalance();
                    return $order;
                })
        ]);
    }

    public function sales(Request $request)
    {

        // $orders = Order::with(['rate', 'user', 'order_items.product'])->whereIn('status', [
        //     Order::STATUS_COMPLETE, Order::STATUS_FULLY_PAID])
        //     ->get()
        //     ->map(function ($order) {
        //         // Add remaining balance to each order
        //         $order->remaining_balance = $order->calculateRemainingBalance();
        //         return $order;
        //     });

        // Default values for start and end date
        $startDate = $request->start_date ?? now()->startOfMonth()->toDateString(); // First day of the current month
        $endDate = $request->end_date ?? now()->endOfMonth()->toDateString(); // Last day of the current month

        // Filter by order status (e.g., 'Completed', 'Pending', etc.)
        $status = $request->status; // Optional parameter

        // Query the orders
        $orders = Order::query()
            ->whereBetween('created_at', [$startDate, $endDate]) // Filter by date range
            ->when($status, function ($query, $status) {
                return $query->where('status', $status); // Filter by status if provided
            })
            ->get(); // Or use paginate() if you want paginated results

        // Optionally, calculate additional metrics like total sales, number of orders, etc.
        $totalSales = $orders->sum('total_amount');
        $averageOrderValue = $orders->avg('total_amount');
        $numberOfOrders = $orders->count();


        return Inertia::render('Admin/Sales', [
            'orders' => Order::with(['rate', 'user', 'order_items.product'])->whereIn('status', [
                Order::STATUS_COMPLETE, Order::STATUS_FULLY_PAID])
                ->get()
                ->map(function ($order) {
                    // Add remaining balance to each order
                    $order->remaining_balance = $order->calculateRemainingBalance();
                    return $order;
                })
        ]);
    }

    public function update(Request $request, Order $order)
    {
        switch($order->status) {
            case Order::STATUS_DOWN_PAYMENT_PENDING:
                $order->update([
                    'status' => Order::STATUS_DOWN_PAYMENT_PAID
                ]);
                break;
            case Order::STATUS_FULLY_PAID_PENDING:
                $order->update([
                    'status' => Order::STATUS_FULLY_PAID
                ]);
                break;
            case Order::STATUS_RESERVATION_FEE_PENDING:
                $order->update([
                    'status' => Order::STATUS_RESERVATION_FEE_PENDING,
                    'reservation_fee' => 0
                ]);
                break;
        }

        return back();

    }

}
