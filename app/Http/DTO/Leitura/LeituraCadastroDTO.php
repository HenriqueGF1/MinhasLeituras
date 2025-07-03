<?php

namespace App\Http\DTO\Leitura;

class LeituraCadastroDTO
{
    public string $titulo;

    public string $descricao;

    public ?string $capa;

    public ?string $isbn = null;

    public ?string $data_publicacao = null;

    public ?string $data_registro;

    public ?int $qtd_capitulos;

    public ?int $qtd_paginas;

    public ?int $id_editora;

    public ?int $id_autor;

    public function __construct(array $dados)
    {
        $this->titulo = $dados['titulo'];
        $this->descricao = $dados['descricao'];
        $this->capa = $dados['capa'];
        $this->isbn = $dados['isbn'] ?? null;
        $this->data_publicacao = $dados['data_publicacao'];
        $this->data_registro = $dados['data_registro'] ?? null;
        $this->qtd_capitulos = $dados['qtd_capitulos'];
        $this->qtd_paginas = $dados['qtd_paginas'];
        $this->id_editora = $dados['id_editora'];
        $this->id_autor = $dados['id_autor'];
    }

    public function toArray(): array
    {
        return [
            'titulo' => $this->titulo,
            'descricao' => $this->descricao,
            'capa' => $this->capa,
            'isbn' => $this->isbn,
            'data_publicacao' => $this->data_publicacao,
            'data_registro' => $this->data_registro,
            'qtd_capitulos' => $this->qtd_capitulos,
            'qtd_paginas' => $this->qtd_paginas,
            'id_editora' => $this->id_editora,
            'id_autor' => $this->id_autor,
        ];
    }
}
