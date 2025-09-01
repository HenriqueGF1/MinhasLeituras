<?php

namespace App\Rules\Leitura;

use App\Http\DTO\LeituraProgresso\LeituraProgressoPesquisaDTO;
use App\Http\Services\Leituras\LeituraProgresso\LeituraProgressoTotalPaginasLida;
use App\Models\LeituraProgresso;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Auth;

class QuantidadePaginasLeitura implements ValidationRule
{
    public function __construct(protected int $idLeitura) {}

    /**
     * Run the validation rule.
     *
     * @param \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $leituraProgressoTotalPaginasLidaService = new LeituraProgressoTotalPaginasLida(new LeituraProgresso);

        $dtoAvaliacaoLeituraPesquisa = new LeituraProgressoPesquisaDTO([
            'id_usuario' => Auth::user()->id_usuario,
            'id_leitura' => $this->idLeitura,
        ]);

        $leitura = $leituraProgressoTotalPaginasLidaService->pesquisarLeituraProgressoTotalPaginasLida($dtoAvaliacaoLeituraPesquisa);

        if ($leitura !== null && $value > $leitura->qtd_paginas) {
            $fail('A quantidade de páginas lidas excede o total de páginas da leitura.');
        }

        $total = $leitura->total_paginas_lidas + $value;

        if ($leitura !== null && $leitura->total_paginas_lidas >= $leitura->qtd_paginas) {
            $fail('Você já leu todas as páginas do livro');

            return;
        }

        if ($leitura !== null && $total > $leitura->qtd_paginas) {
            $fail('Quantidades de páginas restantes excedem a quantidade de páginas do livro.');
        }
    }
}
