@php $checked = true; @endphp

@extends('templates.header', ['menu' => 'admin', 'submenu' => 'Novo Fornecedor'])

@section('titulo') Desenvolvimento Web @endsection

@section('conteudo')
    <link rel="stylesheet" href="{{ asset('../css/fornecedor/create.css') }}">

    <form action="{{ route('fornecedores.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control @if ($errors->has('nome')) is-invalid @endif"
                        name="nome" placeholder="Nome" value="{{ old('nome') }}" />
                    <label for="nome">Nome</label>
                    @if ($errors->has('nome'))
                        <div class='invalid-feedback'>
                            {{ $errors->first('nome') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="form-floating mb-3">
                    <input type="text" inputmode="numeric" autocomplete="cc-number" name="documento" id="documento" placeholder="CPF ou CNPJ"
                        oninput="formatarDocumento(this.value)" value="{{ old('documento') }}" />
                    <label for="documento">Documento</label>
                    @if ($errors->has('documento'))
                        <div class='invalid-feedback'>
                            {{ $errors->first('documento') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="form-floating mb-3">
                    <input type="tel" inputmode="numeric" autocomplete="tel" maxlength="14"
                        placeholder="(99) 99999-9999" name="telefone" id="telefone" oninput="formatarTelefone(this.value)"
                        value="{{ old('telefone') }}" />
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
                    <textarea type="text" class="form-control @if ($errors->has('descricao')) is-invalid @endif" name="descricao"
                        placeholder="Descrição" style="min-height: 100px">{{ old('descricao') }}</textarea>
                    <label for="descricao">Descrição</label>
                    @if ($errors->has('descricao'))
                        <div class='invalid-feedback'>
                            {{ $errors->first('descricao') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="form-floating mb-3">
                    <input type="email" class="form-control @if ($errors->has('email')) is-invalid @endif"
                        name="email" placeholder="E-mail" value="{{ old('email') }}" />
                    <label for="email">E-mail</label>
                    @if ($errors->has('email'))
                        <div class='invalid-feedback'>
                            {{ $errors->first('email') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control @if ($errors->has('endereco')) is-invalid @endif"
                        name="endereco" placeholder="Endereço" value="{{ old('endereco') }}" />
                    <label for="endereco">Endereço</label>
                    @if ($errors->has('endereco'))
                        <div class='invalid-feedback'>
                            {{ $errors->first('endereco') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="form-floating mb-3">
                    <div class="form-check">
                        <input type="checkbox" id="ativo" name="ativo"
                            @if ($checked) checked @endif value="1">
                        <label for="ativo">Ativo</label>
                    </div>
                    <input type="hidden" name="ativo" value="0">
                    @if ($errors->has('ativo'))
                        <div class='invalid-feedback'>
                            {{ $errors->first('ativo') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <a href="{{ route('fornecedores.index') }}"
                    class="btn-voltar btn btn-secondary btn-block align-content-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                        class="bi bi-arrow-left-square-fill" viewBox="0 0 16 16">
                        <path
                            d="M16 14a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12zm-4.5-6.5H5.707l2.147-2.146a.5.5 0 1 0-.708-.708l-3 3a.5.5 0 0 0 0 .708l3 3a.5.5 0 0 0 .708-.708L5.707 8.5H11.5a.5.5 0 0 0 0-1z" />
                    </svg>
                    &nbsp; Voltar
                </a>
                <button type="submit" class="btn-confirm btn btn-block align-content-center">
                    Confirmar &nbsp;
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                        class="bi bi-check-circle-fill" viewBox="0 0 16 16">
                        <path
                            d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                    </svg>
                </button>
            </div>
        </div>
    </form>
@endsection
