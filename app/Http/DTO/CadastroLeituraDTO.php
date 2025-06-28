<?php

namespace App\Http\DTO;

use InvalidArgumentException;

class CadastroLeituraDTO
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

    // Editora
    public ?int $id_editora = null;

    public ?string $descricao_editora = null;

    // Autor
    public ?int $id_autor = null;

    public ?string $nome_autor = null;

    // Usuário e status
    public int $id_usuario;

    public int $id_status_leitura;

    // Gêneros (array de inteiros)
    public array $id_genero = [];

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
        $this->descricao_editora = $dados['descricao_editora'] ?? null;

        $this->id_autor = $dados['id_autor'] ?? null;
        $this->nome_autor = $dados['nome_autor'] ?? null;

        $this->id_usuario = $dados['id_usuario'];
        $this->id_status_leitura = $dados['id_status_leitura'];

        $this->id_genero = $dados['id_genero'] ?? [];

        $this->validar();
    }

    private function validar(): void
    {
        if (! empty($this->id_editora) && ! empty($this->descricao_editora)) {
            throw new InvalidArgumentException('Não é permitido preencher descrição da editora quando id editora já está definido.');
        }

        if (! empty($this->id_autor) && ! empty($this->nome_autor)) {
            throw new InvalidArgumentException('Não é permitido preencher nome do autor quando id autor já está definido.');
        }
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
            'descricao_editora' => $this->descricao_editora,

            'id_autor' => $this->id_autor,
            'nome_autor' => $this->nome_autor,

            'id_usuario' => $this->id_usuario,
            'id_status_leitura' => $this->id_status_leitura,
            'id_genero' => $this->id_genero,
        ];
    }
}
