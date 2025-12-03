@extends('layout')

@section('titulo', 'Editar Usuario')

@section('contenido')

    <h1>Editar Usuario</h1>

    <form action="/usuario/{{ $usuario->id }}" method="POST">
        @csrf

        <label for="nombre">Nombre:</label>
        <input name="nombre" id="nombre" type="text" value="{{ $usuario->nombre }}" required>
        <br><br>

        <label for="email">Email:</label>
        <input name="email" id="email" type="email" value="{{ $usuario->email }}" required>
        <br><br>

        <button type="submit">Guardar Cambios</button>
    </form>

    <br>
    <a href="/usuarios">Volver a la lista</a>

@endsection
