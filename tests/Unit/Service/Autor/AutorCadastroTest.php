<?php

declare(strict_types=1);

// Declara o namespace do teste (organização por pasta)

namespace Tests\Unit\Service\Autor;

// Importações de classes necessárias
use App\Http\DTO\Autor\AutorCadastroDTO;  // Classe DTO para transferência de dados
use App\Http\Services\Autor\AutorCadastro; // Serviço sendo testado
use App\Models\Autor;                      // Model Eloquent
use Illuminate\Support\Facades\DB;         // Facade para operações de banco de dados
use Mockery;                               // Biblioteca para criar mocks
use PHPUnit\Framework\Attributes\Test;     // Atributo para marcar métodos como teste
use PHPUnit\Framework\TestCase;            // Classe base para testes do PHPUnit

class AutorCadastroTest extends TestCase
{
    // Propriedade para armazenar o mock do model Autor
    private Autor $autorModelMock;

    // Método executado antes de cada teste
    protected function setUp(): void
    {
        parent::setUp();  // Chama o setup da classe pai (TestCase)

        // Cria um mock da classe Autor usando Mockery
        $this->autorModelMock = Mockery::mock(Autor::class);
    }

    // Método executado após cada teste
    protected function tearDown(): void
    {
        Mockery::close();  // Limpa os mocks criados pelo Mockery
    }

    // Atributo que marca este método como um teste
    #[Test]
    public function test_cadastrar_autor_com_sucesso(): void
    {
        // ARRANGE: Prepara os dados e configurações para o teste
        $dadosAutor = ['nome' => 'Autor 001'];  // Dados de entrada
        $autorDto = new AutorCadastroDTO($dadosAutor);  // Cria DTO com dados fictícios

        // Configura o comportamento do mock do model Autor:
        $this->autorModelMock
            ->expects('create')  // Espera chamada ao método create()
            ->once()                // Deve ser chamado exatamente uma vez
            ->with($dadosAutor)     // Com estes dados de entrada
            ->andReturn(new Autor([ // Retorna este resultado
                'id_autor' => 1,   // ID fictício
                'nome' => $dadosAutor['nome'],  // Nome igual ao input
            ]));

        // Configura expectativas para a facade DB:
        DB::expects('beginTransaction')->once();  // beginTransaction deve ser chamado 1x
        DB::expects('commit')->once();            // commit deve ser chamado 1x
        DB::expects('rollBack')->never();          // rollBack NUNCA deve ser chamado

        // ACT: Executa o código sendo testado
        $service = new AutorCadastro($this->autorModelMock);  // Instancia o serviço com mock
        $resultado = $service->cadastrarAutor($autorDto);     // Chama o método alvo

        // ASSERT: Verifica os resultados
        $this->assertInstanceOf(Autor::class, $resultado);  // Verifica se retornou um Autor
        $this->assertEquals(1, $resultado->id_autor);       // ID é o esperado?
        $this->assertEquals($dadosAutor['nome'], $resultado->nome);  // Nome coincide?
    }
}
