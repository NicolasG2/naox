<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoriaIngrediente extends Model
{
    use HasFactory;

    protected $table = 'categoria_ingredientes';

    protected $fillable = ['nome', 'area'];

    public function ingrediente()
    {
        return $this->belongsToMany('App\Models\Ingrediente', 'ingrediente_muitas_categorias', 'id_categoria_ingrediente', 'id_ingrediente'
        );
    }
}
