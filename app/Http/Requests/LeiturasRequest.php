<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LeiturasRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'titulo'               => 'required|string|max:255',
            'descricao'            => 'nullable|string|max:500',
            'capa'                 => 'nullable|url',
            // 'id_editora'           => 'required|integer|exists:editora,id',
            // 'id_autor'             => 'required|integer|exists:autore,id',
            'id_editora'           => 'required|integer',
            'id_autor'             => 'required|integer',
            // 'data_publicacao'       => 'required|integer|min:1900|max:' . date('Y'),
            'data_publicacao'       => 'required|date',
            'qtd_capitulos'        => 'required|integer|min:1',
            'qtd_paginas'          => 'required|integer|min:1',
            'isbn'                 => 'required|string|size:13',
            'data_inicio_leitura'  => 'required|date',
            // 'id_status_leitura'    => 'required|integer|exists:status_leituras,id',
            'id_status_leitura'    => 'required|integer',
            'data_registro'        => 'required|date',
        ];
    }

    public function messages()
    {
        return [
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
            'id_editora.exists'            => 'A editora selecionada não existe.',
            'id_autor.required'            => 'O campo ID do autor é obrigatório.',
            'id_autor.integer'             => 'O campo ID do autor deve ser um número inteiro.',
            'id_autor.exists'              => 'O autor selecionado não existe.',
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
            'isbn.required'                => 'O campo ISBN é obrigatório.',
            'isbn.string'                  => 'O ISBN deve ser uma string.',
            'isbn.size'                    => 'O ISBN deve ter 13 caracteres.',
            'data_inicio_leitura.required' => 'O campo data de início da leitura é obrigatório.',
            'data_inicio_leitura.date_format' => 'A data de início da leitura deve estar no formato DD/MM/YYYY.',
            'id_status_leitura.required'   => 'O campo ID do status de leitura é obrigatório.',
            'id_status_leitura.integer'    => 'O campo ID do status de leitura deve ser um número inteiro.',
            'id_status_leitura.exists'     => 'O status de leitura selecionado não existe.',
            'data_registro.required'       => 'O campo data de registro é obrigatório.',
            'data_registro.date_format'    => 'A data de registro deve estar no formato DD/MM/YYYY.',
        ];
    }
}
