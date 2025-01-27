<?php

use App\Http\Controllers\Api\Gateways\StripeController;
use Illuminate\Support\Facades\Route;

Route::post('stripe/session', [StripeController::class, 'getSessionRequest']);
Route::post('stripe/publickey', [StripeController::class, 'getPublicKey']);
