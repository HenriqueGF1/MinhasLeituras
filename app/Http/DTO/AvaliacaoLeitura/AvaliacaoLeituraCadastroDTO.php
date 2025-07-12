<?php

namespace App\Http\DTO\AvaliacaoLeitura;

use Carbon\Carbon;
use Exception;

class AvaliacaoLeituraCadastroDTO
{
    public readonly int $id_leitura;

    public readonly int $id_usuario;

    public readonly int $nota;

    public readonly string $descricao_avaliacao;

    public readonly Carbon $data_inicio;

    public readonly Carbon $data_termino;

    public readonly Carbon $data_registro;

    public function __construct(array $dados)
    {
        $camposObrigatorios = [
            'id_leitura',
            'id_usuario',
            'nota',
            'descricao_avaliacao',
            'data_inicio',
            'data_termino',
        ];

        foreach ($camposObrigatorios as $campo) {
            if (! array_key_exists($campo, $dados)) {
                throw new \InvalidArgumentException("Campo obrigatório '{$campo}' não foi fornecido.");
            }
        }

        $this->id_usuario = $dados['id_usuario'];
        $this->id_leitura = $dados['id_leitura'];
        $this->nota = $dados['nota'];
        $this->descricao_avaliacao = $dados['descricao_avaliacao'];

        try {
            $this->data_inicio = Carbon::createFromFormat('Y-m-d', $dados['data_inicio']);
        } catch (Exception $e) {
            throw new \InvalidArgumentException("Data inválida: {$dados['data_inicio']}");
        }

        try {
            $this->data_termino = Carbon::createFromFormat('Y-m-d', $dados['data_termino']);
        } catch (Exception $e) {
            throw new \InvalidArgumentException("Data inválida: {$dados['data_termino']}");
        }

        $this->validar();
    }

    private function validar(): void
    {
        if (empty($this->id_usuario)) {
            throw new \InvalidArgumentException('É necessário informar id_usuario da leitura.');
        }

        if (empty($this->id_leitura)) {
            throw new \InvalidArgumentException('É necessário informar id_leitura da leitura.');
        }

        if (empty($this->nota)) {
            throw new \InvalidArgumentException('É necessário informar nota da leitura.');
        }

        if (empty($this->descricao_avaliacao)) {
            throw new \InvalidArgumentException('É necessário informar descricao_avaliacao da leitura.');
        }

        if (empty($this->data_inicio)) {
            throw new \InvalidArgumentException('É necessário informar data_inicio da leitura.');
        }

        if (empty($this->data_termino)) {
            throw new \InvalidArgumentException('É necessário informar data_termino da leitura.');
        }
    }

    public function toArray(): array
    {
        return [
            'id_leitura' => $this->id_leitura,
            'id_usuario' => $this->id_usuario,
            'nota' => $this->nota,
            'descricao_avaliacao' => $this->descricao_avaliacao,
            'data_inicio' => $this->data_inicio->format('Y-m-d'),
            'data_termino' => $this->data_termino->format('Y-m-d'),
        ];
    }
}
