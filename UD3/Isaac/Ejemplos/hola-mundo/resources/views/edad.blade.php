@extends('layout')

@section('titulo', 'Ver edad!')

@section('contenido')

    @if($edad < 18)
        <x-h1 color="red">No puedes votar!</x-h1>
    @else
        <x-h1>Tampoco puedes votar!</x-h1>
    @endif

@endsection