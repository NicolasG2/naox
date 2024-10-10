<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FornecimentoDoProduto extends Model
{
    use HasFactory;

    protected $table = 'fornecimento_do_produto';

    protected $fillable = [
        'quantidade_do_produto',
        'valor_do_produto',
        'valor_total_do_fornecimento',
        'horario_requisicao_produto',
        'horario_entrega_produto',
        'id_fornecedor',
        'id_produto',
    ];

    public function fornecedor()
    {
        return $this->belongsTo('App\Models\Fornecedor', 'id_fornecedor');
    }

    public function produto()
    {
        return $this->belongsTo('App\Models\Produto', 'id_produto');
    }
}
