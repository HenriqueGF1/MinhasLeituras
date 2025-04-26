<?php

namespace Tests\Unit\App\Http\Controllers;

use App\Http\Controllers\LeiturasController;
use App\Http\Requests\LeiturasRequest;

use App\Http\Services\Leituras\LeiturasService;
use Illuminate\Http\JsonResponse;
use Mockery;
use Tests\TestCase;

class LeiturasControllerUnitTest extends TestCase
{
    // php artisan test --filter=LeiturasControllerUnitTest::test_unit_controller_store_leitura
    public function test_unit_controller_store_leitura()
    {
        // GIVEN: Dados simulados para criar uma nova leitura
        $dados = [
            'id_leitura' => 1, // ID da leitura simulada
            'titulo' => 'O Senhor dos Anéis: A Sociedade do Anel', // Título do livro
            'descricao' => 'Primeiro volume da épica trilogia de J.R.R. Tolkien...', // Descrição
            'capa' => 'https://upload.wikimedia.org/wikipedia/pt/0/06/The_Fellowship_of_the_Ring_cover.gif', // URL da capa
            'id_editora' => 10, // ID simulado da editora
            'id_autor' => 5,    // ID simulado do autor
            'data_publicacao' => '1954-07-29', // Data de publicação
            'qtd_capitulos' => 22, // Quantidade de capítulos
            'qtd_paginas' => 576,  // Número de páginas
            'isbn' => '978-85-333-0227-0', // ISBN do livro
            'data_registro' => '1954-07-29', // Data de registro
        ];

        // GIVEN: Cria um objeto simulando o que o service retornaria
        $leituraMock = (object) $dados;

        // GIVEN: Mock do serviço LeiturasService simulando o comportamento do método cadastrarLeitura
        $serviceMock = Mockery::mock(LeiturasService::class)
            ->shouldReceive('cadastrarLeitura') // Simula o método cadastrarLeitura
            ->once() // Deve ser chamado apenas uma vez
            ->with($dados) // Deve ser chamado com os dados simulados
            ->andReturn($leituraMock) // Retorna o objeto simulado
            ->getMock();

        // GIVEN: Cria a instância do controller com o service mockado
        $controller = new LeiturasController($serviceMock);

        // GIVEN: Mocka a request que será enviada para o controller
        $requestMock = Mockery::mock(LeiturasRequest::class);
        $requestMock->shouldReceive('safe')->andReturnSelf(); // Mock do método safe()
        $requestMock->shouldReceive('all')->andReturn($dados); // Mock do método all() para retornar os dados simulados

        // WHEN: Executa o método store passando a request mockada
        $response = $controller->store($requestMock);

        // THEN: Verifica se o retorno é um JsonResponse
        $this->assertInstanceOf(JsonResponse::class, $response);

        // THEN: Verifica se o status HTTP da resposta é 200
        $this->assertEquals(200, $response->getStatusCode());

        // THEN: Verifica o conteúdo da resposta
        $content = json_decode($response->getContent(), true); // Decodifica o JSON retornado

        $this->assertTrue($content['success']); // Verifica se success é true
        $this->assertEquals('Leitura cadastrada com sucesso', $content['message']); // Verifica a mensagem de sucesso
        $this->assertIsArray($content['data']); // Verifica se data é um array
    }
}
