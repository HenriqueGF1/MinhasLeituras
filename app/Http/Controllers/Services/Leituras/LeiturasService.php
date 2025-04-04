<?php

declare(strict_types=1);

namespace App\Http\Controllers\Services\Leituras;

use App\Http\Controllers\Services\Editora\EditoraService;
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

    public function cadastrarLeitura($dadosRequisicao)
    {
        $resultado = [
            'statusCode' => 400,
            'cadastroEditora' => false,
            'cadastroLeitura' => false,
            'cadastroLeituraUsuario' => false,
            'mensagens' => [
                'cadastroEditora' => null,
                'cadastroLeitura' => null,
                'cadastroLeituraUsuario' => null,
            ],
        ];

        try {
            DB::beginTransaction();

            $dadosLeitura = isset($dadosRequisicao['isbn']) ? $this->pesquisaIsbnBase($dadosRequisicao['isbn']) : null;
            $idLeitura = $dadosLeitura->id_leitura ?? null;

            if (! $idLeitura) {
                if (empty($dadosRequisicao['id_editora'])) {
                    $editoraService = new EditoraService;
                    $editoraNova = $editoraService->cadastrarEditora($dadosRequisicao);

                    $resultado['cadastroEditora'] = $editoraNova->getData()->success;
                    $resultado['mensagens']['cadastroEditora'] = $editoraNova->getData()->message;
                    $resultado['statusCode'] = $editoraNova->getStatusCode();

                    $dadosRequisicao['id_editora'] = $editoraNova->getData()->data->id_editora ?? null;
                }

                if (! empty($dadosRequisicao['id_editora'])) {
                    $novaLeitura = $this->model->create($dadosRequisicao);
                    $idLeitura = $novaLeitura->id_leitura;

                    $resultado['cadastroLeitura'] = $idLeitura > 0;
                    $resultado['mensagens']['cadastroLeitura'] = $idLeitura > 0 ? 'Sucesso ao cadastrar leitura' : 'Erro ao cadastrar leitura';
                    $resultado['statusCode'] = $idLeitura > 0 ? 200 : $resultado['statusCode'];
                }
            } else {
                $resultado['mensagens']['cadastroLeitura'] = 'Já existe essa leitura no banco de dados';
                $resultado['statusCode'] = 409;
            }

            if ($idLeitura) {
                $usuarioLeituraService = new UsuarioLeituraService;
                $cadastroLeituraUsuario = $usuarioLeituraService->salvarLeituraUsuario($idLeitura, $dadosRequisicao);

                $resultado['cadastroLeituraUsuario'] = $cadastroLeituraUsuario->getData()->success;
                $resultado['mensagens']['cadastroLeituraUsuario'] = $cadastroLeituraUsuario->getData()->message;
                $resultado['statusCode'] = $cadastroLeituraUsuario->getStatusCode();
            }

            DB::commit();

            return response()->json([
                'success' => [
                    'cadastroEditora' => $resultado['cadastroEditora'],
                    'cadastroLeitura' => $resultado['cadastroLeitura'],
                    'cadastroLeituraUsuario' => $resultado['cadastroLeituraUsuario'],
                ],
                'message' => $resultado['mensagens'],
                'data' => $this->model->find($idLeitura),
            ], $resultado['statusCode']);
        } catch (Exception $exception) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Erro ao cadastrar leitura',
                'erroDev' => $exception->getMessage(),
            ], 500);
        }
    }
}
