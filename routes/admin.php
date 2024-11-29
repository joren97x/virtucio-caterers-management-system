<?php

use App\Http\Controllers\AddOnCategoryController;
use App\Http\Controllers\Admin\AddOnController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\AdminViewController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Admin\ExpenseController;
use App\Http\Controllers\IngredientController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Admin\RateController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::resource('/users', UserController::class)->names([
        'index' => 'admin.users.index',
        'store' => 'admin.users.store',
        'update' => 'admin.users.update',
        'destroy' => 'admin.users.destroy',
    ]);
    Route::resource('/ingredients', IngredientController::class)->names([
        'index' => 'admin.ingredients.index',
        'store' => 'admin.ingredients.store',
        'update' => 'admin.ingredients.update',
    ]);
    Route::resource('/expenses', ExpenseController::class)->names([
        'index' => 'admin.expenses.index',
        'store' => 'admin.expenses.store',
        'update' => 'admin.expenses.update',
        'destroy' => 'admin.expenses.destroy',
    ]);
    Route::get('/orders/pending', [OrderController::class, 'pending'])->name('admin.orders.pending');
    Route::get('/orders/cancelled', [OrderController::class, 'cancelled'])->name('admin.orders.cancelled');
    Route::get('/orders/confirmed', [OrderController::class, 'confirmed'])->name('admin.orders.confirmed');
    Route::get('/orders/history', [OrderController::class, 'history'])->name('admin.orders.history');
    Route::resource('/orders', OrderController::class)->names([
        'index' => 'admin.orders.index',
        'store' => 'admin.orders.store',
        'show' => 'admin.orders.show',
        'update' => 'admin.orders.update'
    ]);
    Route::resource('/products', ProductController::class)->names([
        'store' => 'admin.products.store',
        'update' => 'admin.products.update',
        'destroy' => 'admin.products.destroy',
    ]);
    Route::resource('categories', CategoryController::class)->names([
        'store' => 'admin.categories.store',
    ]);
    Route::resource('rates', RateController::class)->names([
        'store' => 'admin.rates.store',
        'index' => 'admin.rates.index',
        'update' => 'admin.rates.update',
        'destroy' => 'admin.rates.destroy',
    ]);
    Route::resource('add_ons', AddOnController::class)->names([
        'store' => 'admin.add_ons.store',
        'index' => 'admin.add_ons.index',
        'update' => 'admin.add_ons.update',
        'destroy' => 'admin.add_ons.destroy',
    ]);
    Route::resource('add_on_categories', AddOnCategoryController::class)->names([
        'store' => 'admin.add_on_categories.store',
        'index' => 'admin.add_on_categories.index',
    ]);
    Route::get('/dashboard', [AdminViewController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/menu-management', [AdminViewController::class, 'menu_management'])->name('admin.menu_management');
    Route::get('/sales', [OrderController::class, 'sales'])->name('admin.sales');
});