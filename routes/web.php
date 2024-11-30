<?php

use App\Http\Controllers\Admin\RateController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ViewController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [ViewController::class, 'home'])->name('home');


require __DIR__.'/admin.php';

Route::get('/about-us', [ViewController::class, 'about'])->name('about');
Route::get('/blog', [ViewController::class, 'blog'])->name('blog');
Route::get('/contact', [ViewController::class, 'contact'])->name('contact');
Route::post('/message', [MessageController::class, 'store'])->name('messages.store');
Route::get('/blog', [ViewController::class, 'blog'])->name('blog');
Route::get('/menu', [ViewController::class, 'menu'])->name('menu');
// Route::resource('foods', ProductController::class)->names([
//     'index' => 'user.products.index',
//     'show' => 'user.products.show',
// ]);

Route::middleware('auth', 'user')->group(function () {

    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::put('/orders/{order}', [OrderController::class, 'update'])->name('orders.update');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');

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