<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CategoriaProduto;
use App\Models\Fornecedor;
use App\Models\Ingrediente;
use App\Models\Produto;

class ProdutoController extends Controller
{
    public function index()
    {
        $produtos = Produto::with(['ingredientes', 'categoriaProduto', 'fornecedor'])->orderBy('id')->get();

        $produtos_data = array();
        $cont = 0;
        foreach ($produtos as $d) {
            $produtos_data[$cont]['id'] = $d->id;
            $produtos_data[$cont]['nome'] = $d->nome;
            $produtos_data[$cont]['preco'] = $d->preco;
            $produtos_data[$cont]['ativo'] = $d->ativo;
            $produtos_data[$cont]['quantidade'] = $d->quantidade;
            $produtos_data[$cont]['descricao'] = $d->descricao;
            $produtos_data[$cont]['custo'] = $d->custo;
            $produtos_data[$cont]['foto'] = $d->foto;

            $ingredientes_nome = [];
            foreach ($d->ingredientes as $ingrediente) {
                $ingredientes_nome[] = $ingrediente->nome;
            }
            $produtos_data[$cont]['ingrediente_nome'] = implode(', ', $ingredientes_nome);

            $produtos_data[$cont]['categoria_nome'] = $d->categoriaProduto->first()->nome ?? '';
            $produtos_data[$cont]['fornecedor_nome'] = $d->fornecedor->nome ?? '';

            $cont++;
        }

        return view('produtos.index', compact('produtos_data'));
    }

    public function create()
    {
        $categorias = CategoriaProduto::orderBy('nome')->get();
        $fornecedores = Fornecedor::orderBy('nome')->get();
        $ingredientes = Ingrediente::orderBy('nome')->get();

        return view('produtos.create', compact('categorias', 'fornecedores', 'ingredientes'));
    }

    public function store(Request $request)
    {
        $regras = [
            'nome' => 'required|max:255|min:2',
            'preco' => 'required|numeric|min:0',
            'ativo' => 'required|boolean',
            'quantidade' => 'required|integer|min:0',
            'descricao' => 'nullable|string|min:10',
            'custo' => 'nullable|numeric|min:0',
            'foto' => 'nullable|image',
            'ingrediente' => 'nullable|array',
            'ingrediente.*' => 'nullable|integer',
            'categoria' => 'required|integer',
            'fornecedor' => 'nullable|integer',
        ];

        $msgs = [
            "required" => "O preenchimento do campo [:attribute] é obrigatório!",
            "max" => "O campo [:attribute] possui tamanho máximo de [:max] caracteres!",
            "min" => "O campo [:attribute] possui tamanho mínimo de [:min] caracteres!",
        ];

        $request->validate($regras, $msgs);

        $reg = Produto::where('nome', $request->nome)->first();

        if (!isset($reg)) {
            $reg = new Produto();

            $reg->nome = $request->nome;
            $reg->preco = $request->preco;
            $reg->ativo = $request->ativo;
            $reg->quantidade = $request->quantidade;
            $reg->descricao = $request->descricao;
            $reg->custo = $request->custo;
            if ($request->hasFile('foto')) {
                $reg->foto = $request->file('foto')->store('fotos_produtos');
            }
            $reg->categoria = $request->categoria;
            $reg->fornecedor = $request->fornecedor;

            $reg->save();

            $reg->ingredientes()->sync($request->ingrediente);

            return redirect()->route('produtos.index');
        }

        return redirect()->route('produtos.index')->withErrors(['nome' => 'Produto já existente.']);
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $produto = Produto::with('ingredientes')->find($id);
        $ingredientes = Ingrediente::all();
        $fornecedores = Fornecedor::all();
        $categorias = CategoriaProduto::all();

        if (!$produto) {
            return "<h1>Id: $id não encontrado!</h1>";
        }

        $ingredientes_selecionados = $produto->ingredientes->pluck('id')->toArray();

        return view('produtos.edit', compact('categorias', 'fornecedores', 'ingredientes', 'ingredientes_selecionados', 'produto'));
    }

    public function update(Request $request, $id)
    {
        $regras = [
            'nome' => 'required|max:255|min:2',
            'preco' => 'required|numeric|min:0',
            'ativo' => 'required|boolean',
            'quantidade' => 'required|integer|min:0',
            'descricao' => 'nullable|string|min:10',
            'custo' => 'nullable|numeric|min:0',
            'foto' => 'nullable|image',
            'categoria' => 'required|integer',
            'ingrediente' => 'nullable|array',
            'ingrediente.*' => 'nullable|integer',
            'fornecedor' => 'nullable|integer',
        ];

        $msgs = [
            "required" => "O preenchimento do campo [:attribute] é obrigatório!",
            "max" => "O campo [:attribute] possui tamanho máximo de [:max] caracteres!",
            "min" => "O campo [:attribute] possui tamanho mínimo de [:min] caracteres!",
        ];

        $request->validate($regras, $msgs);

        $reg = Produto::find($id);

        if (isset($reg)) {
            $reg->nome = $request->nome;
            $reg->preco = $request->preco;
            $reg->ativo = $request->ativo;
            $reg->quantidade = $request->quantidade;
            $reg->descricao = $request->descricao;
            $reg->custo = $request->custo;
            if ($request->hasFile('foto')) {
                $reg->foto = $request->file('foto')->store('fotos_produtos');
            }
            $reg->categoria = $request->categoria;
            $reg->fornecedor = $request->fornecedor;

            $reg->save();

            $reg->ingredientes()->sync($request->ingrediente);

            return redirect()->route('produtos.index');
        }

        return "<h1>Produto ID: $id não encontrado!</h1>";
    }

    public function destroy($id)
    {
        //
    }
}