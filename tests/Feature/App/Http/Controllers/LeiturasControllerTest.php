<?php

namespace Tests\Feature\App\Http\Controllers;

use App\Models\User;
use Tests\TestCase;

class LeiturasControllerTest extends TestCase
{
    // php artisan test --filter=LeiturasControllerTest::test_feature_controller_store_leitura
    public function test_feature_controller_store_leitura()
    {
        // GIVEN: Preparação do teste - gerando o token JWT para autenticação
        $headers = [
            'Authorization' => 'Bearer ' . auth('api')->fromUser(User::where('id_usuario', User::USUARIO_TESTE)->first()), // Gera o token JWT para o usuário de teste
            'Accept' => 'application/json', // Define que a resposta esperada será em formato JSON
        ];

        // GIVEN: Dados de entrada para o cadastro da leitura
        $dados = [
            'titulo' => 'O Hobbit', // Título do livro
            'descricao' => 'O Hobbit é uma obra clássica de fantasia escrita por J.R.R. Tolkien...', // Descrição do livro
            'capa' => 'https://upload.wikimedia.org/wikipedia/pt/2/29/Capa_O_Hobbit.jpg', // URL da capa do livro
            'id_editora' => 1, // ID da editora
            'id_autor' => 1, // ID do autor
            'data_publicacao' => '1937-09-21', // Data de publicação
            'qtd_capitulos' => 19, // Quantidade de capítulos
            'qtd_paginas' => 310, // Quantidade de páginas
            'isbn' => '9788595084727', // ISBN do livro
            'data_registro' => '1937-09-21', // Data de registro do livro
            'id_usuario' => User::USUARIO_TESTE, // ID do usuário que está cadastrando
            'id_status_leitura' => 1, // ID do status da leitura
            'id_genero' => [8, 9], // IDs dos gêneros literários
        ];

        // WHEN: Ação - Fazendo a requisição POST para cadastrar a leitura
        $response = $this->postJson('/api/leituras/cadastrar', $dados, $headers); // Envia os dados para a API

        // THEN: Verificação - Checa se a resposta tem o status 200 (OK)
        $response->assertStatus(200); // Verifica se o status da resposta é 200 (sucesso)

        // THEN: Verificação - Checa se a resposta contém sucesso e a mensagem correta
        $response->assertJson([
            'success' => true, // Verifica se o campo success é verdadeiro
            'message' => 'Leitura cadastrada com sucesso', // Verifica a mensagem retornada
            'data' => [
                'titulo' => 'O Hobbit', // Verifica se o título retornado é o mesmo
                'isbn' => '9788595084727', // Verifica se o ISBN retornado é o mesmo
            ],
        ]);
    }
}
