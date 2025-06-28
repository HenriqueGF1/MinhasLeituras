<?php

namespace App\Http\Services\Leituras;

use App\Http\DTO\CadastroLeituraDTO;
use App\Http\Services\Autor\AutorCadastro;
use App\Http\Services\Autor\AutorPesquisa;
use App\Http\Services\Autor\AutorPrecessoHandler;
use App\Http\Services\Editora\EditoraCadastro;
use App\Http\Services\Editora\EditoraPesquisa;
use App\Http\Services\Editora\EditoraPrecessoHandler;
use App\Http\Services\Genero\GeneroLeituraCadastro;
use App\Http\Services\Genero\GeneroPesquisa;
use App\Http\Services\Genero\GeneroPrecessoHandler;
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
    ) {}

    public function processoDeCadastroDeLeitura(CadastroLeituraDTO $dtoLeitura): Leituras
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

            $autorHandler = new AutorPrecessoHandler($this->autorPesquisa, $this->autorCadastro);
            $editoraHandler = new EditoraPrecessoHandler($this->editoraPesquisa, $this->editoraCadastro);
            $leituraHandler = new LeituraProcessoHandler($this->leituraPesquisa, $this->leituraCadastro);
            $leituraUsuarioHandler = new LeituraUsuarioProcessoHandler($this->usuarioLeituraPesquisa, $this->usuarioLeituraCadastro);
            $generoPrecessoHandler = new GeneroPrecessoHandler($this->generoPesquisa, $this->generoLeituraCadastro);

            // Passo a passo de cadastro
            $autorHandler->setNext($editoraHandler);
            $editoraHandler->setNext($leituraHandler);
            $leituraHandler->setNext($leituraUsuarioHandler);
            $leituraUsuarioHandler->setNext($generoPrecessoHandler);

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
