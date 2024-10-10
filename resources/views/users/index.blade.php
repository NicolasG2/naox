@extends('templates.header', ['menu' => 'admin', 'submenu' => 'Usuário', 'rota' => 'users.create'])

@section('titulo') Usuários @endsection

@section('conteudo')
<link rel="stylesheet" href="{{asset('../css/user/index.css')}}">

    <div class="row">
        <div class="col">
            <table class="tabela_user table align-middle caption-top table-striped">
                <caption>Tabela de <b>Usuários</b></caption>
                <thead>
                    <tr>
                        <th scope="col">USUÁRIO</th>
                        <th scope="col">NOME</th>
                        <!--<th scope="col">SENHA</th>-->
                        <th scope="col">TIPO DE ACESSO</th>
                        <th scope="col">E-MAIL</th>
                        <th scope="col">TELEFONE</th>
                        <th scope="col">ATIVO</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $item)
                        <tr>
                            <td>{{ $item->usuario }}</td>
                            <td>{{ $item->nome }}</td>
                            <!--<td>{{ $item->password }}</td>-->
                            <td>{{ $item->tipo_acesso }}</td>
                            <td>{{ $item->email }}</td>
                            <td>{{ $item->telefone }}</td>
                            @if($item->ativo == 1)
                                <td>Sim</td>
                            @endif
                            @if($item->ativo == 0)
                                <td>Não</td>
                            @endif
                            <td>
                                <a href="{{ route('users.edit', $item->id) }}" class="btn-edit btn">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#FFF" class="bi bi-arrow-counterclockwise" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M8 3a5 5 0 1 1-4.546 2.914.5.5 0 0 0-.908-.417A6 6 0 1 0 8 2v1z" />
                                        <path d="M8 4.466V.534a.25.25 0 0 0-.41-.192L5.23 2.308a.25.25 0 0 0 0 .384l2.36 1.966A.25.25 0 0 0 8 4.466z" />
                                    </svg>
                                    </a>
                                </a>
                                <a nohref style="cursor:pointer" onclick="showRemoveModal('{{ $item->id }}')" class="btn-delete btn btn-danger">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#FFF" class="bi bi-trash-fill" viewBox="0 0 16 16">
                                        <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z" />
                                    </svg>
                                </a>
                            </td>
                            <form action="{{ route('users.destroy', $item->id) }}" method="POST"
                                id="form_{{ $item->id }}">
                                @csrf
                                @method('DELETE')
                            </form>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
