<?php

namespace App\Http\Controllers\Admin;

use App\Models\Expense;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Http\Controllers\Controller;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    // Get current month if no date range is provided
    // $startDate = $request->start_date ?? now()->startOfMonth()->toDateString(); // First day of current month
    // $endDate = $request->end_date ?? now()->endOfMonth()->toDateString(); // Last day of current month

    // $revenue = Order::where('status', 'completed')
    //     ->whereBetween('created_at', [$startDate, $endDate])
    //     ->sum('total_amount');

    // $expenses = Expense::whereBetween('date', [$startDate, $endDate])
    //     ->sum('amount');

    // $profit = $revenue - $expenses;

    // $orders = Order::whereIn('status', [Order::STATUS_COMPLETE, Order::STATUS_FULLY_PAID])
    //     ->whereBetween('created_at', [$startDate, $endDate])
    //     ->get(['id', 'user_id', 'total_amount', 'created_at', 'status']);

    // $expenseDetails = Expense::whereBetween('date', [$startDate, $endDate])
    //     ->get(['id', 'category', 'description', 'amount', 'date']);
    // $expenses_total = 0;
    // $expenses = Expense::get()
    // ->map(function ($expense) {
    //     // Add a computed field 'total_amount' = amount * quantity
    //     $expense->total_amount = $expense->amount * $expense->quantity;
    //     $expenses_total += $expense->total_amount;
    //     return $expense;
    // });

    $total_expenses = 0;

    $expenses = Expense::get()->map(function ($expense) {
        // Compute total amount for each expense
        $expense->total_amount = $expense->amount * $expense->quantity;
        return $expense;
    });
    $total_expenses = $expenses->sum('total_amount');

    return Inertia::render('Admin/Expenses', [
        'expenses' => Expense::latest()->get(),
        'total_expenses' => $total_expenses
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
            'quantity' => 'required'
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
            'quantity' => 'required'
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
