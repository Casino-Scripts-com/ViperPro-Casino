<?php


use App\Http\Controllers\Layouts\ApplicationController;
use Illuminate\Support\Facades\Route;

Route::get('{view}', ApplicationController::class)->where('view', '(.*)');
