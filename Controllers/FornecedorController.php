<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fornecedor;

class FornecedorController extends Controller
{
    
    public function index()
    {
        $fornecedores = Fornecedor::orderBy('nome')->get();
        return view('fornecedores.index', compact('fornecedores'));
    }


    public function create()
    {
        return view('fornecedores.create');
    }


    public function store(Request $request)
    {
        $regras = [
            'nome' => 'required|max:255|min:2',
            'telefone' => 'required',
            'documento' => 'required',
            'ativo' => 'required',
        ];

        $msgs = [
            "required" => "O preenchimento do campo [:attribute] é obrigatório!",
            "max" => "O campo [:attribute] possui tamanho máximo de [:max] caracteres!",
            "min" => "O campo [:attribute] possui tamanho mínimo de [:min] caracteres!",
        ];

        $request->validate($regras, $msgs);

        $reg = Fornecedor::where('nome', $request->nome)->first();

        if (!isset($reg)) {

            $reg = new Fornecedor();

            if (isset($reg)) {
                $reg->nome = $request->nome;
                $reg->descricao = $request->descricao;
                $reg->telefone = $request->telefone;
                $reg->documento = $request->documento;
                $reg->email = $request->email;
                $reg->endereco = $request->endereco;
                $reg->ativo = $request->ativo;

                $reg->save();
            }

            return redirect()->route('fornecedores.index');
        }
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {

        $fornecedores = Fornecedor::find($id);

        if (!isset($fornecedores)) {
            return "<h1>Id: $id não encontrado!</h1>";
        }

        return view('fornecedores.edit', compact('fornecedores'));
    }


    public function update(Request $request, $id)
    {
        $regras = [
            'nome' => 'required|max:255|min:2',
            'telefone' => 'required',
            'documento' => 'required',
            'ativo' => 'required',
        ];

        $msgs = [
            "required" => "O preenchimento do campo [:attribute] é obrigatório!",
            "max" => "O campo [:attribute] possui tamanho máximo de [:max] caracteres!",
            "min" => "O campo [:attribute] possui tamanho mínimo de [:min] caracteres!",
        ];

        $request->validate($regras, $msgs);

        $reg = Fornecedor::find($id);

        if (isset($reg)) {
            $reg->nome = $request->nome;
            $reg->descricao = $request->descricao;
            $reg->telefone = $request->telefone;
            $reg->documento = $request->documento;
            $reg->email = $request->email;
            $reg->endereco = $request->endereco;
            $reg->ativo = $request->ativo;

            $reg->save();
        } else {
            return "<h1>ID: $id não encontrado!";
        }

        return redirect()->route('fornecedores.index');
    }


    public function destroy($id)
    {

        $reg = Fornecedor::find($id);

        if (!isset($reg)) {
            return "<h1>ID: $id não encontrado!";
        }

        $reg->delete();

        return redirect()->route('fornecedores.index');
    }
}
