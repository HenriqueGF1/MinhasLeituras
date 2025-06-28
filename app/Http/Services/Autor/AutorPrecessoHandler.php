<?php

namespace App\Http\Services\Autor;

use App\Http\DTO\AutorDTO;
use App\Http\DTO\CadastroLeituraDTO;
use App\Http\Services\Leituras\ProcessoCadastroLeituraHandler;

class AutorPrecessoHandler extends ProcessoCadastroLeituraHandler
{
    public function __construct(
        protected AutorPesquisa $autorPesquisa,
        protected AutorCadastro $autorCadastro,
    ) {}

    public function processar(CadastroLeituraDTO $leituraDto): CadastroLeituraDTO
    {
        $autorDto = new AutorDTO($leituraDto->toArray());

        $this->checaSeExisteRegistro($autorDto);

        if (empty($autorDto->id_autor)) {
            $this->cadastra($autorDto);
        }

        $leituraDto->id_autor = $autorDto->id_autor;

        return $this->next
            ? $this->next->processar($leituraDto)
            : $leituraDto;
    }

    private function checaSeExisteRegistro(AutorDTO $autorDto): void
    {
        if (! empty($autorDto->id_autor) || ! empty($autorDto->nome_autor)) {
            $registro = $this->autorPesquisa->pesquisaAutor($autorDto);
            $autorDto->id_autor = $registro?->id_autor ?? null;
        }
    }

    private function cadastra(AutorDTO $autorDto): void
    {
        $autorDto->id_autor = $this->autorCadastro
            ->cadastrarAutor($autorDto)?->id_autor;
    }
}
