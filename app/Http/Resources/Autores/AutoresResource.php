<?php

namespace App\Http\Resources\Autores;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class AutoresResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id_autor' => $this->id_autor,
            'nome' => $this->nome,
            'data_registro' => Carbon::parse($this->data_registro)->format('d/m/Y H:i:s'),
        ];
    }
}
