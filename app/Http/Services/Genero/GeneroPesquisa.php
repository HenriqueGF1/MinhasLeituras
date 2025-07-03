<?php

namespace App\Http\Services\Genero;

use App\Http\DTO\GeneroLeitura\GeneroLeituraPesquisaDTO;
use App\Models\GeneroLeitura;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class GeneroPesquisa
{
    public function __construct(protected GeneroLeitura $model) {}

    public function pesquisarGeneroLeitura(GeneroLeituraPesquisaDTO $dto): ?Collection
    {
        // dd($dto);

        try {
            return $this->model
                ->where('id_leitura', $dto->id_leitura)
                ->whereIn('id_genero', $dto->id_genero)
                ->get();
        } catch (Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }
}
