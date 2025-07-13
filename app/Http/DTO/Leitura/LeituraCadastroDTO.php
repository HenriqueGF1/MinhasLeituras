<?php

namespace App\Http\DTO\Leitura;

class LeituraCadastroDTO
{
    public readonly string $titulo;

    public readonly string $descricao;

    public readonly string $capa;

    public ?string $isbn = null;

    public readonly string $data_publicacao;

    public readonly int $qtd_capitulos;

    public readonly int $qtd_paginas;

    public readonly int $id_editora;

    public readonly int $id_autor;

    public function __construct(array $dados)
    {
        $camposObrigatorios = [
            'titulo',
            'descricao',
            'capa',
            'data_publicacao',
            'qtd_capitulos',
            'qtd_paginas',
            'id_editora',
            'id_autor',
        ];

        foreach ($camposObrigatorios as $campo) {
            if (! array_key_exists($campo, $dados)) {
                throw new \InvalidArgumentException("Campo obrigatório '{$campo}' não foi fornecido.");
            }
        }

        $this->titulo = $dados['titulo'];
        $this->descricao = $dados['descricao'];
        $this->capa = $dados['capa'];
        $this->isbn = $dados['isbn'] ?? null;
        $this->data_publicacao = $dados['data_publicacao'];
        $this->qtd_capitulos = $dados['qtd_capitulos'];
        $this->qtd_paginas = $dados['qtd_paginas'];
        $this->id_editora = $dados['id_editora'];
        $this->id_autor = $dados['id_autor'];

        $this->validar();
    }

    private function validar(): void
    {
        if (empty($this->titulo)) {
            throw new \InvalidArgumentException('É necessário informar titulo leitura.');
        }

        if (empty($this->descricao)) {
            throw new \InvalidArgumentException('É necessário informar descricao leitura.');
        }

        if (empty($this->capa)) {
            throw new \InvalidArgumentException('É necessário informar capa leitura.');
        }
    }

    public function toArray(): array
    {
        return [
            'titulo' => $this->titulo,
            'descricao' => $this->descricao,
            'capa' => $this->capa,
            'isbn' => $this->isbn,
            'data_publicacao' => $this->data_publicacao,
            'qtd_capitulos' => $this->qtd_capitulos,
            'qtd_paginas' => $this->qtd_paginas,
            'id_editora' => $this->id_editora,
            'id_autor' => $this->id_autor,
        ];
    }
}
