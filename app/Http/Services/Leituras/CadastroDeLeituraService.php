<?php

namespace App\Http\Services\Leituras;

use App\Http\Services\Autor\AutorService;
use App\Http\Services\Editora\EditoraService;
use App\Http\Services\Genero\GeneroLeituraService;
use App\Http\Services\Usuario\UsuarioLeituraService;
use App\Models\Leituras;
use Exception;
use Illuminate\Support\Facades\DB;

class CadastroDeLeituraService
{
    public function __construct(
        protected AutorService $autorService,
        protected EditoraService $editoraService,
        protected GeneroLeituraService $generoLeituraService,
        protected UsuarioLeituraService $usuarioService
    ) {}

    public function cadastroDeLeitura(array $dados): Leituras
    {
        try {
            DB::beginTransaction();

            $dados['id_autor'] ??= $this->autorService->cadastrarAutor($dados)?->id_autor;
            $dados['id_editora'] ??= $this->editoraService->cadastrarEditora($dados)?->id_editora;

            if (empty($dados['id_leitura'])) {
                $leitura = Leituras::create($dados);
                $dados['id_leitura'] = $leitura->id_leitura;
            } else {
                $leitura = Leituras::findOrFail($dados['id_leitura']);
            }

            $this->generoLeituraService->cadastrarGeneroLeitura($dados);
            $this->usuarioService->salvarLeituraUsuario($dados['id_leitura'], $dados);

            DB::commit();

            return $leitura;
        } catch (Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }
}
