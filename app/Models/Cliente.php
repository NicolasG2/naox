<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $table = 'clientes';

    protected $fillable = [
        'nome',
        'comentario',
        'telefone',
        'desconto',
        'cpf',
    ];

    public function pedidoDoCliente()
    {
        return $this->hasMany('App\Models\PedidoDoCliente', 'id_cliente');
    }
}
