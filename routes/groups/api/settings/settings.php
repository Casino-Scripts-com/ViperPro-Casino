<?php

use App\Http\Controllers\Api\Settings\SettingController;
use Illuminate\Support\Facades\Route;

Route::get('/data', [SettingController::class, 'index']);
