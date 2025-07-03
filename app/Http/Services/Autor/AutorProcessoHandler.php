<?php

namespace App\Http\Services\Autor;

use App\Http\DTO\Autor\Fabrica\AutorCadastroDTOFactory;

use App\Http\DTO\Autor\Fabrica\AutorPesquisaDTOFactory;
use App\Http\DTO\CadastroLeituraDto;
use App\Http\Services\Leituras\ProcessoCadastroLeituraHandler;

class AutorProcessoHandler extends ProcessoCadastroLeituraHandler
{
    public function __construct(
        protected AutorPesquisa $autorPesquisa,
        protected AutorCadastro $autorCadastro,
        private AutorPesquisaDTOFactory $pesquisaFactory,
        private AutorCadastroDTOFactory $cadastroFactory
    ) {}

    public function processar(CadastroLeituraDto $dto): CadastroLeituraDto
    {
        $pesquisaDto = $this->pesquisaFactory->criarDTO($dto->toArray());
        $registro = $this->autorPesquisa->pesquisaAutor($pesquisaDto);

        if ($registro?->id_autor) {
            $dto->id_autor = $registro->id_autor;
        } else {
            $cadastroDto = $this->cadastroFactory->criarDTO($dto->toArray());
            $novoId = $this->autorCadastro->cadastrarAutor($cadastroDto);
            $dto->id_autor = $novoId?->id_autor;
        }

        return $this->next
            ? $this->next->processar($dto)
            : $dto;
    }
}
