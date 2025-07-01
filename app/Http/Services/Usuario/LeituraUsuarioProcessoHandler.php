<?php

namespace App\Http\Services\Usuario;

use App\Http\DTO\CadastroLeituraDTO;
use App\Http\DTO\UsuarioLeituraDTO;
use App\Http\Services\Leituras\ProcessoCadastroLeituraHandler;

class LeituraUsuarioProcessoHandler extends ProcessoCadastroLeituraHandler
{
    public function __construct(
        protected UsuarioLeituraPesquisa $usuarioLeituraPesquisa,
        protected UsuarioLeituraCadastro $usuarioLeituraCadastro
    ) {}

    public function processar(CadastroLeituraDTO $cadastroDto): CadastroLeituraDTO
    {
        $usuarioDto = new UsuarioLeituraDTO($cadastroDto->toArray());

        $this->checaSeExisteRegistro($usuarioDto);

        if (empty($usuarioDto->id_leitura_usuario)) {
            $this->cadastra($usuarioDto);
        }

        return $this->next
            ? $this->next->processar($cadastroDto)
            : $cadastroDto;
    }

    private function checaSeExisteRegistro(UsuarioLeituraDTO $dto): void
    {
        if (! empty($dto->id_leitura)) {
            $usuarioLeitura = $this->usuarioLeituraPesquisa
                ->pesquisaLeituraUsuario($dto);

            $dto->id_leitura_usuario = $usuarioLeitura?->id_usuario_leitura ?? null;
        }
    }

    private function cadastra(UsuarioLeituraDTO $dto): void
    {
        dd('Vai cadastrar UsuarioLeituraDTO');
        $dto->id_leitura_usuario = $this->usuarioLeituraCadastro
            ->cadastrarLeituraDoUsuario($dto)?->id_leitura;
    }
}
