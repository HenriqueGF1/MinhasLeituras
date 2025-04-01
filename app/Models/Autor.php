<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Autor extends Model
{
    protected $table = 'editora';
    protected $primaryKey = "id_autor";
    public $incrementing = false;
    public $timestamps = false;
    protected $fillable = [
        'id_autor',
        'nome',
        'email',
        'data_registro',
    ];
}
