<?php

use App\Http\Controllers\AdminViewController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\IngredientController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\UserController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/about-us', function () {
    return Inertia::render('AboutUs');
});

Route::resource('foods', ProductController::class)->names([
    'index' => 'user.products.index',
    'show' => 'user.products.show',
]);

Route::get('/admin/dashboard', function () {
    return Inertia::render('Admin/Dashboard');
})->name('admin.dashboard');

Route::middleware('auth', 'user')->group(function () {
    Route::get('/cart', function () {
        return Inertia::render('User/Cart');
    })->name('cart');

    Route::get('/check-out', function() {
        return Inertia::render('User/Checkout');
    });

});

Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::resource('/users', UserController::class)->names([
        'index' => 'admin.users.index',
        'store' => 'admin.users.store',
    ]);
    Route::resource('/ingredients', IngredientController::class)->names([
        'index' => 'admin.ingredients.index',
    ]);
    Route::resource('/expenses', ExpenseController::class)->names([
        'index' => 'admin.expenses.index',
    ]);
    Route::resource('/orders', OrderController::class)->names([
        'index' => 'admin.orders.index',
    ]);
    Route::resource('/products', ProductController::class)->names([
        'store' => 'admin.products.store',
        'update' => 'admin.products.update',
    ]);
    Route::resource('categories', CategoryController::class)->names([
        'store' => 'admin.categories.store',
    ]);
    Route::get('/dashboard', [AdminViewController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/menu-management', [AdminViewController::class, 'menu_management'])->name('admin.menu_management');
    Route::get('/order-history', [AdminViewController::class, 'order_history'])->name('admin.order_history');
    Route::get('/sales', [AdminViewController::class, 'sales'])->name('admin.sales');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
