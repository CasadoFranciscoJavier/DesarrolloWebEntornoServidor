@extends('layout')

@section('titulo', 'Hola Mundo!')

@section('contenido')
    <h1>Hola, {{ $nombre }}!</h1>
    <p>Bienvenido a nuestra aplicación de ejemplo construida en Laravel.</p>
@endsection