@extends('layout')

@section('titulo', 'Detalle de Usuario')

@section('contenido')

    <h1>Usuario Registrado Correctamente</h1>

    <p><strong>ID:</strong> {{ $usuario->id }}</p>
    <p><strong>Nombre:</strong> {{ $usuario->nombre }}</p>
    <p><strong>Email:</strong> {{ $usuario->email }}</p>

    <br>
    <a href="/nuevo_usuario">Registrar otro usuario</a>
    <br>
    <a href="/usuarios">Ver lista de usuarios</a>

@endsection
