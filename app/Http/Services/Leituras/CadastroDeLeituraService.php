<?php

namespace App\Http\Services\Leituras;

use App\Http\Services\Autor\AutorService;
use App\Http\Services\Editora\EditoraService;
use App\Http\Services\Genero\GeneroLeituraService;
use App\Http\Services\Usuario\UsuarioLeituraService;

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
        $dados['id_autor'] ??= $this->autorService->cadastrarAutor($dados)->id_autor ?? null;
        $dados['id_editora'] ??= $this->editoraService->cadastrarEditora($dados)->id_editora ?? null;
        $dados['id_leitura'] ??= $this->leituraService->cadastramentoDeLeitura($dados)->id_leitura ?? null;

        $this->generoLeituraService->cadastrarGeneroLeitura($dados);

        $this->usuarioService->salvarLeituraUsuario($dados['id_leitura'], $dados);

        return $dados;
    }
}
