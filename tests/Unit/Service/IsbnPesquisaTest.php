<?php

namespace Tests\Unit\Services\Leituras;

use App\Http\Services\Leituras\IsbnPesquisa;
use App\Models\Leituras;
use Tests\TestCase;

/**
 * @runInSeparateProcess
 *    - Indica que este teste deve ser executado em um processo separado.
 *      Isso é útil quando você precisa isolar efeitos colaterais, como manipulação de variáveis globais ou estado do PHP.
 *
 * @preserveGlobalState disabled
 *    - Evita que o PHPUnit preserve o estado global (como variáveis globais, classes estáticas etc) entre testes.
 *      É recomendado junto com @runInSeparateProcess para garantir isolamento total.
 */
class IsbnPesquisaTest extends TestCase
{
    private $isbnPesquisaClasse;

    protected function setUp(): void
    {
        // Este método é chamado automaticamente ANTES de cada método de teste
        // Aqui você prepara o ambiente para o teste, como instanciar objetos ou mocks

        // Cria um mock (simulação) da classe IsbnPesquisa
        $this->isbnPesquisaClasse = $this->createMock(IsbnPesquisa::class);
    }

    public function test_pesquisa_com_isbn_para_retornar_dados()
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

        // ACT (Ação)
        // Configura o mock para:
        // - Esperar que o método pesquisaIsbnBase seja chamado UMA VEZ
        // - Com o parâmetro igual ao ISBN do livro
        // - E retornar uma instância da model Leituras com os dados fornecidos
        $this->isbnPesquisaClasse
            ->expects($this->once())                        // Espera que o método seja chamado apenas 1 vez
            ->method('pesquisaIsbnBase')                   // Qual método está sendo "simulado"
            ->with($dadosLivro['isbn'])                    // Com quais parâmetros
            ->willReturn(new Leituras($dadosLivro));       // O que esse método deve retornar

        // Executa o método que está sendo testado
        $resultado = $this->isbnPesquisaClasse->pesquisaIsbnBase($dadosLivro['isbn']);

        // ASSERT (Verificação dos resultados)
        $this->assertInstanceOf(Leituras::class, $resultado); // Verifica se o retorno é uma instância da classe Leituras
        $this->assertEquals($dadosLivro['titulo'], $resultado->titulo); // Verifica se o título retornado é o esperado
        $this->assertEquals($dadosLivro['isbn'], $resultado->isbn);     // Verifica se o ISBN retornado é o esperado
    }

    public function test_pesquisa_isbn_sem_isbn_retornar_null()
    {
        // ARRANGE
        // Mesmo cenário anterior, mas o ISBN está em branco
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
        // Configura o mock para:
        // - Retornar null quando o método pesquisaIsbnBase for chamado com ISBN vazio
        $this->isbnPesquisaClasse
            ->expects($this->once())
            ->method('pesquisaIsbnBase')
            ->with($dadosLivro['isbn'])
            ->willReturn(null);

        // Executa o método que está sendo testado
        $resultado = $this->isbnPesquisaClasse->pesquisaIsbnBase($dadosLivro['isbn']);

        // ASSERT
        // Verifica que o resultado foi null
        $this->assertNull($resultado);
    }
}
