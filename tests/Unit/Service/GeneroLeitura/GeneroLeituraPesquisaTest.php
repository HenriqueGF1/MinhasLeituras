<?php

use App\Http\DTO\GeneroLeitura\GeneroLeituraPesquisaDTO;
use App\Http\Services\Genero\GeneroPesquisa;
use App\Models\GeneroLeitura;
use Illuminate\Database\Eloquent\Collection;
use Mockery;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class GeneroLeituraPesquisaTest extends TestCase
{
    private GeneroLeitura $mockModelGeneroLeitura;

    protected function setUp(): void
    {
        parent::setUp();

        $this->mockModelGeneroLeitura = Mockery::mock(GeneroLeitura::class);
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        Mockery::close();
    }

    #[Test]
    public function test_pesquisar_genero_leitura()
    {
        // ARRANG
        $dadosGeneroLeitura = [
            'id_leitura' => 1,
            'id_genero' => [2, 3],
        ];

        $generoLeituraPesquisaDTO = new GeneroLeituraPesquisaDTO($dadosGeneroLeitura);

        // Mocks para encadeamento
        $queryBuilderMock = Mockery::mock(\Illuminate\Database\Eloquent\Builder::class);
        $queryBuilderMock2 = Mockery::mock(\Illuminate\Database\Eloquent\Builder::class);

        $resultMock = new Collection([
            new GeneroLeitura([
                'id_leitura' => 1,
                'id_genero' => 2,
            ]),
            new GeneroLeitura([
                'id_leitura' => 1,
                'id_genero' => 3,
            ]),
        ]);

        // Expectativas de chamadas encadeadas
        $this->mockModelGeneroLeitura
            ->shouldReceive('where')
            ->with('id_leitura', $generoLeituraPesquisaDTO->id_leitura)
            ->andReturn($queryBuilderMock);

        $queryBuilderMock
            ->shouldReceive('whereIn')
            ->with('id_genero', $generoLeituraPesquisaDTO->id_genero)
            ->andReturn($queryBuilderMock2);

        $queryBuilderMock2
            ->shouldReceive('get')
            ->andReturn($resultMock);

        $serviceGeneroPesquisa = new GeneroPesquisa($this->mockModelGeneroLeitura);

        // ACT
        $resultadoPesquisa = $serviceGeneroPesquisa->pesquisarGeneroLeitura($generoLeituraPesquisaDTO);

        // ASSERT
        $this->assertInstanceOf(Collection::class, $resultadoPesquisa);
        $this->assertCount(2, $resultadoPesquisa);
        $this->assertEquals(2, $resultadoPesquisa[0]->id_genero);
    }

    #[Test]
    public function test_pesquisa_de_genero_leitura_sem_dados_essenciais()
    {
        // ARRANG
        $dadosGeneroLeitura = [
            'id_leitura' => 0,
            'id_genero' => [0],
        ];

        // // ASSERT
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('É necessário informar id leitura');

        // ARRANG
        $generoLeituraPesquisaDTO = new GeneroLeituraPesquisaDTO($dadosGeneroLeitura);
        $serviceGeneroPesquisa = new GeneroPesquisa($this->mockModelGeneroLeitura);

        // ACT
        $serviceGeneroPesquisa->pesquisarGeneroLeitura($generoLeituraPesquisaDTO);
    }
}
