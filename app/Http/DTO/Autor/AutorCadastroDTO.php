<?php

namespace App\Http\DTO\Autor;

class AutorCadastroDTO
{
    public readonly string $nome;

    public function __construct(array $dados)
    {
        $this->nome = $dados['nome'];

        $this->validar();
    }

    private function validar(): void
    {
        if (empty($this->nome)) {
            throw new \InvalidArgumentException('É necessário informar nome autor.');
        }
    }

    public function toArray(): array
    {
        return [
            'nome' => $this->nome,
        ];
    }
}
