<?php
use App\Http\Controllers\Api\Settings\CurrencyController;
use Illuminate\Support\Facades\Route;


Route::prefix('bonus')
    ->group(function ()
    {
        Route::get('/', [CurrencyController::class, 'index']);
    });
