<?php

namespace App\Models;

use App\Models\StatusLeitura;
use Illuminate\Database\Eloquent\Model;

class Leituras extends Model
{
    protected $table = 'leituras';
    protected $primaryKey = "id_leitura";
    public $incrementing = false;
    public $timestamps = false;
    protected $fillable = [
        'id_leitura',
        'titulo',
        'descricao',
        'capa',
        'id_editora',
        'id_autor',
        'data_publicacao',
        'qtd_capitulos',
        'qtd_paginas',
        'isbn',
        'data_registro',
    ];

    protected $attributes = [
        'qtd_capitulos' => 1,
        'qtd_paginas' => 1,
    ];
}
