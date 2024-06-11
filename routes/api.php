<?php

use App\Http\Controllers\api\ApiController;
use Illuminate\Support\Facades\Route;

Route::get('findUser/{id}', [ApiController::class, 'findUserByIdApi'])->name('apiFindUser')->middleware('auth:sanctum');
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

Route::get('admin/allUsers', [ApiController::class, 'allUsersData'])->name('apiAllUsers');
Route::delete('admin/deleteUser/{id}', [ApiController::class, 'deleteUsers'])->name('deleteUsers');
Route::put('admin/addTaskByAdmin/{id}', [ApiController::class, 'addTaskByAdmin'])->name('addTaskByAdmin');
Route::get('admin/deactivateUser/{id}', [ApiController::class, 'deactivateUser'])->name('deactivateUser');
Route::get('admin/activateUser/{id}', [ApiController::class, 'activateUser'])->name('activateUser');
