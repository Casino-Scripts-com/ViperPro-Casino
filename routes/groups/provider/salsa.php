<?php

use App\Http\Controllers\Api\Games\GameController;
use Illuminate\Support\Facades\Route;

Route::prefix('cron')
    ->group(function ()
    {

        Route::post('salsa/webhook', [GameController::class, 'webhookSalsaMethod']);
    });

