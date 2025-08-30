<?php

namespace App\Http\Resources\Generos;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class GenerosResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id_genero' => $this->id_genero,
            'nome' => $this->nome,
            'data_registro' => Carbon::parse($this->data_registro)->format('d/m/Y H:i:s'),
        ];
    }
}
