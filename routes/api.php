<?php

use App\Http\Controllers\AdminApiController;
use Illuminate\Support\Facades\Route;

Route::get('/allUsers', [AdminApiController::class, 'allUsersForAPI']);
Route::post('/forLogin', [AdminApiController::class, 'loginApi']);
