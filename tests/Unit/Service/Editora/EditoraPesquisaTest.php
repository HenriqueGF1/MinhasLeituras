<?php

namespace Tests\Unit\Service\Editora;

use App\Http\DTO\Editora\EditoraPesquisaDTO;
use App\Http\Services\Editora\EditoraPesquisa;
use App\Models\Editora;
use Mockery;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class EditoraPesquisaTest extends TestCase
{
    private Editora $editoraModelMock;

    protected function setUp(): void
    {
        parent::setUp();

        $this->editoraModelMock = Mockery::mock(Editora::class);
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        Mockery::close();
    }

    #[Test]
    public function test_pesquisar_editora_com_id_editora()
    {
        // ARRANGE
        $dadosEditora = [
            'id_editora' => 1,
            'descricao_editora' => null,
        ];

        $editoraPesquisaDto = new EditoraPesquisaDTO($dadosEditora);

        $this->editoraModelMock
            ->shouldReceive('find')
            ->once()
            ->with($dadosEditora['id_editora'])
            ->andReturn(new Editora(
                [
                    'id_editora' => $dadosEditora['id_editora'],
                    'descricao' => $dadosEditora['descricao_editora'],
                ]
            ));

        // ACT
        $editoraPesquisaService = new EditoraPesquisa($this->editoraModelMock);
        $resultadoPesquisa = $editoraPesquisaService->pesquisaEditora($editoraPesquisaDto);

        // ASSERT
        $this->assertInstanceOf(Editora::class, $resultadoPesquisa);
        $this->assertEquals($dadosEditora['id_editora'], $resultadoPesquisa->id_editora);
    }

    #[Test]
    public function test_pesquisar_editora_com_descricao_editora()
    {
        // ARRANGE
        $dadosEditora = [
            'id_editora' => null,
            'descricao_editora' => 'Minha Editora',
        ];

        $editoraPesquisaDto = new EditoraPesquisaDTO($dadosEditora);

        // Cria um mock da classe Builder do Eloquent
        // Isso permite simular consultas como where(), first(), etc., sem acessar o banco de dados real.
        $queryMock = Mockery::mock(Builder::class);

        $this->editoraModelMock
            ->shouldReceive('where')
            ->once()
            ->with(
                'descricao',
                'LIKE',
                '%' . $dadosEditora['descricao_editora'] . '%'
            )
            ->andReturn($queryMock);

        $queryMock
            ->shouldReceive('first')
            ->once()
            ->andReturn(new Editora(
                [
                    'id_editora' => $dadosEditora['id_editora'],
                    'descricao' => $dadosEditora['descricao_editora'],
                ]
            ));

        // ACT
        $editoraPesquisaService = new EditoraPesquisa($this->editoraModelMock);
        $resultadoPesquisa = $editoraPesquisaService->pesquisaEditora($editoraPesquisaDto);

        // ASSERT
        $this->assertInstanceOf(Editora::class, $resultadoPesquisa);
        $this->assertEquals($dadosEditora['descricao_editora'], $resultadoPesquisa->descricao);
    }

    #[Test]
    public function test_pesquisar_editora_sem_descricao_e_id_editora()
    {
        // ARRANGE
        $dadosEditora = [
            'id_editora' => null,
            'descricao_editora' => null,
        ];

        // ASSERT
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('É necessário informar id editora ou descricao editora.');

        // ARRANGE
        $editoraPesquisaDto = new EditoraPesquisaDTO($dadosEditora);

        // ACT
        $editoraPesquisaService = new EditoraPesquisa($this->editoraModelMock);
        $editoraPesquisaService->pesquisaEditora($editoraPesquisaDto);
    }
}
