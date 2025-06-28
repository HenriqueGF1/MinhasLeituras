<?php

namespace App\Http\DTO;

class LeituraDTO
{
    // Leitura
    public ?int $id_leitura = null;

    public string $titulo;

    public string $descricao;

    public ?string $capa = null;

    public ?string $isbn = null;

    public ?string $data_publicacao = null;

    public ?string $data_registro = null;

    public ?int $qtd_capitulos = null;

    public ?int $qtd_paginas = null;

    public ?int $id_editora = null;

    public ?int $id_autor = null;

    public function __construct(array $dados)
    {
        $this->id_leitura = $dados['id_leitura'] ?? null;
        $this->titulo = $dados['titulo'] ?? '';
        $this->descricao = $dados['descricao'] ?? '';
        $this->capa = $dados['capa'] ?? null;
        $this->isbn = $dados['isbn'] ?? null;
        $this->data_publicacao = $dados['data_publicacao'] ?? null;
        $this->data_registro = $dados['data_registro'] ?? null;
        $this->qtd_capitulos = $dados['qtd_capitulos'] ?? null;
        $this->qtd_paginas = $dados['qtd_paginas'] ?? null;
        $this->id_editora = $dados['id_editora'] ?? null;
        $this->id_autor = $dados['id_autor'] ?? null;
    }

    public function toArray(): array
    {
        return [
            'id_leitura' => $this->id_leitura,
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
