<?php

namespace App\Http\Facades\Leitura\ProcessoCadastroLeitura;

use App\Http\DTO\Leitura\CadastroLeituraDto;
use App\Http\DTO\Leitura\Fabrica\LeituraCadastroDTOFactory;
use App\Http\DTO\Leitura\Fabrica\LeituraPesquisaDTOFactory;
use App\Http\Services\Leituras\LeituraCadastro;
use App\Http\Services\Leituras\LeituraPesquisa;

class LeituraProcessoHandler extends ProcessoCadastroLeituraHandler
{
    public function __construct(
        protected LeituraPesquisa $leituraPesquisa,
        protected LeituraCadastro $leituraCadastro,
        private LeituraPesquisaDTOFactory $leituraPesquisaDTOFactory,
        private LeituraCadastroDTOFactory $leituraCadastroDTOFactory,
    ) {}

    public function processar(CadastroLeituraDto $dto): CadastroLeituraDto
    {
        $pesquisaDto = $this->leituraPesquisaDTOFactory->criarDTO($dto->toArray());
        $registro = $this->leituraPesquisa->pesquisaLeitura($pesquisaDto);

        if ($registro?->id_leitura) {
            $dto->id_leitura = $registro->id_leitura;
        } else {
            $cadastroDto = $this->leituraCadastroDTOFactory->criarDTO($dto->toArray());
            $novoId = $this->leituraCadastro->cadastroDeLeitura($cadastroDto);
            $dto->id_leitura = $novoId?->id_leitura;
        }

        return $this->next
            ? $this->next->processar($dto)
            : $dto;
    }
}
