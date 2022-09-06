<?php

use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::group(['middleware' => 'api', 'prefix' => 'auth'], function ($router) {
    Route::post('/login/', [AuthController::class, 'login']);
    Route::post('/logout/', [AuthController::class, 'logout']);
});

Route::group(['middleware' => 'auth', 'prefix' => 'blogs'], function ($router) {
    Route::post('/store/', [BlogController::class, 'store']);
    Route::patch('/{bog}/update/', [BlogController::class, 'update']);
    Route::get('/{bog}/retrieve/', [BlogController::class, 'retrieve']);
    Route::delete('/{bog}/destroy/', [BlogController::class, 'destroy']);
});

Route::get('/me/', [AuthController::class, 'me']);
