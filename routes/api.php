<?php

use Illuminate\Support\Facades\Route;

Route::post('/auth/login', [App\Http\Controllers\AuthController::class, 'login']);

Route::get('/user/{id}', [App\Http\Controllers\UserController::class, 'show']);
