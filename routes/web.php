<?php
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AuditLogController;
use App\Models\Product;
use App\Models\Category;
use App\Models\User;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/home', [HomeController::class, 'index']);
Route::get('/san-pham/{id}', [HomeController::class, 'show'])->name('product.detail');
Route::get('/danh-muc/{id}', [HomeController::class, 'category'])->name('category.show');
Route::get('/search', [HomeController::class, 'search'])->name('search');

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::get('/add-to-cart/{id}', [CartController::class, 'addToCart'])->name('cart.add');
Route::get('/remove-from-cart/{id}', [CartController::class, 'removeFromCart'])->name('cart.remove');
Route::post('/update-cart', [CartController::class, 'updateCart'])->name('cart.update');
Route::get('/clear-cart', [CartController::class, 'clearCart'])->name('cart.clear');

Auth::routes();

Route::middleware([
    'auth',
    \App\Http\Middleware\AdminMiddleware::class,
])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/', function () {
            $tongSanPham = Product::count();
            $tongTaiKhoan = User::count();
            $tongDanhMuc = Category::count();
            return view('admin.dashboard', compact(
                'tongSanPham',
                'tongTaiKhoan',
                'tongDanhMuc'
            ));
        })->name('dashboard');
        
        Route::resource('products', ProductController::class);
        Route::resource('categories', CategoryController::class);
        Route::resource('users', UserController::class);
        Route::get('audit-logs', [AuditLogController::class, 'index'])->name('audit-logs.index');
    });