<?php

use Illuminate\Support\Facades\Route;

Route::post('/auth/login', [App\Http\Controllers\AuthController::class, 'login']);
Route::delete('/auth/logout', [App\Http\Controllers\AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::post('/user', [App\Http\Controllers\UserController::class, 'store']);
Route::get('/user/{id}', [App\Http\Controllers\UserController::class, 'show'])->middleware('auth:sanctum');

Route::apiResource('recipe', App\Http\Controllers\RecipeController::class)->middleware('auth:sanctum');
