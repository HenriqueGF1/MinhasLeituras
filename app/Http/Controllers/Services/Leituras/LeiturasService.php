<?php

declare(strict_types=1);

namespace App\Http\Controllers\Services\Leituras;

use App\Http\Controllers\Services\Usuario\UsuarioLeituraService;
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

    /** Pesuisa do ISBN no meu banco de dados */
    public function pesquisaIsbnBase($isbn)
    {
        $isbn = isset($isbn->isbn) ? $isbn->isbn : $isbn;

        return $this->model->where('isbn', '=', $isbn)->first();
    }

    public function cadastrarLeitura($request)
    {
        try {
            DB::beginTransaction();

            $dadosRequisicao = $request->safe()->all();
            $dadosLeitura = $this->pesquisaIsbnBase($dadosRequisicao['isbn']);
            $usuarioLeituraService = new UsuarioLeituraService;

            $idLeitura = $dadosLeitura->id_leitura ?? null;
            $novaLeitura = null;

            if (! $idLeitura) {
                $novaLeitura = $this->model->create($dadosRequisicao);
                $idLeitura = $novaLeitura->id_leitura;
            }

            $cadastroLeituraUsuario = $usuarioLeituraService->salvarLeituraUsuario($idLeitura, $dadosRequisicao);

            DB::commit();

            return response()->json([
                'success' => [
                    'cadastroLeitura' => (bool) $novaLeitura,
                    'cadastroLeituraUsuario' => $cadastroLeituraUsuario->getData()->success,
                ],
                'message' => [
                    'cadastroLeitura' => $novaLeitura ? 'Sucesso ao cadastrar leitura' : null,
                    'cadastroLeituraUsuario' => $cadastroLeituraUsuario->getData()->message,
                ],
                'data' => $this->model->find($idLeitura),
            ], $cadastroLeituraUsuario->getStatusCode());
        } catch (Exception $exception) {
            DB::rollBack();

            throw new Exception(json_encode([
                'success' => false,
                'msg' => 'Erro ao cadastrar leitura',
                'erroDev' => $exception->getMessage(),
            ]));
        }
    }
}
