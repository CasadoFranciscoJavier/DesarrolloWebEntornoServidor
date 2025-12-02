@extends('layout')

@section('titulo', 'edad comprobador')

@section('contenido')
@if($edad >= 18)
<p>Bienvenido.</p>
@else
<x-color color="red">
    eres menor
</x-color>
@endif

@endsection