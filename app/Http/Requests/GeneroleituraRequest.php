<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GeneroleituraRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id_genero' => 'required|unique:genero_leitura,id_genero',
            // 'id_leitura' => 'required|unique:leituras,id_leitura',
        ];
    }
}
