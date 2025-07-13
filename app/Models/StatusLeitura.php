<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatusLeitura extends Model
{
    protected $table = 'status_leitura';

    protected $primaryKey = 'id_status_leitura';

    public $incrementing = true;

    public $timestamps = false;

    protected $fillable = [
        'id_status_leitura',
        'descricao',
        'data_registro',
    ];

    public const STATUS_LIDO = 1;

    public const STATUS_LENDO = 2;

    public const STATUS_PRETENDO_LER = 3;

    public static function pegarStatus()
    {
        // StatusLeitura::pegarStatus()[StatusLeitura::STATUS_LIDO];
        return [
            self::STATUS_LIDO => 'Lido',
            self::STATUS_LENDO => 'Lendo',
            self::STATUS_PRETENDO_LER => 'Pretendo Ler',
        ];
    }
}
