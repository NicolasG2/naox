<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PedidoDoCliente extends Model
{
    use HasFactory;

    protected $table = 'pedido_dos_clientes';

    protected $fillable = [
        'id_cliente',
        'id_pedido',
    ];

    public function pedido()
    {
        return $this->belongsTo('App\Models\Pedido', 'id_pedido');
    }

    public function cliente()
    {
        return $this->belongsTo('App\Models\Cliente', 'id_cliente');
    }
}
