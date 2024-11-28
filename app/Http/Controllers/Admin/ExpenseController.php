<?php

namespace App\Http\Controllers\Admin;

use App\Models\Expense;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Http\Controllers\Controller;
use App\Models\Order;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
         // Get date range or use default values
    $startDate = $request->start_date ?? '2024-11-01';
    $endDate = $request->end_date ?? '2024-12-31';

    // Revenue: Sum of completed orders
    $revenue = Order::where('status', 'completed')
        ->whereBetween('created_at', [$startDate, $endDate])
        ->sum('total_amount');

    // Expenses: Sum of all expenses
    $expenses = Expense::whereBetween('date', [$startDate, $endDate])
        ->sum('amount');

    // Profit: Revenue - Expenses
    $profit = $revenue - $expenses;

    // Get detailed orders for the period
    $orders = Order::whereIn('status', [Order::STATUS_COMPLETE, Order::STATUS_FULLY_PAID])
        ->whereBetween('created_at', [$startDate, $endDate])
        ->get(['id', 'user_id', 'total_amount', 'created_at', 'status']);

    // Get detailed expenses for the period
    $expenseDetails = Expense::whereBetween('date', [$startDate, $endDate])
        ->get(['id', 'category', 'description', 'amount', 'date']);

    return Inertia::render('Admin/Expenses', [
        'revenue' => $revenue,
        'expenses' => $expenses,
        'profit' => $profit,
        'orders' => $orders,
        'expenses_details' => $expenseDetails,
    ]);
        // return Inertia::render('Admin/Expenses', [
        //     'expenses' => Expense::orderBy('date', 'desc')->get()
        // ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validated = $request->validate([
            'category' => 'required|string|max:255',
            'amount' => 'required|numeric',
            'description' => 'nullable|string',
            'date' => 'required|date',
        ]);

        // Create a new expense
        $expense = Expense::create($validated);
        return back();

    }

    /**
     * Display the specified resource.
     */
    public function show(Expense $expense)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Expense $expense)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Expense $expense)
    {
        //
        $validated = $request->validate([
            'category' => 'required|string|max:255',
            'amount' => 'required|numeric',
            'description' => 'nullable|string',
            'date' => 'required|date',
        ]);

        // Find the expense by ID and update it
        $expense->update($validated);
        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Expense $expense)
    {
        //
        $expense->delete();
        return back();
    }
}
