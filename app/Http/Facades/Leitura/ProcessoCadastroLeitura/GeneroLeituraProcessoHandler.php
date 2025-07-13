<?php

namespace App\Http\Facades\Leitura\ProcessoCadastroLeitura;

use App\Http\DTO\GeneroLeitura\Fabrica\GeneroLeituraCadastroDTOFactory;

use App\Http\DTO\GeneroLeitura\Fabrica\GeneroLeituraPesquisaDTOFactory;
use App\Http\DTO\Leitura\CadastroLeituraDto;
use App\Http\Services\Genero\GeneroLeituraCadastro;
use App\Http\Services\Genero\GeneroPesquisa;

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
