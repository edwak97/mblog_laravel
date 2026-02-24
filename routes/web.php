<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NoteController;

Route::resource('notes', NoteController::class)->only('index');

Route::redirect('/', '/notes', 302);
