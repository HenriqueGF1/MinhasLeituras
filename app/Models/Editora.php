<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Editora extends Model
{
    protected $table = 'editora';

    protected $primaryKey = 'id_editora';

    public $incrementing = true;

    public $timestamps = false;

    protected $fillable = [
        'id_editora',
        'descricao',
        'data_registro',
    ];
}
