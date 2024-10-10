@extends('templates.header', ['menu' => 'admin'])

@section('titulo') Configurações @endsection

@section('conteudo')

<ul>
    <li>
        <a href="{{ route('mesas.index') }}">
            <i class="material-icons">next_week</i>
            <i class="material-icons">settings</i>
        </a>
    </li>
</ul>

@endsection