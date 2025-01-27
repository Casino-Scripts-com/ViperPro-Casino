<?php


use App\Http\Controllers\Api\Profile\LikeController;
use Illuminate\Support\Facades\Route;

Route::post('/like/{user}', [LikeController::class, 'likeUser']);
