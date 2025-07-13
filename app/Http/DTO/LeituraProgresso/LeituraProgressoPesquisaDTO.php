<?php

namespace App\Http\DTO\LeituraProgresso;

class LeituraProgressoPesquisaDTO
{
    public readonly int $id_usuario;

    public readonly int $id_leitura;

    public function __construct(array $dados)
    {
        $camposObrigatorios = [
            'id_usuario',
            'id_leitura',
        ];

        foreach ($camposObrigatorios as $campo) {
            if (! array_key_exists($campo, $dados)) {
                throw new \InvalidArgumentException("Campo obrigatório '{$campo}' não foi fornecido.");
            }
        }

        $this->id_usuario = $dados['id_usuario'];
        $this->id_leitura = $dados['id_leitura'];

        $this->validar();
    }

    private function validar(): void
    {
        if (empty($this->id_usuario)) {
            throw new \InvalidArgumentException('É necessário informar id_usuario da leitura.');
        }

        if (empty($this->id_leitura)) {
            throw new \InvalidArgumentException('É necessário informar id_leitura da leitura.');
        }
    }

    public function toArray(): array
    {
        return [
            'id_usuario' => $this->id_usuario,
            'id_leitura' => $this->id_leitura,
        ];
    }
}
