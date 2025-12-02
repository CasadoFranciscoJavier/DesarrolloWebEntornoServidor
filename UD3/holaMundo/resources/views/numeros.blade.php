@extends('layout')

@section('titulo', 'mostrar números')

@section('contenido')
<h2>Lista de némeros de 1 al {{ $size }}</h2>
<ul>
    @foreach($numeros as $numero)
        <li>{{ $numero}}</li>
    @endforeach
</ul>
@endsection