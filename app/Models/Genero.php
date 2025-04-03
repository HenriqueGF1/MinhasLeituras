<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Genero extends Model
{
    protected $table = 'genero';
    protected $primaryKey = "id_genero";
    public $incrementing = false;
    public $timestamps = false;
    protected $fillable = [
        'id_genero',
        'nome',
        'data_registro',
    ];
}
