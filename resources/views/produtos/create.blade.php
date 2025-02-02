@php $checked = true; @endphp

@extends('templates.header', ['menu' => 'admin', 'submenu' => 'Novo Produto'])

@section('titulo') Produtos @endsection

@section('conteudo')
    <link rel="stylesheet" href="{{ asset('../css/produto/create.css') }}">

    <form action="{{ route('produtos.store') }}" method="POST" enctype="multipart/form-data">
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
                    <input type="number" class="form-control @if ($errors->has('preco')) is-invalid @endif"
                        min="0" name="preco" placeholder="Preço" value="{{ old('preco') }}" />
                    <label for="preco">Preço</label>
                    @if ($errors->has('preco'))
                        <div class='invalid-feedback'>
                            {{ $errors->first('preco') }}
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
                    <input type="hidden" name="ativo" value="1">
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
                <div class="form-floating mb-3">
                    <input type="text" class="form-control @if ($errors->has('descricao')) is-invalid @endif"
                        name="descricao" placeholder="Descrição" value="{{ old('descricao') }}" />
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
                    <input type="number" class="form-control @if ($errors->has('quantidade')) is-invalid @endif"
                        min="0" name="quantidade" placeholder="Quantidade" value="{{ old('quantidade') }}" />
                    <label for="quantidade">Quantidade</label>
                    @if ($errors->has('quantidade'))
                        <div class='invalid-feedback'>
                            {{ $errors->first('quantidade') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="form-floating mb-3">
                    <input type="number" class="form-control @if ($errors->has('custo')) is-invalid @endif"
                        min="0" name="custo" placeholder="Custo" value="{{ old('custo') }}" />
                    <label for="custo">Custo</label>
                    @if ($errors->has('custo'))
                        <div class='invalid-feedback'>
                            {{ $errors->first('custo') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <label for="ingrediente">Ingredientes</label>
                <div class="form mb-3">
                    @foreach ($ingredientes as $item)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="ingrediente[]"
                                id="ingrediente_{{ $item->id }}" value="{{ $item->id }}">
                            <label class="form-check-label" for="ingrediente_{{ $item->id }}">
                                {{ $item->nome }}
                            </label>
                        </div>
                    @endforeach
                    @if ($errors->has('ingrediente'))
                        <div class='invalid-feedback'>
                            {{ $errors->first('ingrediente') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <label for="categoria">Categoria</label>
                <div class="form mb-3">
                    <select class="form-control @if ($errors->has('categoria')) is-invalid @endif" name="categoria"
                        placeholder="Categoria">{{ old('categoria') }}
                        <option value="">Selecione uma categoria</option>
                        @foreach ($categorias as $item)
                            <option value="{{ $item->id }}">{{ $item->nome }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('categoria'))
                        <div class='invalid-feedback'>
                            {{ $errors->first('categoria') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <label for="fornecedor">Fornecedor</label>
                <div class="form mb-3">
                    <select class="form-control @if ($errors->has('fornecedor')) is-invalid @endif" name="fornecedor"
                        placeholder="Fornecedor">{{ old('fornecedor') }}
                        <option value="">Selecione um fornecedor</option>
                        @foreach ($fornecedores as $item)
                            <option value="{{ $item->id }}">{{ $item->nome }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('fornecedor'))
                        <div class='invalid-feedback'>
                            {{ $errors->first('fornecedor') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <a href="{{ route('produtos.index') }}"
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