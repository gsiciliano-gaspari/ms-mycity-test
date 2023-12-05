<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api;

Route::controller(Api::class)->group(function () {
    Route::post('/register', 'register');
    Route::post('/login', 'login');
    Route::get('/users', 'index');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [Api::class, 'logout']);
});
