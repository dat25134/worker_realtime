<?php

use App\Http\Controllers\RealTimeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/realtime', [RealTimeController::class, 'index']);
