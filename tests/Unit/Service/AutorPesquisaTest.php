<?php

namespace Tests\Unit\Service;

use App\Http\DTO\Autor\AutorPesquisaDTO;
use App\Http\Services\Autor\AutorPesquisa;
use App\Models\Autor;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class AutorPesquisaTest extends TestCase
{
    private AutorPesquisa&MockObject $autorPesquisa;

    protected function setUp(): void
    {
        parent::setUp();

        // Use createMock para criar um mock configurável
        $this->autorPesquisa = $this->createMock(AutorPesquisa::class);
    }

    #[Test]
    public function pesquisar_autor_com_id_autor(): void
    {
        // ARRANGE
        $dadosAutor = [
            'id_autor' => 1,
            'nome' => 'Autor 01',
        ];

        $autorDto = new AutorPesquisaDTO($dadosAutor);
        $autorEsperado = new Autor($dadosAutor);

        // Configuração do mock: espera que pesquisaAutor seja chamado uma vez com $autorDto
        $this->autorPesquisa
            ->expects($this->once())
            ->method('pesquisaAutor')
            ->with($autorDto)
            ->willReturn($autorEsperado);

        // ACT
        $resultado = $this->autorPesquisa->pesquisaAutor($autorDto);

        // ASSERT
        $this->assertInstanceOf(Autor::class, $resultado);
        $this->assertEquals(1, $resultado->id_autor);
    }

    #[Test]
    public function pesquisar_autor_com_nome(): void
    {
        // ARRANGE
        $dadosAutor = [
            'id_autor' => 1,
            'nome' => 'Autor 01',
        ];

        $autorDto = new AutorPesquisaDTO($dadosAutor);
        $autorEsperado = new Autor($dadosAutor);

        // Configuração do mock: espera que pesquisaAutor seja chamado uma vez com $autorDto
        $this->autorPesquisa
            ->expects($this->once())
            ->method('pesquisaAutor')
            ->with($autorDto)
            ->willReturn($autorEsperado);

        // ACT
        $resultado = $this->autorPesquisa->pesquisaAutor($autorDto);

        // ASSERT
        $this->assertInstanceOf(Autor::class, $resultado);
        $this->assertEquals($dadosAutor['nome'], $resultado->nome);
    }

    #[Test]
    public function pesquisar_autor_sem_dto_auto_id_e__nome(): void
    {
        // ARRANGE
        $dadosAutor = [
            'id_autor' => null,
            'nome' => null,
        ];

        // ASSERT
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('É necessário informar id ou nome autor.');

        // ARRANGE
        $autorDto = new AutorPesquisaDTO($dadosAutor);
        $autorEsperado = new Autor($dadosAutor);

        // Configuração do mock: espera que pesquisaAutor seja chamado uma vez com $autorDto
        $this->autorPesquisa
            ->expects($this->once())
            ->method('pesquisaAutor')
            ->with($autorDto)
            ->willReturn($autorEsperado);

        // ACT
        $resultado = $this->autorPesquisa->pesquisaAutor($autorDto);
    }
}
