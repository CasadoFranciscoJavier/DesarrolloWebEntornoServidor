@extends('layout')


@section('titulo', 'Hola mundo')

@section('contenido')
    <h1>Bienvenido a mi página de inicio</h1>
    <p>Esta es la primera página de mi aplicación Laravel.</p>
    <x-color color="red">
    Eres menor 
</x-color>

@endsection