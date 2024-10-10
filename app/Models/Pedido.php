<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;

    protected $table = 'pedidos';

    protected $fillable = [
        'num_pessoas',
        'valor_total_pedido',
        'comentario',
        'id_mesa',
    ];

    public function atendimentoFeitoPeloFuncionario()
    {
        return $this->hasMany('App\Models\AtendimentoFeitoPeloFuncionario', 'id_pedido');
    }

    public function mesa()
    {
        return $this->belongsTo('App\Models\Mesa', 'id_mesa');
    }

    public function itensDePedido()
    {
        return $this->hasMany('App\Models\ItensDePedido', 'id_pedido');
    }

    public function pedidoDoCliente()
    {
        return $this->hasOne('App\Models\PedidoDoCliente', 'id_pedido');
    }
}
