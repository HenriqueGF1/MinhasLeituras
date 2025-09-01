<?php

namespace App\Http\Resources\UsuarioLeitura;

use App\Http\Resources\AvaliacaoLeitura\AvaliacaoLeituraPesquisaResource;
use App\Http\Resources\Leitura\LeiturasResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UsuarioLeituraResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id_usuario_leitura' => $this->id_usuario_leitura,
            'id_usuario' => $this->id_usuario,
            'id_leitura' => $this->id_leitura,
            'id_status_leitura' => $this->id_status_leitura,
            'data_registro' => $this->data_registro,
            'avaliacao' => new AvaliacaoLeituraPesquisaResource($this->whenLoaded('avaliacao')),
            'leitura' => new LeiturasResource($this->whenLoaded('leitura')),
        ];
    }
}
