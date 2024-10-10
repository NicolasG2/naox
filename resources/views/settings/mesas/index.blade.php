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
                        <div class="grid-item" id="mesa-{{ $mesa->id }}" data-mesa-id="{{ $mesa->id }}"
                            data-mesa-numero="{{ $mesa->numero }}"
                            onclick="showMesaDetails({{ $mesa->id }}, {{ json_encode($mesa) }})">
                            {{ $mesa->numero }}
                        </div>
                    @endforeach
                    @for ($i = $mesas->count() + 1; $i <= 60; $i++)
                        <div class="grid-item empty border rounded" id="empty-{{ $i }}"
                            onclick="showCreateModal()">
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
        <h4>Criar Mesa</h4>
        <label for="mesaNumeroInput">Número da Mesa (1-150):</label>
        <input type="number" id="mesaNumeroInput" min="1" max="150" required>

        <label for="mesaCapacidadeInput">Capacidade (2-16):</label>
        <input type="number" id="mesaCapacidadeInput" min="2" max="16" required>

        <button onclick="createMesa()">Criar Mesa</button>
        <button onclick="hideCreateMesaMessage()">Cancelar</button>
    </div>

    <div id="editMesaMessage" class="confirmation-modal" style="display: none;">
        <h4>Editar Mesa</h4>
        <label for="editMesaNumeroInput">Número da Mesa (1-150):</label>
        <input type="number" id="editMesaNumeroInput" min="1" max="150" required>

        <label for="editMesaCapacidadeInput">Capacidade (2-16):</label>
        <input type="number" id="editMesaCapacidadeInput" min="2" max="16" required>

        <label for="editMesaFormatoSelect">Formato:</label>
        <select id="editMesaFormatoSelect" required>
            <option value="Quadrada">Quadrada</option>
            <option value="Retangular">Retangular</option>
            <option value="Redonda">Redonda</option>
        </select>

        <button onclick="confirmEditMesa()">Salvar Alterações</button>
        <button onclick="hideEditMesaModal()">Cancelar</button>
    </div>


    <div id="deleteMesaMessage" class="confirmation-modal">
        <p id="deleteMesaText"></p>
        <button onclick="confirmDeleteMesa()">Sim</button>
        <button onclick="hideDeleteMesaMessage()">Não</button>
    </div>

    <script>
        let mesaNumeroGlobal;
        let id_mesa_global;

        function showCreateModal() {
            document.getElementById('createMesaMessage').style.display = 'block';
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
                        hideDeleteMesaMessage();
                    } else {
                        alert('Erro ao excluir mesa.');
                    }
                })
                .catch(error => console.error('Error:', error));
        }

        function createMesa() {
            const mesaNumeroInput = document.getElementById('mesaNumeroInput').value;
            const mesaCapacidadeInput = document.getElementById('mesaCapacidadeInput').value;

            fetch(`/settings/mesas/check-number/${mesaNumeroInput}`)
                .then(response => response.json())
                .then(data => {
                    if (!data.available) {
                        alert('Número da mesa já está em uso. Por favor, escolha outro número.');
                        return;
                    }

                    fetch('{{ route('mesas.store') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                numero: mesaNumeroInput,
                                capacidade: mesaCapacidadeInput,
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                const emptyDiv = document.querySelector(`.grid-item.empty`);
                                emptyDiv.classList.remove('empty');
                                emptyDiv.setAttribute('id', `mesa-${data.mesa.id}`);
                                emptyDiv.setAttribute('data-mesa-id', data.mesa.id);
                                emptyDiv.setAttribute('data-mesa-numero', mesaNumeroInput);
                                emptyDiv.textContent = data.mesa.numero;
                                emptyDiv.setAttribute('onclick',
                                    `showMesaDetails(${data.mesa.id}, ${JSON.stringify(data.mesa)})`);

                                hideCreateMesaMessage();
                            } else {
                                alert('Erro ao criar mesa.');
                            }
                        })
                        .catch(error => console.error('Error:', error));
                })
                .catch(error => console.error('Error:', error));
        }

        function showMesaDetails(id_mesa, mesa) {
            id_mesa_global = id_mesa;
            const detailsDiv = document.getElementById('mesa-details');
            detailsDiv.innerHTML = `
                <p><strong>Número:</strong> ${mesa.numero}</p>
                <p><strong>Capacidade:</strong> ${mesa.capacidade}</p>
                <button class="btn btn-secondary" onclick="showEditMesaModal(${id_mesa}, ${JSON.stringify(mesa)})">Editar mesa</button>
                <button class="btn btn-danger" onclick="showDeleteMesaModal(${id_mesa}, ${mesa.numero})">Excluir mesa</button>
            `;
        }

        function showEditMesaModal(id_mesa, mesa) {
            id_mesa_global = id_mesa;

            document.getElementById('editMesaNumeroInput').value = mesa.numero;
            document.getElementById('editMesaCapacidadeInput').value = mesa.capacidade;
            document.getElementById('editMesaFormatoSelect').value = mesa.formato;

            document.getElementById('editMesaMessage').style.display = 'block';
        }

        function hideEditMesaModal() {
            document.getElementById('editMesaMessage').style.display = 'none';
        }

        function confirmEditMesa() {
            const mesaNumeroInput = document.getElementById('editMesaNumeroInput').value;
            const mesaCapacidadeInput = document.getElementById('editMesaCapacidadeInput').value;
            const mesaFormatoInput = document.getElementById('editMesaFormatoSelect').value;

            fetch(`/settings/mesas/check-number/${mesaNumeroInput}`)
                .then(response => response.json())
                .then(data => {
                    if (!data.available) {
                        alert('Número da mesa já está em uso. Por favor, escolha outro número.');
                        return;
                    }

                    fetch(`/settings/mesas/${id_mesa_global}`, {
                            method: 'PUT',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                numero: mesaNumeroInput,
                                capacidade: mesaCapacidadeInput,
                                formato: mesaFormatoInput,
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                const mesaDiv = document.getElementById(`mesa-${id_mesa_global}`);
                                mesaDiv.setAttribute('data-mesa-numero', mesaNumeroInput);
                                mesaDiv.textContent = mesaNumeroInput;
                                mesaDiv.setAttribute('onclick',
                                    `showMesaDetails(${id_mesa_global}, ${JSON.stringify(data.mesa)})`);

                                showMesaDetails(id_mesa_global, data.mesa);

                                alert('Mesa editada com sucesso!');
                                hideEditMesaModal();
                            } else {
                                alert('Erro ao editar mesa.');
                            }
                        })
                        .catch(error => console.error('Error:', error));
                })
                .catch(error => console.error('Error:', error));
        }
    </script>
@endsection