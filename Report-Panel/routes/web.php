<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\PlayerLoginController;
use App\Http\Controllers\BkashController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\WebController;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\PaymentController;

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

Route::get('/', [HomeController::class, 'home'])->name('home');

Auth::routes();

Route::get('/admin', [HomeController::class, 'admin'])->name('admin');


// Public routes

Route::match(['get', 'put'], '/account', [WebController::class, 'account'])->name('account')->middleware('role:player,admin');
Route::get('/category', [WebController::class, 'category'])->name('category');
Route::get('/not-allow', [WebController::class, 'notAllow'])->name('not-allow');

// Player Login routes
Route::prefix('player')->name('player.')->group(function () {
    Route::post('/login', [PlayerLoginController::class, 'login'])->name('login');
    Route::post('/register', [PlayerLoginController::class, 'register'])->name('register');
});



// Payment methods routes
Route::prefix('payment')->name('payment.')->group(function () {
    Route::get('/get-token', [PaymentController::class, 'getToken'])->name('get-token');
    Route::match(['get', 'post'], '/create/{msisdn}', [PaymentController::class, 'createPayment'])->name('create');
    Route::match(['get', 'post'], '/execute/{msisdn}/{paymentID}', [PaymentController::class, 'executePayment'])->name('execute');
    Route::match(['get', 'post'], '/consent_back/{msisdn}/{trxID}', [PaymentController::class, 'consentBack'])->name('consent-back');
});


// Bkash routes

Route::prefix('bkash')->name('bkash.')->group(function () {
    Route::match(['get', 'post'], '/auth', [BkashController::class, 'auth'])->name('auth');
    Route::get('/login/{id_token}', [BkashController::class, 'login'])->name('login');
});



// Home Page Public fetch
Route::get('campaign/{id}/fetch', [CampaignController::class, 'fetch'])->name('fetch');
Route::get('game/{id}/fetch', [GameController::class, 'fetch'])->name('fetch');
Route::get('leaderboard/{id}/fetch', [CampaignController::class, 'fetchLeaderboard'])->name('fetch-leaderboard');


Route::prefix('admin')->name('admin.')->middleware('role:admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // CampaignController
    //
    Route::prefix('/campaign')->name('campaign.')->group(function () {
        Route::get('/', [CampaignController::class, 'index'])->name('index');
        Route::post('/create', [CampaignController::class, 'create'])->name('create');
        Route::put('/{id}/update', [CampaignController::class, 'update'])->name('update');
        Route::delete('/{id}/delete', [CampaignController::class, 'delete'])->name('delete');
    });

    Route::prefix('/game')->name('game.')->group(function () {
        Route::get('/', [GameController::class, 'index'])->name('index');
        Route::post('/create', [GameController::class, 'create'])->name('create');
        Route::put('/update', [GameController::class, 'update'])->name('update');
    });
});
