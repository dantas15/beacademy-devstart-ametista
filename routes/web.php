<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    UserController,
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

Route::get('/usuarios', [UserController::class, 'index'])->name('users.index');
Route::get('/usuarios/criar', [UserController::class, 'create'])->name('users.create');
Route::get('/usuarios/{id}', [UserController::class, 'show'])->name('users.show');
Route::post('/usuarios', [UserController::class, 'store'])->name('users.store');
