<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\CustomersController;
use App\Http\Controllers\DiscountsController;
use App\Http\Controllers\WishlistsController;
use App\Http\Controllers\ProductCategoriesController;
use App\Http\Controllers\DiscountCategoriesController;

// Route::get('/', function () {
//     return view('welcome');
// })->name('welcome');

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/home/{id}', [HomeController::class, 'single'])->name('single');
Route::get('/menu', [MenuController::class, 'index'])->name('menu');
Route::get('/menu/{id}', [MenuController::class, 'single'])->name('single');

Route::get('/', function () {
    return redirect()->route('home');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::prefix('product-categories')->name('product_categories.')->group(function () {
        Route::get('/', [ProductCategoriesController::class, 'index'])->name('index');
        Route::get('/create', [ProductCategoriesController::class, 'create'])->name('create');
        Route::post('/', [ProductCategoriesController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [ProductCategoriesController::class, 'edit'])->name('edit');
        Route::put('/{id}', [ProductCategoriesController::class, 'update'])->name('update');
        Route::delete('/{id}', [ProductCategoriesController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('discount-categories')->name('discount_categories.')->group(function () {
        Route::get('/', [DiscountCategoriesController::class, 'index'])->name('index');
        Route::get('/create', [DiscountCategoriesController::class, 'create'])->name('create');
        Route::post('/store', [DiscountCategoriesController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [DiscountCategoriesController::class, 'edit'])->name('edit');
        Route::put('/{id}', [DiscountCategoriesController::class, 'update'])->name('update');
        Route::delete('/{id}', [DiscountCategoriesController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('products')->group(function () {
        Route::get('/', [ProductsController::class, 'index'])->name('products.index');
        Route::get('/create', [ProductsController::class, 'create'])->name('products.create');
        Route::post('/store', [ProductsController::class, 'store'])->name('products.store');
        Route::get('/{id}/edit', [ProductsController::class, 'edit'])->name('products.edit');
        Route::put('/{id}', [ProductsController::class, 'update'])->name('products.update');
        Route::delete('/{id}', [ProductsController::class, 'destroy'])->name('products.destroy');
    });

    Route::prefix('discounts')->name('discounts.')->group(function () {
        Route::get('/', [DiscountsController::class, 'index'])->name('index');
        Route::get('/create', [DiscountsController::class, 'create'])->name('create');
        Route::post('/', [DiscountsController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [DiscountsController::class, 'edit'])->name('edit');
        Route::put('/{id}', [DiscountsController::class, 'update'])->name('update');
        Route::delete('/{id}', [DiscountsController::class, 'destroy'])->name('destroy');
    });
});

Route::get('/customers-register', function () {
    return view('customers-register');
})->name('customers-register');

Route::get('/customers-login', function () {
    return view('customers-login');
})->name('customers-login');

Route::post('/customers-register', [CustomersController::class, 'register'])->name('customer.register');
Route::post('/customers-login', [CustomersController::class, 'login'])->name('customer.login');
Route::post('/customers-logout', [CustomersController::class, 'logout'])->name('customer.logout')->middleware('auth:customers');

Route::middleware('auth:customers')->group(function () {
    Route::post('/wishlists/add', [WishlistsController::class, 'store'])->name('wishlists.add');
});



// Route::prefix('products')->group(function () {
//     Route::get('/', [HomeController::class, 'index']);
//     Route::get('/{id}', [HomeController::class, 'single'])->name('product.single');
// });


require __DIR__ . '/auth.php';
