<?php

namespace App\Http\Services\Leituras;

use App\Models\Leituras;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class LeiturasPesquisa
{
    public function __construct(protected Leituras $model) {}

    public function pesquisa(int $perPage = 10): LengthAwarePaginator
    {
        $query = $this->model->newQuery();

        if ($userId = Auth::id()) {
            $query->withExists([
                'usuarios as usuario_tem_leitura' => function ($q) use ($userId) {
                    $q->where('id_usuario', $userId);
                },
            ]);
        }

        return $query->paginate($perPage);
    }
}
