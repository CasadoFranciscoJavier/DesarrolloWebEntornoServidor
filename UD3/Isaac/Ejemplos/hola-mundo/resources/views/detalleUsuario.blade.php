@extends('layout')

@section('titulo', 'Detalle Usuario')

@section('contenido')

    <h2>Detalle de usuario</h2>

    <p><b>Nombre: </b>{{ $usuario->nombre }}</p>
    <p><b>Email: </b>{{ $usuario->email }}</p>

@endsection