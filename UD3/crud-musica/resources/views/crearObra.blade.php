@extends('layouts.app')
@section('title', 'Añadir Obra')
@section('content')

<div class="container">
    <h1>Añadir Obra para {{ $autor->nombre }}</h1>

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

    <form method="POST" action="/obra">
        @csrf

        <input type="hidden" name="autor_id" value="{{ $autor->id }}">

        <div class="mb-3">
            <label for="titulo" class="form-label">Título:</label>
            <input type="text" class="form-control" id="titulo" name="titulo" value="{{ old('titulo') }}">
        </div>

        <div class="mb-3">
            <label for="tipo" class="form-label">Tipo:</label>
            <select class="form-select" id="tipo" name="tipo">
                <option value="">-- Selecciona un tipo --</option>
                @foreach($tipos as $tipo)
                    <option value="{{ $tipo }}" {{ old('tipo') == $tipo ? 'selected' : '' }}>
                        {{ $tipo }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="anio" class="form-label">Año (opcional):</label>
            <input type="number" class="form-control" id="anio" name="anio" value="{{ old('anio') }}" min="1000" max="{{ date('Y') + 10 }}">
        </div>

        <button type="submit" class="btn btn-primary">Añadir Obra</button>
        <a href="/autor/detalle/{{ $autor->id }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
