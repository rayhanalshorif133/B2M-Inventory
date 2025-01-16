<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\ExpensesIncomeController;
use App\Http\Controllers\PurchaseReturnController;
use App\Http\Controllers\ExpensesIncomeHeadController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\ExpensesIncomeCategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\LedgerController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\TransactionTypeController;
use App\Http\Controllers\SalesReturnController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TipsAndTourController;
use App\Http\Controllers\CommonController;
use Illuminate\Support\Facades\Artisan;

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
    // return redirect()->route('auth.login');
    return view('welcome');
});

Route::get('/link', function () {
    Artisan::call('storage:link');
    return 'Storage Linked success';
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
        Route::get('/fetch-auth', 'fetchAuth')->name('fetch-auth');
        Route::get('/sidebar/data-fetch', 'fetchSidebarData')->name('sidebar-data-fetch');
        Route::match(['get', 'put'], '/profile', 'profile')->name('profile');
        Route::get('/fetch-roles', 'fetchRoles')->name('fetch-roles');
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
        Route::get('/fetch-by-code', 'fetchByCode')->name('fetch-by-code');
        Route::get('/show-product-details/{id?}', 'showProductDetails')->name('show.product.details');
        Route::get('/fetch-attribute', 'fetchAttribute')->name('fetch-attribute');
        Route::get('/check-duplicate-code/{code}', 'checkDuplicateCode')->name('check-duplicate-code');
        Route::match(['get', 'post'], '/barcode', 'barcode')->name('barcode');
        // update
        Route::put('/update/{id}', 'update')->name('update');
        Route::get('/getProductCode', 'getProductCode')->name('getProductCode');
    });



Route::middleware('auth')
    ->prefix('transaction-types')
    ->name('transaction-types.')
    ->controller(TransactionTypeController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/fetch', 'fetch')->name('fetch');
        Route::post('/create', 'createUpdate')->name('create');
        Route::put('/update', 'createUpdate')->name('update');
        Route::delete('{id}/delete', 'delete')->name('delete');
    });


Route::middleware('auth')
    ->prefix('supplier')
    ->name('supplier.')
    ->controller(SupplierController::class)->group(function () {
        Route::post('/create', 'create')->name('create');
        Route::get('/fetch', 'fetch')->name('fetch');
        Route::get('/list', 'list')->name('list');
        Route::put('/update', 'update')->name('update');
        Route::delete('/{id}/delete', 'delete')->name('delete');
    });

Route::middleware('auth')
    ->prefix('customer')
    ->name('customer.')
    ->controller(CustomerController::class)->group(function () {
        Route::post('/create', 'create')->name('create');
        Route::get('/fetch', 'fetch')->name('fetch');
        Route::put('/update', 'update')->name('update');
        Route::delete('/{id}/delete', 'delete')->name('delete');
        Route::get('/list', 'list')->name('list');
    });

Route::middleware('auth')
    ->prefix('purchase')
    ->name('purchase.')
    ->controller(PurchaseController::class)->group(function () {
        Route::match(['get', 'post'], '/create', 'create')->name('create');
        Route::get('/list', 'index')->name('index');
        Route::get('/fetch/{id}', 'fetch')->name('fetch');
        Route::match(['get', 'put'], '/{id}/edit/', 'edit')->name('edit');
        Route::delete('/{id}/delete/', 'delete')->name('delete');
        Route::get('/fetch-invoice', 'fetchInvoice')->name('invoice.fetch-invoice');
        Route::get('/payment-list', 'paymentList')->name('payment-list');

        Route::get('/due-amount', 'dueCollection')->name('due-collection');
    });


Route::middleware('auth')
    ->prefix('purchase/return')
    ->name('purchase.return.')
    ->controller(PurchaseReturnController::class)->group(function () {
        Route::match(['get', 'post'], '/create', 'create')->name('create');
        Route::get('/invoice/{id}', 'invoice')->name('invoice');
        Route::get('/list/{id?}', 'index')->name('index');
        Route::get('/fetch/{id}', 'fetch')->name('fetch');
        Route::match(['get', 'put'], '/{id}/edit/', 'edit')->name('edit');
    });

