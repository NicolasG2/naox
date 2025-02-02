<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categoria;

class CategoriaController extends Controller
{
    public function index()
    {
        $categorias = Categoria::orderBy('nome')->get();
        return view('categorias.index', compact('categorias'));
    }


    public function create()
    {
        return view('categorias.create');
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

        $reg = Categoria::where('nome', $request->nome)->first();

        if(!isset($reg)) {

            $reg = new Categoria();

            if(isset($reg)) {
                $reg->nome = $request->nome;
                $reg->area = $request->area;

                $reg->save();  
            } 
            
            return redirect()->route('categorias.index');
        }
    }

    
    public function show($id)
    {
        //
    }

    
    public function edit($id)
    {
        $categorias = Categoria::find($id);

        if(!isset($categorias)) { return "<h1>Id: $id não encontrado!</h1>"; }

        return view('categorias.edit', compact('categorias'));
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

        $reg = Categoria::find($id);
        
        if(isset($reg)) {
            $reg->nome = $request->nome;
            $reg->area = $request->area;
            
            $reg->save();
        } else {
            return "<h1>ID: $id não encontrado!";
        }

        return redirect()->route('categorias.index');
    }

    
    public function destroy($id)
    {
        $reg = Categoria::find($id);

        if(!isset($reg)) { return "<h1>ID: $id não encontrado!"; }

        $reg->delete();

        return redirect()->route('categorias.index');
    }
}