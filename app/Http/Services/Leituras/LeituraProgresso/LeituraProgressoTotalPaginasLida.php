<?php

namespace App\Http\Services\Leituras\LeituraProgresso;

use App\Http\DTO\LeituraProgresso\LeituraProgressoPesquisaDTO;
use App\Models\LeituraProgresso;

class LeituraProgressoTotalPaginasLida
{
    public function __construct(
        protected LeituraProgresso $leituraProgressoModel
    ) {}

    public function pesquisarLeituraProgressoTotalPaginasLida(LeituraProgressoPesquisaDTO $dto): ?LeituraProgresso
    {
        $leituraProgresso = $this->leituraProgressoModel
            ->select(
                'leitura_progresso.id_usuario',
                'leitura_progresso.id_leitura',
                \DB::raw('SUM(leitura_progresso.qtd_paginas_lidas) as total_paginas_lidas'),
                'leituras.titulo',
                'leituras.descricao',
                'leituras.capa',
                'leituras.id_editora',
                'leituras.id_autor',
                'leituras.data_publicacao',
                'leituras.qtd_capitulos',
                'leituras.qtd_paginas',
                'leituras.isbn',
                'leituras.data_registro'
            )
            ->join('leituras', 'leitura_progresso.id_leitura', '=', 'leituras.id_leitura')
            ->where('leitura_progresso.id_usuario', $dto->id_usuario)
            ->where('leitura_progresso.id_leitura', $dto->id_leitura)
            ->groupBy(
                'leitura_progresso.id_usuario',
                'leitura_progresso.id_leitura',
                'leituras.titulo',
                'leituras.descricao',
                'leituras.capa',
                'leituras.id_editora',
                'leituras.id_autor',
                'leituras.data_publicacao',
                'leituras.qtd_capitulos',
                'leituras.qtd_paginas',
                'leituras.isbn',
                'leituras.data_registro'
            )
            ->first();

        return $leituraProgresso ?: null;
    }
}
