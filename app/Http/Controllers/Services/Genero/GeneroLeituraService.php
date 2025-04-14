<?php

namespace App\Http\Controllers\Services\Genero;

use App\Models\GeneroLeitura;
use Exception;
use Illuminate\Support\Facades\DB;

class GeneroLeituraService
{
    protected $model;

    public function __construct()
    {
        $this->model = new GeneroLeitura;
    }

    public function cadastrarGeneroLeitura($dadosGeneroleitura)
    {
        try {
            DB::beginTransaction();

            $generosCadastrodos = $this->model
                ->whereIn('id_genero', [1, 2, 3])
                ->where('id_leitura', $dadosGeneroleitura['id_leitura'])
                ->get();

            $novoGeneroLeitura = array_diff($dadosGeneroleitura['id_genero'], $generosCadastrodos->pluck('id_genero')->toArray());

            if (count($novoGeneroLeitura) > 0) {
                foreach ($novoGeneroLeitura as $valor) {
                    $generoleitura = $this->model->create(
                        [
                            'id_genero' => $valor,
                            'id_leitura' => $dadosGeneroleitura['id_leitura'],
                        ]
                    );
                }
            }

            DB::commit();

            return $generoleitura;
        } catch (Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }
}
