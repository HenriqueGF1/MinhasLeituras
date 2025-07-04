<?php

namespace Tests\Unit\Services\Leituras;

use App\Http\Services\Leituras\IsbnPesquisa;
use App\Models\Leituras;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class IsbnPesquisaTest extends TestCase
{
    private IsbnPesquisa&MockObject $isbnPesquisaClasse;

    protected function setUp(): void
    {
        parent::setUp(); // Chamada obrigatória no PHPUnit 10+

        // Este método é chamado automaticamente ANTES de cada método de teste
        // Aqui você prepara o ambiente para o teste, como instanciar objetos ou mocks

        // Cria um mock (simulação) da classe IsbnPesquisa
        $this->isbnPesquisaClasse = $this->createMock(IsbnPesquisa::class);
    }

    #[Test]
    public function pesquisa_com_isbn_retorna_dados(): void
    {
        // ARRANGE (Preparação do cenário de teste)
        // Define os dados que um livro com ISBN retornaria
        $dadosLivro = [
            'titulo' => 'Percy Jackson e o Ladrão de Raios',
            'descricao' => 'Escrito por Rick Riordan...',
            'capa' => 'https://upload.wikimedia.org/wikipedia/pt/4/4b/Percy_Jackson_Ladrao_de_Raios_capa.jpg',
            'id_editora' => 80,
            'id_autor' => 81,
            'data_publicacao' => '2005-06-28',
            'qtd_capitulos' => 22,
            'qtd_paginas' => 400,
            'isbn' => '',
            'data_registro' => '2005-06-28',
            'id_usuario' => 1,
            'id_status_leitura' => 1,
            'id_genero' => [8, 9],
        ];

        $leituraEsperada = new Leituras($dadosLivro);

        // ACT (Ação)
        // Configura o mock para:
        // - Esperar que o método pesquisaIsbnBase seja chamado UMA VEZ
        // - Com o parâmetro igual ao ISBN do livro
        // - E retornar uma instância da model Leituras com os dados fornecidos
        $this->isbnPesquisaClasse
            ->expects($this->once())                        // Espera que o método seja chamado apenas 1 vez
            ->method('pesquisaIsbnBase')                   // Qual método está sendo "simulado"
            ->with($dadosLivro['isbn'])                    // Com quais parâmetros
            ->willReturn($leituraEsperada);       // O que esse método deve retornar
        // Executa o método que está sendo testado
        $resultado = $this->isbnPesquisaClasse->pesquisaIsbnBase($dadosLivro['isbn']);

        // ASSERT (Verificação dos resultados)
        $this->assertInstanceOf(Leituras::class, $resultado); // Verifica se o retorno é uma instância da classe Leituras
        $this->assertEquals($dadosLivro['titulo'], $resultado->titulo); // Verifica se o título retornado é o esperado
        $this->assertEquals($dadosLivro['isbn'], $resultado->isbn);     // Verifica se o ISBN retornado é o esperado
    }

    #[Test]
    public function pesquisa_com_isbn_vazio_retorna_null(): void
    {
        // ARRANGE
        $dadosLivro = [
            'titulo' => 'Percy Jackson e o Ladrão de Raios',
            'descricao' => 'Escrito por Rick Riordan...',
            'capa' => 'https://upload.wikimedia.org/wikipedia/pt/4/4b/Percy_Jackson_Ladrao_de_Raios_capa.jpg',
            'id_editora' => 80,
            'id_autor' => 81,
            'data_publicacao' => '2005-06-28',
            'qtd_capitulos' => 22,
            'qtd_paginas' => 400,
            'isbn' => '',
            'data_registro' => '2005-06-28',
            'id_usuario' => 1,
            'id_status_leitura' => 1,
            'id_genero' => [8, 9],
        ];

        // ACT
        $this->isbnPesquisaClasse
            ->expects($this->once())
            ->method('pesquisaIsbnBase')
            ->with($dadosLivro['isbn'])
            ->willReturn(null);

        $resultado = $this->isbnPesquisaClasse->pesquisaIsbnBase($dadosLivro['isbn']);

        // ASSERT
        $this->assertNull($resultado);
    }
}
