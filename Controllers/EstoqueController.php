<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produto;
use App\Models\Ingrediente;

class EstoqueController extends Controller
{
    public function index()
    {
        $produtos = Produto::orderBy('nome')->get();
        $ingredientes = Ingrediente::orderBy('nome')->get();

        return view('estoque.index', compact('produtos', 'ingredientes'));
    }


    public function update(Request $request)
    {
        $type = $request->type;
        $id = $request->id;

        if ($type === 'produto') {
            return $this->updateProduto($request, $id);
        } elseif ($type === 'ingrediente') {
            return $this->updateIngrediente($request, $id);
        }

        return redirect()->route('estoque.index')->with('error', 'Tipo de item inválido.');
    }


    public function updateProduto(Request $request, $id)
    {
        $produto = Produto::find($id);

        if ($produto && $produto->exists) {
            $produto->update($request->only(['nome', 'quantidade']));
            return redirect()->route('estoque.index')->with('success', 'Produto atualizado com sucesso.');
        }

        return redirect()->route('estoque.index')->with('error', 'Produto não encontrado.');
    }
    

    public function updateIngrediente(Request $request, $id)
    {
        $ingrediente = Ingrediente::find($id);

        if ($ingrediente && $ingrediente->exists) {
            $ingrediente->update($request->only(['nome', 'quantidade']));
            return redirect()->route('estoque.index')->with('success', 'Ingrediente atualizado com sucesso.');
        }

        return redirect()->route('estoque.index')->with('error', 'Ingrediente não encontrado.');
    }
}