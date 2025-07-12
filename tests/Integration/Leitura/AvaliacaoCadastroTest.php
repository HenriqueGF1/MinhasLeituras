<?php

declare(strict_types=1);

use Tests\TestCase;
use App\Models\User;
use App\Models\Autor;
use App\Models\Editora;
use App\Models\Leituras;
use App\Models\AvaliacaoLeitura;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AvaliacaoCadastroTest extends TestCase
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
        parent::tearDown();
    }

    public function test_cadastro_avaliacao_leitura(): void
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

        // Dados de avaliação
        $dadosAvaliacaoLeitura = [
            'id_leitura' => $leitura->id_leitura,
            'id_usuario' => 1,
            'nota' => 9,
            'descricao_avaliacao' => 'Uma história envolvente com ótimos personagens e ritmo excelente.',
            'data_inicio' => '2025-07-01',
            'data_termino' => '2025-07-11',
        ];

        // ACT
        $response = $this->withHeaders([
            'Authorization' => "Bearer {$this->token}",
        ])->post('api/leituras/avaliar', $dadosAvaliacaoLeitura);

        // ASSERT
        $response->assertStatus(200);
        $response->assertJsonFragment([
            'id_leitura' => $leitura->id_leitura,
            'nota' => 9,
        ]);

        $this->assertDatabaseHas('avaliacao_leitura', [
            'id_leitura' => $leitura->id_leitura,
            'nota' => 9,
            'id_usuario' => 1,
        ]);

        // // Apagar Registros
        // Autor::destroy($autor->id_autor);
        // Editora::destroy($editora->id_editora);
        // Leituras::destroy($leitura->id_leitura);
        // AvaliacaoLeitura::query()->delete();
    }
}
