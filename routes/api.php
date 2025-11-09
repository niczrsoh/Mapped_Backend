<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SampleController;

// API routes are stateless and do not include CSRF protection
Route::post('/sample/insert', [SampleController::class, 'insert']);