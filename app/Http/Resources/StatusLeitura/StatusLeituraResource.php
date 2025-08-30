<?php

namespace App\Http\Resources\StatusLeitura;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class StatusLeituraResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id_status_leitura' => $this->id_status_leitura,
            'descricao' => $this->descricao,
            'data_registro' => Carbon::parse($this->data_registro)->format('d/m/Y H:i:s'),
        ];
    }
}
