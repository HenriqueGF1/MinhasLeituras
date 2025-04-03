<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Autor extends Model
{
    protected $table = 'editora';

    protected $primaryKey = 'id_autor';

    public $incrementing = true;

    public $timestamps = false;

    protected $fillable = [
        'id_autor',
        'nome',
        'data_registro',
    ];
}
