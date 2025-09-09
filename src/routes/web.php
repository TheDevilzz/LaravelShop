<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\products;
use App\Http\Controllers\AdminPannel;

Route::get('/', [products::class, 'index']);
Route::get('productdetail/{id}', [products::class, 'productdetail'])->name('productdetail');
Route::get('cart', [products::class, 'cart'])->name('cart');
Route::get('addCart/{id}', [products::class, 'addCart'])->name('addCart');
Route::post('addCarts/{id}', [products::class, 'addCarts'])->name('addCarts');
Route::get('deleteCart/{id}', [products::class, 'deleteCart'])->name('deleteCart');
Route::get('pluscart/{id}', [products::class, 'pluscart'])->name('pluscart');
Route::post('/users/update-role/{id}', [products::class, 'updateRole'])->name('users.updateRole');
Route::post('checkout', [products::class, 'checkout'])->name('checkout');
Route::get('minuscart/{id}', [products::class, 'minuscart'])->name('minuscart');
Route::get('adminPannel', [AdminPannel::class, 'index'])->name('dashboard');
Route::get('product', [AdminPannel::class, 'products'])->name('product');
Route::get('productupload', [AdminPannel::class, 'productsUpload'])->name('productupload');
Route::post('addProduct', [AdminPannel::class, 'addProduct'])->name('addProduct');
Route::delete('/deleteProduct/{id}', [AdminPannel::class, 'deleteProduct'])->name('deleteProduct');
Route::get('/editProduct/{id}', [AdminPannel::class, 'editProduct'])->name('editProduct');
Route::post('updateProduct/{id}', [AdminPannel::class, 'updateProduct'])->name('updateProduct');
Route::get('userlist', [AdminPannel::class, 'users'])->name('userlist');
Route::delete('/userdelete/{id}', [AdminPannel::class, 'userdelete'])->name('userdelete');
Route::get('order', [AdminPannel::class, 'order'])->name('order');



Auth::routes();

Route::get('home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
