<?php

use App\Http\DTO\AvaliacaoLeitura\AvaliacaoLeituraCadastroDTO;
use App\Http\Services\AvaliacaoLeitura\AvaliacaoLeituraCadastroService;
use App\Models\AvaliacaoLeitura;
use Illuminate\Support\Facades\DB;
use Mockery;
use Tests\TestCase;

class AvaliacaoLeituraCadastroServiceTest extends TestCase
{
    private AvaliacaoLeitura $avaliacaoLeituraMockModel;

    protected function setUp(): void
    {
        parent::setUp();

        $this->avaliacaoLeituraMockModel = Mockery::mock(AvaliacaoLeitura::class);
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        Mockery::close();
    }

    public function test_cadastro_avaliacao_leitura()
    {
        // ARRANGE
        $dadosAvaliacaoLeitura = [
            'id_leitura' => 1,
            'id_usuario' => 1,
            'nota' => 1,
            'descricao_avaliacao' => 'Uma história envolvente com ótimos personagens e ritmo excelente.',
            'data_inicio' => '2025-07-01',
            'data_termino' => '2025-07-11',
        ];

        $dtoAvaliacaoLeituraCadastro = new AvaliacaoLeituraCadastroDTO($dadosAvaliacaoLeitura);

        $this->avaliacaoLeituraMockModel
            ->expects('create')
            ->once()
            ->with($dtoAvaliacaoLeituraCadastro->toArray())
            ->andReturn(new AvaliacaoLeitura([
                'id_avaliacao_leitura' => 15,
                'id_leitura' => $dadosAvaliacaoLeitura['id_leitura'],
                'id_usuario' => $dadosAvaliacaoLeitura['id_usuario'],
                'nota' => $dadosAvaliacaoLeitura['nota'],
                'descricao_avaliacao' => $dadosAvaliacaoLeitura['descricao_avaliacao'],
                'data_inicio' => $dadosAvaliacaoLeitura['data_inicio'],
                'data_termino' => $dadosAvaliacaoLeitura['data_termino'],
            ]));

        DB::expects('beginTransaction')->once();
        DB::expects('commit')->once();
        DB::expects('rollBack')->never();

        $avaAvaliacaoLeituraCadastroServicelicao = new AvaliacaoLeituraCadastroService($this->avaliacaoLeituraMockModel);

        // ACT
        $resultadoAvalicaoCadastro = $avaAvaliacaoLeituraCadastroServicelicao->cadastroDeAvaliacaoDeLeitura($dtoAvaliacaoLeituraCadastro);

        // ASSERT
        $this->assertInstanceOf(AvaliacaoLeitura::class, $resultadoAvalicaoCadastro);
        $this->assertEquals(15, $resultadoAvalicaoCadastro->id_avaliacao_leitura);
        $this->assertEquals($dadosAvaliacaoLeitura['id_leitura'], $resultadoAvalicaoCadastro->id_leitura);
        $this->assertEquals($dadosAvaliacaoLeitura['id_usuario'], $resultadoAvalicaoCadastro->id_usuario);
    }

    public function test_deve_lancar_excecao_para_data_leitura_termino(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Data inválida');

        // ARRANGE
        $dadosAvaliacaoLeitura = [
            'id_leitura' => 1,
            'id_usuario' => 1,
            'nota' => 1,
            'descricao_avaliacao' => 'Uma história envolvente com ótimos personagens e ritmo excelente.',
            'data_inicio' => '2025-07-01',
            'data_termino' => 'aaaaaa',
        ];

        $dtoAvaliacaoLeituraCadastro = new AvaliacaoLeituraCadastroDTO($dadosAvaliacaoLeitura);
    }

    public function test_deve_lancar_excecao_para_data_leitura_inicio(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Data inválida');

        // ARRANGE
        $dadosAvaliacaoLeitura = [
            'id_leitura' => 1,
            'id_usuario' => 1,
            'nota' => 1,
            'descricao_avaliacao' => 'Uma história envolvente com ótimos personagens e ritmo excelente.',
            'data_inicio' => 'aaaa',
            'data_termino' => '2025-07-01',
        ];

        $dtoAvaliacaoLeituraCadastro = new AvaliacaoLeituraCadastroDTO($dadosAvaliacaoLeitura);
    }
}
