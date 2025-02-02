<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('nome')->get();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $regras = [
            'nome' => 'required|max:255|min:2',
            'password' => [
                'required',
                'string',
                'min:8',
                function ($attribute, $value, $fail) {
                    if (!preg_match('/[a-zA-Z]/', $value)) {
                        $fail('A senha deve conter pelo menos uma letra.');
                    }
                    if (!preg_match('/[@$!%*#?&]/', $value)) {
                        $fail('A senha deve conter pelo menos um caractere especial (@$!%*#?&).');
                    }
                },
            ],
            'tipo_acesso' => 'required|string',
            'email' => 'required|string|email|min:10',
            'telefone' => 'required',
            'ativo' => 'nullable|boolean',
        ];

        $msgs = [
            "required" => "O preenchimento do campo :attribute é obrigatório!",
            "max" => "O campo :attribute possui tamanho máximo de :max caracteres!",
            "min" => "O campo :attribute possui tamanho mínimo de :min caracteres!",
            "email" => "O campo :attribute deve ser um endereço de e-mail válido!",
            "numeric" => "O campo :attribute deve ser um número!",
        ];

        $request->validate($regras, $msgs);

        $user = new User();

        $user->nome = $request->nome;
        $user->password = bcrypt($request->password);
        $user->tipo_acesso = $request->tipo_acesso;
        $user->email = $request->email;
        $user->telefone = $request->telefone;
        $user->ativo = $request->ativo ? true : false;

        $estabelecimento = 'digiDinner';
        $usuario = $request->nome . '@' . $estabelecimento;
        $user->usuario = $usuario;

        $user->save();

        return redirect()->route('users.index')->with('success', 'Usuário criado com sucesso!');
    }


    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $users = User::find($id);

        return view('users.edit', compact('users'));
    }

    public function update(Request $request, $id)
    {
        $regras = [
            'tipo_acesso' => 'required|string',
            'email' => 'required|string|email|min:10',
            'telefone' => 'required',
            'ativo' => 'nullable|boolean',
        ];

        $msgs = [
            "required" => "O preenchimento do campo :attribute é obrigatório!",
            "max" => "O campo :attribute possui tamanho máximo de :max caracteres!",
            "min" => "O campo :attribute possui tamanho mínimo de :min caracteres!",
            "email" => "O campo :attribute deve ser um endereço de e-mail válido!",
            "numeric" => "O campo :attribute deve ser um número!",
        ];

        $request->validate($regras, $msgs);

        $user = User::find($id);

        $user->tipo_acesso = $request->tipo_acesso;
        $user->email = $request->email;
        $user->telefone = $request->telefone;
        $user->ativo = $request->ativo ? true : false;

        $user->save();

        return redirect()->route('users.index')->with('success', 'Usuário editado com sucesso!');
    }

    public function destroy($id)
    {
        $reg = User::find($id);

        if (!isset($reg)) {
            return "<h1>ID: $id não encontrado!";
        }

        $reg->delete();

        return redirect()->route('users.index');
    }
}