<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SampleController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/sample', [SampleController::class, 'index']);

Route::post('/sample/insert', [SampleController::class, 'insert']);

Route::get('/sample/all', [SampleController::class, 'all']);
