<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pedido;
use App\Models\Mesa;
use App\Models\Produto;
use App\Models\Cliente;
use App\Models\User;
use App\Models\ItemDePedido;

class PedidoController extends Controller
{

    public function home()
    {
        $mesas = Mesa::all();
        $produtos = Produto::all();
        $clientes = Cliente::all();
        $users = User::all();
        return view('templates.home', compact('mesas', 'produtos', 'clientes', 'users'));
    }

    public function index()
    {
        $pedidos = Pedido::with('mesa', 'itensDePedido.produto', 'pedidoDoCliente.cliente')->get();
        return view('pedidos.index', compact('pedidos'));
    }

    public function create()
    {
        $mesas = Mesa::all();
        $produtos = Produto::all();
        $clientes = Cliente::all();
        $users = User::all();

        return view('pedidos.create', compact('mesas', 'produtos', 'clientes', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_mesa' => 'required|exists:mesas,id',
            'num_pessoas' => 'required|integer',
            'id_usuario' => 'required|exists:users,id',
            'id_cliente' => 'nullable|exists:clientes,id',
        ]);

        $pedido = Pedido::create([
            'num_pessoas' => $request->num_pessoas,
            'valor_total_pedido' => 0, 
            'comentario' => $request->comentario,
            'id_mesa' => $request->id_mesa,
            'id_cliente' => $request->id_cliente,
            'id_usuario' => $request->id_usuario,
        ]);

        return response()->json($pedido);
    }

    public function edit(Pedido $pedido)
    {
        $mesas = Mesa::all();
        $produtos = Produto::all();
        $clientes = Cliente::all();
        $users = User::all();

        return view('pedidos.edit', compact('pedido', 'mesas', 'produtos', 'clientes', 'users'));
    }

    public function update(Request $request, Pedido $pedido)
    {
        $request->validate([
            'id_mesa' => 'required|exists:mesas,id',
            'num_pessoas' => 'required|integer',
            'id_usuario' => 'required|exists:users,id',
            'id_cliente' => 'nullable|exists:clientes,id',
            'itens' => 'nullable|array',
            'itens.*.id_produto' => 'required|exists:produtos,id',
            'itens.*.quantidade_do_item' => 'required|numeric|min:0',
        ]);

        $pedido->update([
            'num_pessoas' => $request->num_pessoas,
            'id_mesa' => $request->id_mesa,
            'id_cliente' => $request->id_cliente,
            'id_usuario' => $request->id_usuario,
            'comentario' => $request->comentario,
        ]);

        $pedido->itemDePedido()->delete();

        $valorTotal = 0;
        if ($request->has('itens')) {
            foreach ($request->itens as $item) {
                $valorTotal += $item['quantidade_do_item'] * Produto::find($item['id_produto'])->preco;

                $pedido->itemDePedido()->create([
                    'id_produto' => $item['id_produto'],
                    'quantidade_do_item' => $item['quantidade_do_item'],
                    'valor_do_item' => Produto::find($item['id_produto'])->preco * $item['quantidade_do_item'],
                    'horario_requisicao_pedido' => now(),
                    'horario_entrega_pedido' => null,
                ]);
            }
        }

        $pedido->update(['valor_total_pedido' => $valorTotal]);

        return redirect()->route('pedidos.index')->with('success', 'Pedido atualizado com sucesso!');
    }

    public function destroy(Pedido $pedido)
    {
        $pedido->delete();

        return redirect()->route('pedidos.index')->with('success', 'Pedido excluído com sucesso!');
    }
}
