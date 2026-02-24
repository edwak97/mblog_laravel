<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NoteControllerApi;
use App\Http\Controllers\AuthController;

Route::prefix('public')->group(function() {
	Route::apiResource('notes', NoteControllerApi::class)
		->only(['index', 'show'])
	;
	Route::post('login', [AuthController::class, 'login']);
});

Route::middleware('auth:admin')->group(function() {
	Route::apiResource('notes', NoteControllerApi::class)
		->except(['index', 'show'])
	;
});

