<?php

use App\Http\Controllers\api\ApiController;
use Illuminate\Support\Facades\Route;

Route::get('allUsers', [ApiController::class, 'showData'])->name('apiAllUsers');
Route::get('findUser/{id}', [ApiController::class, 'findUserByIdApi'])->name('apiFindUser');
// after register send gmail

Route::delete('deleteAccount/{id}', [ApiController::class, 'deleteUserByIdApi'])->name('apiDeleteUser');
Route::patch('updateUserApi/{id}', [ApiController::class, 'updateUserByIdApi'])->name('apiUpdateUser');
Route::post('loginApi', [ApiController::class, 'login'])->name('loginApi');
Route::put('registerApi', [ApiController::class, 'register'])->name('registerApi');
// task

Route::get('tasks/{id}', [ApiController::class, 'tasks'])->name('tasks');
Route::get('task/{id}', [ApiController::class, 'task'])->name('task');
Route::delete('task/delete/{id}', [ApiController::class, 'taskDelete'])->name('taskDelete');
Route::put('task/addTask/{id}', [ApiController::class, 'addTask'])->name('addTask');
Route::patch('task/updateTask/{id}', [ApiController::class, 'updateTask'])->name('updateTask');
//admin

