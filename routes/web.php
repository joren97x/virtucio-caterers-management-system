<?php

use App\Http\Controllers\AddOnCategoryController;
use App\Http\Controllers\AddOnController;
use App\Http\Controllers\AdminViewController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\IngredientController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RateController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\UserController;
use App\Models\AddOn;
use App\Models\AddOnCategory;
use App\Models\Category;
use App\Models\Rate;
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

    Route::get('/check-out', [OrderController::class, 'checkout'])->name('checkout');
    // Route::get('/check-out', function () {
    //     abort(419);
    // });

    Route::prefix('orders')->group(function () {
        // Route::get('/order', [OrderController::class, 'index'])->name('order');
        Route::get('', [OrderController::class, 'orders'])->name('orders');
        Route::get('/new-order/pax', [OrderController::class, 'pax'])->name('order.pax');
        Route::get('/new-order/add-ons', [OrderController::class, 'add_ons'])->name('order.add_ons');
        Route::get('/new-order/soups', [OrderController::class, 'soups'])->name('order.soups');
        Route::get('/new-order/main-dishes', [OrderController::class, 'main_dishes'])->name('order.main_dishes');
        Route::get('/new-order/desserts', [OrderController::class, 'desserts'])->name('order.desserts');
        Route::get('/new-order/foods', [OrderController::class, 'foods'])->name('order.foods');
        Route::get('/new-order/contact-form', [OrderController::class, 'contact_form'])->name('order.contact_form');
        Route::post('/pay', [PaymentController::class, 'pay'])->name('order.pay');
        Route::post('/pay-balance/{order}', [PaymentController::class, 'pay_balance'])->name('order.pay_balance');
        Route::get('/pay-balance/{order}/success', [PaymentController::class, 'pay_balance_success'])->name('order.pay_balance_success');
        Route::get('/success', [PaymentController::class, 'success'])->name('order.success');
    });
});

Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::resource('/users', UserController::class)->names([
        'index' => 'admin.users.index',
        'store' => 'admin.users.store',
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
    ]);
    Route::get('/orders/pending', [OrderController::class, 'pending'])->name('admin.orders.pending');
    Route::get('/orders/confirmed', [OrderController::class, 'confirmed'])->name('admin.orders.confirmed');
    Route::get('/orders/history', [OrderController::class, 'history'])->name('admin.orders.history');
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
    Route::resource('rates', RateController::class)->names([
        'store' => 'admin.rates.store',
        'index' => 'admin.rates.index',
    ]);
    Route::resource('add_ons', AddOnController::class)->names([
        'store' => 'admin.add_ons.store',
        'index' => 'admin.add_ons.index',
    ]);
    Route::resource('add_on_categories', AddOnCategoryController::class)->names([
        'store' => 'admin.add_on_categories.store',
        'index' => 'admin.add_on_categories.index',
    ]);
    Route::get('/dashboard', [AdminViewController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/menu-management', [AdminViewController::class, 'menu_management'])->name('admin.menu_management');
    Route::get('/sales', [AdminViewController::class, 'sales'])->name('admin.sales');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/test', function() {
    return Inertia::render('Test');
});

require __DIR__.'/auth.php';
