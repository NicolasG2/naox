<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IngredienteTemMuitasCategorias extends Model
{
    use HasFactory;

    protected $table = 'ingrediente_muitas_categorias';

    public function ingrediente()
    {
        return $this->belongsTo('App\Models\Ingrediente', 'id_ingrediente');
    }

    public function categoriaIngrediente()
    {
        return $this->belongsTo('App\Models\CategoriaIngrediente', 'id_categoria_ingrediente');
    }
}
