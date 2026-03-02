<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NoteController;

Route::resource('notes', NoteController::class)->only('index');

//Route::get('/', function () {
//   return 'Hello World';
//});

Route::redirect('/', '/notes', 302);
