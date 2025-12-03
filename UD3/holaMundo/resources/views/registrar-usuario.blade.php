
@extends('layout')

@section('titulo', 'mostrar números')

@section('contenido')

    <h1>Mi Primerito formulario</h1>
    
    <form action="miPrimeritoFormulario.php" method="GET">
        <label for="nombre">Nombre</label>
        <input name="nombre" id="nombre" type="test">

        <label for="email">Email</label>
        <input name="email" id="email" type="email">

        <input type="submit">

    </form>
@endsection