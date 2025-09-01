<?php

namespace App\Observers;

use App\Http\DTO\UsuarioLeitura\UsuarioLeituraAtualizarDTO;
use App\Http\Services\Usuario\Leitura\UsuarioLeituraAtualizar;
use App\Models\LeituraProgresso;
use App\Models\Leituras;
use App\Models\StatusLeitura;
use App\Models\UsuarioLeitura;
use Illuminate\Contracts\Events\ShouldHandleEventsAfterCommit;

class LeituraProgressoObserver implements ShouldHandleEventsAfterCommit
{
    /**
     * Handle the LeituraProgresso "created" event.
     * Apos o cadastrar do leitura progresse relmente ser executado no banco de dados
     */
    public function created(LeituraProgresso $leituraProgresso): void
    {
        $leitura = Leituras::find($leituraProgresso->id_leitura);

        $totalPaginasLidasProgresso = $leituraProgresso::where('id_usuario', $leituraProgresso->id_usuario)
            ->where('id_leitura', $leituraProgresso->id_leitura)
            ->sum('qtd_paginas_lidas');

        if ($totalPaginasLidasProgresso == $leitura->qtd_paginas) {
            $usuarioLeitura = UsuarioLeitura::where('id_usuario', '=', $leituraProgresso->id_usuario)
                ->where('id_leitura', '=', $leituraProgresso->id_leitura)
                ->first();

            if (! is_null($usuarioLeitura)) {
                $serviceUsuarioLeituraAtualizar = new UsuarioLeituraAtualizar(new UsuarioLeitura);
                $dtoUsuarioLeituraAtualizar = new UsuarioLeituraAtualizarDTO([
                    'id_usuario_leitura' => $usuarioLeitura->id_usuario_leitura,
                    'id_usuario' => $leituraProgresso->id_usuario,
                    'id_leitura' => $leituraProgresso->id_leitura,
                    'id_status_leitura' => StatusLeitura::STATUS_LIDO,
                ]);

                $serviceUsuarioLeituraAtualizar->atualizarLeituraDoUsuario($dtoUsuarioLeituraAtualizar);
            }
        }
    }
}
