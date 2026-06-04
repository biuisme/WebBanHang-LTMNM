<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\UserController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/home', [HomeController::class, 'index']);

Route::get('/san-pham/{id}', [HomeController::class, 'show'])->name('product.detail');
Route::get('/danh-muc/{id}', [HomeController::class, 'category'])->name('category.show');
Route::get('/search', [HomeController::class, 'search'])->name('search');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::get('/add-to-cart/{id}', [CartController::class, 'addToCart'])->name('cart.add');



Route::middleware(['auth', \App\Http\Middleware\AdminMiddleware::class])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

    // Bảng điều khiển (Dashboard) của Admin
    Route::get('/', function () {

         $tongSanPham = \App\Models\Product::count();
         $tongTaiKhoan = 0;
         $tongDanhMuc = 0;

         return view('admin.dashboard', compact('tongSanPham', 'tongTaiKhoan', 'tongDanhMuc'));
    })->name('dashboard');

    Route::resource('products', ProductController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('users', UserController::class);

    
    Route::get('/admin/users/{id}', [UserController::class, 'show'])->name('admin.users.show'); 
    Route::get('/admin/users/{id}/edit', [UserController::class, 'edit'])->name('admin.users.edit'); 
    Route::put('/admin/users/{id}', [UserController::class, 'update'])->name('admin.users.update'); 
});



Auth::routes();
