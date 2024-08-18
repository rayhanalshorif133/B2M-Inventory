<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\TransactionTypeController;
use App\Http\Controllers\UserController;
use App\Models\ProductAttribute;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::middleware('auth')->get('/home', [HomeController::class, 'index'])->name('home');

// LoginController
Route::controller(AuthController::class)->name('auth.')->group(function () {
    Route::middleware('isLoggedIn')->match(['get', 'post'], '/login', 'login')->name('login');
    Route::match(['get', 'post'], '/register', 'register')->name('register');
    Route::match(['get', 'post'], '/forgot-password', 'forgotPassword')->name('forgot-password');
    Route::match(['get', 'post'], '/reset-password', 'resetPassword')->name('reset-password');
});

Route::middleware('auth')->get('/user-logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->controller(UserController::class)
    ->prefix('user')
    ->name('user.')
    ->group(function () {
        Route::match(['get', 'post'], '/create', 'create')->name('create');
        Route::get('/list', 'list')->name('list');
    });

Route::middleware('auth')->controller(CategoryController::class)->prefix('category')->name('category.')
    ->group(function () {
        Route::get('/list', 'list')->name('list');
        Route::get('/fetch', 'fetch')->name('fetch');
        Route::match(['get', 'post'], '/create', 'create')->name('create');
        Route::put('/update/{category_id}', 'update')->name('update');
        Route::put('/add-new-sub/{category_id}', 'addNewSubCategory')->name('add-new-sub');
        Route::delete('delete/{id}', 'delete')->name('delete');
    });

Route::middleware('auth')->controller(ProductController::class)
    ->prefix('product')->name('product.')
    ->group(function () {
        Route::get('/list', 'list')->name('list');
        Route::match(['get', 'post'], '/create', 'create')->name('create');
        Route::get('/fetch/{id?}', 'fetch')->name('fetch');
        Route::get('/fetch-attribute', 'fetchAttribute')->name('fetch-attribute');
        Route::get('/check-duplicate-code/{code}', 'checkDuplicateCode')->name('check-duplicate-code');
    });



Route::middleware('auth')
    ->prefix('transaction-types')
    ->controller(TransactionTypeController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/fetch', 'fetch')->name('fetch');
    });


Route::middleware('auth')
    ->prefix('supplier')
    ->controller(SupplierController::class)->group(function () {
        Route::post('/create', 'create')->name('create');
        Route::get('/fetch', 'fetch')->name('fetch');
    });

Route::middleware('auth')
    ->prefix('purchase')
    ->name('purchase.')
    ->controller(PurchaseController::class)->group(function () {
        Route::match(['get', 'post'], '/create', 'create')->name('create');
        Route::get('/list', 'index')->name('index');
        Route::get('/invoice/{id}', 'invoice')->name('invoice');
        Route::get('/fetch-invoice', 'fetchInvoice')->name('invoice.fetch-invoice');
        Route::get('/payment-list', 'paymentList')->name('payment-list');
    });

Route::middleware('auth')
    ->prefix('payment')
    ->name('payment.')
    ->group(function () {

        // purchase
        Route::prefix('/purchase')->controller(PaymentController::class)->group(function () {
            Route::match(['get', 'post'], '/pay', 'purchasePay')->name('purchase.pay');
            Route::match(['get', 'post'], '/pay-slip/{id}', 'purchasePaySlip')->name('purchase.pay-slip');
        });
    });




