<?php

namespace App\Http\Controllers\Services\Leituras;

use App\Http\Controllers\Services\Autor\AutorService;
use App\Http\Controllers\Services\Editora\EditoraService;
use App\Http\Controllers\Services\Genero\GeneroLeituraService;
use App\Http\Controllers\Services\Usuario\UsuarioLeituraService;

class CadastroDeLeituraService
{
    protected $autorService;

    protected $editoraService;

    protected $generoLeituraService;

    protected $leitura;

    protected $leituraService;

    protected $usuarioService;

    public function __construct()
    {
        $this->autorService = new AutorService;
        $this->editoraService = new EditoraService;
        $this->generoLeituraService = new GeneroLeituraService;
        $this->leituraService = new LeiturasService;
        $this->usuarioService = new UsuarioLeituraService;
    }

    public function cadastroDeLeitura($dados)
    {
        if (is_null($dados['id_autor'])) {
            $autorNovo = $this->autorService->cadastrarAutor($dados);
            $dados['id_autor'] = $autorNovo->id_autor ?? null;
        }

        if (is_null($dados['id_editora'])) {
            $editoraNova = $this->editoraService->cadastrarEditora($dados);
            $dados['id_editora'] = $editoraNova->id_editora ?? null;
        }

        if (is_null($dados['id_leitura'])) {
            $leituraNova = $this->leituraService->cadastramentoDeLeitura($dados);
            $dados['id_leitura'] = $leituraNova->id_leitura ?? null;
        }

        if (! is_null($dados['id_leitura'])) {
            $this->generoLeituraService->cadastrarGeneroLeitura($dados);
        }

        $this->usuarioService->salvarLeituraUsuario($dados['id_leitura'], $dados);

        return $dados;
    }
}
