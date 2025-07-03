<?php

namespace Tests\Unit\App\Controller;

use App\Http\Controllers\Leituras\CadastroDeLeituraController;
use App\Http\Requests\LeiturasRequest;
use App\Http\Services\Leituras\CadastroDeLeituraService;
use App\Models\Leituras;
use Illuminate\Http\JsonResponse;
use Mockery;
use Tests\TestCase;

class CadastroDeLeituraControllerTest extends TestCase
{
    // php artisan test --filter=CadastroDeLeituraControllerTest::deve_cadastrar_uma_leitura_e_retornar_resposta_de_sucesso
    /** @test */
    public function deve_cadastrar_uma_leitura_e_retornar_resposta_de_sucesso()
    {
        // GIVEN: Dados de entrada simulados
        $dadosRequisicao = [
            'titulo' => 'O Hobbit',
            'descricao' => 'O Hobbit é uma obra clássica de fantasia...',
            'capa' => 'https://upload.wikimedia.org/wikipedia/pt/2/29/Capa_O_Hobbit.jpg',
            'descricao_editora' => 'Minha editora 02',
            'id_autor' => 1,
            'data_publicacao' => '1937-09-21',
            'qtd_capitulos' => 19,
            'qtd_paginas' => 310,
            'isbn' => '9788595084724',
            'data_registro' => '1937-09-21',
            'id_usuario' => 1,
            'id_status_leitura' => 1,
            'id_genero' => [8, 9],
        ];

        // Cria uma instância real do modelo Leitura com os dados simulados
        $leitura = new Leituras($dadosRequisicao);

        // Cria um mock do serviço de cadastro de leitura
        $servicoMock = Mockery::mock(CadastroDeLeituraService::class);
        $servicoMock->shouldReceive('cadastroDeLeitura')
            ->once()
            ->with($dadosRequisicao)
            ->andReturn($leitura);

        // Cria um mock da requisição validada
        $requisicaoMock = Mockery::mock(LeiturasRequest::class);
        $requisicaoMock->shouldReceive('safe->all')
            ->andReturn($dadosRequisicao);

        // Instancia a controller com o serviço mockado
        $controller = new CadastroDeLeituraController($servicoMock);

        // WHEN: Executa o método __invoke da controller
        $resposta = $controller->__invoke($requisicaoMock);

        // THEN: Verifica se a resposta é uma instância de JsonResponse
        $this->assertInstanceOf(JsonResponse::class, $resposta);
        $this->assertEquals(200, $resposta->getStatusCode());

        // Converte a resposta para um array associativo
        $conteudoResposta = $resposta->getData(true);

        // Verifica se a chave 'data' está presente na resposta
        $this->assertArrayHasKey('data', $conteudoResposta);

        // Verifica se a mensagem de sucesso está correta
        $this->assertEquals('Leitura cadastrada com sucesso', $conteudoResposta['message']);
    }
}
