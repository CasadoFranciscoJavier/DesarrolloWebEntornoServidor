@extends('layout')

@section('titulo', 'Lista de Números')

@section('contenido')
    <h2>Lista de números del 1 al {{ $size }}</h2>
    <ul>
        @foreach($numeros as $numero)
            <li>{{ $numero }}</li>
        @endforeach
    </ul>
@endsection
