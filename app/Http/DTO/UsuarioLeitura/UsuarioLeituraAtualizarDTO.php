<?php

namespace App\Http\DTO\UsuarioLeitura;

use App\Models\StatusLeitura;

class UsuarioLeituraAtualizarDTO
{
    public readonly int $id_usuario_leitura;

    public readonly int $id_usuario;

    public readonly int $id_leitura;

    public readonly int $id_status_leitura;

    public function __construct(array $dados)
    {
        $camposObrigatorios = [
            'id_usuario_leitura',
            'id_leitura',
            'id_usuario',
            'id_status_leitura',
        ];

        foreach ($camposObrigatorios as $campo) {
            if (! array_key_exists($campo, $dados)) {
                throw new \InvalidArgumentException("Campo obrigatório '{$campo}' não foi fornecido.");
            }
        }

        $statusValido = array_key_exists($dados['id_status_leitura'], StatusLeitura::pegarStatus());

        if (! $statusValido) {
            throw new \InvalidArgumentException("Status inválido: {$dados['id_status_leitura']}");
        }

        $this->id_usuario_leitura = $dados['id_usuario_leitura'];
        $this->id_leitura = $dados['id_leitura'];
        $this->id_usuario = $dados['id_usuario'];
        $this->id_status_leitura = $dados['id_status_leitura'];
        $this->validar();
    }

    private function validar(): void
    {
        if (empty($this->id_usuario_leitura) && empty($this->id_leitura) && empty($this->id_usuario) && empty($this->id_status_leitura)) {
            throw new \InvalidArgumentException('É necessário informar id_usuario_leitura id leitura e id usuario e status leitura');
        }
    }

    public function toArray(): array
    {
        return [
            'id_usuario_leitura' => $this->id_usuario_leitura,
            'id_leitura' => $this->id_leitura,
            'id_usuario' => $this->id_usuario,
            'id_status_leitura' => $this->id_status_leitura,
        ];
    }
}
