<?php

namespace App\Http\Services\Leituras;

use App\Models\Leituras;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class LeiturasPesquisaService
{
    /**
     * Pesquisas Leituras
     *
     * @return Leituras|null
     */
    public function pesquisa(): LengthAwarePaginator
    {
        return Leituras::paginate();
    }
}
