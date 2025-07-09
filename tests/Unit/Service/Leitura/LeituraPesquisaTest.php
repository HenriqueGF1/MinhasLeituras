<?php

use App\Http\DTO\Leitura\LeituraPesquisaDTO;
use App\Http\Services\Leituras\LeituraPesquisa;
use App\Models\Leituras;
use Illuminate\Database\Eloquent\Builder;
use Mockery;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class LeituraPesquisaTest extends TestCase
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
    public function test_pesquisa_de_leitura_com_id_leitura()
    {
        // ARANGE
        $dadosLeitura = [
            'id_leitura' => 1,
            'titulo' => null,
        ];

        $this->leiturasMockModel
            ->expects('find')
            ->once()
            ->with($dadosLeitura['id_leitura'])
            ->andReturn(new Leituras([
                'id_leitura' => $dadosLeitura['id_leitura'],
                'titulo' => $dadosLeitura['titulo'],
            ]));

        $leituraPesquisaDto = new LeituraPesquisaDTO($dadosLeitura);
        $serviceLeituraPesquisa = new LeituraPesquisa($this->leiturasMockModel);

        // ACT
        $resultadoPesquisa = $serviceLeituraPesquisa->pesquisaLeitura($leituraPesquisaDto);

        // ASSERT
        $this->assertInstanceOf(Leituras::class, $resultadoPesquisa);
        $this->assertEquals($dadosLeitura['id_leitura'], $resultadoPesquisa->id_leitura);
    }

    #[Test]
    public function test_pesquisa_de_leitura_com_titulo()
    {
        // ARANGE
        $dadosLeitura = [
            'id_leitura' => null,
            'titulo' => 'Percy Jackson e o Ladrão de Raios',
        ];

        // Cria um mock da classe Builder do Eloquent
        // Isso permite simular consultas como where(), first(), etc., sem acessar o banco de dados real.
        $queryMock = Mockery::mock(Builder::class);

        // Configura cadeia de métodos
        $this->leiturasMockModel
            ->shouldReceive('where')
            ->once()
            ->with(
                'titulo',
                'LIKE',
                '%' . $dadosLeitura['titulo'] . '%'
            )
            ->andReturn($queryMock);

        $queryMock
            ->shouldReceive('first')
            ->once()
            ->andReturn(new Leituras([
                'id_leitura' => $dadosLeitura['id_leitura'],
                'titulo' => $dadosLeitura['titulo'],
            ]));

        $leituraPesquisaDto = new LeituraPesquisaDTO($dadosLeitura);
        $serviceLeituraPesquisa = new LeituraPesquisa($this->leiturasMockModel);

        // ACT
        $resultadoPesquisa = $serviceLeituraPesquisa->pesquisaLeitura($leituraPesquisaDto);

        // ASSERT
        $this->assertInstanceOf(Leituras::class, $resultadoPesquisa);
        $this->assertEquals($dadosLeitura['titulo'], $resultadoPesquisa->titulo);
    }

    #[Test]
    public function test_pesquisa_de_leitura_sem_id_e_titulo()
    {
        // ARANGE
        $dadosLeitura = [
            'id_leitura' => null,
            'titulo' => null,
        ];

        // // ASSERT
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('É necessário informar id ou titulo da leitura.');

        // ARANGE
        $leituraPesquisaDto = new LeituraPesquisaDTO($dadosLeitura);
        $serviceLeituraPesquisa = new LeituraPesquisa($this->leiturasMockModel);

        // ACT
        $serviceLeituraPesquisa->pesquisaLeitura($leituraPesquisaDto);
    }
}
