<?php

namespace App\Http\Controllers\Services\Leituras;

use App\Models\Leituras;
use Exception;
use Illuminate\Support\Facades\DB;

class LeiturasService
{
    protected $model;

    public function __construct(Leituras $leituras)
    {
        $this->model = $leituras;
    }

    public function pesquisarLeituras()
    {
        return $this->model->paginate();
    }

    public function pesquisaIsbn($isbn)
    {

        $isbn = isset($isbn->isbn) ? $isbn->isbn : $isbn;

        return $this->model->where('isbn', '=', $isbn)->first();
    }

    public function cadastrarLeitura($request)
    {

        $dadosLeitura = $this->pesquisaIsbn($request->isbn);

        dd($dadosLeitura);

        try {
            DB::beginTransaction();

            $leitura = $this->model->create(
                $request->safe()->all()
            );
            DB::commit();

            return $leitura;
        } catch (Exception $exception) {
            DB::rollBack();
            throw new Exception(json_encode([
                'msg' => 'Erro ao cadastrar leitura',
                'erroDev' => $exception->getMessage(),
            ]));
        }
    }
}
