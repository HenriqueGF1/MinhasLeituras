<?php

namespace App\Http\Services\Leituras;

use App\Http\Services\Autor\AutorCadastro;
use App\Http\Services\Editora\EditoraCadastro;
use App\Http\Services\Genero\GeneroLeituraCadastro;
use App\Http\Services\Usuario\UsuarioLeituraCadastro;
use App\Models\Leituras;
use Exception;
use Illuminate\Support\Facades\DB;

class CadastramentoDeLeituraFacade
{
    public function __construct(
        protected AutorCadastro $autorCadastro,
        protected EditoraCadastro $editoraCadastro,
        protected GeneroLeituraCadastro $generoLeituraCadastro,
        protected UsuarioLeituraCadastro $usuarioLeituraCadastro,
        protected IsbnPesquisa $isbnPesquisa,
        protected LeituraCadastro $leituraCadastro,
        protected LeituraDadosBuilder $leituraDadosBuilder
    ) {}

    public function processoDeCadastroDeLeitura(array $dadosRequisicao): Leituras
    {
        $dadosIsbn = isset($dadosRequisicao['isbn'])
            ? $this->isbnPesquisa->pesquisaIsbnBase($dadosRequisicao['isbn'])?->toArray() ?? []
            : [];

        $dadosBase = array_merge($dadosRequisicao, $dadosIsbn);

        $dadosCompletos = $this->leituraDadosBuilder
            ->comDados($dadosBase)
            ->limparNulos()
            ->build();

        try {
            DB::beginTransaction();

            // 3. Cadastrar autor e editora se necessário
            $dadosCompletos['id_autor'] ??= $this->autorCadastro->cadastrarAutor($dadosCompletos)?->id_autor;
            $dadosCompletos['id_editora'] ??= $this->editoraCadastro->cadastrarEditora($dadosCompletos)?->id_editora;

            $leitura = $this->leituraCadastro->cadastroDeLeitura($dadosCompletos);

            $dadosCompletos = array_merge($dadosCompletos, $leitura->toArray());

            $this->generoLeituraCadastro->cadastrarGeneroLeitura($leitura->id_leitura, $dadosCompletos);

            $this->usuarioLeituraCadastro->cadastrarLeituraDoUsuario($leitura->id_leitura, $dadosCompletos);

            DB::commit();

            return $leitura;
        } catch (Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }
}
