<?php

namespace App\Http\DTO\GeneroLeitura;

class GeneroLeituraCadastroDTO
{
    public array $id_genero;

    public int $id_leitura;

    public function __construct(array $dados)
    {
        $this->id_genero = $dados['id_genero'];
        $this->id_leitura = $dados['id_leitura'];

        $this->validar();
    }

    private function validar(): void
    {
        if (empty($this->id_genero) && empty($this->id_leitura)) {
            throw new \InvalidArgumentException('É necessário informar id genero e id leitura');
        }
    }

    public function toArray(): array
    {
        return [
            'id_genero' => $this->id_genero,
            'id_leitura' => $this->id_leitura,
        ];
    }
}
