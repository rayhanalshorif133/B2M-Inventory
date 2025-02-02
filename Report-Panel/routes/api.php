<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\ScoreController;

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




//{{baseurl}}/api/score?msisdn=8801711111111&score=100&keyword=mergeDice
Route::match(['get', 'post'], '/score', [ScoreController::class, 'score']);


// {{baseurl}}/api/redirect?msisdn=8801711111111&keyword=mergeDice
Route::match(['get', 'post'], '/redirect', [ScoreController::class, 'redirect']);

