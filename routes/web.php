<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    HomeController,
    CartController,
    CheckoutController,
    ShopController,
    UserController,
    AddressController,
    CategoryController,
    ProductController,
    AuthenticatedUserController,
    AdminController
};

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

Route::get('/', [HomeController::class, 'index'])->name('index');

Route::prefix('shop')->name('shop.')->group(function () {
    Route::get('/', [ShopController::class, 'index'])->name('index');

    Route::prefix('cart')->name('cart.')->group(function () {
        Route::get('/', [CartController::class, 'index'])->name('index');
        Route::post('/', [CartController::class, 'store'])->name('store');
        Route::delete('/clear', [CartController::class, 'clearCart'])->name('clear');
        Route::delete('/{productId}/{amount}', [CartController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('checkout')->name('checkout.')->middleware('auth')->group(function () {
        Route::get('/address', [CheckoutController::class, 'selectAddress'])->name('selectAddress');

        Route::get('/{addressId}', [CheckoutController::class, 'paymentForm'])->name('paymentForm');

        Route::post('/', [CheckoutController::class, 'payment'])->name('payment');
    });
});

Auth::routes(); // Login, Register, Logout

Route::middleware('auth')->group(function () {
    Route::prefix('me')->name('me.')->group(function () {
        Route::get('/', [AuthenticatedUserController::class, 'index'])->name('index');
        Route::put('/', [AuthenticatedUserController::class, 'update'])->name('update');

        Route::get('/orders', [AuthenticatedUserController::class, 'orders'])->name('orders');

        Route::prefix('addresses')->name('addresses.')->group(function () {
            Route::get('/', [AuthenticatedUserController::class, 'addresses'])->name('index');

            Route::get('/create', [AuthenticatedUserController::class, 'createAddress'])->name('create');
            Route::post('/', [AuthenticatedUserController::class, 'storeAddress'])->name('store');
            Route::get('/{id}', [AuthenticatedUserController::class, 'editAddress'])->name('edit');
            Route::put('/{id}', [AuthenticatedUserController::class, 'updateAddress'])->name('update');

            Route::delete('/{id}', [AuthenticatedUserController::class, 'destroyAddress'])->name('destroy');
        });
    });

    Route::prefix('admin')->name('admin.')->middleware('auth.admin')->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('index');

        Route::get('/orders', [AdminController::class, 'orders'])->name('orders');

        Route::prefix('products')->name('products.')->group(function () {
            Route::get('/', [ProductController::class, 'index'])->name('index');
            Route::get('/create', [ProductController::class, 'create'])->name('create');
            Route::post('/', [ProductController::class, 'store'])->name('store');

            Route::get('/{id}', [ProductController::class, 'show'])->name('show');

            Route::delete('/{id}', [ProductController::class, 'destroy'])->name('destroy');

            Route::get('/{product}/edit', [ProductController::class, 'edit'])->name('edit');
            Route::put('/{id}', [ProductController::class, 'update'])->name('update');
        });
        Route::prefix('categories')->name('categories.')->group(function () {
            Route::get('/', [CategoryController::class, 'index'])->name('index');
            Route::get('/create', [CategoryController::class, 'create'])->name('create');
            Route::post('/', [CategoryController::class, 'store'])->name('store');

            Route::get('/{id}', [CategoryController::class, 'show'])->name('show');

            Route::delete('/{id}', [CategoryController::class, 'destroy'])->name('destroy');

            Route::get('/{category}/edit', [CategoryController::class, 'edit'])->name('edit');
            Route::put('/{id}', [CategoryController::class, 'update'])->name('update');
        });

        Route::prefix('users')->name('users.')->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('index');
            Route::get('/create', [UserController::class, 'create'])->name('create');
            Route::post('/', [UserController::class, 'store'])->name('store');

            Route::get('/{id}', [UserController::class, 'show'])->name('show');

            Route::delete('/{id}', [UserController::class, 'destroy'])->name('destroy');

            Route::get('/edit/{id}', [UserController::class, 'edit'])->name('edit');
            Route::put('/{id}', [UserController::class, 'update'])->name('update');

            Route::prefix('/{userId}/addresses')->name('addresses.')->group(function () {
                Route::get('/', [AddressController::class, 'index'])->name('index');

                Route::get('/create', [AddressController::class, 'create'])->name('create');
                Route::post('/', [AddressController::class, 'store'])->name('store');
                Route::get('/edit/{id}', [AddressController::class, 'edit'])->name('edit');
                Route::put('/{id}', [AddressController::class, 'update'])->name('update');

                Route::delete('/{id}', [AddressController::class, 'destroy'])->name('destroy');
            });
        });
    });
});
