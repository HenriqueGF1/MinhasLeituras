<?php

namespace App\Http\Services\AvaliacaoLeitura;

use App\Models\AvaliacaoLeitura;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class AvaliacaoPesquisa
{
    public function __construct(protected AvaliacaoLeitura $model) {}

    public function pesquisa(): LengthAwarePaginator
    {
        return $this->model
            ->with('leituras')
            ->where('id_usuario', '=', Auth::user()->id_usuario)
            ->paginate();
    }
}
