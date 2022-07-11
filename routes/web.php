<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    UserController,
    AddressController
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

Route::get('/', function () {
    return view('welcome');
})->name('index');

Route::name('products')->get('/produtos', function () {
    return view('products.list');
});

Route::prefix('usuarios')->name('users.')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('index');
    Route::get('/criar', [UserController::class, 'create'])->name('create');
    Route::post('/', [UserController::class, 'store'])->name('store');

    Route::get('/{id}', [UserController::class, 'show'])->name('show');

    Route::get('/editar/{id}', [UserController::class, 'edit'])->name('edit');
    Route::put('/{id}', [UserController::class, 'update'])->name('update');

    Route::name('addresses.')->group(function () {
        Route::get('/{userId}/enderecos', [AddressController::class, 'index'])->name('index');

        Route::get('/{userId}/enderecos/criar', [AddressController::class, 'create'])->name('create');
        Route::post('/{userId}/enderecos', [AddressController::class, 'store'])->name('store');
        Route::get('/{userId}/enderecos/editar/{id}', [AddressController::class, 'edit'])->name('edit');
        Route::put('/{userId}/enderecos/{id}', [AddressController::class, 'update'])->name('update');
    });
});
