<?php

namespace App\Http\Resources\Leitura;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class LeiturasResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        // URL base do seu site
        $baseUrl = config('app.url');

        return [
            'id_leitura' => $this->id_leitura,
            'titulo' => $this->titulo,
            'descricao' => $this->descricao,
            'capa' => $this->capa
                ? (str_starts_with($this->capa, 'http')
                    ? $this->capa
                    : $baseUrl . $this->capa)
                : null,
            'id_editora' => $this->id_editora,
            'id_autor' => $this->id_autor,
            'data_publicacao' => Carbon::parse($this->data_publicacao)->format('d/m/Y H:i:s'),
            'qtd_capitulos' => $this->qtd_capitulos,
            'qtd_paginas' => $this->qtd_paginas,
            'isbn' => $this->isbn,
            'data_registro' => Carbon::parse($this->data_registro)->format('d/m/Y H:i:s'),
        ];
    }
}
