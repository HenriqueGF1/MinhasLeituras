<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::controller(UserController::class)->group(function () {
    Route::post('/login', 'login')->name('usuario.login');
    Route::post('/cadastrar', 'cadastrar')->name('usuario.cadastrar');
    Route::get('/logout', 'logout')->name('usuario.logout');

    Route::middleware(['auth:api'])->group(function () {
        Route::get('/teste', action: 'teste')->name(name: 'usuario.teste');
    });
});
