<?php

use App\Http\Controllers\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::resource('tasks', TaskController::class);

Route::get('tasks/filter-by-status/{status}', [TaskController::class, 'filter'])->name('tasks.filter');
