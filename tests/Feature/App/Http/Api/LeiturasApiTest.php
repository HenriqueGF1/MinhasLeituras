<?php

namespace Tests\Feature\App\Http\Api;

use App\Models\User;
use Tests\TestCase;

class LeiturasApiTest extends TestCase
{
    // php artisan test --filter=LeiturasApiTest::test_feature_nao_permite_cadastro_sem_titulo
    public function test_feature_nao_permite_cadastro_sem_titulo()
    {
        // GIVEN: Preparação do teste - gerando o token JWT para autenticação
        $headers = [
            'Authorization' => 'Bearer ' . auth('api')->fromUser(User::where('id_usuario', User::USUARIO_TESTE)->first()), // Gera o token JWT para o usuário de teste
            'Accept' => 'application/json', // Define que a resposta esperada será em formato JSON
        ];

        // GIVEN: Dados de entrada para o cadastro
        $payload = [
            'titulo' => '', // Passa um título vazio para testar a validação do campo
        ];

        // WHEN: Ação - fazendo a requisição POST para cadastrar a leitura
        $response = $this->postJson('/api/leituras/cadastrar', $payload, $headers); // Realiza a requisição com os dados e cabeçalhos acima

        // THEN: Verificação - checa se a resposta tem o status de erro de validação 422
        // Verifica se o campo 'titulo' foi validado e retornou um erro (validação falhou porque o título está vazio)
        $response->assertStatus(422) // Verifica se o status da resposta é 422 (erro de validação)
            ->assertJsonValidationErrors('titulo'); // Verifica se o campo 'titulo' está com erro de validação no JSON retornado
    }
}
