<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FornecimentoDoIngrediente extends Model
{
    use HasFactory;

    protected $table = 'fornecimento_do_ingrediente';

    protected $fillable = [
        'quantidade_do_ingrediente',
        'valor_do_ingrediente',
        'valor_total_do_fornecimento',
        'horario_requisicao_ingrediente',
        'horario_entrega_ingrediente',
        'id_fornecedor',
        'id_ingrediente',
    ];

    public function fornecedor()
    {
        return $this->belongsTo('App\Models\Fornecedor', 'id_fornecedor');
    }

    public function ingrediente()
    {
        return $this->belongsTo('App\Models\Ingrediente', 'id_ingrediente');
    }
}
