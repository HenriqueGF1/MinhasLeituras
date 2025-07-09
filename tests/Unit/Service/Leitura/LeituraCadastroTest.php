<?php

declare(strict_types=1);

namespace Tests\Unit\Service\Leitura;

use App\Http\DTO\Leitura\LeituraCadastroDTO;
use App\Http\Services\Leituras\LeituraCadastro;
use App\Models\Leituras;
use Illuminate\Support\Facades\DB;
use Mockery;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class LeituraCadastroTest extends TestCase
{
    private Leituras $leiturasMockModel;

    protected function setUp(): void
    {
        parent::setUp();

        $this->leiturasMockModel = Mockery::mock(Leituras::class);
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        Mockery::close();
    }

    #[Test]
    public function test_cadastrar_leitura_com_sucesso(): void
    {
        // ARRANGE
        $dadosLeitura = [
            'titulo' => 'Percy Jackson e o Ladrão de Raios',
            'descricao' => 'Escrito por Rick Riordan, este é o primeiro livro da série Percy Jackson e os Olimpianos. A história segue Percy, um garoto que descobre ser um semideus, filho de Poseidon, e embarca em uma missão para recuperar o raio mestre de Zeus e evitar uma guerra entre os deuses do Olimpo.',
            'capa' => 'https=>//upload.wikimedia.org/wikipedia/pt/4/4b/Percy_Jackson_Ladrao_de_Raios_capa.jpg',
            'id_editora' => 20,
            'id_autor' => 21,
            'data_publicacao' => '2005-06-28',
            'qtd_capitulos' => 22,
            'qtd_paginas' => 400,
            'isbn' => '9788598078394',
            'data_registro' => '2005-06-28',
        ];

        $this->leiturasMockModel
            ->expects('create')
            ->once()
            ->with($dadosLeitura)
            ->andReturn(new Leituras([
                'id_leitura' => 14,
                'titulo' => $dadosLeitura['titulo'],
                'descricao' => $dadosLeitura['descricao'],
                'capa' => $dadosLeitura['capa'],
                'id_editora' => $dadosLeitura['id_editora'],
                'id_autor' => $dadosLeitura['id_autor'],
                'data_publicacao' => $dadosLeitura['data_publicacao'],
                'qtd_capitulos' => $dadosLeitura['qtd_capitulos'],
                'qtd_paginas' => $dadosLeitura['qtd_paginas'],
                'isbn' => $dadosLeitura['isbn'],
                'data_registro' => $dadosLeitura['data_registro'],
            ]));

        DB::expects('beginTransaction')->once();
        DB::expects('commit')->once();
        DB::expects('rollBack')->never();

        $leituraCadastroDto = new LeituraCadastroDTO($dadosLeitura);
        $serviceLeituraCadastro = new LeituraCadastro($this->leiturasMockModel);

        // ACT
        $resultadoCadastroLeitura = $serviceLeituraCadastro->cadastroDeLeitura($leituraCadastroDto);

        // ASERT
        $this->assertInstanceOf(Leituras::class, $resultadoCadastroLeitura);
        $this->assertEquals(14, $resultadoCadastroLeitura->id_leitura);
        $this->assertEquals($dadosLeitura['titulo'], $resultadoCadastroLeitura->titulo);
    }

    #[Test]
    public function test_cadastrar_leitura_sem_isbn(): void
    {
        // ARRANGE
        $dadosLeitura = [
            'titulo' => 'Percy Jackson e o Ladrão de Raios',
            'descricao' => 'Escrito por Rick Riordan, este é o primeiro livro da série Percy Jackson e os Olimpianos. A história segue Percy, um garoto que descobre ser um semideus, filho de Poseidon, e embarca em uma missão para recuperar o raio mestre de Zeus e evitar uma guerra entre os deuses do Olimpo.',
            'capa' => 'https=>//upload.wikimedia.org/wikipedia/pt/4/4b/Percy_Jackson_Ladrao_de_Raios_capa.jpg',
            'id_editora' => 20,
            'id_autor' => 21,
            'data_publicacao' => '2005-06-28',
            'qtd_capitulos' => 22,
            'qtd_paginas' => 400,
            'isbn' => null,
            'data_registro' => '2005-06-28',
        ];

        $this->leiturasMockModel
            ->expects('create')
            ->once()
            ->with($dadosLeitura)
            ->andReturn(new Leituras([
                'id_leitura' => 82,
                'titulo' => $dadosLeitura['titulo'],
                'descricao' => $dadosLeitura['descricao'],
                'capa' => $dadosLeitura['capa'],
                'id_editora' => $dadosLeitura['id_editora'],
                'id_autor' => $dadosLeitura['id_autor'],
                'data_publicacao' => $dadosLeitura['data_publicacao'],
                'qtd_capitulos' => $dadosLeitura['qtd_capitulos'],
                'qtd_paginas' => $dadosLeitura['qtd_paginas'],
                'isbn' => $dadosLeitura['isbn'],
                'data_registro' => $dadosLeitura['data_registro'],
            ]));

        DB::expects('beginTransaction')->once();
        DB::expects('commit')->once();
        DB::expects('rollBack')->never();

        $leituraCadastroDto = new LeituraCadastroDTO($dadosLeitura);
        $serviceLeituraCadastro = new LeituraCadastro($this->leiturasMockModel);

        // ACT
        $resultadoCadastroLeitura = $serviceLeituraCadastro->cadastroDeLeitura($leituraCadastroDto);

        // ASERT
        $this->assertInstanceOf(Leituras::class, $resultadoCadastroLeitura);
        $this->assertEquals(82, $resultadoCadastroLeitura->id_leitura);
        $this->assertEquals($dadosLeitura['titulo'], $resultadoCadastroLeitura->titulo);
        $this->assertEquals(null, $resultadoCadastroLeitura->isbn);
    }

    #[Test]
    public function test_cadastrar_leitura_sem_dados_essenciais(): void
    {
        // ARRANGE
        $dadosLeitura = [
            'titulo' => '',
            'descricao' => '',
            'capa' => '',
            'data_publicacao' => '',
            'data_registro' => '',
            'qtd_capitulos' => 0,
            'qtd_paginas' => 0,
            'isbn' => null,
            'id_editora' => 0,
            'id_autor' => 0,
        ];

        // ASERT
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('É necessário informar titulo leitura.');

        $leituraCadastroDto = new LeituraCadastroDTO($dadosLeitura);
        $serviceLeituraCadastro = new LeituraCadastro($this->leiturasMockModel);

        // ACT
        $serviceLeituraCadastro->cadastroDeLeitura($leituraCadastroDto);
    }
}
