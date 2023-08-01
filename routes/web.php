<?php

use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect('/tasks'));

Route::name('tasks.')->group(function () {
    $controller = TaskController::class;
    Route::get('/tasks', [$controller, 'index'])->name('index');
    Route::get('/tasks/create', [$controller, 'create'])->name('create');
    Route::post('/tasks', [$controller, 'store'])->name('store');
    Route::post('/tasks/{task}/change-status', [$controller, 'changeStatus'])->name('changeStatus');
    Route::get('/tasks/{task}', [$controller, 'edit'])->name('edit');
});
