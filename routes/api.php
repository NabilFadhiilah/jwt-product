<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryProductController;

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

Route::group(['middleware' => 'api','prefix' => 'auth'], function ($router) {
    Route::post('register', [AuthController::class,'register']);
    Route::post('login', [AuthController::class,'login']);
    Route::post('logout', [AuthController::class,'logout']);
    Route::post('refresh', [AuthController::class,'refresh']);
});

Route::group(['middleware' => 'api'], function ($router) {
    Route::resource('category-products', CategoryProductController::class)->only([
        'index','store','update','destroy'
    ]);
    Route::get('/category-products/{id}', [CategoryProductController::class, 'show']);
    Route::resource('products', ProductController::class)->only([
        'index','store','update','destroy'
    ]);
    Route::get('/products/{id}', [ProductController::class, 'show']);
});