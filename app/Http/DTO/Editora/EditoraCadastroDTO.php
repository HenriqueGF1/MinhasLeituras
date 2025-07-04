<?php

namespace App\Http\DTO\Editora;

readonly class EditoraCadastroDTO
{
    public string $descricao_editora;

    public function __construct(array $dados)
    {
        $this->descricao_editora = $dados['descricao_editora'];

        $this->validar();
    }

    private function validar(): void
    {
        if (empty($this->descricao_editora)) {
            throw new \InvalidArgumentException('É necessário informar descricao da editora.');
        }
    }

    public function toArray(): array
    {
        return [
            'descricao_editora' => $this->descricao_editora,
        ];
    }
}
