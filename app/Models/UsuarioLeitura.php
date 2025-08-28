<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class UsuarioLeitura extends Model
{
    protected $table = 'usuario_leituras';

    protected $primaryKey = 'id_usuario_leitura';

    public $incrementing = true;

    public $timestamps = false;

    protected $fillable = [
        'id_usuario',
        'id_leitura',
        'id_status_leitura',
        'data_registro',
    ];

    public function leitura()
    {
        return $this->belongsTo(Leituras::class, 'id_leitura', 'id_leitura');
    }

    public function avaliacao()
    {
        return $this->belongsTo(AvaliacaoLeitura::class, 'id_leitura', 'id_leitura')
            ->where('id_usuario', '=', Auth::user()->id_usuario);
    }
}
