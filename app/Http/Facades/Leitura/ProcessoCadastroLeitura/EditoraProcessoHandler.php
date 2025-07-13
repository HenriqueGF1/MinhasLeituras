<?php

namespace App\Http\Facades\Leitura\ProcessoCadastroLeitura;

use App\Http\DTO\Editora\Fabrica\EditoraCadastroDTOFactory;
use App\Http\DTO\Editora\Fabrica\EditoraPesquisaDTOFactory;
use App\Http\DTO\Leitura\CadastroLeituraDto;
use App\Http\Services\Editora\EditoraCadastro;
use App\Http\Services\Editora\EditoraPesquisa;

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
        // dd($dto);
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
