<?php

use App\Http\Controllers\Api\Profile\FavoriteController;
use Illuminate\Support\Facades\Route;

Route::prefix('favorites')
    ->group(function ()
    {
        Route::get('/', [FavoriteController::class, 'index']);
    });
