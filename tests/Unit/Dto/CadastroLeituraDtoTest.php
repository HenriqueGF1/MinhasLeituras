<?php

namespace Tests\Unit\Dto;

use App\Http\DTO\Leitura\CadastroLeituraDto;
use InvalidArgumentException;
use Tests\TestCase;

class CadastroLeituraDtoTest extends TestCase
{
    public function test_criando_dto_sem_dados_obrigatorios()
    {
        // ARRANGE (Preparar)
        $livro = '{
            "descricao": "Escrito por Rick Riordan, este é o primeiro livro da série Percy Jackson e os Olimpianos. A história segue Percy, um garoto que descobre ser um semideus, filho de Poseidon, e embarca em uma missão para recuperar o raio mestre de Zeus e evitar uma guerra entre os deuses do Olimpo.",
            "capa": "https://upload.wikimedia.org/wikipedia/pt/4/4b/Percy_Jackson_Ladrao_de_Raios_capa.jpg",
            "descricao_editora": "Intrínseca",
            "nome_autor": "Rick Riordan",
            "data_publicacao": "2005-06-28",
            "qtd_capitulos": 22,
            "qtd_paginas": 400,
            "isbn": "9788598078394",
            "data_registro": "2005-06-28",
            "id_usuario": 1,
            "id_status_leitura": 1,
            "id_genero": [8, 9]
        }';

        $livroParaCadastro = json_decode($livro, true);

        // ASSERT (Verificar/Validar)
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Campo "titulo" é obrigatório.');

        // ACT (Agir/Executar)
        new CadastroLeituraDto($livroParaCadastro);
    }
}
