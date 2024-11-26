<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

use App\Http\Controllers\homeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ClientController;

Auth::routes();

Route::post('login', [LoginController::class, 'login'])->name('login');
Route::post('register', [RegisterController::class, 'register'])->name('register');
Route::post('logout', [LoginController::class, 'logout'])->name('logout');


Route::get('/', function () {
    return redirect('/login');;
});

Route::get('/home', [homeController::class, 'index'])->name('home')->middleware('auth');

Route::resource('orders', OrderController::class)->middleware('auth');
Route::post('/save-order', [OrderController::class, 'store'])->name('save.order');
Route::post('/orders/save', [OrderController::class, 'saveOrder']);
Route::delete('/orders/{order}', [OrderController::class, 'destroy'])->name('orders.destroy');
Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
Route::get('/orders', [OrderController::class, 'getOrders'])->name('get.orders');
Route::get('/orders', [OrderController::class, 'index'])->name('orders.index')->middleware('auth');
Route::delete('/orders/{order}', [OrderController::class, 'destroy'])->name('orders.destroy')->middleware('auth');
Route::patch('/orders/{order}', [OrderController::class, 'update'])->name('orders.update')->middleware('auth');
Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show')->middleware('auth');
Route::get('/filter-orders', [OrderController::class, 'filterOrders']);

Route::get('/products', [ProductController::class, 'index'])->name('products.index')->middleware('auth');
Route::post('/products', [ProductController::class, 'store'])->name('products.store')->middleware('auth');
Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy')->middleware('auth');
Route::patch('/products/{product}', [productController::class, 'update'])->name('products.update')->middleware('auth');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show')->middleware('auth');

Route::get('/Clients', [ClientController::class, 'index'])->name('Clients.index')->middleware('auth');
Route::post('/Clients', [ClientController::class, 'store'])->name('Clients.store')->middleware('auth');
Route::delete('/Clients/{Client}', [ClientController::class, 'destroy'])->name('Clients.destroy')->middleware('auth');
Route::patch('/Clients/{Client}', [ClientController::class, 'update'])->name('Clients.update')->middleware('auth');
Route::get('/Clients/{Client}', [ClientController::class, 'show'])->name('Clients.show')->middleware('auth');

Route::get('/api/clients', [OrderController::class, 'getClients']);
Route::get('/api/products', [OrderController::class, 'getProducts']);

