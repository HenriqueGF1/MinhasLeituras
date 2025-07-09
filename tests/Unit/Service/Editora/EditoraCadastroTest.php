<?php

namespace Tests\Unit\Service\Editora;

use App\Http\DTO\Editora\EditoraCadastroDTO;
use App\Http\Services\Editora\EditoraCadastro;
use App\Models\Editora;
use Mockery;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class EditoraCadastroTest extends TestCase
{
    private Editora $editoraCadastroModelMock;

    protected function setUp(): void
    {
        parent::setUp();

        $this->editoraCadastroModelMock = Mockery::mock(Editora::class);
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        Mockery::close();
    }

    #[Test]
    public function test_cadastrar_editora_com_sucesso()
    {
        // ARRANGE
        $dadosEditora = [
            'descricao_editora' => 'Minha Editora',
        ];

        $editoraCadastroDTO = new EditoraCadastroDTO($dadosEditora);

        $this->editoraCadastroModelMock
            ->expects('create')
            ->once()
            ->with([
                'descricao' => $dadosEditora['descricao_editora'],
            ])
            ->andReturn(new Editora(
                [
                    'id_editora' => 87,
                    'descricao' => $dadosEditora['descricao_editora'],
                ]
            ));

        // ACT
        $editoraEditoraCadastro = new EditoraCadastro($this->editoraCadastroModelMock);
        $resultadoCadastro = $editoraEditoraCadastro->cadastrarEditora($editoraCadastroDTO);

        // ASSERT
        $this->assertInstanceOf(Editora::class, $resultadoCadastro);
        $this->assertEquals(87, $resultadoCadastro->id_editora);
        $this->assertEquals($dadosEditora['descricao_editora'], $resultadoCadastro->descricao);
    }

    #[Test]
    public function test_cadastrar_editora_sem_dados_essenciais()
    {
        // ARRANGE
        $dadosEditora = [
            'descricao_editora' => '',
        ];

        // ASSERT
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('É necessário informar descrição da editora.');

        // ARRANGE
        $editoraCadastroDTO = new EditoraCadastroDTO($dadosEditora);

        // ACT
        $editoraEditoraCadastro = new EditoraCadastro($this->editoraCadastroModelMock);
        $editoraEditoraCadastro->cadastrarEditora($editoraCadastroDTO);
    }
}
