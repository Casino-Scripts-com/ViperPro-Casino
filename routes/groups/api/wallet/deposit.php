<?php

use App\Http\Controllers\Api\Wallet\DepositController;
use Illuminate\Support\Facades\Route;

Route::prefix('deposit')
    ->group(function ()
    {
        Route::get('/', [DepositController::class, 'index']);
        Route::post('/payment', [DepositController::class, 'submitPayment']);
    });

