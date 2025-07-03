<?php

namespace App\Http\DTO\Editora;

class EditoraPesquisaDTO
{
    // Editora
    public ?int $id_editora = null;

    public ?string $descricao_editora = null;

    public function __construct(array $dados)
    {
        $this->id_editora = $dados['id_editora'] ?? null;
        $this->descricao_editora = $dados['descricao_editora'] ?? null;

        $this->validar();
    }

    private function validar(): void
    {
        if (empty($this->id_editora) && empty($this->descricao_editora)) {
            throw new \InvalidArgumentException('É necessário informar id editora ou descricao editora.');
        }
    }

    public function toArray(): array
    {
        return [
            'id_editora' => $this->id_editora,
            'descricao_editora' => $this->descricao_editora,
        ];
    }
}
