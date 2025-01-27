<?php


use App\Http\Controllers\Api\Profile\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ProfileController::class, 'index']);
Route::post('/upload-avatar', [ProfileController::class, 'uploadAvatar']);
Route::post('/updateName', [ProfileController::class, 'updateName']);
