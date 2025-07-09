<?php

namespace App\Http\Services\Genero;

use App\Http\DTO\GeneroLeitura\GeneroLeituraPesquisaDTO;
use App\Models\GeneroLeitura;
use Illuminate\Database\Eloquent\Collection;

class GeneroPesquisa
{
    public function __construct(protected GeneroLeitura $model) {}

    public function pesquisarGeneroLeitura(GeneroLeituraPesquisaDTO $dto): ?Collection
    {
        return $this->model
            ->where('id_leitura', $dto->id_leitura)
            ->whereIn('id_genero', $dto->id_genero)
            ->get();
    }
}
