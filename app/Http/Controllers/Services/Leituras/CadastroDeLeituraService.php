<?php

namespace App\Http\Controllers\Services\Leituras;

use App\Http\Controllers\Services\Autor\AutorService;
use App\Http\Controllers\Services\Editora\EditoraService;
use App\Http\Controllers\Services\Usuario\UsuarioLeituraService;

class CadastroDeLeituraService
{
    protected $leitura;

    protected $leituraService;

    protected $usuarioService;

    protected $autorService;

    protected $editoraService;

    public function __construct()
    {
        $this->leituraService = new LeiturasService;
        $this->autorService = new AutorService;
        $this->editoraService = new EditoraService;
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

        $this->usuarioService->salvarLeituraUsuario($dados['id_leitura'], $dados);

        return $dados;
    }
}
