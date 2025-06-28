<?php

namespace App\Http\Services\Editora;

use App\Http\DTO\CadastroLeituraDTO;
use App\Http\DTO\EditoraDTO;
use App\Http\Services\Leituras\ProcessoCadastroLeituraHandler;

class EditoraPrecessoHandler extends ProcessoCadastroLeituraHandler
{
    public function __construct(
        protected EditoraPesquisa $editoraPesquisa,
        protected EditoraCadastro $editoraCadastro,
    ) {}

    public function processar(CadastroLeituraDTO $leituraDto): CadastroLeituraDTO
    {
        $editoraDto = new EditoraDTO($leituraDto->toArray());

        $this->checaSeExisteRegistro($editoraDto);

        if (empty($editoraDto->id_editora)) {
            $this->cadastra($editoraDto);
        }

        $leituraDto->id_editora = $editoraDto->id_editora;
        $leituraDto->descricao_editora = $editoraDto->descricao_editora;

        return $this->next
            ? $this->next->processar($leituraDto)
            : $leituraDto;
    }

    private function checaSeExisteRegistro(EditoraDTO $dto): void
    {
        if (! empty($dto->id_editora) || ! empty($dto->descricao_editora)) {
            $registro = $this->editoraPesquisa->pesquisaEditora($dto);
            $dto->id_editora = $registro?->id_editora ?? null;
        }
    }

    private function cadastra(EditoraDTO $dto): void
    {
        $dto->id_editora = $this->editoraCadastro
            ->cadastrarEditora($dto)?->id_editora;
    }
}
