<?php

namespace App\Rules\Leitura;

use App\Models\Leituras;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

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
        $leitura = Leituras::find($this->idLeitura);

        if ($leitura !== null && $value > $leitura->qtd_paginas) {
            $fail('A quantidade de páginas lidas excede o total de páginas da leitura.');
        }
    }
}
