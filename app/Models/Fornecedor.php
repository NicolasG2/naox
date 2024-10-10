<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fornecedor extends Model
{
    use HasFactory;

    protected $table = 'fornecedors';

    protected $fillable = [
        'nome',
        'telefone',
        'documento',
        'ativo',
        'email',
        'endereco',
        'descricao',
        'foto',
    ];

    public function produto()
    {
        return $this->belongsToMany('App\Models\Produto', 'fornecimento_do_produto', 'id_fornecedor', 'id_produto');
    }

    public function ingrediente()
    {
        return $this->belongsToMany('App\Models\Ingrediente', 'fornecimento_do_ingrediente', 'id_fornecedor', 'id_ingrediente');
    }
}
