<?php

namespace App\Http\Resources\Usuario;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class UsuarioResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id_usuario' => $this->id_usuario,
            'nome' => $this->nome,
            'email' => $this->email,
            'password' => $this->password,
            'data_nascimento' => Carbon::parse($this->data_nascimento)->format('d/m/Y H:i:s'),
            'data_registro' => Carbon::parse($this->data_registro)->format('d/m/Y H:i:s'),
        ];
    }
}
