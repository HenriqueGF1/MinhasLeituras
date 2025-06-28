<?php

namespace App\Http\Services\Genero;

use App\Http\DTO\CadastroLeituraDTO;
use App\Http\DTO\GeneroLeituraDTO;
use App\Http\Services\Leituras\ProcessoCadastroLeituraHandler;

class GeneroPrecessoHandler extends ProcessoCadastroLeituraHandler
{
    public function __construct(
        protected GeneroPesquisa $generoPesquisa,
        protected GeneroLeituraCadastro $generoLeituraCadastro,
    ) {}

    public function processar(CadastroLeituraDTO $leituraDto): CadastroLeituraDTO
    {
        $generoDto = new GeneroLeituraDTO($leituraDto->toArray());

        $this->checaSeExisteRegistro($generoDto);

        if (! empty($generoDto->id_genero)) {
            $this->cadastra($generoDto);
        }

        $leituraDto->id_genero = $generoDto->id_genero;

        return $this->next
            ? $this->next->processar($leituraDto)
            : $leituraDto;
    }

    private function checaSeExisteRegistro(GeneroLeituraDTO $dto): void
    {
        if (! empty($dto->id_genero) || ! empty($dto->id_leitura)) {
            $dadosGenero = $this->generoPesquisa->pesquisarGeneroLeitura($dto);

            if ($dadosGenero && $dadosGenero->isNotEmpty()) {
                $idsGenero = $dadosGenero->pluck('id_genero');

                if (! empty($dto->id_genero)) {
                    $dto->id_genero = collect($dto->id_genero)
                        ->merge($idsGenero)
                        ->unique()
                        ->values()
                        ->toArray();
                }
            }
        }
    }

    private function cadastra(GeneroLeituraDTO $dto): void
    {
        $dto->id_genero = $this->generoLeituraCadastro
            ->cadastrarGeneroLeitura($dto)?->id_genero;
    }
}
