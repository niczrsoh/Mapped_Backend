<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SampleController;

Route::get('/', function () {
    return view('welcome');
});

// Simple JSON endpoint to integrate with Flutter frontend
Route::get('/sample', [SampleController::class, 'index']);
