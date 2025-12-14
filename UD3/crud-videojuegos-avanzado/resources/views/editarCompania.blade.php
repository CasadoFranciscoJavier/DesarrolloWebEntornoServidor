@extends('layouts.app')
@section('title', 'Editar Compañía')
@section('content')
<div class="container">
    <h1>Editar Compañía: {{ $compania->nombre }}</h1>

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

    <form method="POST" action="/compania/edit/{{ $compania->id }}">
        @csrf

        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre:</label>
            <input type="text" class="form-control" id="nombre" name="nombre" value="{{ old('nombre', $compania->nombre) }}">
        </div>

        <div class="mb-3">
            <label for="pais" class="form-label">País:</label>
            <input type="text" class="form-control" id="pais" name="pais" value="{{ old('pais', $compania->pais) }}">
        </div>

        <div class="mb-3">
            <label for="tipo" class="form-label">Tipo:</label>
            <select class="form-select" id="tipo" name="tipo">
                <option value="">-- Selecciona un tipo --</option>
                @foreach(\App\Models\Compania::VALID_TIPOS as $tipo)
                    <option value="{{ $tipo }}" {{ old('tipo', $compania->tipo) == $tipo ? 'selected' : '' }}>
                        {{ $tipo }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
        <a href="/compania/detalle/{{ $compania->id }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
