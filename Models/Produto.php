<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    use HasFactory;

    protected $table = 'produtos';

    protected $fillable = [
        'nome',
        'preco',
        'ativo',
        'quantidade',
        'descricao',
        'custo',
        'foto',
        'fornecedor_id', // Assuming this is the correct foreign key column
    ];

    public function fornecimentoProduto()
    {
        return $this->hasMany('App\Models\FornecimentoDoProduto', 'id_produto');
    }

    public function ingredientes()
    {
        return $this->belongsToMany('App\Models\Ingrediente', 'receitas', 'id_produto', 'id_ingrediente');
    }

    public function itensDePedido()
    {
        return $this->hasMany('App\Models\ItensDePedido', 'id_produto');
    }

    public function categoriaProduto()
    {
        return $this->belongsToMany('App\Models\CategoriaProduto', 'produto_muitas_categorias', 'id_produto', 'id_categoria_produto');
    }

    public function fornecedor()
    {
        return $this->belongsTo('App\Models\Fornecedor', 'fornecedor_id');
    }
}
