<?php

namespace App\Http\Services\Usuario\Leitura;

use App\Models\UsuarioLeitura;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class LeiturasPesquisa
{
    public function __construct(protected UsuarioLeitura $modelUsuarioLeitura) {}

    public function pesquisaLeiturasUsuario(): LengthAwarePaginator
    {
        return $this->modelUsuarioLeitura
            ->with('leitura')
            ->where('id_usuario', Auth::user()->id_usuario)
            ->paginate();
    }
}
