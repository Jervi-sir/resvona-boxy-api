<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ServerController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// what can a use do
Route::get('/awake', [ServerController::class, 'awake']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/preview/{uuid}', [UserController::class, 'show']);
Route::post('/updateImage', [UserController::class, 'image']);

// Protected routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/edit', [UserController::class, 'editPage']);
    //Details
    Route::post('/updateBio', [UserController::class, 'bio']);
    Route::post('/updateName', [UserController::class, 'name']);
    //Socials
    Route::post('/addSocial', [UserController::class, 'addSocial']);
    Route::post('/editSocial', [UserController::class, 'editSocial']);
    Route::post('/deleteSocial', [UserController::class, 'deleteSocial']);
});


//admin things not from api
//Route::post('/register', [AuthController::class, 'register']);

