<?php

use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return redirect('/task-todos');
    });
});

Route::get('/welcome', function () {
    return view('welcome');
})->name('welcome');

Route::get('/session-test', function() {
    // Cek session
    dd([
        'session_user_id' => session('user_id'),
        'auth_check' => auth()->check(),
        'auth_id' => auth()->id(),
        'session_data' => session()->all()
    ]);
});
