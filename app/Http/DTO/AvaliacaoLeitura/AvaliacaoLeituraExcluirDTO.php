<?php

namespace App\Http\DTO\AvaliacaoLeitura;

class AvaliacaoLeituraExcluirDTO
{
    public readonly int $id_avaliacao_leitura;

    public function __construct(array $dados)
    {
        $camposObrigatorios = [
            'id_avaliacao_leitura',
        ];

        foreach ($camposObrigatorios as $campo) {
            if (! array_key_exists($campo, $dados)) {
                throw new \InvalidArgumentException("Campo obrigatório '{$campo}' não foi fornecido.");
            }
        }

        $this->id_avaliacao_leitura = $dados['id_avaliacao_leitura'];

        $this->validar();
    }

    private function validar(): void
    {
        if (empty($this->id_avaliacao_leitura)) {
            throw new \InvalidArgumentException('É necessário informar id_avaliacao_leitura.');
        }
    }

    public function toArray(): array
    {
        return [
            'id_avaliacao_leitura' => $this->id_avaliacao_leitura,
        ];
    }
}
