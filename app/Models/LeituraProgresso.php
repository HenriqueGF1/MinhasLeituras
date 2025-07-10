<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeituraProgresso extends Model
{
    protected $table = 'leitura_progresso';

    protected $primaryKey = 'id_leitura_progresso';

    public $incrementing = true;

    public $timestamps = false;

    protected $fillable = [
        'id_leitura_progresso',
        'id_usuario',
        'id_leitura',
        'qtd_paginas_lidas',
        'data_leitura',
        'data_registro',
    ];
}
