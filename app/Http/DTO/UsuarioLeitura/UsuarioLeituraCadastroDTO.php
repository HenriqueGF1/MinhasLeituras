<?php

namespace App\Http\DTO\UsuarioLeitura;

class UsuarioLeituraCadastroDTO
{
    public readonly int $id_usuario;

    public readonly int $id_leitura;

    public readonly int $id_status_leitura;

    public function __construct(array $dados)
    {
        $camposObrigatorios = [
            'id_leitura',
            'id_usuario',
            'id_status_leitura',
        ];

        foreach ($camposObrigatorios as $campo) {
            if (! array_key_exists($campo, $dados)) {
                throw new \InvalidArgumentException("Campo obrigatório '{$campo}' não foi fornecido.");
            }
        }

        $this->id_leitura = $dados['id_leitura'];
        $this->id_usuario = $dados['id_usuario'];
        $this->id_status_leitura = $dados['id_status_leitura'];
        $this->validar();
    }

    private function validar(): void
    {
        if (empty($this->id_leitura) && empty($this->id_usuario) && empty($this->id_status_leitura)) {
            throw new \InvalidArgumentException('É necessário informar id leitura e id usuario e status leitura');
        }
    }

    public function toArray(): array
    {
        return [
            'id_leitura' => $this->id_leitura,
            'id_usuario' => $this->id_usuario,
            'id_status_leitura' => $this->id_status_leitura,
        ];
    }
}
