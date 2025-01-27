<?php

use App\Http\Controllers\Api\Games\GameController;
use Illuminate\Support\Facades\Route;

Route::prefix('vibra')
    ->group(function ()
    {

        Route::get('webhooks/{parameters?}', [GameController::class, 'webhookVibraMethod']);
    });

