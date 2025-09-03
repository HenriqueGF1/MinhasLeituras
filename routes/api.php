<?php

use App\Http\Controllers\Autor\PesquisarAutorController;
use App\Http\Controllers\Avaliacao\AvaliacaoExcluirController;
use App\Http\Controllers\Avaliacao\AvaliacaoLeituraCadastroController;
use App\Http\Controllers\Avaliacao\AvaliacaoPesquisaController;
use App\Http\Controllers\Editora\PesquisarEditoraController;
use App\Http\Controllers\Generos\PesquisarGenerosController;
use App\Http\Controllers\Leituras\CadastroDeLeituraController;
use App\Http\Controllers\Leituras\IsbnPesquisaApiController;
use App\Http\Controllers\Leituras\IsbnPesquisaController;
use App\Http\Controllers\Leituras\PesquisarLeituraAleatoriaController;
use App\Http\Controllers\Leituras\PesquisarLeituraController;
use App\Http\Controllers\ProgressoLeituras\LeituraProgessoCadastroController;
use App\Http\Controllers\ProgressoLeituras\PesquisarLeituraTotalPaginasLidasController;
use App\Http\Controllers\StatusLeitura\PesquisarStatusLeituraController;
use App\Http\Controllers\Usuario\UsuarioCadastroController;
use App\Http\Controllers\Usuario\UsuarioLoginController;
use App\Http\Controllers\Usuario\UsuarioLogoutController;
use App\Http\Controllers\UsuarioLeituras\PesquisarLeiturasUsuariosController;
use App\Http\Controllers\UsuarioLeituras\UsuarioLeituraCadastrarController;
use App\Http\Controllers\UsuarioLeituras\UsuarioLeituraExcluirController;
use Illuminate\Support\Facades\Route;

// SWAGGER ROTA
// http://127.0.0.1:8000/api/rotas

Route::prefix('usuario')->name('usuario.')->group(function () {
    Route::post('/', UsuarioCadastroController::class)->name('cadastrar');
    Route::post('/login', UsuarioLoginController::class)->name('login');
    //
    Route::middleware(['auth:api'])->group(function () {
        Route::get('/logout', UsuarioLogoutController::class)->name('logout');
    });
});

Route::prefix('leituras')->name('leituras.')->group(function () {
    Route::get('/', PesquisarLeituraController::class)->name('pesquisarLeituras');
    Route::get('/aleatoria', PesquisarLeituraAleatoriaController::class)->name('aleatoria');
    Route::middleware(['auth:api'])->group(function () {
        Route::get('/isbn/{isbn}', IsbnPesquisaController::class)->name('pesquisa-isbn');
        Route::get('/isbn-api/{isbn}', IsbnPesquisaApiController::class)->name('pesquisa-isbn.api');
        Route::post('/', CadastroDeLeituraController::class)->name('cadastrar');
    });
});

Route::middleware(['auth:api'])->group(function () {
    Route::prefix('usuario-leitura')->name('usuario-leitura.')->group(function () {
        Route::get('/', PesquisarLeiturasUsuariosController::class)->name('pesquisar');
        Route::post('/', UsuarioLeituraCadastrarController::class)->name(name: 'cadastro');
        Route::delete('/{id_usuario_leitura}', action: UsuarioLeituraExcluirController::class)->name('excluir');
    });

    Route::prefix('avaliacoes')->name('avaliacoes-leitura.')->group(function () {
        Route::get('/', AvaliacaoPesquisaController::class)->name('pesquisa');
        Route::post('/', AvaliacaoLeituraCadastroController::class)->name('cadastrar');
        Route::delete('/{id_avaliacao_leitura}', AvaliacaoExcluirController::class)->name('deletar');
    });

    Route::prefix('progresso')->name('progresso-leitura.')->group(function () {
        Route::post('/', LeituraProgessoCadastroController::class)->name('cadastrar');
        Route::post('/total', PesquisarLeituraTotalPaginasLidasController::class)->name('quantidade.total.paginas.lida');
    });

    Route::prefix('generos')->name('generos.')->group(function () {
        Route::get('/', PesquisarGenerosController::class)->name(name: 'pesquisar');
    });

    Route::prefix('autores')->name('autores.')->group(function () {
        Route::get('/', PesquisarAutorController::class)->name(name: 'pesquisar');
    });

    Route::prefix('status')->name('status-leituras.')->group(function () {
        Route::get('/leituras', PesquisarStatusLeituraController::class)->name(name: 'pesquisar');
    });

    Route::prefix('editoras')->name('editoras.')->group(function () {
        Route::get('/', PesquisarEditoraController::class)->name(name: 'pesquisar');
    });
});
