<?php

use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductOrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TestimonialController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [FrontController::class, 'index'])->name('front.index');
Route::get('/details/{product:slug}', [FrontController::class, 'details'])->name('front.details');
Route::get('/category/{category}', [FrontController::class, 'category'])->name('front.category');
Route::get('/search', [FrontController::class, 'search'])->name('front.search');
Route::get('/about', [FrontController::class, 'about'])->name('front.about');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Routes for pembeli only
    Route::get('/checkout/{product:slug}', [CheckoutController::class, 'checkout'])
        ->name('front.checkout')
        ->middleware('role:buyer');
    Route::post('/checkout/store/{product:slug}', [CheckoutController::class, 'store'])
        ->name('front.checkout.store')
        ->middleware('role:buyer');
    
    // Buyer routes
    Route::prefix('buyer')->name('buyer.')->middleware('role:buyer')->group(function(){
        // Orders
        Route::get('/orders', [ProductOrderController::class, 'myOrders'])->name('orders.index');
        Route::get('/orders/stories', [ProductOrderController::class, 'stories'])->name('orders.stories');
        Route::patch('/orders/{order}/cancel', [ProductOrderController::class, 'cancel'])->name('orders.cancel');
        
        // Testimonials
        Route::get('/testimonials', [TestimonialController::class, 'buyerIndex'])->name('testimonials.index');
        Route::get('/testimonials/create', [TestimonialController::class, 'create'])->name('testimonials.create');
        Route::post('/testimonials/store', [TestimonialController::class, 'store'])->name('testimonials.store');
    });

    // Admin routes - hanya untuk seller
    Route::prefix('admin')->name('admin.')->middleware('role:seller')->group(function(){
        Route::resource('products', ProductController::class);
        Route::resource('product_orders', ProductOrderController::class);

        Route::get('/transactions', [ProductOrderController::class, 'transactions'])->name('product_orders.transactions');
        Route::get('/transactions/details/{productOrder}', [ProductOrderController::class, 'transactions_details'])->name('product_orders.transactions.details');

        Route::get('/download/file/{productOrder}', [ProductOrderController::class, 'download_file'])->name('product_orders.download')->middleware('throttle:1,1');

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        
        // Testimonial management for penjual
        Route::get('/testimonials', [TestimonialController::class, 'index'])->name('testimonials.index');
        Route::get('/testimonials/{testimonial}', [TestimonialController::class, 'show'])->name('testimonials.show');
    });
});

require __DIR__.'/auth.php';
