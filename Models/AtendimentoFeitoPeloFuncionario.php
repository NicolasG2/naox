<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AtendimentoFeitoPeloFuncionario extends Model
{
    use HasFactory;

    protected $table = 'atendimentos_feitos_pelo_funcionario';

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'id_usuario');
    }

    public function pedido()
    {
        return $this->belongsTo('App\Models\Pedido', 'id_pedido');
    }
}
