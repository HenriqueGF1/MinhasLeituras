<?php

namespace App\Http\Services\Genero;

use App\Models\GeneroLeitura;
use Illuminate\Support\Facades\DB;

class GeneroLeituraCadastro
{
    public function __construct(protected GeneroLeitura $model) {}

    public function cadastrarGeneroLeitura(int $id_leitura, array $generosLeituras): array
    {
        DB::beginTransaction();

        try {
            // Busca gêneros já cadastrados para a leitura
            $generosCadastrados = $this->model
                ->where('id_leitura', isset($id_leitura) ? $id_leitura : null)
                ->whereIn('id_genero', $generosLeituras['id_genero'])
                ->pluck('id_genero')
                ->toArray();

            // Filtra apenas os gêneros ainda não cadastrados
            $novosGeneros = array_diff($generosLeituras['id_genero'], $generosCadastrados);

            if (empty($novosGeneros)) {
                return []; // Nada a fazer
            }

            $generosInseridos = [];

            foreach ($novosGeneros as $idGenero) {
                $generosInseridos[] = $this->model->create([
                    'id_genero' => $idGenero,
                    'id_leitura' => $id_leitura,
                ]);
            }

            DB::commit();

            return $generosInseridos;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
