<?php

namespace App\Http\Resources\Leitura;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class LeituraProgressoResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id_leitura_progresso' => $this->id_leitura_progresso,
            'id_usuario' => $this->id_usuario,
            'id_leitura' => $this->id_leitura,
            'qtd_paginas_lidas' => $this->qtd_paginas_lidas,
            'data_leitura' => Carbon::parse($this->data_leitura)->format('d/m/Y H:i:s'),
            'data_registro' => Carbon::parse($this->data_registro)->format('d/m/Y H:i:s'),
        ];
    }
}
