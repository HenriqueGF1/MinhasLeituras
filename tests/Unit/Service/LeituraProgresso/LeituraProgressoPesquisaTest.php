<?php

use App\Http\DTO\LeituraProgresso\LeituraProgressoPesquisaDTO;
use App\Http\Services\Leituras\LeituraProgresso\LeituraProgressoPesquisa;
use App\Models\LeituraProgresso;
use Tests\TestCase;

class LeituraProgressoPesquisaTest extends TestCase
{
    private LeituraProgresso $leituraProgressoMock;

    protected function setUp(): void
    {
        parent::setUp();
        $this->leituraProgressoMock = Mockery::mock(LeituraProgresso::class);
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        Mockery::close();
    }

    public function test_pesquisa_de_progresso_de_leitura(): void
    {
        $dados = ['id_usuario' => 15, 'id_leitura' => 13];
        $dto = new LeituraProgressoPesquisaDTO($dados);

        $registro = new LeituraProgresso([
            'id_leitura_progresso' => 1,
            'id_usuario' => 15,
            'id_leitura' => 13,
            'qtd_paginas_lidas' => 14,
            'data_leitura' => now(),
        ]);

        $queryMock = Mockery::mock(Builder::class);

        $this->leituraProgressoMock
            ->shouldReceive('where')
            ->once()
            ->with([ // exatamente o mesmo array de filtros
                ['id_usuario', '=', $dados['id_usuario']],
                ['id_leitura', '=', $dados['id_leitura']],
            ])
            ->andReturn($queryMock);

        $queryMock
            ->shouldReceive('first')
            ->once()
            ->andReturn($registro);

        $service = new LeituraProgressoPesquisa($this->leituraProgressoMock);

        $resultado = $service->pesquisarProgresso($dto);

        $this->assertInstanceOf(LeituraProgresso::class, $resultado);
        $this->assertEquals(
            $registro->id_leitura_progresso,
            $resultado->id_leitura_progresso
        );
    }
}
