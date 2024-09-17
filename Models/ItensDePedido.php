<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItensDePedido extends Model
{
    use HasFactory;

    protected $table = 'itens_de_pedidos';

    protected $fillable = [
        'quantidade_do_item',
        'valor_do_item',
        'horario_requisicao_pedido',
        'horario_entrega_pedido',
        'id_pedido',
        'id_produto',
    ];

    public function pedido()
    {
        return $this->belongsTo('App\Models\Pedido', 'id_pedido');
    }

    public function produto()
    {
        return $this->belongsTo('App\Models\Produto', 'id_produto');
    }
}
