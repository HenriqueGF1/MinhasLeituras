<?php

declare(strict_types=1);

use App\Models\User;
use App\Models\UsuarioLeitura;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class UsuarioLeituraExcluirTest extends TestCase
{
    private User $usuario;

    private $token;

    protected function setUp(): void
    {
        parent::setUp();
        $this->usuario = User::find(1);
        $this->token = JWTAuth::fromUser($this->usuario);
    }

    // Método executado após cada teste
    protected function tearDown(): void
    {
        parent::tearDown();
    }

    public function test_cadastro_leitura_usuario_excluir(): void
    {
        $usuarioLeitura = UsuarioLeitura::latest('id_usuario_leitura')->first();

        $dadosUsuarioLeitura = [
            'id_usuario_leitura' => $usuarioLeitura->id_usuario_leitura,
        ];

        $response = $this->withHeaders([
            'Authorization' => "Bearer {$this->token}",
        ])->deleteJson(
            "/api/leituras/excluir/{$dadosUsuarioLeitura['id_usuario_leitura']}"
        );

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'success' => true,
            'message' => 'Leitura Excluida com sucesso',
            'data' => [],
        ]);
        $this->assertDatabaseMissing('usuario_leituras', [
            'id_usuario_leitura' => $dadosUsuarioLeitura['id_usuario_leitura'],
        ]);
    }

    public function test_cadastro_leitura_validacao_leitura_usuario_excluir(): void
    {
        $dadosUsuarioLeitura = [
            'id_usuario_leitura' => 75,
        ];

        $response = $this->withHeaders([
            'Authorization' => "Bearer {$this->token}",
        ])->deleteJson(
            "/api/leituras/excluir/{$dadosUsuarioLeitura['id_usuario_leitura']}"
        );

        $response
            ->assertStatus(422)
            ->assertJson(
                fn (AssertableJson $json) => $json->has('errors.id_usuario_leitura')
                    ->etc()
            );

        $this->assertDatabaseMissing('usuario_leituras', [
            'id_usuario_leitura' => $dadosUsuarioLeitura['id_usuario_leitura'],
        ]);
    }
}
