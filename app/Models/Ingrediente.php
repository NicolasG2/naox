<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingrediente extends Model
{
    use HasFactory;

    protected $table = 'ingredientes';

    protected $fillable = ['nome', 'unidade', 'quantidade', 'custo'];

    public function fornecimentoIngrediente()
    {
        return $this->hasMany('App\Models\FornecimentoDoIngrediente', 'id_ingrediente');
    }

    public function produto()
    {
        return $this->belongsToMany('App\Models\Produto', 'receitas', 'id_ingrediente', 'id_produto');
    }

    public function categoriaIngrediente()
    {
        return $this->belongsToMany('App\Models\CategoriaIngrediente', 'ingrediente_muitas_categorias', 'id_ingrediente', 'id_categoria_ingrediente');
    }
}
