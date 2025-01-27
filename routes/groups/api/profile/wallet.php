<?php

use App\Http\Controllers\Api\Profile\WalletController;
use Illuminate\Support\Facades\Route;

Route::prefix('wallet')
    ->group(function ()
    {
        Route::get('/', [WalletController::class, 'index']);
    });

Route::prefix('mywallet')
    ->group(function ()
    {
        Route::get('/', [WalletController::class, 'myWallet']);
        Route::post('/{id}', [WalletController::class, 'setWalletActive']);
    });
