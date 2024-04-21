<?php

use Illuminate\Support\Facades\Route;
use Modules\FinancePiutang\App\Http\Controllers\FinancePiutangController;
use Modules\FinancePiutang\App\Http\Controllers\InvoiceController;
use Modules\FinancePiutang\App\Http\Controllers\ReceivePaymentController;
use Modules\FinancePiutang\App\Http\Controllers\SalesOrderController;

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

Route::group(['middleware' => ['auth', 'verified']], function () {
    Route::prefix('finance')->name('finance.piutang.')->group(function () {
        Route::get('/piutang', [FinancePiutangController::class, 'index'])->name('index');

        Route::resource('/piutang/sales-order', SalesOrderController::class);
        Route::resource('/piutang/invoice', InvoiceController::class);
        Route::resource('/piutang/receive-payment', ReceivePaymentController::class);
    });
});
