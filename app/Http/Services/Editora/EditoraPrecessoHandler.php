<?php

namespace App\Http\Services\Editora;

use App\Http\Services\Leituras\ProcessoCadastroLeituraHandler;

class EditoraPrecessoHandler extends ProcessoCadastroLeituraHandler
{
    public function __construct(
        protected EditoraPesquisa $editoraPesquisa,
        protected EditoraCadastro $editoraCadastro
    ) {}

    public function processar(array &$dados): array
    {
        $this->checaSeExisteRegistro($dados);

        if (! empty($dados['id_editora'])) {
            unset($dados['descricao_editora']);

            return $dados;
        }

        $this->cadastra($dados);

        if ($this->next) {
            return $this->next->processar($dados);
        }

        return $dados;
    }

    private function checaSeExisteRegistro(array &$dados): array
    {
        if (! empty($dados['id_editora']) || ! empty($dados['descricao'])) {
            $dadosAutor = $this->editoraPesquisa->pesquisaEditora(
                isset($dados['id_editora']),
                $dados['descricao'] ?? ''
            );

            $dados['id_editora'] = isset($dadosAutor?->id_editora) ? $dadosAutor?->id_editora : null;

            return $dados;
        }

        return $dados;
    }

    private function cadastra(array &$dados)
    {
        $dados['id_editora'] = $this->editoraCadastro->cadastrarEditora($dados['descricao'] ?? '')?->id_editora;
    }
}
