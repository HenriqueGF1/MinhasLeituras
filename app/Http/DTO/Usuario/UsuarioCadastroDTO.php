<?php

namespace App\Http\DTO\Usuario;

use Carbon\Carbon;
use Exception;

class UsuarioCadastroDTO
{
    public readonly string $nome;

    public readonly string $email;

    public readonly string $password;

    public readonly Carbon $data_nascimento;

    public function __construct(array $dados)
    {
        $camposObrigatorios = [
            'nome',
            'email',
            'password',
            'data_nascimento',
        ];

        foreach ($camposObrigatorios as $campo) {
            if (! array_key_exists($campo, $dados)) {
                throw new \InvalidArgumentException("Campo obrigatório '{$campo}' não foi fornecido.");
            }
        }

        $this->nome = $dados['nome'];
        $this->email = $dados['email'];
        $this->password = $dados['password'];

        try {
            $this->data_nascimento = Carbon::createFromFormat('Y-m-d', $dados['data_nascimento']);
        } catch (Exception $e) {
            throw new \InvalidArgumentException("Data inválida: {$dados['data_nascimento']}");
        }

        $this->validar();
    }

    private function validar(): void
    {
        if (empty($this->nome) && empty($this->email) && empty($this->password)) {
            throw new \InvalidArgumentException('É necessário informar dados do usuario');
        }
    }

    public function toArray(): array
    {
        return [
            'nome' => $this->nome,
            'email' => $this->email,
            'password' => $this->password,
            'data_nascimento' => $this->data_nascimento->format('Y-m-d'),
        ];
    }
}
