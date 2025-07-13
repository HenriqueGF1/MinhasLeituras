<?php

namespace App\Http\DTO\GeneroLeitura;

class GeneroLeituraCadastroDTO
{
    public readonly array $id_genero;

    public readonly int $id_leitura;

    public function __construct(array $dados)
    {
        $camposObrigatorios = [
            'id_genero',
            'id_leitura',
        ];

        foreach ($camposObrigatorios as $campo) {
            if (! array_key_exists($campo, $dados)) {
                throw new \InvalidArgumentException("Campo obrigatório '{$campo}' não foi fornecido.");
            }
        }

        $this->id_genero = $dados['id_genero'];
        $this->id_leitura = $dados['id_leitura'];

        $this->validar();
    }

    private function validar(): void
    {
        if (empty($this->id_genero) && empty($this->id_leitura)) {
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
            'id_genero' => $this->id_genero,
            'id_leitura' => $this->id_leitura,
        ];
    }
}
