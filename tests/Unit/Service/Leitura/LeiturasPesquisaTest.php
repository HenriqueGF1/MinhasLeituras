<?php

use App\Http\Services\Leituras\LeiturasPesquisa;
use App\Models\Leituras;
use Illuminate\Pagination\LengthAwarePaginator;
use Mockery;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class LeiturasPesquisaTest extends TestCase
{
    private Leituras $leiturasMockModel;

    protected function setUp(): void
    {
        parent::setUp();

        $this->leiturasMockModel = Mockery::mock(Leituras::class);
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        Mockery::close();
    }

    #[Test]
    public function test_pesquisa_de_todas_as_leituras()
    {
        // ARRANGE
        $dadosLeitura = [
            'id_leitura' => 1,
            'titulo' => 'Titulo',
        ];

        $item = (object) $dadosLeitura;
        $collection = collect([$item]);
        $paginator = new LengthAwarePaginator($collection, $collection->count(), 15, 1);

        // Mock do query builder
        $queryMock = Mockery::mock();
        $queryMock->shouldReceive('paginate')
            ->once()
            ->andReturn($paginator);

        // Mock do model para retornar o query mock
        $this->leiturasMockModel
            ->shouldReceive('newQuery')
            ->once()
            ->andReturn($queryMock);

        $service = new LeiturasPesquisa($this->leiturasMockModel);

        // ACT
        $resultado = $service->pesquisa();

        // ASSERT
        $this->assertInstanceOf(LengthAwarePaginator::class, $resultado);
        $this->assertEquals(1, $resultado->items()[0]->id_leitura);
        $this->assertEquals('Titulo', $resultado->items()[0]->titulo);
    }
}
