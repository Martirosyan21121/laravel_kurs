<?php

use App\Http\Controllers\api\ApiController;
use Illuminate\Support\Facades\Route;

Route::get('findUser/{id}', [ApiController::class, 'findUserByIdApi'])->name('apiFindUser')->middleware('token');
Route::patch('updateUserApi/{id}', [ApiController::class, 'updateUserByIdApi'])->name('apiUpdateUser')->middleware('token');
Route::post('loginApi', [ApiController::class, 'login'])->name('loginApi')->middleware('token');
Route::put('registerApi', [ApiController::class, 'register'])->name('registerApi')->middleware('token');
// task

Route::get('tasks/{id}', [ApiController::class, 'tasks'])->name('tasks')->middleware('token');
Route::get('task/{id}', [ApiController::class, 'task'])->name('task')->middleware('token');
Route::delete('task/delete/{id}', [ApiController::class, 'taskDelete'])->name('taskDelete')->middleware('token');
Route::put('task/addTask/{id}', [ApiController::class, 'addTask'])->name('addTask')->middleware('token');
Route::patch('task/updateTask/{id}', [ApiController::class, 'updateTask'])->name('updateTask')->middleware('token');
//admin

Route::get('admin/allUsers', [ApiController::class, 'allUsersData'])->name('apiAllUsers')->middleware('token');
Route::delete('admin/deleteUser/{id}', [ApiController::class, 'deleteUsers'])->name('deleteUsers')->middleware('token');
Route::put('admin/addTaskByAdmin/{id}', [ApiController::class, 'addTaskByAdmin'])->name('addTaskByAdmin')->middleware('token');
Route::get('admin/deactivateUser/{id}', [ApiController::class, 'deactivateUser'])->name('deactivateUser')->middleware('token');
Route::get('admin/activateUser/{id}', [ApiController::class, 'activateUser'])->name('activateUser')->middleware('token');

Route::get('/logout/{id}', [ApiController::class, 'logout'])->name('logout');
