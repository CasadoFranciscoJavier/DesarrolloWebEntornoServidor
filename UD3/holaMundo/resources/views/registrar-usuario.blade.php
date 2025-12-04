@extends('layout')

@section('titulo', 'Registrar Usuario')

@section('contenido')

    <h1>Registrar Nuevo Usuario</h1>

    @if ($errors->any())
        <h3>Errores</h3>
        <ol>
            @foreach ($errors->all() as $mensajeError)
                <li>{{ $mensajeError }} </li>
            @endforeach
        </ol>
    @endif

    <form method="POST" action="/usuario">
        @csrf
        <label>Nombre: <input type="text" name="nombre"></label><br>
        <label>Email: <input type="text" name="email"></label><br>

        <input type="submit">
    </form>
@endsection