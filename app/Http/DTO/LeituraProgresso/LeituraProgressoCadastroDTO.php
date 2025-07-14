<?php

namespace App\Http\DTO\LeituraProgresso;

use App\Models\Leituras;
use Carbon\Carbon;
use Exception;

class LeituraProgressoCadastroDTO
{
    public readonly int $id_usuario;

    public readonly int $id_leitura;

    public readonly int $qtd_paginas_lidas;

    public readonly Carbon $data_leitura;

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
            $this->data_leitura = Carbon::createFromFormat('Y-m-d H:i:s', $dados['data_leitura']);
        } catch (Exception $e) {
            throw new \InvalidArgumentException("Data inválida: {$dados['data_leitura']}");
        }

        if ($this->data_leitura->lt(now()->startOfDay())) {
            throw new \InvalidArgumentException('A data da leitura não pode ser anterior a hoje.');
        }

        $leitura = Leituras::find($this->id_leitura);

        if ((! is_null($leitura)) && $this->qtd_paginas_lidas > $leitura->qtd_paginas) {
            throw new \InvalidArgumentException('Quantidade de páginas lidas maior que o total disponível na leitura.');
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
