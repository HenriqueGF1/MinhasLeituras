<?php

declare(strict_types=1);

use App\Models\Autor;
use App\Models\Editora;
use App\Models\Leituras;
use App\Models\User;
use App\Models\UsuarioLeitura;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class UsuarioLeituraExcluirTest extends TestCase
{
    private User $usuario;

    private $token;

    protected function setUp(): void
    {
        parent::setUp();
        $this->usuario = User::find(1);
        $this->token = JWTAuth::fromUser($this->usuario);
    }

    // Método executado após cada teste
    protected function tearDown(): void
    {
        // Lista das tabelas a preservar
        $tabelasParaIgnorar = ['usuario', 'genero', 'status_leitura'];

        // Lista das tabelas conforme seu script
        $tabelas = [
            'avaliacao_leitura',
            'leitura_progresso',
            'genero_leitura',
            'usuario_leituras',
            'leituras',
            'autor',
            'editora',
            // 'usuario', // Ignorada
            // 'status_leitura', // Ignorada
            // 'genero', // Ignorada
        ];

        foreach ($tabelas as $tabela) {
            if (! in_array($tabela, $tabelasParaIgnorar)) {
                DB::table($tabela)->truncate();
            }
        }

        parent::tearDown();
    }

    public function test_cadastro_leitura_usuario_excluir(): void
    {
        // ARRANGE
        // Criar autor e editora
        $autor = Autor::create(['nome' => 'Autor TESTE']);
        $editora = Editora::create(['descricao' => 'Editora TESTE']);

        // Criar leitura
        $leitura = Leituras::create([
            'titulo' => 'O Hobbit',
            'descricao' => 'Escrito por J.R.R. Tolkien, "O Hobbit" é uma clássica aventura de fantasia que acompanha Bilbo Bolseiro em uma jornada inesperada ao lado de anões para recuperar um tesouro guardado por um dragão chamado Smaug.',
            'capa' => 'https://upload.wikimedia.org/wikipedia/pt/0/0e/O_Hobbit_-_Capa.png',
            'id_editora' => $editora->id_editora,
            'id_autor' => $autor->id_autor,
            'data_publicacao' => '1937-09-21',
            'qtd_capitulos' => 19,
            'qtd_paginas' => 320,
            'isbn' => '9780547928227',
            'data_registro' => now(),
            'id_usuario' => 1,
            'id_status_leitura' => 1,
        ]);

        $leituraUsuario = UsuarioLeitura::create([
            'id_usuario' => 1,
            'id_leitura' => $leitura->id_leitura,
            'id_status_leitura' => 1,
            'data_registro' => now(),
        ]);

        $usuarioLeitura = UsuarioLeitura::find($leituraUsuario->id_usuario_leitura)->first();

        $dadosUsuarioLeitura = [
            'id_usuario_leitura' => $usuarioLeitura->id_usuario_leitura,
        ];

        $response = $this->withHeaders([
            'Authorization' => "Bearer {$this->token}",
        ])->deleteJson(
            "/api/leituras/excluir/{$dadosUsuarioLeitura['id_usuario_leitura']}"
        );

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'success' => true,
            'message' => 'Leitura Excluida com sucesso',
            'data' => [],
        ]);
        $this->assertDatabaseMissing('usuario_leituras', [
            'id_usuario_leitura' => $dadosUsuarioLeitura['id_usuario_leitura'],
        ]);
    }

    public function test_cadastro_leitura_validacao_leitura_usuario_excluir(): void
    {
        $dadosUsuarioLeitura = [
            'id_usuario_leitura' => 75,
        ];

        $response = $this->withHeaders([
            'Authorization' => "Bearer {$this->token}",
        ])->deleteJson(
            "/api/leituras/excluir/{$dadosUsuarioLeitura['id_usuario_leitura']}"
        );

        $response
            ->assertStatus(422)
            ->assertJson(
                fn (AssertableJson $json) => $json->has('errors.id_usuario_leitura')
                    ->etc()
            );

        $this->assertDatabaseMissing('usuario_leituras', [
            'id_usuario_leitura' => $dadosUsuarioLeitura['id_usuario_leitura'],
        ]);
    }
}
