@extends('layouts.app')
@section('title', 'Editar Juego')
@section('content')


    @php
        $fotoDefault = 'https://ui-avatars.com/api/?name=?&background=random&size=256';
    @endphp

    <div class="container">
        <h1>Editar Juego: {{ $juego->titulo }}</h1>

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

        <form method="POST" action="/juego/edit/{{ $juego->id }}">
            @csrf

            <input type="hidden" name="compania_id" value="{{ $juego->compania_id }}">

            <div class="mb-3">
                <label for="titulo" class="form-label">Título:</label>
                <input type="text" class="form-control" id="titulo" name="titulo"
                    value="{{ old('titulo', $juego->titulo) }}">
            </div>

            <div class="mb-3">
                <label for="cover_url" class="form-label">Cover URL:</label>
                <input type="text" class="form-control" id="cover_url" name="cover_url" value="{{ old('cover_url', $juego->cover_url) }}"
                    oninput="document.getElementById('foto').src = this.value ">
                <img id="foto" src="{{ old('cover_url', $juego->cover_url) }}" style="max-width: 200px; margin-top: 10px;">
            </div>

            <div class="mb-3">
                <label for="anio" class="form-label">Año Lnazamiento:</label>
                <input type="text" class="form-control" id="anio" name="anio" value="{{ old('anio', $juego->anio) }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Géneros (selecciona al menos uno):</label>
                <div class="row">
                    @foreach($generos as $genero)
                        <div class="col-md-6 col-lg-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="generos[]" value="{{ $genero->id }}"
                                    id="genero{{ $genero->id }}"
                                    {{ (old('generos') ? in_array($genero->id, old('generos')) : $juego->generos->contains($genero->id)) ? 'checked' : '' }}>
                                <label class="form-check-label" for="genero{{ $genero->id }}">
                                    {{ $genero->nombre }}
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
            <a href="/juego/detalle/{{ $juego->id }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
@endsection