<?php

namespace App\Http\DTO\Usuarioleitura;

class UsuarioLeituraPesquisaDTO
{
    public int $id_usuario;

    public int $id_leitura;

    public function __construct(array $dados)
    {
        $camposObrigatorios = [
            'id_leitura',
            'id_usuario',
        ];

        foreach ($camposObrigatorios as $campo) {
            if (! array_key_exists($campo, $dados)) {
                throw new \InvalidArgumentException("Campo obrigatório '{$campo}' não foi fornecido.");
            }
        }

        $this->id_leitura = $dados['id_leitura'];
        $this->id_usuario = $dados['id_usuario'];

        $this->validar();
    }

    private function validar(): void
    {
        if (empty($this->id_leitura) && empty($this->id_usuario)) {
            throw new \InvalidArgumentException('É necessário informar id leitura ou id usuario.');
        }
    }

    public function toArray(): array
    {
        return [
            'id_leitura' => $this->id_leitura,
            'id_usuario' => $this->id_usuario,
        ];
    }
}
