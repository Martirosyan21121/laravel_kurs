<?php

use App\Http\Controllers\api\ApiController;
use Illuminate\Support\Facades\Route;

Route::get('allUsers', [ApiController::class, 'showData'])->name('apiAllUsers');
Route::get('findUser/{id}', [ApiController::class, 'findUserByIdApi'])->name('apiFindUser');

Route::delete('deleteAccount/{id}', [ApiController::class, 'deleteUserByIdApi'])->name('apiDeleteUser');
Route::patch('updateUserApi/{id}', [ApiController::class, 'updateUserByIdApi'])->name('apiUpdateUser');

Route::post('loginApi', [ApiController::class, 'login'])->name('loginApi');
Route::post('registerApi', [ApiController::class, 'register'])->name('registerApi');
// task

Route::get('tasks/{id}', [ApiController::class, 'tasks'])->name('tasks');
Route::get('task/{id}', [ApiController::class, 'task'])->name('task');

