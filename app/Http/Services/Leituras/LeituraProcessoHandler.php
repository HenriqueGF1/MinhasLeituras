<?php

namespace App\Http\Services\Leituras;

class LeituraProcessoHandler extends ProcessoCadastroLeituraHandler
{
    public function __construct(
        protected LeituraPesquisa $leituraPesquisa,
        protected LeituraCadastro $leituraCadastro
    ) {}

    public function processar(array &$dados): array
    {
        $this->checaSeExisteRegistro($dados);

        if (! empty($dados['id_leitura'])) {
            return $dados;
        }

        $this->cadastra($dados);

        if ($this->next) {
            return $this->next->processar($dados);
        }

        return $dados;
    }

    protected function checaSeExisteRegistro(array &$dados): array
    {
        if (! empty($dados['id_leitura']) || ! empty($dados['titulo'])) {
            $dadosLeitura = $this->leituraPesquisa->pesquisaLeitura(
                isset($dados['id_leitura']),
                $dados['titulo'] ?? ''
            );

            $dados['id_leitura'] = isset($dadosLeitura?->id_leitura) ? $dadosLeitura?->id_leitura : null;

            return $dados;
        }

        return $dados;
    }

    protected function cadastra(array &$dados): void
    {
        $dados['id_leitura'] = $this->leituraCadastro->cadastroDeLeitura($dados)?->id_leitura;
    }
}
