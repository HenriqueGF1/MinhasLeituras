<?php

namespace App\Http\DTO;

class UsuarioLeituraDTO
{
    public int $id_usuario;

    public int $id_leitura;

    public int $id_status_leitura;

    public ?string $data_publicacao = null;

    public ?string $data_registro = null;

    public function __construct(array $dados)
    {
        $this->id_leitura = $dados['id_leitura'];
        $this->id_usuario = $dados['id_usuario'];
        $this->data_publicacao = $dados['data_publicacao'] ?? null;
        $this->data_registro = $dados['data_registro'] ?? null;
        $this->id_status_leitura = $dados['id_status_leitura'];
    }

    public function toArray(): array
    {
        return [
            'id_leitura' => $this->id_leitura,
            'id_usuario' => $this->id_usuario,
            'id_status_leitura' => $this->id_status_leitura,
            'data_publicacao' => $this->data_publicacao,
            'data_registro' => $this->data_registro,
        ];
    }
}
