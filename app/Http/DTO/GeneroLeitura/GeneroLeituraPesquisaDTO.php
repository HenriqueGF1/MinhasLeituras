<?php

namespace App\Http\DTO\GeneroLeitura;

class GeneroLeituraPesquisaDTO
{
    public ?int $id_genero_leitura = null;

    public ?array $id_genero = null;

    public ?int $id_leitura = null;

    public function __construct(array $dados)
    {
        $this->id_genero_leitura = $dados['id_genero_leitura'] ?? null;
        $this->id_genero = $dados['id_genero'] ?? null;
        $this->id_leitura = $dados['id_leitura'] ?? null;

        $this->validar();
    }

    private function validar(): void
    {
        if (! is_null($this->id_genero_leitura)) {
            throw new \InvalidArgumentException('É necessário informar id genero e id leitura');
        }

        if (empty($this->id_genero)) {
            throw new \InvalidArgumentException('É necessário informar id genero');
        }

        if (empty($this->id_leitura)) {
            throw new \InvalidArgumentException('É necessário informar id leitura');
        }
    }

    public function toArray(): array
    {
        return [
            'id_genero_leitura' => $this->id_genero_leitura,
            'id_genero' => $this->id_genero,
            'id_leitura' => $this->id_leitura,
        ];
    }
}
