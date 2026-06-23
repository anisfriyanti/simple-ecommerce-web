<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\MidtransCallbackController;
use Illuminate\Support\Facades\Route;



Route::get('/', [HomeController::class, 'index']);
Route::get('/products', [ProductController::class, 'index']);
Route::get(
    '/products/{slug}',
    [ProductController::class, 'show']
);
//callback midtrans
Route::post(
    '/midtrans/callback',
    [MidtransCallbackController::class, 'handle']
);
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

 //cart routes
 Route::post(
        '/cart/add/{product}',
        [CartController::class, 'add']
    );

    Route::get(
        '/cart',
        [CartController::class, 'index']
    );

     Route::post(
        '/cart/update/{cartItem}',
        [CartController::class, 'update']
    );
 //checkout routes
     Route::post(
        '/checkout',
        [CheckoutController::class, 'store']
    );   
//orders routes
 Route::get(
        '/orders',
        [OrderController::class, 'index']
    );
    //payment routes
Route::get(
        '/payments/{transaction}',
        [PaymentController::class, 'create']
    );

    Route::post(
        '/payments/{transaction}',
        [PaymentController::class, 'store']
    );
});

//prefix admin routes with middleware
Route::middleware([
    'auth',
    'admin'
])->prefix('admin')
->group(function () {

    Route::get(
        '/',
        [AdminController::class, 'dashboard']
    );

    Route::get(
        '/payments',
        [AdminController::class, 'payments']
    );

    Route::post(
        '/payments/{payment}/approve',
        [AdminController::class, 'approvePayment']
    );
    // other admin routes...
Route::resource(
    '/products',
    \App\Http\Controllers\Admin\ProductController::class
);
//categories
Route::resource(
    '/categories',
    \App\Http\Controllers\Admin\CategoryController::class
);
//orders
Route::get(
    '/orders',
    [\App\Http\Controllers\Admin\OrderController::class, 'index']
);

Route::get('/orders/{transaction}', [\App\Http\Controllers\Admin\OrderController::class, 'show'])
    ->name('admin.orders.show');

Route::post(
    '/orders/{transaction}/status',
    [\App\Http\Controllers\Admin\OrderController::class, 'updateStatus']
);
});
require __DIR__.'/auth.php';
