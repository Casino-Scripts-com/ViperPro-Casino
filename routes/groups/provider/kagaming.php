<?php


use App\Http\Controllers\Api\Games\GameController;
use Illuminate\Support\Facades\Route;

Route::prefix('kagaming')
    ->group(function ()
    {

        Route::get('webhooks', [GameController::class, 'webhookKaGamingMethod']);
    });

