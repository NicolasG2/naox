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
                        <div class="grid-item border rounded" id="mesa-{{ $mesa->id }}"
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
    @endsection

    @section('script')
        <script>
            const clientes = @json($clientes);
            const atendentes = @json($users);
            const produtos = @json($produtos);
            let id_mesa_global;

            function showMesaDetails(id_mesa, mesa) {
                id_mesa_global = id_mesa;
                const detailsDiv = document.getElementById('mesa-details');

                hideAllComponents();

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
                        <input id="num_pessoas" type="number" value="1" min="1" max="12" />
                        <div class="stat-plus"><i class="material-icons" alt="Plus">exposure_plus_1</i></div>
                    </div>
                    <div class="d-flex">
                        <p><strong>Cliente:</strong></p>
                        <select class="form-control" name="cliente" id="cliente-select">${clientesOptions}</select>
                    </div>
                    <div class="d-flex">
                        <p><strong>Atendente:</strong></p>
                        <select class="form-control" name="atendente" id="user-select">${atendentesOptions}</select>
                    </div>
                    <div class="d-flex">
                        <p><strong>Comentário:</strong></p>
                        <textarea name="comentario" id="comentario" cols="30" rows="5"></textarea>
                    </div>
                    <button class="btn btn-info" onclick="abrirMesa(${id_mesa})">Abrir Mesa</button>
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

            function atualizarNomes() {
                const clienteId = document.getElementById('cliente-select').value;
                const userID = document.getElementById('user-select').value;

                const clienteNome = clienteId ? clientes.find(c => c.id == clienteId)?.nome : 'Não selecionado';
                const userNome = userID ? atendentes.find(u => u.id == userID)?.nome : 'Não selecionado';

                const detailsDiv = document.getElementById('mesa-details');
                const rowElement = detailsDiv.querySelector('.row');

                if (rowElement) {
                    rowElement.innerHTML = `
                        <span>Pessoas na mesa: ${document.getElementById('num_pessoas').value}; </span>
                        <span>Cliente: ${clienteNome}; </span>
                        <span>Atendente: ${userNome}; </span>
                    `;
                } else {
                    console.warn('The .row element was not found.');
                }
            }

            function renderPedidoArea(id_mesa, data) {

                console.log('Dados recebidos em renderPedidoArea:', data);

                let id_pedido_atual = data.id;
                const detailsDiv = document.getElementById('mesa-details');
                console.log('Data received in renderPedidoArea:', data);

                const itensDePedido = data.itens_de_pedido || [];
                const valor_total_pedido = data.valor_total_pedido || 0;

                const clienteSelect = document.getElementById('cliente-select');
                const clienteId = clienteSelect ? clienteSelect.value : '';
                const cliente_desconto = clienteId ? clientes.find(c => c.id == clienteId)?.desconto : 0;
                const clienteNome = clienteId ? clientes.find(c => c.id == clienteId)?.nome : 'Não selecionado';

                const userSelect = document.getElementById('user-select');
                const userID = userSelect ? userSelect.value : '';
                const userNome = userID ? atendentes.find(u => u.id == userID)?.nome : 'Não selecionado';

                const quantidadeElement = document.getElementById('quantidade');
                const quantidade = quantidadeElement ? quantidadeElement.value : 1;

                const horarioAbertura = data.horario_abertura ? data.horario_abertura : 'Horário não disponível';

                let secaoDesconto = '';
                let produtosOptions = '<option value="">Selecione um produto</option>';
                produtos.forEach(produto => {
                    produtosOptions += `<option value="${produto.id}">${produto.nome}</option>`;
                });

                const pedidosHtml = itensDePedido.length > 0 ? itensDePedido.map(item => `
                    <tr>
                        <td>${item.quantidade}</td>
                        <td>${item.produto.nome}</td>
                        <td>R$${item.valor}</td>
                    </tr>
                `).join('') : '<tr><td colspan="3">Nenhum produto adicionado.</td></tr>';

                if (cliente_desconto > 0) {
                    const discountedTotal = (valor_total_pedido - (valor_total_pedido * (cliente_desconto / 100))).toFixed(2);
                    secaoDesconto = `
                        <tr>
                            <td>Desconto: ${cliente_desconto.toFixed(2)}%</td>
                            <td>Subtotal: R$${discountedTotal}</td>
                        </tr>
                    `;
                } else {
                    secaoDesconto = `<tr><td>Total: R$${valor_total_pedido.toFixed(2)}</td></tr>`;
                }

                detailsDiv.innerHTML = `
                    <h3>Mesa ${id_mesa}</h3>
                    <div class="row">
                        <span>Pessoas na mesa: ${data.num_pessoas}; </span>
                        <span>Cliente: ${clienteNome}; </span>
                        <span>Atendente: ${userNome}; </span>
                        <span>Horário de abertura: ${horarioAbertura}</span>
                    </div>
                    <div class="d-flex flex-column">
                        <div class="d-flex">
                            <p><strong>Produto:</strong></p>
                            <select class="form-control" name="produto" id="produto-select">
                                ${produtosOptions}
                            </select>
                            <input type="number" id="quantidade" value="1" min="1" max="12" style="width: 60px; margin-left: 10px;">
                            <button class="btn btn-success ml-2" onclick="adicionarProduto(${id_mesa}, ${id_pedido_atual})">Adicionar Produto</button>
                        </div>
                        <div>
                            <h4>Produtos Adicionados:</h4>
                            <table class="table">
                                <tbody id="itens-pedido-tbody">
                                    ${pedidosHtml}
                                    ${secaoDesconto}
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <button class="btn btn-primary mt-3" onclick="finalizarPedido(${id_mesa})">Finalizar Pedido</button>
                `;

                console.log('Dados recebidos em renderPedidoArea:', data);
            }

            function adicionarProduto(id_mesa, id_pedido_atual) {
                const produtoSelect = document.getElementById('produto-select');
                const quantidade = document.getElementById('quantidade').value;

                fetch(`/pedidos/${id_pedido_atual}`, { 
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            id_mesa: id_mesa,
                            id_produto: produtoSelect.value,
                            quantidade: quantidade,
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        console.log('Produto adicionado. Dados retornados:', data);
                        atualizarDadosPedido(id_mesa);
                    })
                    .catch(error => console.error('Erro ao adicionar produto:', error));
            }

            function atualizarDadosPedido(id_mesa) {
                fetch(`/pedido/detalhes/${id_mesa}`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log('Dados atualizados do pedido:', data);
                        renderPedidoArea(id_mesa, data);
                    })
                    .catch(error => console.error('Erro ao atualizar dados do pedido:', error));
            }


            function finalizarPedido(id_mesa) {
                fetch(`/pedidos/${id_pedido_atual}/finalizar`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            id_mesa
                        })
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Erro ao finalizar pedido.');
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log('Pedido finalizado com sucesso:', data);
                        location.reload();
                    })
                    .catch(error => console.error('Erro durante a requisição:', error));
            }

            function abrirMesa(id_mesa) {
                const numPessoas = document.getElementById('num_pessoas').value;
                const clienteId = document.getElementById('cliente-select').value;
                const userID = document.getElementById('user-select').value;
                const comentario = document.getElementById('comentario').value;

                fetch('/pedidos', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            id_mesa,
                            num_pessoas: numPessoas,
                            id_cliente: clienteId,
                            id_user: userID,
                            comentario
                        })
                    })
                    .then(response => {
                        if (!response.ok) throw new Error('Erro ao abrir mesa.');
                        return response.json();
                    })
                    .then(data => {
                        id_pedido_atual = data.id;
                        renderPedidoArea(id_mesa, data);
                    })
                    .catch(error => console.error('Erro durante a requisição:', error));
            }

            function hideAllComponents() {
                const detailsDiv = document.getElementById('mesa-details');
                detailsDiv.innerHTML = '<h6><-- Selecione uma mesa</h6>';
            }
        </script>
    @endsection
