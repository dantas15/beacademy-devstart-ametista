<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    UserController,
    ViaCepController
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
});

// Route::get('/hello-world', function () {
//     echo '<h1>hello world!</h1>';
// });

// Route::get('/users/{nome}', function ($nome) {
//     echo "<h1>$nome</h1>";
// });

// php artisan make:controller NomeDoController  (para criar controllers)

Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
Route::get('/users/{id}', [UserController::class, 'show'])->name('users.show');
Route::post('/users', [UserController::class, 'store'])->name('users.store');