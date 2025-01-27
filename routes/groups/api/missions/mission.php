<?php

use App\Http\Controllers\Api\Missions\MissionController;
use Illuminate\Support\Facades\Route;

Route::apiResource('missions', MissionController::class);
