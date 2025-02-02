<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoriaProduto extends Model
{
    use HasFactory;

    protected $table = 'categoria_produtos';

    public function produto()
    {
        return $this->belongsToMany(
            'App\Models\Produto',
            'produto_tem_muitas_categorias',
            'id_categoria_produto',
            'id_produto'
        );
    }
}