<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderDetailController;
use App\Http\Controllers\CountryProductController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) 
{
    return $request->user();
});

Route::post('/user', [UserController::class, 'create']);

Route::get('/user/{id}', [UserController::class, 'item']);

Route::get('/users', [UserController::class, 'list']);

Route::put('/user/{id}', [UserController::class, 'update']);

Route::delete('/user/{id}', [UserController::class, 'delete']);


Route::post('/sale', [SaleController::class, 'create']);

Route::get('/sale/{id}', [SaleController::class, 'item']);

Route::get('/sales', [SaleController::class, 'list']);

Route::put('/sale/{id}', [SaleController::class, 'update']);

Route::delete('/sale/{id}', [SaleController::class, 'delete']);


Route::post('/review', [ReviewController::class, 'create']);

Route::get('/review/{id}', [ReviewController::class, 'item']);

Route::get('/reviews', [ReviewController::class, 'list']);

Route::put('/review/{id}', [ReviewController::class, 'update']);

Route::delete('/review/{id}', [ReviewController::class, 'delete']);


Route::post('/product', [ProductController::class, 'create']);

Route::get('/product/{id}', [ProductController::class, 'item']);

Route::get('/products', [ProductController::class, 'list']);

Route::put('/product/{id}', [ProductController::class, 'update']);

Route::delete('/product/{id}', [ProductController::class, 'delete']);


Route::post('/order', [OrderController::class, 'create']);

Route::get('/order/{id}', [OrderController::class, 'item']);

Route::get('/orders', [OrderController::class, 'list']);

Route::put('/order/{id}', [OrderController::class, 'update']);

Route::delete('/order/{id}', [OrderController::class, 'delete']);


Route::post('/orderDetail', [OrderDetailController::class, 'create']);

Route::get('/orderDetail/{id}', [OrderDetailController::class, 'item']);

Route::get('/orderDetails', [OrderDetailController::class, 'list']);

Route::put('/orderDetail/{id}', [OrderDetailController::class, 'update']);

Route::delete('/orderDetail/{id}', [OrderDetailController::class, 'delete']);


Route::post('/countryProduct', [CountryProductController::class, 'create']);

Route::get('/countryProduct/{id}', [CountryProductController::class, 'item']);

Route::get('/countryProducts', [CountryProductController::class, 'list']);

Route::put('/countryProduct/{id}', [CountryProductController::class, 'update']);

Route::delete('/countryProduct/{id}', [CountryProductController::class, 'delete']);


Route::post('/categoryProduct', [CategoryProductController::class, 'create']);

Route::get('/categoryProduct/{id}', [CategoryProductController::class, 'item']);

Route::get('/categoryProducts', [CategoryProductController::class, 'list']);

Route::put('/categoryProduct/{id}', [CategoryProductController::class, 'update']);

Route::delete('/categoryProduct/{id}', [CategoryProductController::class, 'delete']);


Route::post('register', [UserController::class, 'register']);

Route::post('login', [UserController::class, 'login']);

Route::post('logout', [UserController::class, 'logout'])->middleware('auth:sanctum');