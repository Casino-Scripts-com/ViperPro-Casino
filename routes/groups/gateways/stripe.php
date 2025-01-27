<?php

use App\Http\Controllers\Api\Gateways\StripeController;
use Illuminate\Support\Facades\Route;


Route::prefix('webhooks')
    ->group(function ()
    {
        Route::post('stripe', [StripeController::class, 'webhooks']);
    });



