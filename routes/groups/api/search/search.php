<?php

use App\Http\Controllers\Api\Search\SearchGameController;
use Illuminate\Support\Facades\Route;

Route::get('/games', [SearchGameController::class, 'index']);
