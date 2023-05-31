<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

Route::get('/', fn () => Redirect(route('tasks.index')));

Route::name('tasks.')->group(function () { 
    $controller = TaskController::class;
    Route::get('/tasks', [$controller, 'index'])->name('index');
    Route::get('/tasks/create', [$controller, 'create'])->name('create');
 });