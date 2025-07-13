<?php

namespace App\Http\Services\Leituras\LeituraProgresso;

use App\Http\DTO\LeituraProgresso\LeituraProgressoCadastroDTO;
use App\Models\LeituraProgresso;
use App\Models\Leituras;
use Exception;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

class LeituraProgressoCadastro
{
    public function __construct(
        protected LeituraProgresso $leituraProgressoModel,
        protected Leituras $leituraModel
    ) {}

    public function cadastrarProgresso(LeituraProgressoCadastroDTO $dto): LeituraProgresso
    {
        $leitura = $this->leituraModel->find($dto->id_leitura);

        if (! $leitura) {
            throw new InvalidArgumentException("Leitura com ID {$dto->id_leitura} não encontrada.");
        }

        if ($dto->qtd_paginas_lidas > $leitura->qtd_paginas) {
            throw new InvalidArgumentException('Quantidade de páginas lidas maior que o total disponível na leitura.');
        }

        try {
            DB::beginTransaction();

            $leituraProgresso = $this->leituraProgressoModel->create($dto->toArray());

            DB::commit();

            return $leituraProgresso;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
