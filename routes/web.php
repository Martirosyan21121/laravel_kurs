<?php

use App\Http\Controllers\Auth\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function (){
    return view('home');
});

Route::get('/register', [UserController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [UserController::class, 'register'])->name('register');
Route::get('/user/{id}', [UserController::class, 'show'])->name('user.userSinglePage');

