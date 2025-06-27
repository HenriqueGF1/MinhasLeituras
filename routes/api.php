<?php

declare(strict_types=1);

use App\Http\Controllers\Leituras\CadastroDeLeituraController;
use App\Http\Controllers\Leituras\PesquisarLeituraController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('usuario')->name('usuario.')->controller(UserController::class)->group(function () {
    // Rotas públicas
    Route::post('/login', 'login')->name('login');
    Route::post('/cadastrar', 'cadastrar')->name('cadastrar');
    Route::get('/logout', 'logout')->name('logout');

    // Rotas protegidas por middleware de autenticação
    Route::middleware(['auth:api'])->group(function () {
        Route::get('/teste', 'teste')->name('teste');
    });
});

// Route::prefix('leituras')->name('leituras.')->controller(LeiturasController::class)->group(function () {
//     // Rotas públicas
//     Route::get('/', 'index')->name('pesquisarLeituras');

//     // Rotas protegidas por middleware de autenticação
//     Route::middleware(['auth:api'])->group(function () {
//         Route::post('/isbn', 'pesquisaIsbn')->name('pesquisaIsbn');
//         Route::post('/cadastrar', 'store')->name('cadastrar');
//     });
// });

Route::prefix('leituras')->name('leituras.')->group(function () {
    // Rotas públicas

    Route::get('/', PesquisarLeituraController::class)->name('pesquisarLeituras');

    // Rotas protegidas por middleware de autenticação
    Route::middleware(['auth:api'])->group(function () {
        Route::post('/isbn', PesquisarLeituraController::class)->name('pesquisaIsbn');
        Route::post('/cadastrar', CadastroDeLeituraController::class)->name('cadastrar');
    });
});
