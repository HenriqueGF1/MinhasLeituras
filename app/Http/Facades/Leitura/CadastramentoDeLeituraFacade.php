<?php

namespace App\Http\Facades\Leitura;

use App\Http\DTO\Autor\Fabrica\AutorCadastroDTOFactory;
use App\Http\DTO\Autor\Fabrica\AutorPesquisaDTOFactory;
use App\Http\DTO\Editora\Fabrica\EditoraCadastroDTOFactory;
use App\Http\DTO\Editora\Fabrica\EditoraPesquisaDTOFactory;
use App\Http\DTO\GeneroLeitura\Fabrica\GeneroLeituraCadastroDTOFactory;
use App\Http\DTO\GeneroLeitura\Fabrica\GeneroLeituraPesquisaDTOFactory;
use App\Http\DTO\Leitura\CadastroLeituraDto;
use App\Http\DTO\Leitura\Fabrica\LeituraCadastroDTOFactory;
use App\Http\DTO\Leitura\Fabrica\LeituraPesquisaDTOFactory;
use App\Http\DTO\UsuarioLeitura\Fabrica\UsuarioLeituraCadastroDTOFactory;
use App\Http\DTO\UsuarioLeitura\Fabrica\UsuarioLeituraPesquisaDTOFactory;
use App\Http\Facades\Leitura\ProcessoCadastroLeitura\AutorProcessoHandler;
use App\Http\Facades\Leitura\ProcessoCadastroLeitura\EditoraProcessoHandler;
use App\Http\Facades\Leitura\ProcessoCadastroLeitura\GeneroLeituraProcessoHandler;
use App\Http\Facades\Leitura\ProcessoCadastroLeitura\LeituraProcessoHandler;
use App\Http\Facades\Leitura\ProcessoCadastroLeitura\LeituraUsuarioProcessoHandler;
use App\Http\Services\Autor\AutorCadastro;
use App\Http\Services\Autor\AutorPesquisa;
use App\Http\Services\Editora\EditoraCadastro;
use App\Http\Services\Editora\EditoraPesquisa;
use App\Http\Services\Genero\GeneroLeituraCadastro;
use App\Http\Services\Genero\GeneroPesquisa;
use App\Http\Services\Leituras\IsbnPesquisa;
use App\Http\Services\Leituras\LeituraCadastro;
use App\Http\Services\Leituras\LeituraPesquisa;
use App\Http\Services\Usuario\Leitura\UsuarioLeituraCadastro;
use App\Http\Services\Usuario\Leitura\UsuarioLeituraPesquisa;
use App\Models\Leituras;
use Exception;
use Illuminate\Support\Facades\DB;

class CadastramentoDeLeituraFacade
{
    public function __construct(
        protected AutorCadastro $autorCadastro,
        protected AutorPesquisa $autorPesquisa,
        protected EditoraCadastro $editoraCadastro,
        protected EditoraPesquisa $editoraPesquisa,
        protected GeneroLeituraCadastro $generoLeituraCadastro,
        protected GeneroPesquisa $generoPesquisa,
        protected IsbnPesquisa $isbnPesquisa,
        protected LeituraCadastro $leituraCadastro,
        protected LeituraPesquisa $leituraPesquisa,
        protected UsuarioLeituraCadastro $usuarioLeituraCadastro,
        protected UsuarioLeituraPesquisa $usuarioLeituraPesquisa,
        private AutorPesquisaDTOFactory $pesquisaAutorDtoFactory,
        private AutorCadastroDTOFactory $cadastroAutorDtoFactory,
        private EditoraPesquisaDTOFactory $editoraPesquisaDTOFactory,
        private EditoraCadastroDTOFactory $editoraCadastroDTOFactory,
        private LeituraPesquisaDTOFactory $leituraPesquisaDTOFactory,
        private LeituraCadastroDTOFactory $leituraCadastroDTOFactory,
        private UsuarioLeituraPesquisaDTOFactory $usuarioLeituraPesquisaDTOFactory,
        private UsuarioLeituraCadastroDTOFactory $usuarioLeituraCadastroDTOFactory,
        private GeneroLeituraPesquisaDTOFactory $generoLeituraPesquisaDTOFactory,
        private GeneroLeituraCadastroDTOFactory $generoLeituraCadastroDTOFactory
    ) {}

    public function processoDeCadastroDeLeitura(CadastroLeituraDto $dtoLeitura): Leituras
    {
        if (! empty($dtoLeitura->isbn)) {
            $dadosIsbn = isset($dtoLeitura->isbn)
                ? $this->isbnPesquisa->pesquisaIsbnBase($dtoLeitura->isbn)?->toArray() ?? []
                : [];

            if (! empty($dadosIsbn) > 0) {
                $dtoLeitura->id_leitura = ! empty($dadosIsbn['id_leitura']) ? $dadosIsbn['id_leitura'] : null;
                $dtoLeitura->id_editora = ! empty($dadosIsbn['id_editora']) ? $dadosIsbn['id_editora'] : null;
                $dtoLeitura->id_autor = ! empty($dadosIsbn['id_autor']) ? $dadosIsbn['id_autor'] : null;
            }
        }

        try {
            DB::beginTransaction();

            $autorHandler = new AutorProcessoHandler(
                $this->autorPesquisa,
                $this->autorCadastro,
                $this->pesquisaAutorDtoFactory,
                $this->cadastroAutorDtoFactory
            );

            $editoraHandler = new EditoraProcessoHandler(
                $this->editoraPesquisa,
                $this->editoraCadastro,
                $this->editoraPesquisaDTOFactory,
                $this->editoraCadastroDTOFactory
            );

            $leituraHandler = new LeituraProcessoHandler(
                $this->leituraPesquisa,
                $this->leituraCadastro,
                $this->leituraPesquisaDTOFactory,
                $this->leituraCadastroDTOFactory,
            );

            $leituraUsuarioHandler = new LeituraUsuarioProcessoHandler(
                $this->usuarioLeituraPesquisa,
                $this->usuarioLeituraCadastro,
                $this->usuarioLeituraPesquisaDTOFactory,
                $this->usuarioLeituraCadastroDTOFactory
            );

            $generoLeituraPrecessoHandler = new GeneroLeituraProcessoHandler(
                $this->generoPesquisa,
                $this->generoLeituraCadastro,
                $this->generoLeituraPesquisaDTOFactory,
                $this->generoLeituraCadastroDTOFactory
            );

            // Passo a passo de cadastro
            $autorHandler->setNext($editoraHandler);
            $editoraHandler->setNext($leituraHandler);
            $leituraHandler->setNext($leituraUsuarioHandler);
            $leituraUsuarioHandler->setNext($generoLeituraPrecessoHandler);

            // Inciar (Passo a passo de cadastro)
            $autorHandler->processar($dtoLeitura);

            DB::commit();

            return Leituras::where('id_leitura', '=', $dtoLeitura->id_leitura)->first();
        } catch (Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }
}
