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
use App\Http\Controllers\ViewController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [ViewController::class, 'home'])->name('home');



Route::get('/about-us', [ViewController::class, 'about'])->name('about');
Route::get('/blog', [ViewController::class, 'blog'])->name('blog');
Route::get('/contact', [ViewController::class, 'contact'])->name('contact');
Route::get('/blog', [ViewController::class, 'blog'])->name('blog');
Route::get('/menu', [ViewController::class, 'menu'])->name('menu');
// Route::resource('foods', ProductController::class)->names([
//     'index' => 'user.products.index',
//     'show' => 'user.products.show',
// ]);

Route::get('/admin/dashboard', function () {
    return Inertia::render('Admin/Dashboard');
})->name('admin.dashboard');


Route::get('/yawa', function () {
    dd('yawa');
});


Route::middleware('auth', 'user')->group(function () {

    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    // Route::post('/check-out/{order}', [OrderController::class, 'checkout'])->name('checkout');
    // Route::post('/check-out', [OrderController::class, 'checkout_pay'])->name('checkout.pay');

    Route::get('/start-order', [OrderController::class, 'pax'])->name('order.pax');
    Route::get('/choose-soup', [OrderController::class, 'soups'])->name('order.soups');
    Route::get('/choose-dessert', [OrderController::class, 'desserts'])->name('order.desserts');
    Route::get('/choose-main-dishes', [OrderController::class, 'main_dishes'])->name('order.main_dishes');
    Route::get('/choose-add-ons', [OrderController::class, 'add_ons'])->name('order.add_ons');
    Route::get('/contact-details', [OrderController::class, 'contact_details'])->name('order.contact_details');

    Route::post('/check-out/pay', [PaymentController::class, 'pay'])->name('checkout.pay');
    Route::get('/check-out/{order}', [PaymentController::class, 'checkout'])->name('checkout');
    Route::post('/pay-balance/{order}', [PaymentController::class, 'pay_balance'])->name('order.pay_balance');
    Route::get('/pay-balance/{order}/success', [PaymentController::class, 'pay_balance_success'])->name('order.pay_balance_success');
    Route::get('/success', [PaymentController::class, 'success'])->name('order.success');
    // Route::get('/orders', [OrderController::class, 'orders'])->name('orders');
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
        'store' => 'admin.orders.store',
        'show' => 'admin.orders.show',
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
// Route::get('/dashboard', function () {
//     return Inertia::render('Dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');