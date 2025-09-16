<?php

use Illuminate\Support\Facades\Route;
use App\Modules\TaskTodo\Controllers\MainController;

$CLASS = MainController::class;

Route::controller($CLASS)->middleware('auth')->group(function() {
    $MAIN_URI = "task-todos";
    Route::get('/'.$MAIN_URI, 'index')->name('task-todos.index');
    Route::get('/'.$MAIN_URI.'/create', 'create')->name('task-todos.create');
    Route::post('/'.$MAIN_URI.'/store', 'store')->name('task-todos.store');
    Route::get('/'.$MAIN_URI.'/show/{id}', 'show')->name('task-todos.show');
    Route::get('/'.$MAIN_URI.'/edit/{id}', 'edit')->name('task-todos.edit');
    Route::put('/'.$MAIN_URI.'/update/{id}', 'update')->name('task-todos.update');
    Route::delete('/'.$MAIN_URI.'/destroy/{id}', 'destroy')->name('task-todos.destroy');
});