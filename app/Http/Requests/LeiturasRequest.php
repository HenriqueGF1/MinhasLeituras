<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LeiturasRequest extends FormRequest
{
    protected $isbnRequest;

    protected $usuarioLeituraRequest;

    protected $editoraRequest;

    protected $autorRequest;

    protected $generoLeituraRequest;

    public function __construct()
    {
        $this->isbnRequest = new IsbnRequest;
        $this->usuarioLeituraRequest = new UsuarioLeituraRequest;
        $this->editoraRequest = new EditoraRequest;
        $this->autorRequest = new AutorRequest;
        $this->generoLeituraRequest = new GeneroleituraRequest;
    }

    public function authorize()
    {
        return true;
    }

    protected function prepareForValidation()
    {
        if (! is_null($this->isbn)) {
            $this->merge([
                'isbn' => preg_replace('/[^0-9Xx]/', '', $this->isbn), // Remove traços e mantém o "X" (para ISBN-10)
            ]);
        }
    }

    public function rules()
    {
        $outrasValidacoes = [
            $this->autorRequest->rules(),
            $this->editoraRequest->rules(),
            $this->generoLeituraRequest->rules(),
        ];

        if (! is_null($this->isbn)) {
            $outrasValidacoes[] = $this->isbnRequest->rules();
        }

        $outrasValidacoes[] = $this->usuarioLeituraRequest->rules();

        $outrasValidacoes[] = [
            'titulo' => 'required|string|max:255',
            'descricao' => 'nullable|string|max:500',
            'capa' => 'nullable|url',
            'data_publicacao' => 'required|date',
            'qtd_capitulos' => 'required|integer|min:1',
            'qtd_paginas' => 'required|integer|min:1',
            'data_registro' => 'required|date',
        ];

        return call_user_func_array('array_merge', $outrasValidacoes);
    }

    public function messages()
    {
        $outrasValidacoesMensagens = [
            $this->autorRequest->messages(),
            $this->editoraRequest->messages(),
            $this->generoLeituraRequest->messages(),
        ];

        if (! is_null($this->isbn)) {
            $outrasValidacoesMensagens[] = $this->isbnRequest->messages();
        }

        $outrasValidacoesMensagens[] = $this->usuarioLeituraRequest->messages();

        $outrasValidacoesMensagens[] = [
            'id_leitura.required' => 'O campo ID da leitura é obrigatório.',
            'id_leitura.integer' => 'O campo ID da leitura deve ser um número inteiro.',
            'titulo.required' => 'O campo título é obrigatório.',
            'titulo.string' => 'O título deve ser uma string.',
            'titulo.max' => 'O título não pode ter mais de 255 caracteres.',
            'descricao.string' => 'A descrição deve ser uma string.',
            'descricao.max' => 'A descrição não pode ter mais de 500 caracteres.',
            'capa.url' => 'A capa deve ser uma URL válida.',
            'id_editora.required' => 'O campo ID da editora é obrigatório.',
            'id_editora.integer' => 'O campo ID da editora deve ser um número inteiro.',
            'id_autor.required' => 'O campo ID do autor é obrigatório.',
            'id_autor.integer' => 'O campo ID do autor deve ser um número inteiro.',
            'data_publicacao.required' => 'O campo ano de publicação é obrigatório.',
            'data_publicacao.integer' => 'O ano de publicação deve ser um número inteiro.',
            'data_publicacao.min' => 'O ano de publicação deve ser no mínimo 1900.',
            'data_publicacao.max' => 'O ano de publicação não pode ser superior ao ano atual.',
            'qtd_capitulos.required' => 'O campo quantidade de capítulos é obrigatório.',
            'qtd_capitulos.integer' => 'A quantidade de capítulos deve ser um número inteiro.',
            'qtd_capitulos.min' => 'A quantidade de capítulos deve ser no mínimo 1.',
            'qtd_paginas.required' => 'O campo quantidade de páginas é obrigatório.',
            'qtd_paginas.integer' => 'A quantidade de páginas deve ser um número inteiro.',
            'qtd_paginas.min' => 'A quantidade de páginas deve ser no mínimo 1.',
            'data_registro.required' => 'O campo data de registro é obrigatório.',
            'data_registro.date_format' => 'A data de registro deve estar no formato DD/MM/YYYY.',
        ];

        return call_user_func_array('array_merge', $outrasValidacoesMensagens);
    }
}
