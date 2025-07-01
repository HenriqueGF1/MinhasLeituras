<?php

namespace App\Http\Services\Genero;

use App\Http\DTO\CadastroLeituraDTO;
use App\Http\DTO\GeneroLeituraDTO;
use App\Http\Services\Leituras\ProcessoCadastroLeituraHandler;

class GeneroLeituraPrecessoHandler extends ProcessoCadastroLeituraHandler
{
    public function __construct(
        protected GeneroPesquisa $generoPesquisa,
        protected GeneroLeituraCadastro $generoLeituraCadastro,
    ) {}

    public function processar(CadastroLeituraDTO $leituraDto): CadastroLeituraDTO
    {
        $generoDto = new GeneroLeituraDTO($leituraDto->toArray());

        $this->checaSeExisteRegistro($generoDto);

        $leituraDto->id_genero = $generoDto->id_genero;

        return $this->next
            ? $this->next->processar($leituraDto)
            : $leituraDto;
    }

    private function checaSeExisteRegistro(GeneroLeituraDTO $dto): void
    {
        if (! empty($dto->id_leitura)) {
            $dadosGenero = $this->generoPesquisa->pesquisarGeneroLeitura($dto);

            if ($dadosGenero->isEmpty()) {
                $this->cadastra($dto);

                return;
            }

            $idsGenero = $dadosGenero->pluck('id_genero');
            $idsRequisicaoVsPesquisaGenero = collect($dto->id_genero)
                ->merge($idsGenero)
                ->unique()
                ->values()
                ->toArray();

            $vindoDoBanco = array_count_values($idsRequisicaoVsPesquisaGenero);
            $vindoDaRequisicao = array_count_values($dto->id_genero);
            ksort($vindoDaRequisicao);
            ksort($vindoDoBanco);

            if ($vindoDaRequisicao != $vindoDoBanco) {
                $dto->id_genero = $idsRequisicaoVsPesquisaGenero;
                $this->cadastra($dto);
            }
        }
    }

    private function cadastra(GeneroLeituraDTO $dto): void
    {
        dd('Vai cadastrar GeneroLeituraDTO');

        $novoGenero = $this->generoLeituraCadastro->cadastrarGeneroLeitura($dto);

        // $novoGenero->pluck('id_genero_leitura')->toArray();
    }
}
