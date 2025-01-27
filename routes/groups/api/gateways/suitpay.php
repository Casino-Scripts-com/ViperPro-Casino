<?php
use App\Http\Controllers\Gateway\SuitPayController;
use Illuminate\Support\Facades\Route;

Route::prefix('suitpay')
    ->group(function ()
    {
        Route::post('qrcode-pix', [SuitPayController::class, 'getQRCodePix']);
        Route::post('consult-status-transaction', [SuitPayController::class, 'consultStatusTransactionPix']);
    });



