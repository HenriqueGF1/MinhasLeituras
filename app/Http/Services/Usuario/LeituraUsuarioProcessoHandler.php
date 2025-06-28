<?php

namespace App\Http\Services\Usuario;

use App\Http\Services\Leituras\ProcessoCadastroLeituraHandler;

class LeituraUsuarioProcessoHandler extends ProcessoCadastroLeituraHandler
{
    public function __construct(
        protected UsuarioLeituraPesquisa $usuarioLeituraPesquisa,
        protected UsuarioLeituraCadastro $usuarioLeituraCadastro
    ) {}

    public function processar(array &$dados): array
    {
        dd('LeituraUsuarioProcessoHandler', $dados);

        $this->checaSeExisteRegistro($dados);

        if (! empty($dados['id_leitura_usuario'])) {
            return $dados;
        }

        $this->cadastra($dados);

        if ($this->next) {
            return $this->next->processar($dados);
        }

        return $dados;
    }

    private function checaSeExisteRegistro(array &$dados): array
    {
        if (! empty($dados['id_leitura'])) {
            $dadosLeituraUsuario = $this->usuarioLeituraPesquisa->pesquisaLeituraUsuario(
                isset($dados['id_leitura'])
            );

            $dados['id_leitura_usuario'] = isset($dadosLeituraUsuario?->id_leitura) ? $dadosLeituraUsuario?->id_leitura : null;

            return $dados;
        }

        return $dados;
    }

    private function cadastra(array &$dados)
    {

        $dados['id_leitura_usuario'] = $this->usuarioLeituraCadastro->cadastrarLeituraDoUsuario($dados['id_leitura'], $dados)?->id_leitura;
    }
}
