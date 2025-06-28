<?php

namespace App\Http\Services\Autor;

use App\Http\Services\Leituras\ProcessoCadastroLeituraHandler;

class AutorPrecessoHandler extends ProcessoCadastroLeituraHandler
{
    public function __construct(
        protected AutorPesquisa $autorPesquisa,
        protected AutorCadastro $autorCadastro
    ) {}

    public function processar(array &$dados): array
    {
        $this->checaSeExisteRegistro($dados);

        if (! empty($dados['id_autor'])) {
            unset($dados['nome_autor']);

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
        if (! empty($dados['id_autor']) || ! empty($dados['nome'])) {
            $dadosAutor = $this->autorPesquisa->pesquisaAutor(
                isset($dados['id_autor']),
                $dados['nome_autor'] ?? ''
            );

            $dados['id_autor'] = isset($dadosAutor?->id_autor) ? $dadosAutor?->id_autor : null;

            return $dados;
        }

        return $dados;
    }

    private function cadastra(array &$dados)
    {
        $dados['id_autor'] = $this->autorCadastro->cadastrarAutor($dados['nome'] ?? '')?->id_autor;
    }
}
