<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;

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




Route::middleware(['auth', 'role'])->group(function () {
    Route::get('/add-users', [AdminController::class, 'addUsers'])->name('users.add');
    Route::get('/show-users', [AdminController::class, 'showUsers'])->name('users.show');
    Route::post('/create-users', [AdminController::class, 'createUsers'])->name('users.create');
    Route::get('/hardCreatePage', [AdminController::class, 'hardCreatePage'])->name('users.hardCreatePage');
    Route::post('/hardCreate', [AdminController::class, 'hardCreate'])->name('users.hardCreate');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'role'])->name('dashboard');

require __DIR__.'/auth.php';
