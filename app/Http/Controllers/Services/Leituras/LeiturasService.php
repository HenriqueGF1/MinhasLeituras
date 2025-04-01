<?php

namespace App\Http\Controllers\Services\Leituras;

use Exception;
use App\Models\Leituras;
use Illuminate\Support\Facades\DB;

class LeiturasService
{
    private $model;
    public function __construct()
    {
        $this->model = new Leituras();
    }
    public function pesquisarLeituras()
    {
        return $this->model->paginate();
    }

    public function cadastrarLeitura($request)
    {
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
                'erroDev' => $exception->getMessage()
            ]));
        }
    }
}
