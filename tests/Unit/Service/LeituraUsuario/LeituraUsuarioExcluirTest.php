<?php

use App\Http\DTO\UsuarioLeitura\UsuarioLeituraExcluirDTO;
use App\Http\Services\Usuario\Leitura\UsuarioLeituraExcluir;
use App\Models\UsuarioLeitura;
use Tests\TestCase;

class LeituraUsuarioExcluirTest extends TestCase
{
    private UsuarioLeitura $usuarioLeituraMockModel;

    protected function setUp(): void
    {
        parent::setUp();
        $this->usuarioLeituraMockModel = Mockery::mock(UsuarioLeitura::class);
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        Mockery::close();
    }

    public function test_usuario_excluir_leitura()
    {
        // Arrange
        $dtoUsuarioLeituraExcluirDTO = new UsuarioLeituraExcluirDTO([
            'id_usuario_leitura' => 852,
        ]);

        $this->usuarioLeituraMockModel->expects('delete')->once();

        $this->usuarioLeituraMockModel
            ->expects('findOrFail')
            ->with(852)
            ->once()
            ->andReturn($this->usuarioLeituraMockModel);

        DB::shouldReceive('beginTransaction')->once();
        DB::shouldReceive('commit')->once();
        DB::shouldReceive('rollBack')->never();

        $serviceUsuarioLeituraExcluir = new UsuarioLeituraExcluir($this->usuarioLeituraMockModel);

        // Act
        $serviceUsuarioLeituraExcluir->usuarioLeituraExcluirLeitura($dtoUsuarioLeituraExcluirDTO);
    }

    public function test_usuario_excluir_leitura_falha_rollback()
    {
        $dto = new UsuarioLeituraExcluirDTO([
            'id_usuario_leitura' => 123,
        ]);

        $this->usuarioLeituraMockModel->expects('delete')->once()->andThrow(new Exception('Erro intencional'));

        $this->usuarioLeituraMockModel
            ->expects('findOrFail')
            ->with(123)
            ->once()
            ->andReturn($this->usuarioLeituraMockModel);

        DB::shouldReceive('beginTransaction')->once();
        DB::shouldReceive('rollBack')->once();
        DB::shouldReceive('commit')->never();

        $service = new UsuarioLeituraExcluir($this->usuarioLeituraMockModel);

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Erro intencional');

        $service->usuarioLeituraExcluirLeitura($dto);
    }
}
