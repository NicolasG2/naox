<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mesa extends Model
{
    use HasFactory;

    protected $table = 'mesas';

    protected $fillable = ['numero', 'capacidade', 'formato', 'tamanho'];

    public function pedido()
    {
        return $this->hasMany('App\Models\Pedido', 'id_mesa');
    }
}
