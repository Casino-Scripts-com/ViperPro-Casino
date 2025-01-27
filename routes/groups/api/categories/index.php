<?php

use App\Http\Controllers\Api\Categories\CategoryController;
use Illuminate\Support\Facades\Route;

Route::get('/', [CategoryController::class, 'index']);
