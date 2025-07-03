<?php

namespace App\Http\DTO\GeneroLeitura\Fabrica;

use App\Http\DTO\GeneroLeitura\GeneroLeituraCadastroDTO;

class GeneroLeituraCadastroDTOFactory implements GeneroLeituraDTOFactory
{
    public function criarDTO(array $dados): GeneroLeituraCadastroDTO
    {
        $dadosCadastro = [
            'id_genero' => (array) $dados['id_genero'],
            'id_leitura' => (int) $dados['id_leitura'],
        ];

        return new GeneroLeituraCadastroDTO(
            $dadosCadastro
        );
    }
}
