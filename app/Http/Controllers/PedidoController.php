<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;

use App\Models\Pedido;
use App\Models\Mesa;
use App\Models\Produto;
use App\Models\Cliente;
use App\Models\User;
use App\Models\ItensDePedido;
use App\Models\PedidoDoCliente;
use Throwable;

class PedidoController extends Controller
{
    public function home()
    {
        $mesas = Mesa::all();
        $produtos = Produto::all();
        $clientes = Cliente::all();
        $users = User::all();

        $pedidoDoCliente = PedidoDoCliente::with(['cliente', 'pedido'])->orderBy('id')->get();
        $pedido_cliente_data = [];

        foreach ($pedidoDoCliente as $d) {
            $pedido_cliente_data[] = [
                'id' => $d->id,
                'valor_pago_pelo_cliente' => $d->valor_pago_pelo_cliente,
                'id_cliente' => $d->id_cliente,
                'id_pedido' => $d->id_pedido,
                'cliente_nome' => $d->cliente->nome ?? '',
                'cliente_desconto' => $d->cliente->desconto ?? 0.0,
            ];
        }

        $itensDePedido = ItensDePedido::with(['pedido', 'produto'])->orderBy('id')->get();
        $itens_data = [];

        foreach ($itensDePedido as $d) {
            $itens_data[] = [
                'id' => $d->id,
                'horario_requisicao_pedido' => $d->horario_requisicao_pedido,
                'horario_entrega_pedido' => $d->horario_entrega_pedido,
                'id_pedido' => $d->id_pedido,
                'nome' => $d->produto->nome ?? '',
                'valor' => $d->produto->valor ?? 0,
                'quantidade' => $d->produto->quantidade ?? 0,
            ];
        }

        return view('templates.home', compact('mesas', 'produtos', 'clientes', 'users', 'itens_data'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_mesa' => 'required|exists:mesas,id',
            'num_pessoas' => 'required|integer|min:1',
            'id_cliente' => 'nullable|exists:clientes,id',
            'id_user' => 'required|exists:users,id',
            'comentario' => 'nullable|string',
        ]);

        try {
            $pedido = Pedido::create([
                'id_mesa' => $request->id_mesa,
                'num_pessoas' => $request->num_pessoas,
                'id_cliente' => $request->id_cliente,
                'id_user' => $request->id_user,
                'comentario' => $request->comentario,
                'valor_total_pedido' => 0,
            ]);

            return response()->json($pedido);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao abrir mesa: ' . $e->getMessage()], 500);
        }
    }

    public function adicionarProduto(Request $request, Pedido $pedido)
    {
        Log::info('Request data:', $request->all());
        Log::info('Pedido:', $pedido->toArray());

        try {
            $request->validate([
                'id_mesa' => 'required|integer',
                'id_produto' => 'required|integer',
                'quantidade' => 'required|integer|min:1',
            ]);

            $produto = Produto::findOrFail($request->id_produto);

            $item = $pedido->itensDePedido()->create([
                'id_produto' => $request->id_produto,
                'quantidade' => $request->quantidade,
                'valor' => $produto->valor * $request->quantidade,
            ]);

            $pedido->increment('valor_total_pedido', $produto->valor * $request->quantidade);

            return response()->json([
                'pedido' => $pedido->load('itensDePedido.produto'),
                'item' => $item,
            ], 200);

        } catch (ValidationException $e) {
            \Log::error('Erro ao validar dados para adicionar produto', [
                'errors' => $e->errors(),
            ]);
            return response()->json(['error' => 'Dados inválidos'], 422);
        }
    }


    public function show(Request $request, $id_mesa)
    {        
        $pedido = Pedido::where('id_mesa', $id_mesa)->with('itensDePedido.produto')->first();

        if (!$pedido) {
            return response()->json(['message' => 'Pedido não encontrado'], 404);
        }

        return response()->json($pedido, 200);
    }

    public function render($request, Throwable $exception)
    {
        if ($request->expectsJson()) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }

        return parent::render($request, $exception);
    }
}
