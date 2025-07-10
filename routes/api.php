<?php

declare(strict_types=1);

use App\Http\Controllers\Leituras\CadastroDeLeituraController;
use App\Http\Controllers\Leituras\LeituraProgressoController;
use App\Http\Controllers\Leituras\PesquisarLeituraController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UsuarioLeituraExcluirController;
use Illuminate\Support\Facades\Route;

// php artisan cache:clear && php artisan config:clear && php artisan route:clear && php artisan view:clear && composer du && ./vendor/bin/pint
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
        Route::delete('/excluir/{id_usuario_leitura}', UsuarioLeituraExcluirController::class)->name('excluir');
        Route::post('/progresso', LeituraProgressoController::class)->name('progresso');
    });
});
