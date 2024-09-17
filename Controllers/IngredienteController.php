<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CategoriaIngrediente;
use App\Models\Ingrediente;
use App\Models\Fornecedor;

class IngredienteController extends Controller
{

    public function index()
    {
        $ingredientes = Ingrediente::orderBy('id')->get();

        $ingredientes_data = array();
        $cont = 0;
        foreach ($ingredientes as $d) {

            $ingredientes_data[$cont]['id'] = $d->id;
            $ingredientes_data[$cont]['nome'] = $d->nome;
            $ingredientes_data[$cont]['unidade'] = $d->unidade;
            $ingredientes_data[$cont]['quantidade'] = $d->quantidade;
            $ingredientes_data[$cont]['custo'] = $d->custo;

            $obj = CategoriaIngrediente::find($d->categoria);
            if (isset($obj)) {
                $ingredientes_data[$cont]['categoria_nome'] = $obj->nome;
            } else {
                $ingredientes_data[$cont]['categoria_nome'] = '';
            }

            $obj = Fornecedor::find($d->fornecedor);
            if (isset($obj)) {
                $ingredientes_data[$cont]['fornecedor_nome'] = $obj->nome;
            } else {
                $ingredientes_data[$cont]['fornecedor_nome'] = '';
            }

            $cont++;
        }

        return view('ingredientes.index', compact('ingredientes_data'));
    }

    public function create()
    {
        $fornecedores = Fornecedor::orderBy('nome')->get();
        $categorias = CategoriaIngrediente::orderBy('nome')->get();

        return view('ingredientes.create', compact('fornecedores', 'categorias'));
    }

    public function store(Request $request)
    {
        $regras = [
            'nome' => 'required|max:255|min:2',
            'unidade' => 'required',
            'quantidade' => 'required|min:0',
            'custo' => 'min:0'
        ];

        $msgs = [
            "required" => "O preenchimento do campo [:attribute] é obrigatório!",
            "max" => "O campo [:attribute] possui tamanho máximo de [:max] caracteres!",
            "min" => "O campo [:attribute] possui tamanho mínimo de [:min] caracteres!",
        ];

        $request->validate($regras, $msgs);

        $reg = Ingrediente::where('nome', $request->nome)->first();

        if (!isset($reg)) {

            $reg = new Ingrediente();

            if (isset($reg)) {
                $reg->nome = $request->nome;
                $reg->unidade = $request->unidade;
                $reg->quantidade = $request->quantidade;
                $reg->custo = $request->custo;
                $reg->categoria = $request->categoria;
                $reg->fornecedor = $request->fornecedor;

                $reg->save();
            }

            return redirect()->route('ingredientes.index');
        }
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $ingredientes = Ingrediente::find($id);
        $fornecedores = Fornecedor::all();
        $categorias = CategoriaIngrediente::all();

        if (!$ingredientes) {
            return "<h1>Id: $id não encontrado!</h1>";
        }

        return view('ingredientes.edit', compact('ingredientes', 'fornecedores', 'categorias'));
    }

    public function update(Request $request, $id)
    {
        $regras = [
            'nome' => 'required|max:255|min:2',
            'unidade' => 'required',
            'quantidade' => 'required',
            'custo' => 'min:0'
        ];

        $msgs = [
            "required" => "O preenchimento do campo [:attribute] é obrigatório!",
            "max" => "O campo [:attribute] possui tamanho máximo de [:max] caracteres!",
            "min" => "O campo [:attribute] possui tamanho mínimo de [:min] caracteres!",
        ];

        $request->validate($regras, $msgs);

        $reg = Ingrediente::find($id);

        if (isset($reg)) {
            $reg->nome = $request->nome;
            $reg->unidade = $request->unidade;
            $reg->quantidade = $request->quantidade;
            $reg->custo = $request->custo;
            $reg->categoria = $request->categoria;
            $reg->fornecedor = $request->fornecedor;

            $reg->save();
        } else {
            return "<h1>ID: $id não encontrado!";
        }

        return redirect()->route('ingredientes.index');
    }

    public function destroy($id)
    {
        $reg = Ingrediente::find($id);

        if (!isset($reg)) {
            return "<h1>ID: $id não encontrado!";
        }

        $reg->delete();

        return redirect()->route('ingredientes.index');
    }
}