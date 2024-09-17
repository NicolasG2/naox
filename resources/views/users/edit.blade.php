@extends('templates.header', ['menu' => 'admin', 'submenu' => 'Alterar Usuário', 'rota' => 'users.create'])

@section('titulo') Usuários @endsection

@section('conteudo')
    <link rel="stylesheet" href="{{ asset('../css/user/edit.css') }}">

    <form action="{{ route('users.update', $users->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col">
                <div class="form-floating mb-3">
                    <select class="form-control @if ($errors->has('tipo_acesso')) is-invalid @endif" name="tipo_acesso">
                        <option value="" selected disabled>Selecione o cargo</option>
                        <option value="Funcionário" {{ $users->tipo_acesso == 'Funcionário' ? 'selected' : '' }}>Funcionário</option>
                        <option value="Gerente" {{ $users->tipo_acesso == 'Gerente' ? 'selected' : '' }}>Gerente</option>
                        <option value="Dono" {{ $users->tipo_acesso == 'Dono' ? 'selected' : '' }}>Dono</option>
                    </select>
                    <label for="tipo_acesso">Cargo</label>
                    @if ($errors->has('tipo_acesso'))
                        <div class='invalid-feedback'>
                            {{ $errors->first('tipo_acesso') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col">
            <div class="form-floating mb-3">
                <input type="email" class="form-control @if ($errors->has('email')) is-invalid @endif"
                    name="email" placeholder="E-mail" value="{{ $users->email }}" />
                <label for="email">E-mail</label>
                @if ($errors->has('email'))
                    <div class='invalid-feedback'>
                        {{ $errors->first('email') }}
                    </div>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="form-floating mb-3">
                    <input type="tel" inputmode="numeric" autocomplete="tel" maxlength="14"
                        placeholder="(99) 99999-9999" name="telefone" id="telefone" oninput="formatarTelefone(this.value)"
                        value="{{ $users->relefone }}" />
                    <label for="telefone">Telefone</label>
                    @if ($errors->has('telefone'))
                        <div class='invalid-feedback'>
                            {{ $errors->first('telefone') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="form-floating mb-3">
                    <div class="form-check">
                        <input type="checkbox" id="ativo" name="ativo" {{ $users->ativo ? 'checked' : '' }}
                            value="1">
                        <label for="ativo">Ativo</label>
                    </div>
                    @if ($errors->has('ativo'))
                        <div class='invalid-feedback'>
                            {{ $errors->first('ativo') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="row">
            <div class="col">
                <a href="{{ route('users.index') }}" class="btn-voltar btn btn-secondary btn-block align-content-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                        class="bi bi-arrow-left-square-fill" viewBox="0 0 16 16">
                        <path
                            d="M16 14a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12zm-4.5-6.5H5.707l2.147-2.146a.5.5 0 1 0-.708-.708l-3 3a.5.5 0 0 0 0 .708l3 3a.5.5 0 0 0 .708-.708L5.707 8.5H11.5a.5.5 0 0 0 0-1z" />
                    </svg>
                    &nbsp; Voltar
                </a>
                <a href="javascript:document.querySelector('form').submit();"
                    class="btn-confirm btn btn-success btn-block align-content-center">
                    Confirmar &nbsp;
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                        class="bi bi-check-circle-fill" viewBox="0 0 16 16">
                        <path
                            d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                    </svg>
                </a>
            </div>
        </div>
    @endsection
