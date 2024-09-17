<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receita extends Model
{
    use HasFactory;

    protected $table = 'receitas';

    protected $fillable = [
        'quantidade_do_ingrediente_no_produto',
        'id_produto',
        'id_ingrediente',
    ];

    public function produto()
    {
        return $this->belongsTo('App\Models\Produto', 'id_produto');
    }

    public function ingrediente()
    {
        return $this->belongsTo('App\Models\Ingrediente', 'id_ingrediente');
    }
}
