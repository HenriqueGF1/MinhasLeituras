<?php

namespace App\Http\Services\Editora;

use App\Http\DTO\CadastroLeituraDto;
use App\Http\DTO\Editora\Fabrica\EditoraCadastroDTOFactory;
use App\Http\DTO\Editora\Fabrica\EditoraPesquisaDTOFactory;
use App\Http\Services\Leituras\ProcessoCadastroLeituraHandler;

class EditoraProcessoHandler extends ProcessoCadastroLeituraHandler
{
    public function __construct(
        protected EditoraPesquisa $editoraPesquisa,
        protected EditoraCadastro $editoraCadastro,
        private EditoraPesquisaDTOFactory $editoraPesquisaDTOFactory,
        private EditoraCadastroDTOFactory $editoraCadastroDTOFactory
    ) {}

    public function processar(CadastroLeituraDto $dto): CadastroLeituraDto
    {
        $pesquisaDto = $this->editoraPesquisaDTOFactory->criarDTO($dto->toArray());
        $registro = $this->editoraPesquisa->pesquisaEditora($pesquisaDto);

        if ($registro?->id_editora) {
            $dto->id_editora = $registro->id_editora;
        } else {
            $cadastroDto = $this->editoraCadastroDTOFactory->criarDTO($dto->toArray());
            $novoId = $this->editoraCadastro->cadastrarEditora($cadastroDto);
            $dto->id_editora = $novoId?->id_editora;
        }

        return $this->next
            ? $this->next->processar($dto)
            : $dto;
    }
}
