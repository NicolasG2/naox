@extends('templates.header', ['menu' => 'admin'])

@section('conteudo')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/templates/home.css') }}">

    <a href="{{ route('mesas.index') }}" class="btn btn-primary mb-4">Gerenciador de mesas</a>
    <div class="main d-flex border justify-content-around">
        <div class="col-md-7">
            <div class="grid-container" id="grid-container">
                @foreach ($mesas as $mesa)
                    @php
                        $sizeClass = '';
                        if ($mesa->tamanho == 'Pequena') {
                            $sizeClass = 'grid-size-50';
                        } elseif ($mesa->tamanho == 'Média') {
                            $sizeClass = 'grid-size-60';
                        } elseif ($mesa->tamanho == 'Grande') {
                            $sizeClass = 'grid-size-70';
                        }
                    @endphp
                    <div class="grid-item {{ $sizeClass }} border rounded" id="mesa-{{ $mesa->id }}"
                        data-mesa-id="{{ $mesa->id }}" data-mesa-numero="{{ $mesa->numero }}"
                        onclick="showMesaDetails({{ $mesa->id }}, {{ json_encode($mesa) }})">
                        {{ $mesa->numero }}
                    </div>
                @endforeach
            </div>
        </div>
        <div class="col-md-5 d-flex border rounded justify-content-center align-items-center ml-3">
            <div id="mesa-details" class="text-center w-100">
                <h6><-- Selecione uma mesa</h6>
            </div>
        </div>
    </div>

    <script>
        const clientes = @json($clientes);
        const atendentes = @json($users);
        const produtos = @json($produtos);

        let mesa_id_global;

        function showMesaDetails(mesa_id, mesa) {
            console.log('Mesa selecionada:', mesa_id, mesa);
            mesa_id_global = mesa_id;
            const detailsDiv = document.getElementById('mesa-details');

            hideAllComponents();

            fetch(`/pedidos?mesa_id=${mesa_id}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Erro ao obter pedidos da mesa');
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Pedidos recebidos:', data);
                    renderPedidoArea(mesa_id, data);
                })
                .catch(error => {
                    console.error('Erro durante a requisição:', error);
                });

            let clientesOptions = '<option value="">Selecione um cliente</option>';
            clientes.forEach(cliente => {
                clientesOptions += `<option value="${cliente.id}">${cliente.nome}</option>`;
            });

            let atendentesOptions = '<option value="">Selecione um atendente</option>';
            atendentes.forEach(atendente => {
                atendentesOptions += `<option value="${atendente.id}">${atendente.nome}</option>`;
            });

            detailsDiv.innerHTML = `
        <h3>Mesa ${mesa.numero}</h3>
        <div class="d-flex">
            <p><strong>Número de pessoas:</strong></p>
            <div class="stat-minus"><i class="material-icons" alt="Minus">exposure_neg_1</i></div>
            <input id="num_pessoas" type="number" value="1" min="1" max="12"/>
            <div class="stat-plus"><i class="material-icons" alt="Plus">exposure_plus_1</i></div>
        </div>
        <div class="d-flex">
            <p><strong>Cliente:</strong></p> 
            <select class="form-control" name="cliente" id="cliente-select" placeholder="Cliente">
                ${clientesOptions}
            </select>
        </div>
        <div class="d-flex">
            <p><strong>Atendente:</strong></p> 
            <select class="form-control" name="atendente" id="atendente-select" placeholder="Atendente">
                ${atendentesOptions}
            </select>
        </div>
        <div class="d-flex">
            <p><strong>Comentário:</strong></p>
            <textarea name="comentario" id="comentario" cols="30" rows="5" resize="none"></textarea>
        </div>
        <button class="btn btn-info" onclick="abrirMesa(${mesa_id})">Abrir mesa</button>
    `;

            document.querySelector('.stat-plus').addEventListener('click', function() {
                const numberInput = document.getElementById('num_pessoas');
                let currentValue = parseInt(numberInput.value);
                if (currentValue < numberInput.max) {
                    numberInput.value = currentValue + 1;
                }
            });

            document.querySelector('.stat-minus').addEventListener('click', function() {
                const numberInput = document.getElementById('num_pessoas');
                let currentValue = parseInt(numberInput.value);
                if (currentValue > numberInput.min) {
                    numberInput.value = currentValue - 1;
                }
            });
        }

        function abrirMesa(mesa_id) {
            const num_pessoas = document.getElementById('num_pessoas').value;
            const comentario = document.getElementById('comentario').value;
            const cliente = document.getElementById('cliente-select').value;
            const user = document.getElementById('atendente-select').value;

            console.log('Abrindo mesa com os seguintes dados:', {
                num_pessoas: num_pessoas,
                comentario: comentario,
                cliente: cliente,
                mesa_id: mesa_id,
                user: user
            });

            fetch('/pedidos', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        num_pessoas: num_pessoas,
                        comentario: comentario,
                        id_mesa: mesa_id,
                        id_cliente: cliente,
                        id_usuario: user
                    })
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Erro ao enviar a requisição: ' + response.statusText);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Resposta recebida:', data);
                    renderPedidoArea(mesa_id);
                })
                .catch(error => {
                    console.error('Erro durante a requisição:', error);
                });
        }

        function hideAllComponents() {
            const detailsDiv = document.getElementById('mesa-details');
            detailsDiv.innerHTML = '';
        }

        function renderPedidoArea(mesa_id, data = null) {
            const detailsDiv = document.getElementById('mesa-details');

            let produtosOptions = '<option value="">Selecione um produto</option>';
            produtos.forEach(produto => {
                produtosOptions += `<option value="${produto.id}">${produto.nome}</option>`;
            });

            let pedidosHtml = '';
            if (data && data.pedidos) {
                data.pedidos.forEach(pedido => {
                    pedidosHtml +=
                        `<div class="pedido-item">${pedido.produto.nome} - Quantidade: ${pedido.quantidade_do_item}</div>`;
                });
            }

            const num_pessoas = document.getElementById('num_pessoas')?.value || '';
            const id_cliente = document.getElementById('cliente-select')?.value || '';
            const id_usuario = document.getElementById('atendente-select')?.value || '';

            detailsDiv.innerHTML = `
                    <h3>Mesa ${mesa_id}</h3>
                    <div class="row">
                        <span>Pessoas na mesa: ${num_pessoas}; </span>
                        <span>Cliente: ${id_cliente}; </span>
                        <span>Atendente: ${id_usuario}; </span>
                    </div>
                    <div class="d-flex flex-column">
                        <div class="d-flex">
                            <p><strong>Produto:</strong></p>
                            <select class="form-control" name="produto" id="produto-select">
                                ${produtosOptions}
                            </select>
                            <button class="btn btn-success ml-2" onclick="adicionarPedido(${mesa_id})">Adicionar Produto</button>
                        </div>
                        <div id="lista-pedidos" class="mt-3">
                            ${pedidosHtml}
                        </div>
                    </div>
                    <button class="btn btn-primary mt-3" onclick="finalizarPedidos(${mesa_id})">Finalizar Pedido</button>
                `;
        }

        function adicionarPedido(mesa_id) {
            const produtoSelect = document.getElementById('produto-select');
            const produtoId = produtoSelect.value;
            const produtoNome = produtoSelect.options[produtoSelect.selectedIndex].text;

            fetch('/itens-de-pedidos', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        id_pedido: mesa_id_global,
                        id_produto: produtoId,
                        quantidade_do_item: 1,
                        valor_do_item: 0,
                        horario_requisicao_pedido: new Date().toISOString(),
                        horario_entrega_pedido: null
                    })
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Erro ao enviar o pedido: ' + response.statusText);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Pedido adicionado:', data);
                    renderPedidoArea(mesa_id_global);
                })
                .catch(error => {
                    console.error('Erro durante a requisição:', error);
                });
        }

        function finalizarPedidos(mesa_id) {
            alert(Pedidos da Mesa $ {
                    mesa_id
                }
                finalizados!);
        }
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
@endsection
