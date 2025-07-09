<?php

namespace Tests\Unit\Service\Autor;

use App\Http\DTO\Autor\AutorPesquisaDTO;
use App\Http\Services\Autor\AutorPesquisa;
use App\Models\Autor;
use Illuminate\Database\Eloquent\Builder;
use Mockery;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class AutorPesquisaTest extends TestCase
{
    // Propriedade para armazenar o mock do model Autor
    private Autor $autorModelMock;

    // Método executado antes de cada teste
    protected function setUp(): void
    {
        parent::setUp();  // Chama o setup da classe pai (TestCase)

        // Cria um mock da classe Autor usando Mockery
        $this->autorModelMock = Mockery::mock(Autor::class);
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        Mockery::close();
    }

    #[Test]
    public function pesquisar_autor_com_id_autor(): void
    {
        // ARRANGE
        $dadosAutor = [
            'id_autor' => 1,
            'nome_autor' => null,
        ];

        $this->autorModelMock
            ->expects('find')
            ->once()
            ->with($dadosAutor['id_autor'])
            ->andReturn(new Autor([
                'id_autor' => $dadosAutor['id_autor'],
                'nome' => $dadosAutor['nome_autor'],
            ]));

        $autorDto = new AutorPesquisaDTO($dadosAutor);
        $serviceAutorPesquisa = new AutorPesquisa($this->autorModelMock);

        // ACT
        $resultadoPesquisa = $serviceAutorPesquisa->pesquisaAutor($autorDto);

        // ASSERT
        $this->assertInstanceOf(Autor::class, $resultadoPesquisa);
        $this->assertEquals($dadosAutor['id_autor'], $resultadoPesquisa->id_autor);
    }

    #[Test]
    public function pesquisar_autor_com_nome(): void
    {
        // ARRANGE
        $dadosAutor = [
            'id_autor' => null,
            'nome_autor' => 'Autor 01',
        ];

        $autorDto = new AutorPesquisaDTO($dadosAutor);

        // Cria autor com ID válido
        $autorRetorno = new Autor([
            'id_autor' => 1,
            'nome' => 'Autor 01',
        ]);

        // Cria um mock da classe Builder do Eloquent
        // Isso permite simular consultas como where(), first(), etc., sem acessar o banco de dados real.
        $queryMock = Mockery::mock(Builder::class);

        // Configura cadeia de métodos
        $this->autorModelMock
            ->shouldReceive('where')
            ->once()
            ->with(
                'nome',
                'LIKE',
                '%' . $dadosAutor['nome_autor'] . '%'
            )
            ->andReturn($queryMock);

        $queryMock
            ->shouldReceive('first')
            ->once()
            ->andReturn($autorRetorno);

        // ACT
        $serviceAutorPesquisa = new AutorPesquisa($this->autorModelMock);
        $resultadoPesquisa = $serviceAutorPesquisa->pesquisaAutor($autorDto);

        // ASSERT
        $this->assertInstanceOf(Autor::class, $resultadoPesquisa);
        $this->assertEquals($dadosAutor['nome_autor'], $resultadoPesquisa->nome);
    }

    #[Test]
    public function pesquisar_autor_sem_dto_auto_id_e_nome(): void
    {
        // ARRANGE
        $dadosAutor = [
            'id_autor' => null,
            'nome_autor' => null,
        ];

        //   ASSERT
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('É necessário informar id ou nome autor.');

        $autorDto = new AutorPesquisaDTO($dadosAutor);

        // ACT
        $serviceAutorPesquisa = new AutorPesquisa($this->autorModelMock);
        $resultadoPesquisa = $serviceAutorPesquisa->pesquisaAutor($autorDto);

        // ASSERT
        $this->assertNull($resultadoPesquisa);
    }
}
