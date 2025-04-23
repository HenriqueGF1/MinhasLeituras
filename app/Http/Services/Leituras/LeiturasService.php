<?php

declare(strict_types=1);

namespace App\Http\Services\Leituras;

use App\Models\Leituras;
use Exception;
use Illuminate\Support\Facades\DB;

class LeiturasService
{
    protected $model;

    public function __construct()
    {
        $this->model = new Leituras;
    }

    public function pesquisarLeituras()
    {
        return $this->model->paginate();
    }

    /** Pesuisa do ISBN no meu banco de dados */
    public function pesquisaIsbnBase($isbn)
    {
        $isbn = isset($isbn->isbn) ? $isbn->isbn : $isbn;

        return $this->model->where('isbn', '=', $isbn)->first();
    }

    public function cadastrarLeitura($dadosRequisicao)
    {
        try {
            DB::beginTransaction();

            $dadosLeitura = isset($dadosRequisicao['isbn']) ? $this->pesquisaIsbnBase($dadosRequisicao['isbn']) : null;
            $dadosRequisicao['id_leitura'] = $dadosLeitura['id_leitura'] ?? null;
            $dadosRequisicao['id_editora'] = $dadosLeitura['id_editora'] ?? null;

            $cadastroDeLeituraService = new CadastroDeLeituraService;
            $leitura = $cadastroDeLeituraService->cadastroDeLeitura($dadosRequisicao);

            DB::commit();

            return $this->model->where('id_leitura', '=', $leitura['id_leitura'])->first();
        } catch (Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }

    public function cadastramentoDeLeitura($dadosLeitura)
    {
        unset($dadosLeitura['id_leitura']);

        try {
            DB::beginTransaction();

            $leitura = $this->model->create($dadosLeitura);

            DB::commit();

            return $this->model->where('id_leitura', '=', $leitura['id_leitura'])->first();
        } catch (Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }
}
