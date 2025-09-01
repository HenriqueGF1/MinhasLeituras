<?php

namespace App\Http\Requests\Leitura;

use App\Http\Requests\Autor\AutorRequest;
use App\Http\Requests\Editora\EditoraRequest;
use App\Http\Requests\Genero\GeneroleituraRequest;
use App\Http\Requests\Usuario\UsuarioLeituraRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

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
        $this->merge([
            'id_usuario' => Auth::user()->id_usuario,
        ]);

        if (! is_null($this->isbn)) {
            $this->merge([
                'isbn' => preg_replace('/[^0-9Xx]/', '', $this->isbn), // Remove traços e mantém o "X" (para ISBN-10)
            ]);
        }
    }

    public function rules()
    {
        $outrasValidacoes = [
            $this->generoLeituraRequest->rules(),
        ];

        if (! is_null($this->isbn)) {
            $outrasValidacoes[] = $this->isbnRequest->rules();
        }

        if (! is_null($this->id_autor)) {
            $outrasValidacoes[] = $this->autorRequest->rulesRequiredIdAutor();
        } else {
            $outrasValidacoes[] = $this->autorRequest->rulesNullableIdAutor();
        }

        if (! is_null($this->id_editora)) {
            $outrasValidacoes[] = $this->editoraRequest->rulesRequiredIdEditora();
        } else {
            $outrasValidacoes[] = $this->editoraRequest->rulesNullableIdEditora();
        }

        $outrasValidacoes[] = $this->usuarioLeituraRequest->rules();

        $outrasValidacoes[] = [
            'id_usuario' => 'required|exists:usuario,id_usuario',
            'titulo' => 'required|string|max:255',
            'descricao' => 'required|string|max:500|min:20',
            'capa' => 'required|url',
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
            'id_usuario.required' => 'O campo ID do usuário é obrigatório.',
            'id_usuario.exists' => 'O ID do usuário informado não existe.',

            'titulo.required' => 'O título é obrigatório.',
            'titulo.string' => 'O título deve ser um texto.',
            'titulo.max' => 'O título não pode ter mais que 255 caracteres.',

            'descricao.required' => 'A descrição é obrigatória.',
            'descricao.string' => 'A descrição deve ser um texto.',
            'descricao.min' => 'A descrição deve ter no mínimo 20 caracteres.',
            'descricao.max' => 'A descrição não pode ter mais que 500 caracteres.',

            'capa.required' => 'A URL da capa é obrigatória.',
            'capa.url' => 'A capa deve ser uma URL válida.',

            'data_publicacao.required' => 'A data de publicação é obrigatória.',
            'data_publicacao.date' => 'A data de publicação deve ser uma data válida.',

            'qtd_capitulos.required' => 'A quantidade de capítulos é obrigatória.',
            'qtd_capitulos.integer' => 'A quantidade de capítulos deve ser um número inteiro.',
            'qtd_capitulos.min' => 'A quantidade de capítulos deve ser no mínimo 1.',

            'qtd_paginas.required' => 'A quantidade de páginas é obrigatória.',
            'qtd_paginas.integer' => 'A quantidade de páginas deve ser um número inteiro.',
            'qtd_paginas.min' => 'A quantidade de páginas deve ser no mínimo 1.',

            'data_registro.required' => 'A data de registro é obrigatória.',
            'data_registro.date' => 'A data de registro deve ser uma data válida.',
        ];

        return call_user_func_array('array_merge', $outrasValidacoesMensagens);
    }
}
