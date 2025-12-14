@extends('layouts.app')
@section('title', 'Añadir Juego')
@section('content')

@php
    $fotoDefault = 'https://ui-avatars.com/api/?name=Nuevo+Autor&background=random&size=256';
@endphp

<div class="container">
    <h1>Añadir juego para {{ $compania->nombre }}</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <h3>Errores</h3>
            <ol>
                @foreach ($errors->all() as $mensajeError)
                    <li>{{ $mensajeError }}</li>
                @endforeach
            </ol>
        </div>
    @endif

    <form method="POST" action="/juego">
        @csrf

        <input type="hidden" name="compania_id" value="{{ $compania->id }}">

        <div class="mb-3">
            <label for="titulo" class="form-label">Título:</label>
            <input type="text" class="form-control" id="titulo" name="titulo" value="{{ old('titulo') }}">
        </div>

        <div class="mb-3">
            <label for="cover_url" class="form-label">Cover URL:</label>
            <input type="text" class="form-control" id="cover_url" name="cover_url" value="{{ old('cover_url') }}" oninput="document.getElementById('foto').src = this.value ">
            <img id="foto" src="{{ old('cover_url') ?: $fotoDefault }}" style="max-width: 200px; margin-top: 10px;">
        </div>

        <div class="mb-3">
            <label for="anio" class="form-label">Año de lanzamiento:</label>
            <input type="number" class="form-control" id="anio" name="anio" value="{{ old('anio') }}" min="1000" max="{{ date('Y') + 10 }}">
        </div>

        <div class="mb-3">
            <label for="genero" class="form-label">Género:</label>
            <select class="form-select" id="genero" name="genero">
                <option value="">-- Selecciona un genero --</option>
                @foreach($generos as $genero)
                    <option value="{{ $genero }}" {{ old('genero') == $genero ? 'selected' : '' }}>
                        {{ $genero }}
                    </option>
                @endforeach
            </select>
        </div>    

        <button type="submit" class="btn btn-primary">Añadir Juego</button>
        <a href="/compania/detalle/{{ $compania->id }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
