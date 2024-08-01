<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderDetailController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SortingController;

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

Route::post('register', [UserController::class, 'register']);

Route::post('login', [UserController::class, 'login']);

Route::post('logout', [UserController::class, 'logout'])->middleware('auth:sanctum');

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


Route::get('/productsN', [SortingController::class, 'sortingAscName']);

Route::get('/productsNm', [SortingController::class, 'sortingDescName']);

Route::get('/productsP', [SortingController::class, 'sortingAscPrice']);

Route::get('/productsPr', [SortingController::class, 'sortingDescPrice']);


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


Route::post('/country', [CountryController::class, 'create']);

Route::get('/country/{id}', [CountryController::class, 'item']);

Route::get('/countries', [CountryController::class, 'list']);

Route::put('/country/{id}', [CountryController::class, 'update']);

Route::delete('/country/{id}', [CountryController::class, 'delete']);


Route::post('/category', [CategoryController::class, 'create']);

Route::get('/category/{id}', [CategoryController::class, 'item']);

Route::get('/categories', [CategoryController::class, 'list']);

Route::put('/category/{id}', [CategoryController::class, 'update']);

Route::delete('/category/{id}', [CategoryController::class, 'delete']);
