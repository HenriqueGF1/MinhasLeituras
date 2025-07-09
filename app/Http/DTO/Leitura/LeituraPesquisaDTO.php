<?php

namespace App\Http\DTO\Leitura;

class LeituraPesquisaDTO
{
    // Leitura
    public ?int $id_leitura = null;

    public ?string $titulo = null;

    public function __construct(array $dados)
    {
        $this->id_leitura = $dados['id_leitura'] ?? null;
        $this->titulo = $dados['titulo'] ?? '';
        $this->validar();
    }

    private function validar(): void
    {
        if (empty($this->id_leitura) && empty($this->titulo)) {
            throw new \InvalidArgumentException('É necessário informar id ou titulo da leitura.');
        }
    }

    public function toArray(): array
    {
        return [
            'id_leitura' => $this->id_leitura,
            'titulo' => $this->titulo,
        ];
    }
}
