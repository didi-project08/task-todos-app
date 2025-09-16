<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Auth\Controllers\MainController;

$CLASS = MainController::class;

Route::controller($CLASS)->middleware('guest')->group(function() {
    $MAIN_URI = "auth";
    Route::get('/'.$MAIN_URI, 'vLogin')->name('auth');
    Route::get('/'.$MAIN_URI.'/login', 'vLogin')->name('login');
    Route::get('/'.$MAIN_URI.'/register', 'vRegister')->name('register');
    Route::post('/'.$MAIN_URI.'/login-validate', 'loginValidate')->name('login-validate');
    Route::post('/'.$MAIN_URI.'/regist-validate', 'registerValidate')->name('register-validate');
});

Route::controller($CLASS)->middleware('auth')->group(function() {
    Route::post('/auth/logout', [MainController::class, 'logout'])->name('logout');
});