<?php

namespace App\Http\Services\Leituras;

use App\Http\DTO\CadastroLeituraDTO;
use App\Http\DTO\LeituraDTO;

class LeituraProcessoHandler extends ProcessoCadastroLeituraHandler
{
    public function __construct(
        protected LeituraPesquisa $leituraPesquisa,
        protected LeituraCadastro $leituraCadastro
    ) {}

    public function processar(CadastroLeituraDTO $cadastroDto): CadastroLeituraDTO
    {
        $leituraDto = new LeituraDTO($cadastroDto->toArray());

        if (isset($leituraDto->id_leitura)) {
            $this->checaSeExisteRegistro($leituraDto);
        }

        if (empty($leituraDto->id_leitura)) {
            $this->cadastra($leituraDto);
        }

        $cadastroDto->id_leitura = $leituraDto->id_leitura;

        return $this->next
            ? $this->next->processar($cadastroDto)
            : $cadastroDto;
    }

    protected function checaSeExisteRegistro(LeituraDTO $leituraDto): void
    {
        if (! empty($leituraDto->id_leitura) || ! empty($leituraDto->titulo)) {
            $registro = $this->leituraPesquisa->pesquisaLeitura($leituraDto);
            $leituraDto->id_leitura = $registro?->id_leitura ?? null;
        }
    }

    protected function cadastra(LeituraDTO $leituraDto): void
    {
        dd('Vai cadastrar LeituraDTO');
        $leituraDto->id_leitura = $this->leituraCadastro
            ->cadastroDeLeitura($leituraDto)?->id_leitura;
    }
}
