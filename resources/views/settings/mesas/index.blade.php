@extends('templates.header', ['menu' => 'admin'])

@section('conteudo')
    <link rel="stylesheet" href="{{ asset('../css/mesas/index.css') }}">

    <div class="container">
        <h2 class="my-4">Administração de Mesas</h2>
        <div class="row">
            <div class="col-md-8">
                <h4 class="mb-3">Mesas Possíveis</h4>
                <div class="grid-container" id="grid-container">
                    @foreach ($mesas as $mesa)
                        @php
                            $sizeClass = '';
                            if ($mesa->tamanho == 'Pequena') {
                                $sizeClass = 'grid-size-70';
                            } elseif ($mesa->tamanho == 'Média') {
                                $sizeClass = 'grid-size-80';
                            } elseif ($mesa->tamanho == 'Grande') {
                                $sizeClass = 'grid-size-90';
                            }
                        @endphp
                        <div class="grid-item {{ $sizeClass }}" id="mesa-{{ $mesa->id }}"
                            data-mesa-id="{{ $mesa->id }}" data-mesa-numero="{{ $mesa->numero }}"
                            onclick="showMesaDetails({{ $mesa->id }}, {{ json_encode($mesa) }})">
                            {{ $mesa->numero }}
                        </div>
                    @endforeach
                    @for ($i = $mesas->count() + 1; $i <= 60; $i++)
                        <div class="grid-item empty border rounded" id="empty-{{ $i }}"
                            onclick="showCreateModal({{ $i }})">
                            +
                        </div>
                    @endfor
                </div>
            </div>
            <div class="col-md-4 border rounded">
                <h4 class="mb-3">Detalhes da Mesa</h4>
                <div id="mesa-details"></div>
            </div>
        </div>
    </div>

    <div id="createMesaMessage" class="confirmation-modal">
        <p id="createMesaText"></p>
        <button onclick="createMesa()">Sim</button>
        <button onclick="hideCreateMesaMessage()">Não</button>
    </div>

    <div id="deleteMesaMessage" class="confirmation-modal">
        <p id="deleteMesaText"></p>
        <button onclick="confirmDeleteMesa()">Sim</button>
        <button onclick="hideDeleteMesaMessage()">Não</button>
    </div>

    <script>
        let mesaNumeroGlobal;
        let id_mesa_global;

        let proximoNumeroMesa = 1;
        let posicoesVazias = [];

        function showCreateModal() {
            if (posicoesVazias.length > 0) {
                const posicao = posicoesVazias.shift();
                mesaNumeroGlobal = posicao;
                document.getElementById('createMesaText').innerText =
                    `Deseja criar mesa de número ${posicao}?`;
                document.getElementById('createMesaMessage').style.display = 'block';
            } else {
                const proximaPosicao = proximoNumeroMesa;
                proximoNumeroMesa++;
                mesaNumeroGlobal = proximaPosicao;
                document.getElementById('createMesaText').innerText =
                    `Deseja criar mesa de número ${proximaPosicao}?`;
                document.getElementById('createMesaMessage').style.display = 'block';
            }
        }

        function hideCreateMesaMessage() {
            document.getElementById('createMesaMessage').style.display = 'none';
        }

        function showDeleteMesaModal(id_mesa, mesaNumero) {
            id_mesa_global = id_mesa;
            document.getElementById('deleteMesaText').innerText = `Deseja excluir a mesa de número ${mesaNumero}?`;
            document.getElementById('deleteMesaMessage').style.display = 'block';
        }

        function hideDeleteMesaMessage() {
            document.getElementById('deleteMesaMessage').style.display = 'none';
        }

        function confirmDeleteMesa() {
            fetch(`/settings/mesas/${id_mesa_global}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const mesaDiv = document.querySelector(`.grid-item[data-mesa-id='${id_mesa_global}']`);
                        mesaDiv.classList.add('empty');
                        mesaDiv.textContent = '+';
                        mesaDiv.setAttribute('onclick', `showCreateModal()`);
                        mesaDiv.removeAttribute('data-mesa-id');
                        mesaDiv.removeAttribute('data-mesa-numero');
                        document.getElementById('mesa-details').innerHTML = '';
                        alert('Mesa excluída com sucesso!');
                        posicoesVazias.push(parseInt(mesaDiv.id.split('-')[1]));
                        hideDeleteMesaMessage();
                    } else {
                        alert('Erro ao excluir mesa.');
                    }
                })
                .catch(error => console.error('Error:', error));
        }

        function createMesa() {
            const capacidade = 4;
            const formato = "Quadrada";
            const tamanho = "Média";

            const emptyDiv = document.querySelector(`.grid-item.empty[id='empty-${mesaNumeroGlobal}']`);

            if (emptyDiv) {
                fetch('{{ route('mesas.store') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            numero: mesaNumeroGlobal,
                            capacidade: capacidade,
                            formato: formato,
                            tamanho: tamanho,
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            emptyDiv.classList.remove('empty');
                            emptyDiv.setAttribute('id', `mesa-${data.mesa.id}`);
                            emptyDiv.setAttribute('data-mesa-id', data.mesa.id);
                            emptyDiv.setAttribute('data-mesa-numero', mesaNumeroGlobal);
                            emptyDiv.textContent = data.mesa.numero;
                            emptyDiv.setAttribute('onclick',
                                `showMesaDetails(${data.mesa.id}, ${JSON.stringify(data.mesa)})`);

                            hideCreateMesaMessage();
                        } else {
                            alert('Erro ao criar mesa.');
                        }
                    })
                    .catch(error => console.error('Error:', error));
            } else {
                alert('Não há espaço vazio disponível nessa posição.');
            }
        }

        function showMesaDetails(id_mesa, mesa) {
            id_mesa_global = id_mesa;
            const detailsDiv = document.getElementById('mesa-details');
            detailsDiv.innerHTML = `
                <p><strong>Número:</strong> ${mesa.numero}</p>
                <p><strong>Capacidade:</strong> ${mesa.capacidade}</p>
                <p><strong>Formato:</strong> ${mesa.formato}</p>
                <p><strong>Tamanho:</strong> ${mesa.tamanho}</p>
                <button class="btn btn-secondary" onclick="showEditMesaModal(${id_mesa}, ${JSON.stringify(mesa)})">Editar mesa</button>
                <button class="btn btn-danger" onclick="showDeleteMesaModal(${id_mesa}, ${mesa.numero})">Excluir mesa</button>
            `;
        }

        function showEditMesaModal(id_mesa, mesa) {
            const detailsDiv = document.getElementById('mesa-details');
            detailsDiv.innerHTML = `
                <div>
                    <p>Editar mesa de número ${mesa.numero}</p>
                    <form id="editMesaForm">
                        <label for="numero">Número:</label>
                        <input type="number" id="editNumero" name="numero" value="${mesa.numero}" required>
                        <label for="capacidade">Capacidade:</label>
                        <input type="number" id="editCapacidade" name="capacidade" value="${mesa.capacidade}" required>
                        <label for="formato">Formato:</label>
                        <input type="text" id="editFormato" name="formato" value="${mesa.formato}" required>
                        <label for="tamanho">Tamanho:</label>
                        <input type="text" id="editTamanho" name="tamanho" value="${mesa.tamanho}" required>
                        <button type="button" onclick="editMesa(${id_mesa})">Salvar</button>
                        <button type="button" onclick="hideEditMesaModal()">Cancelar</button>
                    </form>
                </div>
            `;
        }

        function hideEditMesaModal() {
            document.getElementById('mesa-details').innerHTML = '';
        }

        function editMesa(id_mesa) {
            const formData = new FormData(document.getElementById('editMesaForm'));
            const newData = {};
            formData.forEach((value, key) => {
                newData[key] = value;
            });
            fetch(`/settings/mesas/${id_mesa}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify(newData)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const mesaDiv = document.querySelector(`.grid-item[data-mesa-id='${id_mesa}']`);
                        mesaDiv.textContent = data.mesa.numero;
                        mesaDiv.setAttribute('data-mesa-numero', data.mesa.numero);

                        const detailsDiv = document.getElementById('mesa-details');
                        detailsDiv.innerHTML = `
                            <p><strong>Número:</strong> ${data.mesa.numero}</p>
                            <p><strong>Capacidade:</strong> ${data.mesa.capacidade}</p>
                            <p><strong>Formato:</strong> ${data.mesa.formato}</p>
                            <p><strong>Tamanho:</strong> ${data.mesa.tamanho}</p>
                            <button class="btn btn-secondary" onclick="showEditMesaModal(${id_mesa}, ${JSON.stringify(data.mesa)})">Editar mesa</button>
                            <button class="btn btn-danger" onclick="showDeleteMesaModal(${id_mesa}, ${data.mesa.numero})">Excluir mesa</button>
                        `;
                        hideEditMesaModal();
                        alert('Mesa atualizada com sucesso!');
                    } else {
                        alert('Erro ao atualizar mesa.');
                    }
                })
                .catch(error => console.error('Error:', error));
        }
    </script>
@endsection
