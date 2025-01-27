<?php


use App\Http\Controllers\Gateway\SuitPayController;
use Illuminate\Support\Facades\Route;


Route::prefix('suitpay')
    ->group(function ()
    {
        Route::post('callback', [SuitPayController::class, 'callbackMethod']);
        Route::post('payment', [SuitPayController::class, 'callbackMethodPayment']);
        Route::get('withdrawal/{id}', [SuitPayController::class, 'withdrawalFromModal'])->name('suitpay.withdrawal');
        Route::get('cancelwithdrawal/{id}', [SuitPayController::class, 'cancelWithdrawalFromModal'])->name('suitpay.cancelwithdrawal');
    });

