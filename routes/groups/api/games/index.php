<?php

use App\Http\Controllers\Api\Games\GameController;
use Illuminate\Support\Facades\Route;

Route::prefix('games')
    ->group(function ()
    {
        Route::get('all', [GameController::class, 'index']);
        Route::get('single/{id}', [GameController::class, 'show']);
        Route::post('favorite/{id}', [GameController::class, 'toggleFavorite']);
        Route::post('like/{id}', [GameController::class, 'toggleLike']);
    });

Route::prefix('featured')
    ->group(function ()
    {
        Route::any('/games', [GameController::class, 'featured']);
    });

Route::prefix('vgames')
    ->group(function ()
    {
        Route::any('/{token}/{action}', [GameController::class, 'sourceProvider']);
    });

Route::prefix('casinos')
    ->group(function ()
    {
        Route::get('games', [GameController::class, 'allGames']);
    });
