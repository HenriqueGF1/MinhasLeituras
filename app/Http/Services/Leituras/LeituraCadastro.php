<?php

namespace App\Http\Services\Leituras;

use App\Http\DTO\LeituraDTO;
use App\Models\Leituras;
use Exception;
use Illuminate\Support\Facades\DB;

class LeituraCadastro
{
    public function __construct(protected Leituras $model, protected LeituraPesquisa $pesquisaLeitura) {}

    public function cadastroDeLeitura(LeituraDTO $leituraDto): Leituras
    {
        DB::beginTransaction();

        try {
            $leitura = Leituras::create([
                'titulo' => $leituraDto->titulo,
                'descricao' => $leituraDto->descricao,
                'capa' => $leituraDto->capa,
                'id_editora' => $leituraDto->id_editora,
                'id_autor' => $leituraDto->id_autor,
                'data_publicacao' => $leituraDto->data_publicacao,
                'qtd_capitulos' => $leituraDto->qtd_capitulos,
                'qtd_paginas' => $leituraDto->qtd_paginas,
                'isbn' => $leituraDto->isbn,
                'data_registro' => $leituraDto->data_registro,
            ]);

            DB::commit();

            return $leitura;
        } catch (Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }
}
