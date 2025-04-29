<?php

declare(strict_types=1);

namespace App\Http\Services\Leituras;

use App\Models\Leituras;
use Illuminate\Pagination\LengthAwarePaginator;

class LeiturasService
{
    protected CadastroDeLeituraService $cadastroDeLeituraService;

    public function __construct(CadastroDeLeituraService $cadastroDeLeituraService)
    {
        $this->cadastroDeLeituraService = $cadastroDeLeituraService;
    }

    public function pesquisarLeituras(): LengthAwarePaginator
    {
        return Leituras::paginate();
    }

    /** Pesuisa do ISBN no meu banco de dados */
    public function pesquisaIsbnBase($isbn): ?Leituras
    {
        $isbn = isset($isbn->isbn) ? $isbn->isbn : $isbn;

        return Leituras::where('isbn', '=', $isbn)->first();
    }

    public function cadastrarLeitura($dadosRequisicao): ?Leituras
    {
        $dadosLeitura = isset($dadosRequisicao['isbn']) ? $this->pesquisaIsbnBase($dadosRequisicao['isbn']) : null;

        $dadosRequisicao['id_leitura'] = $dadosLeitura['id_leitura'] ?? $dadosRequisicao['id_leitura'] ?? null;
        $dadosRequisicao['id_editora'] = $dadosLeitura['id_editora'] ?? $dadosRequisicao['id_editora'] ?? null;

        $dadosRequisicao = array_filter($dadosRequisicao, fn ($valor) => ! is_null($valor));

        $leitura = $this->cadastroDeLeituraService->cadastroDeLeitura($dadosRequisicao);

        return Leituras::where('id_leitura', '=', $leitura['id_leitura'])->first();
    }
}
