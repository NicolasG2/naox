<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdutoTemMuitasCategorias extends Model
{
    use HasFactory;

    protected $table = 'produto_tem_muitas_categorias';

    public function produto() {
        return $this->belongsTo('App\Models\Produto', 'id_produto');
    }

    public function categoriaProduto() {
        return $this->belongsTo('App\Models\CategoriaDoProduto', 'id_categoria_produto');
    }
}
