<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Subdomains Route Stores
Route::domain('{subdomain}.localhost')->group(function(){
    Route::get('/', [\App\Http\Controllers\Front\StoreController::class, 'index'])
            ->name('front.store');

    Route::prefix('cart')->name('cart.')->group(function(){
        Route::get('/', [\App\Http\Controllers\Front\CartController::class, 'index'])->name('index');
        Route::get('add/{product}', [\App\Http\Controllers\Front\CartController::class, 'add'])->name('add');
        Route::get('remove/{product}', [\App\Http\Controllers\Front\CartController::class, 'remove'])->name('remove');
        Route::get('cancel', [\App\Http\Controllers\Front\CartController::class, 'cancel'])->name('cancel');
    });

    Route::prefix('checkout')->middleware('auth.store')->name('checkout.')->group(function(){
        Route::get('/', [\App\Http\Controllers\Front\CheckoutController::class, 'checkout'])->name('checkout');
        Route::post('/proccess', [\App\Http\Controllers\Front\CheckoutController::class, 'proccess'])->name('proccess');
        Route::get('/thanks', [\App\Http\Controllers\Front\CheckoutController::class, 'thanks'])->name('thanks');
    });

    Route::name('sign.')->group(function() {
        Route::get('/sign-in', [\App\Http\Controllers\Front\AuthenticateController::class, 'index'])->name('index');
        Route::post('/sign-in', [\App\Http\Controllers\Front\AuthenticateController::class, 'signIn'])->name('in');
        Route::post('/sign-up', [\App\Http\Controllers\Front\AuthenticateController::class, 'signUp'])->name('up');
    });
    Route::get('logout', [\App\Http\Controllers\Front\AuthenticateController::class, 'logout'])->name('up');
});


Route::get('/', function () {
        
    return view('welcome');
});

Route::get('/dashboard', function () {
    dump(\App\Models\Product::first());

    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::prefix('admin')->name('admin.')->group(function(){

    Route::resource('products', \App\Http\Controllers\Admin\ProductController::class);
    Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class);

});

require __DIR__.'/auth.php';
