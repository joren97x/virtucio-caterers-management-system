<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title inertia>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @routes
        @vite(['resources/js/app.js', "resources/js/Pages/{$page['component']}.vue"])
        @inertiaHead
    </head>
    <body class="font-sans antialiased">
        @inertia
        <!-- <script src="//code.tidio.co/lnq7igy1lbkgazkelp3rbg4bk94vs4d1.js" async></script> -->
        <script src="//code.tidio.co/qi4msc2rqngq4wvjyn6cgwgoscm7yq9a.js" async></script>
    </body>
</html>


<!-- Route::get('/start-order', [OrderController::class, 'pax'])->name('order.pax');
    Route::get('/choose-soup', [OrderController::class, 'soups'])->name('order.soups');
    Route::get('/choose-dessert', [OrderController::class, 'desserts'])->name('order.desserts');
    Route::get('/choose-main-dishes', [OrderController::class, 'main_dishes'])->name('order.main_dishes');
    Route::get('/choose-add-ons', [OrderController::class, 'add_ons'])->name('order.add_ons');
    Route::get('/contact-details', [OrderController::class, 'contact_details'])->name('order.contact_details');

    Route::post('/check-out/pay', [PaymentController::class, 'pay'])->name('checkout.pay');
    Route::get('/check-out/{order}', [PaymentController::class, 'checkout'])->name('checkout'); -->
