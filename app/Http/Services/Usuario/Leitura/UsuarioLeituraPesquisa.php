<?php

namespace App\Http\Services\Usuario\Leitura;

use App\Http\DTO\Usuarioleitura\UsuarioLeituraPesquisaDTO;
use App\Models\UsuarioLeitura;

class UsuarioLeituraPesquisa
{
    public function __construct(protected UsuarioLeitura $model) {}

    public function pesquisaLeituraUsuario(UsuarioLeituraPesquisaDTO $dto): ?UsuarioLeitura
    {
        $leitura = $this->model->where([
            ['id_usuario', '=', $dto->id_usuario],
            ['id_leitura', '=', $dto->id_leitura],
        ])->first();

        return $leitura ?: null;
    }
}
