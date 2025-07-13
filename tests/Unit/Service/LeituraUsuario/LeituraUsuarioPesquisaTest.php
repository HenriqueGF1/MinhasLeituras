<?php

use App\Http\DTO\Usuarioleitura\UsuarioLeituraPesquisaDTO;

use App\Http\Services\Usuario\Leitura\UsuarioLeituraPesquisa;
use App\Models\UsuarioLeitura;
use Mockery;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class LeituraUsuarioPesquisaTest extends TestCase
{
    private UsuarioLeitura $leituraUsuarioMockModel;

    protected function setUp(): void
    {
        parent::setUp();

        $this->leituraUsuarioMockModel = Mockery::mock(UsuarioLeitura::class);
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        Mockery::close();
    }

    #[Test]
    public function test_pesquisa_de_leitura_usuario_com_id_leitura()
    {
        // ARANGE
        $dadosLeituraUsuario = [
            'id_leitura' => 85,
            'id_usuario' => 63,
        ];

        $queryMock = Mockery::mock(Builder::class);

        $this->leituraUsuarioMockModel
            ->shouldReceive('where')
            ->with([
                ['id_usuario', '=', $dadosLeituraUsuario['id_usuario']],
                ['id_leitura', '=', $dadosLeituraUsuario['id_leitura']],
            ])
            ->andReturn($queryMock);

        $queryMock
            ->shouldReceive('first')
            ->andReturn(new UsuarioLeitura([
                'id_leitura' => $dadosLeituraUsuario['id_leitura'],
                'id_usuario' => $dadosLeituraUsuario['id_usuario'],
            ]));

        $usuarioLeituraPesquisaDTO = new UsuarioLeituraPesquisaDTO($dadosLeituraUsuario);
        $serviceUsuarioLeituraPesquisa = new UsuarioLeituraPesquisa($this->leituraUsuarioMockModel);

        // ACT
        $resultadoPesquisa = $serviceUsuarioLeituraPesquisa->pesquisaLeituraUsuario($usuarioLeituraPesquisaDTO);

        // ASSERT
        $this->assertInstanceOf(UsuarioLeitura::class, $resultadoPesquisa);
        $this->assertEquals($dadosLeituraUsuario['id_leitura'], $resultadoPesquisa->id_leitura);
        $this->assertEquals($dadosLeituraUsuario['id_usuario'], $resultadoPesquisa->id_usuario);
    }

    #[Test]
    public function test_pesquisa_de_leitura_usuario_sem_dados_essenciais()
    {
        // ARANGE
        $dadosLeituraUsuario = [
            'id_leitura' => 0,
            'id_usuario' => 0,
        ];

        // ASSERT
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('É necessário informar id leitura ou id usuario.');

        // ARANGE
        $usuarioLeituraPesquisaDTO = new UsuarioLeituraPesquisaDTO($dadosLeituraUsuario);
        $serviceUsuarioLeituraPesquisa = new UsuarioLeituraPesquisa($this->leituraUsuarioMockModel);

        // ACT
        $serviceUsuarioLeituraPesquisa->pesquisaLeituraUsuario($usuarioLeituraPesquisaDTO);
    }
}
