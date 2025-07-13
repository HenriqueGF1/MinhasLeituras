<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Autor extends Model
{
    protected $table = 'autor';

    protected $primaryKey = 'id_autor';

    public $incrementing = true;

    public $timestamps = false;

    protected $fillable = [
        'id_autor',
        'nome',
        'data_registro',
    ];
}
