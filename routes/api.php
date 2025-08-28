<?php

use App\Http\Controllers\Autor\PesquisarAutorController;
use App\Http\Controllers\Avaliacao\AvaliacaoExcluirController;
use App\Http\Controllers\Avaliacao\AvaliacaoPesquisaController;
use App\Http\Controllers\Editora\PesquisarEditoraController;
use App\Http\Controllers\Generos\PesquisarGenerosController;
use App\Http\Controllers\Leituras\AvaliacaoLeituraCadastroController;
use App\Http\Controllers\Leituras\CadastroDeLeituraController;
use App\Http\Controllers\Leituras\IsbnPesquisaApiController;
use App\Http\Controllers\Leituras\IsbnPesquisaController;
use App\Http\Controllers\Leituras\LeituraProgessoCadastroController;
use App\Http\Controllers\Leituras\PesquisarLeituraAleatoriaController;
use App\Http\Controllers\Leituras\PesquisarLeituraController;
use App\Http\Controllers\Leituras\PesquisarLeiturasUsuariosController;
use App\Http\Controllers\Leituras\PesquisarLeituraTotalPaginasLidasController;
use App\Http\Controllers\StatusLeitura\PesquisarStatusLeituraController;
use App\Http\Controllers\Usuario\UsuarioCadastroController;
use App\Http\Controllers\Usuario\UsuarioLeituraCadastrarController;
use App\Http\Controllers\Usuario\UsuarioLeituraExcluirController;
use App\Http\Controllers\Usuario\UsuarioLoginController;
use App\Http\Controllers\Usuario\UsuarioLogoutController;
use App\Http\DTO\LeituraProgresso\LeituraProgressoPesquisaDTO;
use App\Http\Services\Leituras\LeituraProgresso\LeituraProgressoTotalPaginasLida;
use App\Models\LeituraProgresso;
use Illuminate\Support\Facades\Route;

// SWAGGER ROTA
// http://127.0.0.1:8000/api/rotas

Route::get('/teste', function () {
    $teste = new LeituraProgressoTotalPaginasLida(new LeituraProgresso);
    $dto = new LeituraProgressoPesquisaDTO([
        'id_usuario' => 1,
        'id_leitura' => 5,
    ]);
    $pesquisa = $teste->pesquisarLeituraProgressoTotalPaginasLida($dto);
    dd($pesquisa);
});

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
    Route::get('/aleatoria', PesquisarLeituraAleatoriaController::class)->name('leitura.aleatoria');

    // Rotas protegidas por middleware de autenticação
    Route::middleware(['auth:api'])->group(function () {
        Route::post('/isbn', IsbnPesquisaController::class)->name('pesquisaIsbn');
        Route::post('/isbn-api', IsbnPesquisaApiController::class)->name('pesquisaIsbn.api');
        Route::post('/cadastrar', CadastroDeLeituraController::class)->name('cadastrar');
        Route::delete('/excluir/{id_usuario_leitura}', UsuarioLeituraExcluirController::class)->name('excluir');
        Route::post('/progresso', LeituraProgessoCadastroController::class)->name('progresso.cadastrar');
        Route::post('/progresso/total', PesquisarLeituraTotalPaginasLidasController::class)->name('progresso.quantidade.total.paginas.lida');
        Route::post('/avaliar', AvaliacaoLeituraCadastroController::class)->name('avaliacoes.cadastrar');
        Route::get('/avaliar/pesquisa', AvaliacaoPesquisaController::class)->name('avaliacoes.pesquisa');
        Route::delete('/avaliar/deletar/{id_avaliacao_leitura}', AvaliacaoExcluirController::class)->name('avaliacoes.deletar');
        Route::get('/usuario', PesquisarLeiturasUsuariosController::class)->name('pesquisarLeituras.usuarios');
    });
});

Route::prefix('usuario-leitura')->name('usuario-leitura.')->group(function () {
    // Rotas públicas
    // Rotas protegidas por middleware de autenticação
    Route::middleware(['auth:api'])->group(function () {
        Route::post('/cadastro', UsuarioLeituraCadastrarController::class)->name(name: 'cadastro');
    });
});

Route::prefix('generos')->name('generos.')->group(function () {
    // Rotas públicas
    // Rotas protegidas por middleware de autenticação
    Route::middleware(['auth:api'])->group(function () {
        Route::get('/', PesquisarGenerosController::class)->name(name: 'pesquisar');
    });
});

Route::prefix('autores')->name('autores.')->group(function () {
    // Rotas públicas
    // Rotas protegidas por middleware de autenticação
    Route::middleware(['auth:api'])->group(function () {
        Route::get('/', PesquisarAutorController::class)->name(name: 'pesquisar');
    });
});

Route::prefix('status')->name('status-leituras.')->group(function () {
    // Rotas públicas
    // Rotas protegidas por middleware de autenticação
    Route::middleware(['auth:api'])->group(function () {
        Route::get('/leituras', PesquisarStatusLeituraController::class)->name(name: 'pesquisar');
    });
});

Route::prefix('editoras')->name('editoras.')->group(function () {
    // Rotas públicas
    // Rotas protegidas por middleware de autenticação
    Route::middleware(['auth:api'])->group(function () {
        Route::get('/', PesquisarEditoraController::class)->name(name: 'pesquisar');
    });
});
