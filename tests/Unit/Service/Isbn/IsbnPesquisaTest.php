<?php

namespace Tests\Unit\Service\Isbn;

use App\Http\Services\Leituras\IsbnPesquisa;
use App\Models\Leituras;
use Illuminate\Database\Eloquent\Builder; // 👈 Importe o Builder
use Mockery;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class IsbnPesquisaTest extends TestCase
{
    private $leituraModelMock;

    protected function setUp(): void
    {
        parent::setUp();
        $this->leituraModelMock = Mockery::mock(Leituras::class);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    #[Test]
    public function pesquisa_com_isbn_no_banco_de_dados_retorna_dados(): void
    {
        // ARRANGE
        $isbn = '9788598078394';

        $retornoLeituraEsperado = new Leituras([
            'titulo' => 'Percy Jackson e o Ladrão de Raios',
            'isbn' => $isbn,
        ]);

        // Mock do Query Builder
        $queryMock = Mockery::mock(Builder::class);

        // Configura cadeia de métodos
        $this->leituraModelMock
            ->shouldReceive('where')
            ->once()
            ->with('isbn', '=', $isbn)
            ->andReturn($queryMock);

        $queryMock
            ->shouldReceive('first')
            ->once()
            ->andReturn($retornoLeituraEsperado);

        // ACT - INJETA O MOCK NO SERVIÇO
        $isbnService = new IsbnPesquisa($this->leituraModelMock);
        $resultadoPesquisaIsbn = $isbnService->pesquisaIsbnBase($isbn);

        // ASSERT
        // $this->assertInstanceOf(Leituras::class, $resultadoPesquisaIsbn);
        $this->assertEquals($isbn, $resultadoPesquisaIsbn->isbn);
        $this->assertEquals($retornoLeituraEsperado->titulo, $resultadoPesquisaIsbn->titulo);
    }

    #[Test]
    public function pesquisa_com_isbn_no_banco_de_dados_retorna_null(): void
    {
        // ARRANGE
        $isbn = '';

        // ACT - Pode passar null já que o mock não será usado
        $isbnService = new IsbnPesquisa($this->leituraModelMock);
        $resultadoPesquisaIsbn = $isbnService->pesquisaIsbnBase($isbn);

        // ASSERT
        $this->assertNull($resultadoPesquisaIsbn);
    }
}
