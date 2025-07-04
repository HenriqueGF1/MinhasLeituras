<?php

namespace App\Http\Services\Leituras;

use App\Models\Leituras;

class IsbnPesquisa
{
    /**
     * Pesquisa uma leitura pelo ISBN fornecido.
     */
    public function pesquisaIsbnBase(string $isbn): ?Leituras
    {
        if (empty($isbn)) {
            return null;
        }

        return Leituras::where('isbn', trim($isbn))->first();
    }
}
