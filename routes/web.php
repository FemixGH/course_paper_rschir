<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// Главная страница
Route::get('/', function () {
    return view('home');
})->name('home')->middleware('auth');

// Регистрация и вход
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
