<?php

namespace App\Http\DTO;

class GeneroLeituraDTO
{
    // Para Juncao de GENERO E LEITURA
    public ?int $id_genero_leitura = null;

    public array $id_genero;

    public int $id_leitura;

    public ?string $data_registro = null;

    public function __construct(array $dados)
    {
        $this->id_genero_leitura = $dados['id_genero_leitura'] ?? null;
        $this->id_genero = $dados['id_genero'];
        $this->id_leitura = $dados['id_leitura'];
        $this->data_registro = $dados['data_registro'] ?? null;

        $this->validar();
    }

    private function validar(): void
    {
        if (empty($this->id_genero) || ! is_array($this->id_genero) || count($this->id_genero) === 0) {
            throw new \InvalidArgumentException('O campo id_genero é obrigatório e não pode estar vazio.');
        }

        if (empty($this->id_genero) && empty($this->id_leitura)) {
            throw new \InvalidArgumentException('É necessário informar id genero e id leitura.');
        }
    }

    public function toArray(): array
    {
        return [
            'id_genero_leitura' => $this->id_genero_leitura,
            'id_genero' => $this->id_genero,
            'id_leitura' => $this->id_leitura,
            'data_registro' => $this->data_registro,
        ];
    }
}
