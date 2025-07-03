<?php

namespace App\Http\DTO\Leitura\Fabrica;

use App\Http\DTO\Leitura\LeituraCadastroDTO;

class LeituraCadastroDTOFactory implements LeituraDTOFactory
{
    public function criarDTO(array $dados): LeituraCadastroDTO
    {
        $dadosCadastro = [
            'titulo' => (string) $dados['titulo'],
            'descricao' => (string) $dados['descricao'],
            'capa' => isset($dados['capa']) ? (string) $dados['capa'] : null,
            'isbn' => isset($dados['isbn']) ? (string) $dados['isbn'] : null,
            'data_publicacao' => isset($dados['data_publicacao']) ? (string) $dados['data_publicacao'] : null,
            'data_registro' => '1990-11-26',
            'qtd_capitulos' => isset($dados['qtd_capitulos']) ? (int) $dados['qtd_capitulos'] : null,
            'qtd_paginas' => isset($dados['qtd_paginas']) ? (int) $dados['qtd_paginas'] : null,
            'id_editora' => isset($dados['id_editora']) ? (int) $dados['id_editora'] : null,
            'id_autor' => isset($dados['id_autor']) ? (int) $dados['id_autor'] : null,
        ];

        return new LeituraCadastroDTO(
            $dadosCadastro
        );
    }
}
