<?php

namespace App\Http\DTO\Autor;

class AutorCadastroDTO
{
    public readonly string $nome_autor;

    public function __construct(array $dados)
    {
        $camposObrigatorios = [
            'nome_autor',
        ];

        foreach ($camposObrigatorios as $campo) {
            if (! array_key_exists($campo, $dados)) {
                throw new \InvalidArgumentException("Campo obrigatório '{$campo}' não foi fornecido.");
            }
        }

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
            'nome' => $this->nome_autor,
        ];
    }
}
