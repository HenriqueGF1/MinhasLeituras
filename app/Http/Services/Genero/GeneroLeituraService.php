<?php

namespace App\Http\Services\Genero;

use App\Models\GeneroLeitura;
use Exception;
use Illuminate\Support\Facades\DB;

class GeneroLeituraService
{
    protected GeneroLeitura $model;

    public function __construct(GeneroLeitura $model)
    {
        $this->model = $model;
    }

    public function cadastrarGeneroLeitura($dadosGeneroleitura)
    {
        try {
            $generosCadastrados = $this->model
                ->whereIn('id_genero', $dadosGeneroleitura['id_genero'])
                ->where('id_leitura', $dadosGeneroleitura['id_leitura'])
                ->get();

            $novoGeneroLeitura = array_diff($dadosGeneroleitura['id_genero'], $generosCadastrados->pluck('id_genero')->toArray());

            if (count($novoGeneroLeitura) > 0) {
                DB::beginTransaction();

                foreach ($novoGeneroLeitura as $valor) {
                    $generoleitura = $this->model->create(
                        [
                            'id_genero' => $valor,
                            'id_leitura' => $dadosGeneroleitura['id_leitura'],
                        ]
                    );
                }

                DB::commit();

                return $generoleitura;
            }
        } catch (Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }
}
