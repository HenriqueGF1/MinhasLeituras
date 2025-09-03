<?php

namespace App\Http\Services\Leituras;

use App\Models\Leituras;

class IsbnPesquisa
{
    protected $leituraModel;

    public function __construct(Leituras $leituraModel)
    {
        $this->leituraModel = $leituraModel;
    }

    public function pesquisaIsbnBase(string $isbn): ?Leituras
    {
        return $this->leituraModel->where('isbn', $isbn)->first();
    }
}
