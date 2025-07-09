<?php

namespace App\Http\DTO\UsuarioLeitura;

class UsuarioLeituraExcluirDTO
{
    public readonly int $id_usuario_leitura;

    public function __construct(array $dados)
    {
        $camposObrigatorios = [
            'id_usuario_leitura',
        ];

        foreach ($camposObrigatorios as $campo) {
            if (! array_key_exists($campo, $dados)) {
                throw new \InvalidArgumentException("Campo obrigatório '{$campo}' não foi fornecido.");
            }
        }

        $this->id_usuario_leitura = $dados['id_usuario_leitura'];

        $this->validar();
    }

    private function validar(): void
    {
        if (empty($this->id_usuario_leitura)) {
            throw new \InvalidArgumentException('É necessário informar id usuario leitura');
        }
    }

    public function toArray(): array
    {
        return [
            'id_usuario_leitura' => $this->id_usuario_leitura,
        ];
    }
}
