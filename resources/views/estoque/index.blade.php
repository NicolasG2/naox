@extends('templates.header', ['menu' => 'admin', 'submenu' => 'Estoque'])

@section('titulo') Estoque @endsection

@section('conteudo')
    <link rel="stylesheet" href="{{ asset('../css/estoque/index.css') }}">

    <div class="row">
        <div class="col">
            <table class="tabela_estoque table align-middle caption-top table-striped">
                <caption>Tabela de <b>Produtos</b></caption>
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">NOME PRODUTO</th>
                        <th scope="col">QUANTIDADE PRODUTO</th>
                        <th scope="col">AÇÕES</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($produtos as $produto)
                        <tr>
                            <td>{{ $produto->id }}</td>
                            <td>{{ $produto->nome }}</td>
                            <td>{{ $produto->quantidade }}</td>
                            <td>
                                <button class="btn btn-success btn-primary"
                                    onclick="showEditModal('produto', {{ $produto->id }}, {{ json_encode($produto) }})">
                                    Editar
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="col">
            <table class="tabela_estoque table align-middle caption-top table-striped">
                <caption>Tabela de <b>Ingredientes</b></caption>
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">NOME INGREDIENTE</th>
                        <th scope="col">QUANTIDADE INGREDIENTE</th>
                        <th scope="col">AÇÕES</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($ingredientes as $ingrediente)
                        <tr>
                            <td>{{ $ingrediente->id }}</td>
                            <td>{{ $ingrediente->nome }}</td>
                            <td>{{ $ingrediente->quantidade }}</td>
                            <td>
                                <button class="btn btn-success btn-primary"
                                    onclick="showEditModal('ingrediente', {{ $ingrediente->id }}, {{ json_encode($ingrediente) }})">
                                    Editar
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal de Edição -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Editar Item</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editForm" method="POST" action="{{ route('estoque.update') }}">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="type" id="editType">
                        <input type="hidden" name="id" id="editId">
                        <div class="form-group">
                            <label for="editNome">Nome</label>
                            <input type="text" class="form-control" id="editNome" name="nome" required>
                        </div>
                        <div class="form-group">
                            <label for="editQuantidade">Quantidade</label>
                            <input type="number" class="form-control" id="editQuantidade" name="quantidade" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Salvar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showEditModal(type, id, item) {
            document.getElementById('editType').value = type;
            document.getElementById('editId').value = id;
            document.getElementById('editNome').value = item.nome;
            document.getElementById('editQuantidade').value = item.quantidade;

            let formAction = `{{ url('estoque') }}/${id}`;
            document.getElementById('editForm').action = formAction;

            $('#editModal').modal('show');
        }
    </script>
@endsection
