<?php

use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;

Route::get('/', function (){
    return view('home');
});

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register'])->name('register');
Route::get('/user/{id}', [RegisterController::class, 'show'])->name('user.userSinglePage');

