@extends('templates.header', ['menu' => 'admin'])

@section('conteudo')
    <div>
        <h2>Pedidos da Mesa {{ $mesa_id }}</h2>
        <select id="produto-select" class="form-control">
            @foreach ($produtos as $produto)
                <option value="{{ $produto->id }}">{{ $produto->nome }}</option>
            @endforeach
        </select>
        <button class="btn btn-success" onclick="adicionarPedido({{ $mesa_id }})">Adicionar Produto</button>
        <ul id="lista-pedidos">
            @foreach ($pedidos as $pedido)
                <li>{{ $pedido->produto->nome }}</li>
            @endforeach
        </ul>
    </div>

    <script>
        function adicionarPedido(mesaId) {
            const produtoId = document.getElementById('produto-select').value;

            fetch('/pedidos', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        mesa_id: mesaId,
                        produto_id: produtoId
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const listaPedidos = document.getElementById('lista-pedidos');
                        const novoPedido = document.createElement('li');
                        novoPedido.textContent = data.produto.nome;
                        listaPedidos.appendChild(novoPedido);
                    } else {
                        alert('Erro ao adicionar pedido');
                    }
                })
                .catch(error => console.error('Erro ao adicionar pedido:', error));
        }
    </script>
@endsection