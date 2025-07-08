<?php

namespace Tests\Unit\Service\Autor;

use App\Http\DTO\Autor\AutorPesquisaDTO;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class AutorPesquisaDTOTest extends TestCase
{
    #[Test]
    public function pesquisar_autor_sem_dto_auto_id_e_nome(): void
    {
        // ARRANGE
        $dadosAutor = [
            'id_autor' => null,
            'nome_autor' => null,
        ];

        //   ASSERT
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('É necessário informar id ou nome autor.');

        // ACT
        $autorDto = new AutorPesquisaDTO($dadosAutor);
    }
}
