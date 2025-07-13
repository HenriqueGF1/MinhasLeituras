<?php

namespace App\Http\Services\Leituras\LeituraProgresso;

use App\Http\DTO\LeituraProgresso\LeituraProgressoPesquisaDTO;
use App\Models\LeituraProgresso;

class LeituraProgressoPesquisa
{
    public function __construct(
        protected LeituraProgresso $leituraProgressoModel
    ) {}

    public function pesquisarProgresso(LeituraProgressoPesquisaDTO $dto): ?LeituraProgresso
    {
        $leituraProgresso = $this->leituraProgressoModel->where(
            [
                ['id_usuario', '=', $dto->id_usuario],
                ['id_leitura', '=', $dto->id_leitura],
            ]
        )->first();

        return $leituraProgresso ?: null;
    }
}
