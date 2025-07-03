<?php

namespace App\Http\Services\Genero;

use App\Http\DTO\CadastroLeituraDto;
use App\Http\DTO\GeneroLeitura\Fabrica\GeneroLeituraCadastroDTOFactory;
use App\Http\DTO\GeneroLeitura\Fabrica\GeneroLeituraPesquisaDTOFactory;
use App\Http\Services\Leituras\ProcessoCadastroLeituraHandler;

class GeneroLeituraProcessoHandler extends ProcessoCadastroLeituraHandler
{
    public function __construct(
        protected GeneroPesquisa $generoPesquisa,
        protected GeneroLeituraCadastro $generoLeituraCadastro,
        protected GeneroLeituraPesquisaDTOFactory $generoLeituraPesquisaDTOFactory,
        protected GeneroLeituraCadastroDTOFactory $generoLeituraCadastroDTOFactory
    ) {}

    public function processar(CadastroLeituraDto $dto): CadastroLeituraDto
    {
        $pesquisaDto = $this->generoLeituraPesquisaDTOFactory->criarDTO($dto->toArray());
        $dadosGenero = $this->generoPesquisa->pesquisarGeneroLeitura($pesquisaDto);

        if ($dadosGenero->isEmpty()) {
            $cadastroDto = $this->generoLeituraCadastroDTOFactory->criarDTO($dto->toArray());
            $this->generoLeituraCadastro->cadastrarGeneroLeitura($cadastroDto);
        }

        return $this->next
            ? $this->next->processar($dto)
            : $dto;
    }
}
