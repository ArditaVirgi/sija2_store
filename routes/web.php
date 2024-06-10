<?php

use app\Http\Controllers\HomeController;
use app\Route;

Route::get('/', function () {
    return view('home.index');
});
// Route::get('/home', [HomeController::class, 'index']);
Route::get('/about/index', function () {
    return 'About/Index';
});

Route::get('/register', [\app\Http\Controllers\RegisterController::class, 'index']);
Route::get('/register/create', [\app\Http\Controllers\RegisterController::class, 'create']);
Route::get('/register/{id}edit', [\app\Http\Controllers\RegisterController::class, 'edit']);
Route::get('/register/{id}', [\app\Http\Controllers\RegisterController::class, 'show']);
Route::get('/login', [\app\Http\Controllers\LoginController::class, 'index']);

// Route::resource('/home', \app\Http\Controllers\HomeController::class, 'index');
