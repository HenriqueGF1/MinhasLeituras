<?php

use App\Http\DTO\GeneroLeitura\GeneroLeituraCadastroDTO;
use App\Http\Services\Genero\GeneroLeituraCadastro;
use App\Models\GeneroLeitura;
use Illuminate\Database\Eloquent\Collection;
use Mockery;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class GeneroLeituraCadastroTest extends TestCase
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
    public function test_cadastrar_genero_leitura_com_sucesso()
    {
        // ARRANG
        $dadosGeneroLeitura = [
            'id_leitura' => 6,
            'id_genero' => [5, 8],
        ];

        $serviceGeneroLeituraCadastro = new GeneroLeituraCadastro($this->mockModelGeneroLeitura);
        $generoLeituraCadastroDTO = new GeneroLeituraCadastroDTO($dadosGeneroLeitura);

        $mockBuilder = Mockery::mock(Builder::class);

        DB::shouldReceive('beginTransaction')->once();
        DB::shouldReceive('commit')->once();
        DB::shouldReceive('rollBack')->never();

        // insert
        $this->mockModelGeneroLeitura
            ->shouldReceive('insert')
            ->once()
            ->with([
                ['id_genero' => $dadosGeneroLeitura['id_genero'][0], 'id_leitura' => $dadosGeneroLeitura['id_leitura']],
                ['id_genero' => $dadosGeneroLeitura['id_genero'][1], 'id_leitura' => $dadosGeneroLeitura['id_leitura']],
            ])
            ->andReturnTrue();

        // whereIn chaining
        $this->mockModelGeneroLeitura
            ->shouldReceive('whereIn')
            ->with('id_genero', [5, 8])
            ->andReturn($mockBuilder);

        $mockBuilder
            ->shouldReceive('get')
            ->once()
            ->andReturn(new Collection([
                new GeneroLeitura([
                    'id_leitura' => $dadosGeneroLeitura['id_leitura'],
                    'id_genero' => $dadosGeneroLeitura['id_genero'][0],
                ]),
                new GeneroLeitura([
                    'id_leitura' => $dadosGeneroLeitura['id_leitura'],
                    'id_genero' => $dadosGeneroLeitura['id_genero'][1],
                ]),
            ]));

        // ACT
        $resultadoPesquisa = $serviceGeneroLeituraCadastro->cadastrarGeneroLeitura($generoLeituraCadastroDTO);

        // ASSERT
        $this->assertInstanceOf(Collection::class, $resultadoPesquisa);
        $this->assertCount(2, $resultadoPesquisa);
        $this->assertEquals($dadosGeneroLeitura['id_leitura'], $resultadoPesquisa[0]->id_leitura);
        $this->assertEquals($dadosGeneroLeitura['id_genero'][0], $resultadoPesquisa[0]->id_genero);
        $this->assertEquals($dadosGeneroLeitura['id_leitura'], $resultadoPesquisa[1]->id_leitura);
        $this->assertEquals($dadosGeneroLeitura['id_genero'][1], $resultadoPesquisa[1]->id_genero);
    }

    #[Test]
    public function test_cadastro_de_genero_leitura_sem_dados_essenciais()
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
        $generoLeituraCadastroDTO = new GeneroLeituraCadastroDTO($dadosGeneroLeitura);
        $serviceGeneroLeituraCadastro = new GeneroLeituraCadastro($this->mockModelGeneroLeitura);

        // ACT
        $serviceGeneroLeituraCadastro->cadastrarGeneroLeitura($generoLeituraCadastroDTO);
    }
}
