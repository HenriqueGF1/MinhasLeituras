<?php

use App\Http\DTO\LeituraProgresso\LeituraProgressoCadastroDTO;
use App\Http\Services\Leituras\LeituraProgresso\LeituraProgressoCadastro;
use App\Models\LeituraProgresso;
use App\Models\Leituras;
use Tests\TestCase;

class LeituraProgressoCadastroTest extends TestCase
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

    public function test_cadastro_de_progresso_de_leitura(): void
    {
        // ARRANGE
        $dadosLeituraProgresso = [
            'id_leitura_progresso' => 1,
            'id_usuario' => 15,
            'id_leitura' => 13,
            'qtd_paginas_lidas' => 14,
            'data_leitura' => now(),
        ];

        $dtoLeituraProgressoCadastroDTO = new LeituraProgressoCadastroDTO($dadosLeituraProgresso);

        $this->leituraProgressoMock
            ->expects('create')
            ->once()
            ->with($dtoLeituraProgressoCadastroDTO->toArray())
            ->andReturn(new LeituraProgresso([
                'id_leitura_progresso' => 84,
                'id_usuario' => $dadosLeituraProgresso['id_usuario'],
                'id_leitura' => $dadosLeituraProgresso['id_leitura'],
                'qtd_paginas_lidas' => $dadosLeituraProgresso['qtd_paginas_lidas'],
                'data_leitura' => $dadosLeituraProgresso['data_leitura'],
            ]));

        DB::expects('beginTransaction')->once();
        DB::expects('commit')->once();
        DB::expects('rollBack')->never();

        $leituraProgressoCadastroService = new LeituraProgressoCadastro($this->leituraProgressoMock, new Leituras);

        // ACT
        $resultadoCadastrar = $leituraProgressoCadastroService->cadastrarProgresso($dtoLeituraProgressoCadastroDTO);

        $this->assertInstanceOf(LeituraProgresso::class, $resultadoCadastrar);
        $this->assertSame(84, $resultadoCadastrar->id_leitura_progresso);
        $this->assertEquals($dadosLeituraProgresso['id_leitura'], $resultadoCadastrar->id_leitura);
        $this->assertEquals($dadosLeituraProgresso['id_usuario'], $resultadoCadastrar->id_usuario);
        $this->assertEquals($dadosLeituraProgresso['qtd_paginas_lidas'], $resultadoCadastrar->qtd_paginas_lidas);
        $this->assertEquals($dadosLeituraProgresso['data_leitura'], $resultadoCadastrar->data_leitura);
    }

    public function test_deve_lancar_excecao_para_data_leitura_invalida(): void
    {
        // ASSERT
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Data inválida');

        // ARRANGE
        $dadosLeituraProgresso = [
            'id_usuario' => 15,
            'id_leitura' => 13,
            'qtd_paginas_lidas' => 10,
            'data_leitura' => 'data-nao-valida', // inválida
        ];

        // ACT
        new LeituraProgressoCadastroDTO($dadosLeituraProgresso);
    }

    public function test_cadastro_de_progresso_de_leitura_data_antes_de_hoje(): void
    {
        // ARRANGE
        $dadosLeituraProgresso = [
            'id_leitura_progresso' => 1,
            'id_usuario' => 15,
            'id_leitura' => 13,
            'qtd_paginas_lidas' => 14,
            'data_leitura' => now()->subDay(),
        ];

        // ASERT
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('A data da leitura não pode ser anterior a hoje.');

        // ACT
        new LeituraProgressoCadastroDTO($dadosLeituraProgresso);
    }
}
