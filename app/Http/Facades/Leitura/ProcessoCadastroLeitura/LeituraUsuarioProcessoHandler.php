<?php

namespace App\Http\Facades\Leitura\ProcessoCadastroLeitura;

use App\Http\DTO\Leitura\CadastroLeituraDto;
use App\Http\DTO\UsuarioLeitura\Fabrica\UsuarioLeituraCadastroDTOFactory;
use App\Http\DTO\UsuarioLeitura\Fabrica\UsuarioLeituraPesquisaDTOFactory;
use App\Http\Services\Usuario\Leitura\UsuarioLeituraCadastro;
use App\Http\Services\Usuario\Leitura\UsuarioLeituraPesquisa;

class LeituraUsuarioProcessoHandler extends ProcessoCadastroLeituraHandler
{
    public function __construct(
        protected UsuarioLeituraPesquisa $usuarioLeituraPesquisa,
        protected UsuarioLeituraCadastro $usuarioLeituraCadastro,
        private UsuarioLeituraPesquisaDTOFactory $usuarioLeituraPesquisaDTOFactory,
        private UsuarioLeituraCadastroDTOFactory $usuarioLeituraCadastroDTOFactory
    ) {}

    public function processar(CadastroLeituraDto $dto): CadastroLeituraDto
    {
        $pesquisaDto = $this->usuarioLeituraPesquisaDTOFactory->criarDTO($dto->toArray());
        $registro = $this->usuarioLeituraPesquisa->pesquisaLeituraUsuario($pesquisaDto);

        if ($registro?->id_leitura) {
            $dto->id_leitura = $registro->id_leitura;
        } else {
            $cadastroDto = $this->usuarioLeituraCadastroDTOFactory->criarDTO($dto->toArray());
            $novoId = $this->usuarioLeituraCadastro->cadastrarLeituraDoUsuario($cadastroDto);
            $dto->id_leitura = $novoId?->id_leitura;
        }

        return $this->next
            ? $this->next->processar($dto)
            : $dto;
    }
}
