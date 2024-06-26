<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\Task\TaskController;
use Illuminate\Support\Facades\Route;

// for all
Route::get('/', [UserController::class, 'home'])->name('home');
Route::get('/register', [UserController::class, 'showRegistrationForm'])->name('register');
Route::get('/login', [UserController::class, 'loginForm'])->name('login');

Route::post('/register', [UserController::class, 'register'])->name('registerPost');
Route::post('/login', [UserController::class, 'login']);

//for users
Route::get('/user/{id}', [UserController::class, 'show'])->name('user.userSinglePage')->middleware('user');
Route::get('/addTask', [TaskController::class, 'addTaskForm'])->name('user.addTask')->middleware('user');
Route::get('/userPage', [UserController::class, 'userSinglePage'])->middleware('user');
Route::get('/update', [UserController::class, 'updateDataForm'])->name('user.update')->middleware('user');
Route::get('/allTasks', [TaskController::class, 'allTasks'])->name('tasks.allTasks')->middleware('user');
Route::get('/task/delete/{id}', [TaskController::class, 'deleteTask'])->name('tasks.deleteTask')->middleware('user');
Route::get('/task/update/{id}', [TaskController::class, 'updateTaskForm'])->name('tasks.updateTask')->middleware('user');
Route::get('/task/updateStatus/{id}', [TaskController::class, 'updateTaskStatus'])->middleware('user');

Route::post('/task/updateTaskData/{id}', [TaskController::class, 'updateTask'])->name('tasks.updateTaskData')->middleware('user');
Route::post('/addTaskData', [TaskController::class, 'addTaskData'])->name('tasks.addTaskData')->middleware('user');
Route::post('/updateData', [UserController::class, 'updateData'])->name('tasks.updateUserData')->middleware('user');

//for all Authenticated
Route::post('/logout', [UserController::class, 'logout'])->name('logout')->middleware('auth');

// for admin
Route::get('/admin/{id}', [AdminController::class, 'showAdmin'])->name('admin.adminSinglePage')->middleware('admin');
Route::get('/allUsers', [AdminController::class, 'showAllUsers'])->name('admin.allUsersData')->middleware('admin');
Route::get('/allUsers/deactivateUsers', [AdminController::class, 'showAllDeactivateUsers'])->name('admin.allDeactivateUsersData')->middleware('admin');
Route::get('/adminPage', [AdminController::class, 'adminPage'])->name('admin.adminSinglePageForm')->middleware('admin');
Route::get('/update/user/byAdmin/{id}', [AdminController::class, 'updateUserByAdminForm'])->name('admin.updateUserByAdminForm')->middleware('admin');
Route::get('/deactivate/user/byAdmin/{id}', [AdminController::class, 'deactivateUserByAdmin'])->name('admin.deactivateUserByAdmin')->middleware('admin');
Route::get('/activate/user/byAdmin/{id}', [AdminController::class, 'activateUserByAdmin'])->name('admin.activateUserByAdmin')->middleware('admin');
Route::get('/delete/user/byAdmin/{id}', [AdminController::class, 'deleteUserByAdmin'])->name('admin.deleteUserByAdmin')->middleware('admin');
Route::get('/addUserByAdminForm', [AdminController::class, 'addUserByAdminForm'])->name('admin.addUserByAdminForm')->middleware('admin');
Route::get('/addTask/user/byAdmin/{id}', [AdminController::class, 'addTaskByAdminForm'])->name('admin.addTaskByAdminForm')->middleware('admin');

Route::post('/addUserByAdmin', [AdminController::class, 'addUserByAdmin'])->name('admin.addUserByAdmin')->middleware('admin');
Route::post('/addTask/byAdmin/{id}', [AdminController::class, 'addTaskDataByAdmin'])->name('admin.addTaskByAdmin')->middleware('admin');
Route::post('/update/userData/{id}', [AdminController::class, 'updateUserData'])->name('admin.updateUserByAdmin')->middleware('admin');
