@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0">Añadir Nueva Obra para {{ $autor->nombre }}</h4>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="/obra" method="POST">
                        @csrf
                        <input type="hidden" name="autor_id" value="{{ $autor->id }}">

                        <div class="mb-3">
                            <label for="titulo" class="form-label">Título *</label>
                            <input type="text"
                                   class="form-control"
                                   id="titulo"
                                   name="titulo"
                                   value="{{ old('titulo') }}"
                                   required>
                        </div>

                        <div class="mb-3">
                            <label for="anio" class="form-label">Año</label>
                            <input type="number"
                                   class="form-control"
                                   id="anio"
                                   name="anio"
                                   value="{{ old('anio') }}"
                                   min="1000"
                                   max="{{ date('Y') + 10 }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tipos * (selecciona al menos uno)</label>
                            @foreach ($tipos as $tipo)
                                <div class="form-check">
                                    <input class="form-check-input"
                                           type="checkbox"
                                           name="tipos[]"
                                           value="{{ $tipo->nombre }}"
                                           id="tipo{{ $tipo->id }}"
                                           @if(in_array($tipo->nombre, old('tipos', []))) checked @endif>
                                    <label class="form-check-label" for="tipo{{ $tipo->id }}">
                                        {{ $tipo->nombre }}
                                    </label>
                                </div>
                            @endforeach
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-success">Crear Obra</button>
                            <a href="/autor/detalle/{{ $autor->id }}" class="btn btn-secondary">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
