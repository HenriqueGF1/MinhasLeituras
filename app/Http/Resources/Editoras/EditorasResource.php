<?php

namespace App\Http\Resources\Editoras;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class EditorasResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id_editora' => $this->id_editora,
            'descricao' => $this->descricao,
            'data_registro' => Carbon::parse($this->data_registro)->format('d/m/Y H:i:s'),
        ];
    }
}
