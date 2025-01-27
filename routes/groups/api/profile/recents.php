<?php

use App\Http\Controllers\Api\Profile\RecentsController;
use Illuminate\Support\Facades\Route;

Route::prefix('recents')
    ->group(function ()
    {
        Route::get('/', [RecentsController::class, 'index']);
    });
