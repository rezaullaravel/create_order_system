<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CreateOrderController;

Route::get('/', function () {
    return view('welcome');
});

//login form
Route::get('/login',[AuthController::class,'loginForm'])->name('login');
Route::get('/logout',[AuthController::class,'logout'])->name('logout');
Route::post('/post-login',[AuthController::class,'postLogin'])->name('post.login');


Route::middleware(['check'])->group(function(){
//dashboard
Route::get('/dashboard',[AuthController::class,'dashboard'])->name('dashboard');
});


/**===================frontend route====================== */

Route::get('/order/create',[CreateOrderController::class,'orderCreate'])->name('order.create');
Route::post('/order/place',[CreateOrderController::class,'orderPlace'])->name('order.place');
Route::get('/order/list',[CreateOrderController::class,'orderList'])->name('order.list');

//search product
Route::get('/search-products', [CreateOrderController::class, 'searchProducts']);

//add to cart
Route::post('/add-to-cart', [CreateOrderController::class, 'addToCart']);

//cart product quantity update
Route::post('/cart/update-quantity', [CreateOrderController::class, 'updateQuantity'])->name('cart.updateQuantity');
Route::get('/cart/delete-product', [CreateOrderController::class, 'deleteCartProduct'])->name('cart.deleteProduct');



/**===================frontend route====================== */
