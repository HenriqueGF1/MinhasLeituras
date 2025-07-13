<?php

namespace App\Http\DTO\Autor;

class AutorPesquisaDTO
{
    public ?int $id_autor = null;

    public ?string $nome_autor = null;

    public function __construct(array $dados)
    {
        $this->id_autor = $dados['id_autor'] ?? null;
        $this->nome_autor = $dados['nome_autor'] ?? null;

        $this->validar();
    }

    private function validar(): void
    {
        if (empty($this->id_autor) && empty($this->nome_autor)) {
            throw new \InvalidArgumentException('É necessário informar id ou nome autor.');
        }
    }

    public function toArray(): array
    {
        return [
            'id_autor' => $this->id_autor,
            'nome_autor' => $this->nome_autor,
        ];
    }
}
