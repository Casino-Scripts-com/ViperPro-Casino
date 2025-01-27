<?php

use App\Http\Controllers\Api\Missions\MissionUserController;
use Illuminate\Support\Facades\Route;

Route::apiResource('missionsusers', MissionUserController::class);
