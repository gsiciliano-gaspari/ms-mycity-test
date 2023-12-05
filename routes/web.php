<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\App;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Home;

Route::get('/', function () {
    return redirect('/home');
});

Route::get('/home', [Home::class, 'index'])->name('home');


Route::controller(App::class)->group(function () {
    Route::get('/register', 'register')->name('register');
    Route::post('/store', 'store')->name('store');
    Route::get('/login', 'login')->name('login');
    Route::post('/authenticate', 'authenticate')->name('authenticate');
    Route::post('/logout', 'logout')->name('logout');
});
Route::resources([
    'users' => UserController::class,
]);