Route::middleware('auth')
    ->prefix('sales')
    ->name('sales.')
    ->controller(SalesController::class)->group(function () {
        Route::match(['get', 'post'], '/create', 'create')->name('create');
        Route::get('/list', 'index')->name('index');
        Route::get('/fetch/{id}', 'fetch')->name('fetch');
        Route::match(['get', 'put'], '/{id}/edit/', 'edit')->name('edit');
        Route::delete('/{id}/delete/', 'delete')->name('delete');
        Route::get('/payment-list', 'paymentList')->name('payment-list');
        Route::get('/due-amount', 'dueCollection')->name('due-collection');
    });

Route::middleware('auth')->controller(CommonController::class)
    ->group(function () {
        Route::get('/{type}/invoice/{id}', 'invoice')->name('type.invoice');
    });

Route::middleware('auth')
    ->prefix('sales/return')
    ->name('sales.return.')
    ->controller(SalesReturnController::class)->group(function () {
        Route::match(['get', 'post'], '/create', 'create')->name('create');
        Route::get('/invoice/{id}', 'invoice')->name('invoice');
        Route::get('/list/{id?}', 'index')->name('index');
        Route::get('/fetch/{id}', 'fetch')->name('fetch');
        Route::match(['get', 'put'], '/{id}/edit/', 'edit')->name('edit');
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
        // sales
        Route::prefix('/sales')->controller(PaymentController::class)->group(function () {
            Route::match(['get', 'post'], '/pay', 'salesPay')->name('sales.pay');
            Route::match(['get', 'post'], '/pay-slip/{id}', 'salesPaySlip')->name('sales.pay-slip');
        });

        Route::controller(PaymentController::class)->group(function () {
            Route::get('/fetch/{id}', 'fetch')->name('fetch');
            Route::put('/update', 'update')->name('update');
        });
    });

Route::middleware('auth')
    ->prefix('expense-income')
    ->name('expense-income.')
    ->group(function () {
        // entry
        Route::controller(ExpensesIncomeController::class)->group(function () {
            Route::get('/', 'list')->name('list');
            Route::get('/fetch/{id?}', 'fetch')->name('fetch');
            Route::post('/create', 'create')->name('create');
            Route::put('/update', 'update')->name('update');
            Route::delete('/{id}/delete', 'delete')->name('delete');
        });
        // category
        Route::prefix('/category')->name('category.')->controller(ExpensesIncomeCategoryController::class)->group(function () {
            Route::get('/', 'list')->name('list');
            Route::get('/fetch/{id?}', 'fetch')->name('fetch');
            Route::post('/create', 'create')->name('create');
            Route::put('/update', 'update')->name('update');
            Route::delete('/{id}/delete', 'delete')->name('delete');
        });
        // head
        Route::prefix('/head')->name('head.')->controller(ExpensesIncomeHeadController::class)->group(function () {
            Route::get('/', 'list')->name('list');
            Route::get('/fetch/{id?}', 'fetch')->name('fetch');
            Route::post('/create', 'create')->name('create');
            Route::put('/update', 'update')->name('update');
            Route::delete('/{id}/delete', 'delete')->name('delete');
        });
    });

Route::middleware('auth')
    ->prefix('report')
    ->name('report.')
    ->controller(ReportController::class)
    ->group(function () {
        Route::get('/current-stock', 'currentStock')->name('current-stock');
        Route::get('/purchase', 'purchase')->name('purchase');
        Route::get('/purchase-return', 'purchaseReturn')->name('purchase-return');
        Route::get('/purchase-payment', 'purchasePayment')->name('purchase-payment');
        Route::get('/sales', 'sales')->name('sales');
        Route::get('/sales-return', 'salesReturn')->name('sales-return');
        Route::get('/sales-payment', 'salesPayment')->name('sales-payment');
        Route::get('/profit-loss', 'profitLoss')->name('profit-loss');
    });


Route::middleware('auth')
    ->prefix('ledger')
    ->name('ledger.')
    ->controller(LedgerController::class)
    ->group(function () {
        Route::get('/customer', 'customer')->name('customer');
        Route::get('/supplier', 'supplier')->name('supplier');
        Route::get('/product', 'product')->name('product');
    });


Route::middleware('auth')->controller(TipsAndTourController::class)
    ->prefix('/tips-tour-guide')
    ->group(function () {
        Route::get('/fetch', 'fetchTipsAndSkipsTourGuide');
        Route::put('/update', 'update');
    });
