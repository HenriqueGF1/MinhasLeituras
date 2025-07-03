<?php

namespace App\Http\DTO\Autor;

class AutorCadastroDTO
{
    public string $nome_autor;

    public function __construct(array $dados)
    {
        $this->nome_autor = $dados['nome_autor'];

        $this->validar();
    }

    private function validar(): void
    {
        if (empty($this->nome_autor)) {
            throw new \InvalidArgumentException('É necessário informar nome autor.');
        }
    }

    public function toArray(): array
    {
        return [
            'nome_autor' => $this->nome_autor,
        ];
    }
}
