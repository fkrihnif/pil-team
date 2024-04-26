<?php

use Illuminate\Support\Facades\Route;
use Modules\FinanceReceipt\App\Http\Controllers\FinanceCashInController;
use Modules\FinanceReceipt\App\Http\Controllers\FinanceCashOutController;
use Modules\FinanceReceipt\App\Http\Controllers\FinanceReceiptController;
use Modules\FinanceReceipt\App\Http\Controllers\FinanceReferenceFormatController;

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
    Route::prefix('finance')->name('finance.receipt.')->group(function () {
        Route::get('/receipt', [FinanceReceiptController::class, 'index'])->name('index');
        
        Route::resource('/receipt/cash-out', FinanceCashOutController::class);
        Route::resource('/receipt/cash-in', FinanceCashInController::class);
        Route::resource('/receipt/reference', FinanceReferenceFormatController::class);
    });
});
