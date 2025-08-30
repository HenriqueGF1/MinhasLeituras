<?php

namespace App\Http\Resources\ProgressoLeitura;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProgressoLeituraTotalPaginasResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id_usuario' => $this->id_usuario,
            'id_leitura' => $this->id_leitura,
            'total_paginas_lidas' => $this->total_paginas_lidas,
            'titulo' => $this->titulo,
            'descricao' => $this->descricao,
            'capa' => $this->capa,
            'id_editora' => $this->id_editora,
            'id_autor' => $this->id_autor,
            'data_publicacao' => $this->data_publicacao,
            'qtd_capitulos' => $this->qtd_capitulos,
            'qtd_paginas' => $this->qtd_paginas,
            'isbn' => $this->isbn,
            'data_registro' => $this->data_registro,
        ];
    }
}
