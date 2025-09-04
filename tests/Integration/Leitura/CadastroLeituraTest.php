<?php

declare(strict_types=1);

use App\Models\User;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class CadastroLeituraTest extends TestCase
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

    public function test_cadastro_leitura(): void
    {
        $dadosLivro = [
            'titulo' => 'Percy Jackson e o Ladrão de Raios',
            'descricao' => 'Escrito por Rick Riordan, este é o primeiro livro da série Percy Jackson e os Olimpianos. A história segue Percy, um garoto que descobre ser um semideus, filho de Poseidon, e embarca em uma missão para recuperar o raio mestre de Zeus e evitar uma guerra entre os deuses do Olimpo.',
            'capa' => 'https://upload.wikimedia.org/wikipedia/pt/4/4b/Percy_Jackson_Ladrao_de_Raios_capa.jpg',
            // 'id_editora' => 1,
            'descricao_editora' => 'Intrínseca',
            // 'id_autor' => 1,
            'nome_autor' => 'Rick Riordan',
            'data_publicacao' => '2005-06-28',
            'qtd_capitulos' => 22,
            'qtd_paginas' => 400,
            'isbn' => '9788598078394',
            'data_registro' => '2005-06-28',
            'id_usuario' => 1,
            'id_status_leitura' => 1,
            'id_genero' => [8, 9],
        ];

        $response = $this->withHeaders([
            'Authorization' => "Bearer {$this->token}",
        ])->postJson('api/leituras', $dadosLivro);

        $response->assertStatus(201);
        $response->assertJsonFragment([
            'titulo' => 'Percy Jackson e o Ladrão de Raios',
            'isbn' => '9788598078394',
        ]);
        $this->assertDatabaseHas('leituras', [
            'titulo' => 'Percy Jackson e o Ladrão de Raios',
            'isbn' => '9788598078394',
        ]);
    }

    public function test_cadastro_leitura_validacao(): void
    {
        $dadosLivro = [
            'titulo' => '',
            'descricao' => '',
        ];

        $response = $this->withHeaders([
            'Authorization' => "Bearer {$this->token}",
        ])->postJson('api/leituras', $dadosLivro);

        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                'titulo',
                'descricao',
            ])
            ->assertJsonFragment([
                'titulo' => ['O título é obrigatório.'],
            ])
            ->assertJsonFragment([
                'descricao' => ['A descrição é obrigatória.'],
            ]);

        $this->assertDatabaseMissing('leituras', [
            'descricao' => '',
            'titulo' => '',
        ]);
    }
}
