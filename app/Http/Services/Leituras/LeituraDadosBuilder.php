<?php

namespace App\Http\Services\Leituras;

class LeituraDadosBuilder
{
    protected array $dados = [];

    /**
     * Lista de chaves permitidas.
     */
    protected array $chavesPermitidas = [
        'titulo',
        'descricao',
        'capa',
        'id_editora',
        'descricao_editora',
        'id_autor',
        'nome_autor',
        'data_publicacao',
        'qtd_capitulos',
        'qtd_paginas',
        'isbn',
        'data_registro',
        'id_usuario',
        'id_leitura',
        'id_genero',
        'id_status_leitura',
    ];

    public function comDados(array $dados): self
    {
        foreach ($this->chavesPermitidas as $chave) {
            if (array_key_exists($chave, $dados)) {
                $this->dados[$chave] = $dados[$chave];
            }
        }

        return $this;
    }

    public function limparNulos(): self
    {
        $this->dados = array_filter(
            $this->dados,
            fn($valor) => !is_null($valor)
        );

        return $this;
    }

    public function build(): array
    {
        return $this->dados;
    }
}
