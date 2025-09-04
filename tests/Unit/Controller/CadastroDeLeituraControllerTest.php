<?php

namespace Tests\Unit\Controller;

use App\Http\Controllers\Leituras\CadastroDeLeituraController; // Controller que será testada
use App\Http\DTO\Leitura\CadastroLeituraDto; // DTO usado para transferência de dados
use App\Http\Facades\Leitura\CadastramentoDeLeituraFacade; // Facade do serviço de cadastro de leitura
use App\Http\Requests\Leitura\LeiturasRequest; // FormRequest da leitura
use App\Models\Leituras; // Modelo Eloquent de leituras
use Illuminate\Http\JsonResponse; // Classe de resposta JSON
use Mockery; // Biblioteca para criação de mocks
use PHPUnit\Framework\Attributes\Test; // Atributo para marcar testes
use Tests\TestCase; // Classe base de testes do Laravel

class CadastroDeLeituraControllerTest extends TestCase
{
    // Executado após cada teste
    protected function tearDown(): void
    {
        Mockery::close(); // Fecha todos os mocks do Mockery para evitar conflitos
        parent::tearDown(); // Chama o teardown da classe base
    }

    #[Test] // Marca o método como teste
    public function deve_cadastrar_uma_leitura_e_retornar_resposta_de_sucesso()
    {
        // ARRANGE: dados simulados da requisição que seriam enviados pelo usuário
        $dadosRequisicao = [
            'titulo' => 'O Pequeno Príncipe',
            'descricao' => 'Escrito por Antoine de Saint-Exupéry...',
            'capa' => 'https://m.media-amazon.com/images/I/81a4kCNuH+L.jpg',
            'id_editora' => 1,
            'id_autor' => 1,
            'data_publicacao' => '1943-04-06',
            'qtd_capitulos' => 27,
            'qtd_paginas' => 96,
            'isbn' => '9780156012195',
            'data_registro' => '1943-04-06',
            'id_status_leitura' => 1,
            'id_genero' => [1, 3, 6],
            'id_usuario' => 1,
        ];

        // Cria uma instância real do modelo Leituras com os dados simulados
        $leitura = new Leituras($dadosRequisicao);

        // CRIAÇÃO DE MOCKS

        // Mock da Facade do serviço de cadastro
        $servicoMock = Mockery::mock(CadastramentoDeLeituraFacade::class);
        $servicoMock->shouldReceive('processoDeCadastroDeLeitura') // Espera que o método processoDeCadastroDeLeitura seja chamado
            ->once() // Deve ser chamado exatamente 1 vez
            ->with(Mockery::type(CadastroLeituraDto::class)) // Com um argumento do tipo CadastroLeituraDto
            ->andReturn($leitura); // Retorna o modelo de leitura criado

        // Mock do FormRequest (simula a requisição validada)
        $requisicaoMock = Mockery::mock(LeiturasRequest::class);
        $requisicaoMock->shouldReceive('validated') // Espera que validated() seja chamado
            ->once() // Deve ser chamado exatamente 1 vez
            ->andReturn($dadosRequisicao); // Retorna os dados simulados

        // Controller a ser testada, injetando o mock da Facade
        $controller = new CadastroDeLeituraController($servicoMock);

        // ACT: execução do método __invoke da controller
        $resposta = $controller($requisicaoMock);

        // ASSERT: validação do resultado

        $this->assertInstanceOf(JsonResponse::class, $resposta); // Verifica se a resposta é um JsonResponse
        $this->assertEquals(201, $resposta->getStatusCode()); // Verifica se o status HTTP é 201 (criado)

        // Converte o conteúdo da resposta JSON para array associativo
        $conteudoResposta = $resposta->getData(true);
        $this->assertArrayHasKey('data', $conteudoResposta); // Verifica se existe a chave 'data'
        $this->assertEquals('Leitura cadastrada com sucesso', $conteudoResposta['message']); // Verifica a mensagem de sucesso
    }
}
