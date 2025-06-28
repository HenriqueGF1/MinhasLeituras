<?php

namespace App\Http\Services\Leituras;

use App\Http\Services\Autor\AutorCadastro;
use App\Http\Services\Autor\AutorPesquisa;
use App\Http\Services\Autor\AutorPrecessoHandler;
use App\Http\Services\Editora\EditoraCadastro;
use App\Http\Services\Editora\EditoraPesquisa;
use App\Http\Services\Editora\EditoraPrecessoHandler;
use App\Http\Services\Genero\GeneroLeituraCadastro;
use App\Http\Services\Usuario\LeituraUsuarioProcessoHandler;
use App\Http\Services\Usuario\UsuarioLeituraCadastro;
use App\Http\Services\Usuario\UsuarioLeituraPesquisa;
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
        protected AutorPesquisa $autorPesquisa,
        protected EditoraPesquisa $editoraPesquisa,
        protected LeituraPesquisa $leituraPesquisa,
        protected UsuarioLeituraPesquisa $usuarioLeituraPesquisa,
    ) {}

    public function processoDeCadastroDeLeitura(array $dadosRequisicao): Leituras
    {
        $dadosIsbn = isset($dadosRequisicao['isbn'])
            ? $this->isbnPesquisa->pesquisaIsbnBase($dadosRequisicao['isbn'])?->toArray() ?? []
            : [];

        $dadosParaCadastroLeitura = array_merge($dadosRequisicao, $dadosIsbn);

        try {
            DB::beginTransaction();

            // if (array_key_exists('id_autor', $dadosParaCadastroLeitura) || array_key_exists('nome_autor', $dadosParaCadastroLeitura)) {
            //     $dadosAutor = $this->autorPesquisa->pesquisaAutor(isset($dadosParaCadastroLeitura['id_autor']), isset($dadosParaCadastroLeitura['nome_autor']));
            //     $dadosParaCadastroLeitura['id_autor'] = is_null($dadosAutor) ? null : $dadosAutor->id_autor;
            // }

            // if (is_null($dadosAutor)) {
            //     $dadosParaCadastroLeitura['id_autor'] ??= $this->autorCadastro->cadastrarAutor($dadosParaCadastroLeitura['nome_autor'])?->id_autor;
            // }

            // if (array_key_exists('id_autor', $dadosParaCadastroLeitura) || array_key_exists('descricao_editora', $dadosParaCadastroLeitura)) {
            //     $dadosEditora = $this->editoraPesquisa->pesquisaEditora(isset($dadosParaCadastroLeitura['id_editora']), isset($dadosParaCadastroLeitura['descricao_editora']));
            //     $dadosParaCadastroLeitura['id_editora'] = is_null($dadosEditora) ? null : $dadosEditora->id_editora;
            // }

            // if (is_null($dadosEditora)) {
            //     $dadosParaCadastroLeitura['id_editora'] ??= $this->editoraCadastro->cadastrarEditora($dadosParaCadastroLeitura['descricao_editora'])?->id_editora;
            // }

            // if (! empty($dadosParaCadastroLeitura['id_leitura'])) {
            //     $dadosLeitura = $this->leituraPesquisa->pesquisaLeitura($dadosParaCadastroLeitura['id_leitura'], $dadosParaCadastroLeitura['titulo']);
            //     $dadosParaCadastroLeitura['id_leitura'] = $dadosLeitura->id_leitura;
            // } else {
            //     $dadosLeitura = $this->leituraCadastro->cadastroDeLeitura($dadosParaCadastroLeitura);
            //     $dadosParaCadastroLeitura['id_leitura'] ??= $dadosLeitura->id_leitura;
            // }

            // $dadosLeituraUsuario = $this->usuarioLeituraPesquisa->pesquisaLeituraUsuario($dadosParaCadastroLeitura['id_leitura']);

            // if (is_null($dadosLeituraUsuario)) {
            //     $this->usuarioLeituraCadastro->cadastrarLeituraDoUsuario($dadosParaCadastroLeitura['id_leitura'], $dadosParaCadastroLeitura);
            // }

            $autorHandler = new AutorPrecessoHandler($this->autorPesquisa, $this->autorCadastro);
            $editoraHandler = new EditoraPrecessoHandler($this->editoraPesquisa, $this->editoraCadastro);
            $leituraHandler = new LeituraProcessoHandler($this->leituraPesquisa, $this->leituraCadastro);
            $leituraUsuarioHandler = new LeituraUsuarioProcessoHandler($this->usuarioLeituraPesquisa, $this->usuarioLeituraCadastro);

            $autorHandler
                ->setNext($editoraHandler)
                ->setNext($leituraHandler)
                ->setNext($leituraUsuarioHandler)
                ->processar($dadosParaCadastroLeitura);

            $this->generoLeituraCadastro->cadastrarGeneroLeitura($dadosParaCadastroLeitura['id_leitura'], $dadosParaCadastroLeitura);

            DB::commit();

            return Leituras::find($dadosParaCadastroLeitura['id_leitura'])->first();
        } catch (Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }
}
