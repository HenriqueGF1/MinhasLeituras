<?php

namespace App\Http\DTO\LeituraProgresso;

use Carbon\Carbon;
use Exception;

class LeituraProgressoCadastroDTO
{
    public int $id_usuario;

    public int $id_leitura;

    public int $qtd_paginas_lidas;

    public Carbon $data_leitura;

    public function __construct(array $dados)
    {
        $camposObrigatorios = [
            'id_usuario',
            'id_leitura',
            'qtd_paginas_lidas',
            'data_leitura',
        ];

        foreach ($camposObrigatorios as $campo) {
            if (! array_key_exists($campo, $dados)) {
                throw new \InvalidArgumentException("Campo obrigatório '{$campo}' não foi fornecido.");
            }
        }

        $this->id_usuario = $dados['id_usuario'];
        $this->id_leitura = $dados['id_leitura'];
        $this->qtd_paginas_lidas = $dados['qtd_paginas_lidas'];

        try {
            $this->data_leitura = Carbon::createFromFormat('Y-m-d', $dados['data_leitura']);
        } catch (Exception $e) {
            throw new \InvalidArgumentException("Data inválida: {$dados['data_leitura']}");
        }

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

        if (empty($this->qtd_paginas_lidas)) {
            throw new \InvalidArgumentException('É necessário informar qtd_paginas_lidas da leitura.');
        }

        if (empty($this->data_leitura)) {
            throw new \InvalidArgumentException('É necessário informar data_leitura da leitura.');
        }
    }

    public function toArray(): array
    {
        return [
            'id_usuario' => $this->id_usuario,
            'id_leitura' => $this->id_leitura,
            'qtd_paginas_lidas' => $this->qtd_paginas_lidas,
            'data_leitura' => $this->data_leitura->format('Y-m-d'),
        ];
    }
}
