<?php
use App\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/about/index', function () {
    return 'About/Index';
});

Route::get('/register', [App\Http\Controllers\RegisterController::class, 'index']);
Route::get('/register/create', [App\Http\Controllers\RegisterController::class, 'create']);
Route::get('/register/{id}edit', [App\Http\Controllers\RegisterController::class, 'edit']);
Route::get('/register/{id}', [App\Http\Controllers\RegisterController::class, 'show']);
Route::get('/login', [App\Http\Controllers\LoginController::class, 'index']);

Route::resource('/home', \App\Http\Controllers\HomeController::class);