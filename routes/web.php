<?php

use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\Task\TaskController;
use Illuminate\Support\Facades\Route;
// for all
Route::get('/', [UserController::class, 'home'])->name('home');
Route::get('/register', [UserController::class, 'showRegistrationForm'])->name('register');
Route::get('/login', [UserController::class, 'loginForm'])->name('login');
Route::get('/error', [UserController::class])->name('error');

Route::post('register', [UserController::class, 'register'])->name('register');
Route::post('/login', [UserController::class, 'login']);

//for users
Route::get('/user/{id}', [UserController::class, 'show'])->name('user.userSinglePage')->middleware('user');
Route::get('/addTask', [TaskController::class, 'addTaskForm'])->name('user.addTask')->middleware('user');
Route::get('/userPage', [UserController::class, 'userSinglePage'])->middleware('user');
Route::get('/allTasks', [TaskController::class, 'allTasks'])->name('tasks.allTasks')->middleware('user');

Route::post('/addTaskData', [TaskController::class, 'addTaskData'])->name('tasks.addTaskData')->middleware('user');

//for all Authenticated
Route::post('/logout', [UserController::class, 'logout'])->name('logout')->middleware('auth');

// for admin
Route::get('/admin/{id}', [UserController::class, 'showAdmin'])->name('admin.adminSinglePage')->middleware('admin');

