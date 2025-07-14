<?php

use App\Http\Controllers\Leituras\AvaliacaoLeituraCadastroController;
use App\Http\Controllers\Leituras\CadastroDeLeituraController;
use App\Http\Controllers\Leituras\IsbnPesquisaApiController;
use App\Http\Controllers\Leituras\IsbnPesquisaController;
use App\Http\Controllers\Leituras\LeituraProgessoCadastroController;
use App\Http\Controllers\Leituras\PesquisarLeituraController;
use App\Http\Controllers\Usuario\UsuarioCadastroController;
use App\Http\Controllers\Usuario\UsuarioLeituraExcluirController;
use App\Http\Controllers\Usuario\UsuarioLoginController;
use App\Http\Controllers\Usuario\UsuarioLogoutController;
use Illuminate\Support\Facades\Route;

// php artisan cache:clear && php artisan config:clear && php artisan route:clear && php artisan view:clear && composer du && ./vendor/bin/pint
Route::prefix('usuario')->name('usuario.')->group(function () {
    Route::post('/cadastrar', UsuarioCadastroController::class)->name('cadastrar');
    Route::post('/login', UsuarioLoginController::class)->name('login');

    Route::middleware(['auth:api'])->group(function () {
        Route::get('/logout', UsuarioLogoutController::class)->name('logout');
    });
});

Route::prefix('leituras')->name('leituras.')->group(function () {
    // Rotas públicas

    Route::get('/', PesquisarLeituraController::class)->name('pesquisarLeituras');

    // Rotas protegidas por middleware de autenticação
    Route::middleware(['auth:api'])->group(function () {
        Route::post('/isbn', IsbnPesquisaController::class)->name('pesquisaIsbn');
        Route::post('/isbn-api', IsbnPesquisaApiController::class)->name('pesquisaIsbn.api');
        Route::post('/cadastrar', CadastroDeLeituraController::class)->name('cadastrar');
        Route::delete('/excluir/{id_usuario_leitura}', UsuarioLeituraExcluirController::class)->name('excluir');
        Route::post('/progresso', LeituraProgessoCadastroController::class)->name('progresso.cadastrar');
        Route::post('/avaliar', AvaliacaoLeituraCadastroController::class)->name('avaliacoes.cadastrar');
    });
});
