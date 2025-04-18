<?php

use App\Http\Controllers\StripeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('stripe', [StripeController::class, 'index']);
Route::post('stripe', [StripeController::class, 'charge'])->name('stripe.post');
