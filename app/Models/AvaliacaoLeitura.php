<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AvaliacaoLeitura extends Model
{
    protected $table = 'avaliacao_leitura';

    protected $primaryKey = 'id_avaliacao_leitura';

    public $incrementing = true;

    public $timestamps = false;

    protected $fillable = [
        'id_avaliacao_leitura',
        'id_leitura',
        'id_usuario',
        'nota',
        'descricao_avaliacao',
        'data_inicio',
        'data_termino',
        'data_registro',
    ];

    public function leitura()
    {
        return $this->belongsTo(Leituras::class, 'id_leitura', 'id_leitura');
    }
}
