<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api;

Route::controller(Api::class)->group(function () {
    Route::post('/register', 'register');
    Route::post('/login', 'login');
});
Route::middleware('auth:sanctum')->group(function () {
    Route::controller(Api::class)->group(function () {
        Route::post('/logout', 'logout');
        Route::get('/users', 'index');
        Route::get('/user/{id}', 'show');
        Route::post('/user/update/{id}', 'update');
        Route::delete('/user/destroy/{id}', 'destroy');
    });
});
