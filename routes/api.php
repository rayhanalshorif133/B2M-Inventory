<?php

use App\Http\Controllers\Api\LogController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('log')
    ->name('log.')
    ->controller(LogController::class)
    ->group(function () {

        // /api/log/product?product_attribute_id=1&type=1&qty=219&ref_id=1
        Route::match(['get', 'post'], '/product', 'productLog')->name('product');

        // /api/log/transection?transaction_type_id=1&type=1&amount=219&ref_id=1
        Route::match(['get', 'post'], '/transection', 'transectionLog')->name('transection');
    });
