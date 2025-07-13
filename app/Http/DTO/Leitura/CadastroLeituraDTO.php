<?php

namespace App\Http\DTO\Leitura;

use InvalidArgumentException;

class CadastroLeituraDto
{
    // Leitura
    public ?int $id_leitura = null;

    public string $titulo;

    public string $descricao;

    public string $capa;

    public ?string $isbn = null;

    public string $data_publicacao;

    public ?string $data_registro = null;

    public int $qtd_capitulos;

    public int $qtd_paginas;

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
        $this->titulo = trim($dados['titulo'] ?? '');
        $this->descricao = trim($dados['descricao'] ?? '');
        $this->capa = trim($dados['capa'] ?? '');
        $this->isbn = $dados['isbn'] ?? null;
        $this->data_publicacao = $dados['data_publicacao'] ?? '';
        $this->data_registro = $dados['data_registro'] ?? null;
        $this->qtd_capitulos = (int) ($dados['qtd_capitulos'] ?? 0);
        $this->qtd_paginas = (int) ($dados['qtd_paginas'] ?? 0);

        $this->id_editora = $dados['id_editora'] ?? null;
        $this->descricao_editora = $dados['descricao_editora'] ?? null;

        $this->id_autor = $dados['id_autor'] ?? null;
        $this->nome_autor = $dados['nome_autor'] ?? null;

        $this->id_usuario = (int) ($dados['id_usuario'] ?? 0);
        $this->id_status_leitura = (int) ($dados['id_status_leitura'] ?? 0);

        $this->id_genero = array_map('intval', $dados['id_genero'] ?? []);

        $this->validar();
    }

    private function validar(): void
    {
        if (empty($this->titulo)) {
            throw new InvalidArgumentException('Campo "titulo" é obrigatório.');
        }

        if (empty($this->descricao)) {
            throw new InvalidArgumentException('Campo "descricao" é obrigatório.');
        }

        if (empty($this->capa)) {
            throw new InvalidArgumentException('Campo "capa" é obrigatório.');
        }

        if (empty($this->data_publicacao)) {
            throw new InvalidArgumentException('Campo "data_publicacao" é obrigatório.');
        }

        if ($this->qtd_capitulos <= 0) {
            throw new InvalidArgumentException('Campo "qtd_capitulos" deve ser maior que zero.');
        }

        if ($this->qtd_paginas <= 0) {
            throw new InvalidArgumentException('Campo "qtd_paginas" deve ser maior que zero.');
        }

        if ($this->id_usuario <= 0) {
            throw new InvalidArgumentException('Campo "id_usuario" é obrigatório.');
        }

        if ($this->id_status_leitura <= 0) {
            throw new InvalidArgumentException('Campo "id_status_leitura" é obrigatório.');
        }

        if (! empty($this->id_editora) && ! empty($this->descricao_editora)) {
            throw new InvalidArgumentException('Não é permitido preencher descrição da editora quando id da editora está definido.');
        }

        if (! empty($this->id_autor) && ! empty($this->nome_autor)) {
            throw new InvalidArgumentException('Não é permitido preencher nome do autor quando id do autor está definido.');
        }

        foreach ($this->id_genero as $genero) {
            if (! is_int($genero) || $genero <= 0) {
                throw new InvalidArgumentException('Todos os gêneros devem ser inteiros positivos.');
            }
        }
    }

    public function toArray(): array
    {
        return array_filter([
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
        ], function ($value) {
            return $value !== null && $value !== [];
        });
    }
}
