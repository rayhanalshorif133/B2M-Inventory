<?php

use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;

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


Route::match(['get', 'post'], '/login', [LoginController::class, 'login'])->name('login');

Route::prefix('admin')->middleware('auth')->name('admin.')->group(function () {
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');


    Route::prefix('/user')->name('user.')->group(function () {
        Route::get('/logs', [UserController::class, 'userLogs'])->name('logs');
        Route::get('/guest-activites', [UserController::class, 'guestActivites'])->name('guest-activites');
    });

    Route::prefix('/')->group(function () {
        Route::match(['get', 'post'], '/profile', [LoginController::class, 'profile'])->name('profile');
    });

});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
