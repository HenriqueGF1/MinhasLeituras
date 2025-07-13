<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GeneroLeitura extends Model
{
    protected $table = 'genero_leitura';

    protected $primaryKey = 'id_genero_leitura';

    public $incrementing = true;

    public $timestamps = false;

    protected $fillable = [
        'id_genero_leitura',
        'id_genero',
        'id_leitura',
        'data_registro',
    ];
}
