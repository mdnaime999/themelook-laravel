<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ApiController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('products', [ApiController::class, 'products']);
Route::post('product', [ApiController::class, 'product']);
Route::post('product-insert', [ApiController::class, 'product_insert']);
Route::post('product-insert-image', [ApiController::class, 'product_insert_image']);
Route::get('productgetcolors', [ApiController::class, 'colors']);
Route::get('productgetsizes', [ApiController::class, 'sizes']);
