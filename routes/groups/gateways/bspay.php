<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Gateway\BsPayController;

Route::prefix('bspay')
    ->group(function ()
    {
        Route::post('qrcode-pix', [BsPayController::class, 'getQRCodePix']);
        Route::any('callback', [BsPayController::class, 'callbackMethod']);
        Route::post('consult-status-transaction', [BsPayController::class, 'consultStatusTransactionPix']);

        Route::get('withdrawal/{id}', [BsPayController::class, 'withdrawalFromModal'])->name('bspay.withdrawal');
        Route::get('cancelwithdrawal/{id}', [BsPayController::class, 'cancelWithdrawalFromModal'])->name('bspay.cancelwithdrawal');
    });



