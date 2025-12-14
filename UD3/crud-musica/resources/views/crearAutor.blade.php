@extends('layouts.app')
@section('title', 'Autores - CRUD Música')
@section('content')

@php
    $fotoDefault = 'https://ui-avatars.com/api/?name=Nuevo+Autor&background=random&size=256';
@endphp

<div class="container">
    <h1>Registrar Autor</h1>

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

    <form method="POST" action="/autor">
        @csrf

        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre:</label>
            <input type="text" class="form-control" id="nombre" name="nombre" value="{{ old('nombre') }}">
        </div>

        <div class="mb-3">
            <label for="foto_url" class="form-label">Foto URL (opcional):</label>
            <input type="text" class="form-control" id="foto_url" name="foto_url" value="{{ old('foto_url') }}" oninput="document.getElementById('foto').src = this.value ">
            <img id="foto" src="{{ old('foto_url') ?: $fotoDefault }}" style="max-width: 200px; margin-top: 10px;">
        </div>

        <div class="mb-3">
            <label for="pais" class="form-label">País:</label>
            <input type="text" class="form-control" id="pais" name="pais" value="{{ old('pais') }}">
        </div>

        <div class="mb-3">
            <label for="periodo" class="form-label">Periodo:</label>
            <select class="form-select" id="periodo" name="periodo">
          
                <option value="">-- Selecciona un periodo --</option>
                @foreach($periodos as $periodo)
                    <option value="{{ $periodo }}" {{ old('periodo') == $periodo ? 'selected' : '' }}>
                        {{ $periodo }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Registrar Autor</button>
        <a href="/" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection