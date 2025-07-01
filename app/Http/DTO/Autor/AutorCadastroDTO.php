<?php

namespace App\Http\DTO\Autor;

// Define o namespace da classe, organizando o código dentro da estrutura do projeto Laravel.

use Illuminate\Http\Request;

// Importa a classe Request do Laravel, que é usada para manipular requisições HTTP.

readonly class AutorCadastroDTO
// Declara a classe AutorCadastroDTO como "readonly", ou seja, suas propriedades são imutáveis após a criação do objeto.
{
    public function __construct(public string $nome_autor)
    // Método construtor que recebe uma string $nome_autor e cria a propriedade pública do objeto com esse valor.
    {}

    public static function fromRequest(Request $request): self
    // Método estático que cria uma instância da classe a partir de um objeto Request.
    {
        return new self(nome_autor: $request->input('nome_autor'));
        // Cria um novo objeto AutorCadastroDTO extraindo o valor 'nome_autor' da requisição HTTP.
    }

    public function toArray(): array
    // Método que converte o objeto em um array associativo.
    {
        return ['nome_autor' => $this->nome_autor];
        // Retorna um array com a chave 'nome_autor' e o valor da propriedade do objeto.
    }
}
