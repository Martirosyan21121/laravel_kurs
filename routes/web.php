<?php

use App\Http\Controllers\Auth\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [UserController::class, 'home'])->name('home');

Route::get('/register', [UserController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [UserController::class, 'register'])->name('register');
Route::get('/login', [UserController::class, 'loginForm'])->middleware('auth:user');
Route::post('/login', [UserController::class, 'login']);

Route::get('/user/{id}', [UserController::class, 'show'])->name('user.userSinglePage')->middleware('auth:user');
Route::post('/logout', [UserController::class, 'logout'])->name('logout')->middleware('auth:user');
