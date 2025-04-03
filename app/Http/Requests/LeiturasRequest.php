<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Controllers\Services\Usuario\UsuarioService;

class LeiturasRequest extends FormRequest
{

    protected $isbnRequest;

    public function __construct()
    {
        $this->isbnRequest = new IsbnRequest();
    }

    public function authorize()
    {
        return true;
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'isbn' => preg_replace('/[^0-9Xx]/', '', $this->isbn), // Remove traços e mantém o "X" (para ISBN-10)
        ]);
    }

    public function rules()
    {
        return array_merge(
            $this->isbnRequest->rules(),
            [
                'titulo'               => 'required|string|max:255',
                'descricao'            => 'nullable|string|max:500',
                'capa'                 => 'nullable|url',
                'id_editora'           => 'required|integer',
                'id_autor'             => 'required|integer',
                'data_publicacao'      => 'required|date',
                'qtd_capitulos'        => 'required|integer|min:1',
                'qtd_paginas'          => 'required|integer|min:1',
                'data_registro'        => 'required|date',
            ]
        );
    }

    public function messages()
    {
        return array_merge(
            $this->isbnRequest->messages(),
            [
                'id_leitura.required'          => 'O campo ID da leitura é obrigatório.',
                'id_leitura.integer'           => 'O campo ID da leitura deve ser um número inteiro.',
                'titulo.required'              => 'O campo título é obrigatório.',
                'titulo.string'                => 'O título deve ser uma string.',
                'titulo.max'                   => 'O título não pode ter mais de 255 caracteres.',
                'descricao.string'             => 'A descrição deve ser uma string.',
                'descricao.max'                => 'A descrição não pode ter mais de 500 caracteres.',
                'capa.url'                     => 'A capa deve ser uma URL válida.',
                'id_editora.required'          => 'O campo ID da editora é obrigatório.',
                'id_editora.integer'           => 'O campo ID da editora deve ser um número inteiro.',
                'id_autor.required'            => 'O campo ID do autor é obrigatório.',
                'id_autor.integer'             => 'O campo ID do autor deve ser um número inteiro.',
                'data_publicacao.required'      => 'O campo ano de publicação é obrigatório.',
                'data_publicacao.integer'       => 'O ano de publicação deve ser um número inteiro.',
                'data_publicacao.min'           => 'O ano de publicação deve ser no mínimo 1900.',
                'data_publicacao.max'           => 'O ano de publicação não pode ser superior ao ano atual.',
                'qtd_capitulos.required'       => 'O campo quantidade de capítulos é obrigatório.',
                'qtd_capitulos.integer'        => 'A quantidade de capítulos deve ser um número inteiro.',
                'qtd_capitulos.min'            => 'A quantidade de capítulos deve ser no mínimo 1.',
                'qtd_paginas.required'         => 'O campo quantidade de páginas é obrigatório.',
                'qtd_paginas.integer'          => 'A quantidade de páginas deve ser um número inteiro.',
                'qtd_paginas.min'              => 'A quantidade de páginas deve ser no mínimo 1.',
                'data_registro.required'       => 'O campo data de registro é obrigatório.',
                'data_registro.date_format'    => 'A data de registro deve estar no formato DD/MM/YYYY.',
            ]
        );
    }
}
