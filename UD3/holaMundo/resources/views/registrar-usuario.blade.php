@extends('layout')

@section('titulo', 'Registrar Usuario')

@section('contenido')

    <h1>Registrar Nuevo Usuario</h1>

    <form action="/usuario" method="POST">
        @csrf

        <label for="nombre">Nombre:</label>
        <input name="nombre" id="nombre" type="text" required>
        <br><br>

        <label for="email">Email:</label>
        <input name="email" id="email" type="email" required>
        <br><br>

        <button type="submit">Registrar Usuario</button>
    </form>

@endsection