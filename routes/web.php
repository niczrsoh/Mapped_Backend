<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SampleController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/sample', [SampleController::class, 'index']);

Route::get('/sample/all', [SampleController::class, 'all']);

// Alias for API insert under web path, exempt from CSRF for JSON clients
Route::post('/sample/insert', [SampleController::class, 'insert'])
    ->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class]);