<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class AvaliacaoLeituraResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id_avaliacao_leitura' => $this->id_avaliacao_leitura,
            'id_leitura' => $this->id_leitura,
            'id_usuario' => $this->id_usuario,
            'nota' => $this->nota,
            'descricao_avaliacao' => $this->descricao_avaliacao,
            'data_inicio' => Carbon::parse($this->data_inicio)->format('d/m/Y'),
            'data_termino' => Carbon::parse($this->data_termino)->format('d/m/Y'),
            'data_registro' => Carbon::parse($this->data_registro)->format('d/m/Y'),
        ];
    }
}
