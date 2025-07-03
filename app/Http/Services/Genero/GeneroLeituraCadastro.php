<?php

namespace App\Http\Services\Genero;

use App\Http\DTO\GeneroLeitura\GeneroLeituraCadastroDTO;
use App\Models\GeneroLeitura;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class GeneroLeituraCadastro
{
    public function __construct(protected GeneroLeitura $model) {}

    public function cadastrarGeneroLeitura(GeneroLeituraCadastroDTO $generoLeituraDTO): Collection
    {
        try {
            DB::beginTransaction();

            $dados = array_map(function ($idGenero) use ($generoLeituraDTO) {
                return [
                    'id_genero' => $idGenero,
                    'id_leitura' => $generoLeituraDTO->id_leitura,
                ];
            }, $generoLeituraDTO->id_genero);

            $this->model->insert($dados);

            $genero = $this->model
                ->whereIn('id_genero', $generoLeituraDTO->id_genero)
                ->get();

            DB::commit();

            return $genero;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
