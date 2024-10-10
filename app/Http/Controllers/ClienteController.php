<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;

class ClienteController extends Controller
{
    
    public function index()
    {
        $clientes = Cliente::orderBy('nome')->get();
        return view('clientes.index', compact('clientes'));
    }


    public function create()
    {
        return view('clientes.create');
    }


    public function store(Request $request)
    {
        $regras = [
            'nome' => 'required|max:255|min:2',
        ];

        $msgs = [
            "required" => "O preenchimento do campo [:attribute] é obrigatório!",
            "max" => "O campo [:attribute] possui tamanho máximo de [:max] caracteres!",
            "min" => "O campo [:attribute] possui tamanho mínimo de [:min] caracteres!",
        ];

        $request->validate($regras, $msgs);

        $reg = Cliente::where('nome', $request->nome)->first();

        if(!isset($reg)) {

            $reg = new Cliente();

            if(isset($reg)) {
                $reg->nome = $request->nome;
                $reg->comentario = $request->comentario;
                $reg->telefone = $request->telefone;
                $reg->desconto = $request->desconto;

                $reg->save();  
            } 
            
            return redirect()->route('clientes.index');
        }
    }

    
    public function show($id)
    {
        //
    }

    
    public function edit($id)
    {

        $clientes = Cliente::find($id);

        if(!isset($clientes)) { return "<h1>Id: $id não encontrado!</h1>"; }

        return view('clientes.edit', compact('clientes'));
    }

    
    public function update(Request $request, $id)
    {
        $regras = [
            'nome' => 'required|max:255|min:2',
        ];

        $msgs = [
            "required" => "O preenchimento do campo [:attribute] é obrigatório!",
            "max" => "O campo [:attribute] possui tamanho máximo de [:max] caracteres!",
            "min" => "O campo [:attribute] possui tamanho mínimo de [:min] caracteres!",
        ];

        $request->validate($regras, $msgs);

        $reg = Cliente::find($id);
        
        if(isset($reg)) {
            $reg->nome = $request->nome;
            $reg->comentario = $request->comentario;
            $reg->telefone = $request->telefone;
            $reg->desconto = $request->desconto;
            
            $reg->save();
        } else {
            return "<h1>ID: $id não encontrado!";
        }

        return redirect()->route('clientes.index');
    }

    
    public function destroy($id)
    {

        $reg = Cliente::find($id);

        if(!isset($reg)) { return "<h1>ID: $id não encontrado!"; }

        $reg->delete();

        return redirect()->route('clientes.index');
    }
}
