<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AutorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $idEditora = ['id_autor' => 'nullable'];

        if (isset($this->id_autor)) {
            $idEditora['id_autor'] = '"required|exists:autor,id_autor';
        }

        return array_merge($idEditora, [
            'nome' => 'string|max:50',
        ]);
    }
}
