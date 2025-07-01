<?php

namespace App\Http\Services\Autor;

use App\Http\DTO\Autor\AutorCadastroDTO;
use App\Http\DTO\Autor\AutorPesquisaDTO;
use App\Http\DTO\Autor\Strategy\AutorDTOStrategy;

use App\Http\DTO\CadastroLeituraDTO;
use App\Http\Services\Leituras\ProcessoCadastroLeituraHandler;

class AutorPrecessoHandler extends ProcessoCadastroLeituraHandler
{
    public function __construct(
        protected AutorPesquisa $autorPesquisa,
        protected AutorCadastro $autorCadastro,
        protected AutorDTOStrategy $dtoStrategy
    ) {}

    public function processar(CadastroLeituraDTO $leituraDto): CadastroLeituraDTO
    {
        $factory = $this->dtoStrategy->getFactory('pesquisa');
        $autorDto = $factory->create($leituraDto->toArray());

        dd($autorDto);

        $this->checaSeExisteRegistro($autorDto);

        if (empty($autorDto->id_autor)) {

            $factory = $this->dtoStrategy->getFactory('cadastro');
            $autorDto = $factory->create($leituraDto->toArray());

            $this->cadastra($autorDto);
        }

        $leituraDto->id_autor = $autorDto->id_autor;

        return $this->next
            ? $this->next->processar($leituraDto)
            : $leituraDto;
    }

    private function checaSeExisteRegistro(AutorPesquisaDTO $autorDto): void
    {
        $registro = $this->autorPesquisa->pesquisaAutor($autorDto);
        $autorDto->id_autor = $registro?->id_autor ?? null;
    }

    private function cadastra(AutorCadastroDTO $autorDto): void
    {
        dd('Vai cadastrar AutorDTO', $autorDto);
        $autorDto->id_autor =
            $this->autorCadastro
            ->cadastrarAutor($autorDto)
            ?->id_autor;
    }
}
