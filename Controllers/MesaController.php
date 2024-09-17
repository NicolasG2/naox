<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mesa;
use App\Models\User;
use App\Models\Cliente;

class MesaController extends Controller
{
    public function index()
    {
        $mesas = Mesa::orderBy('numero')->get();

        return view('settings.mesas.index', compact('mesas'));
    }

    public function main()
    {
        $mesas = Mesa::orderBy('numero')->get();
        $clientes = Cliente::orderBy('nome')->get();
        $atendentes = User::orderBy('nome')->get();

        return view('templates.main', compact('mesas', 'clientes', 'atendentes'));
    }

    public function create()
    {
        return view('settings.mesas.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'numero' => 'required|integer|unique:mesas',
            'capacidade' => 'required|integer',
            'formato' => 'required|string|max:255',
            'tamanho' => 'required|string|max:255',
        ]);

        $mesa = Mesa::create($validatedData);

        return response()->json(['success' => true, 'mesa' => $mesa]);
    }

    public function edit(Mesa $mesa)
    {
        return view('settings.mesas.edit', compact('mesa'));
    }

    public function update(Request $request, Mesa $mesa)
    {
        $validatedData = $request->validate([
            'numero' => 'required|integer|unique:mesas,numero,' . $mesa->id,
            'capacidade' => 'required|integer',
            'formato' => 'required|string|max:255',
            'tamanho' => 'required|string|max:255',
        ]);

        $mesa->update($validatedData);

        return response()->json(['success' => true, 'mesa' => $mesa]);
    }

    public function destroy(Mesa $mesa)
    {
        $mesa->delete();
        return response()->json(['success' => true, 'mesa' => $mesa]);
    }
}