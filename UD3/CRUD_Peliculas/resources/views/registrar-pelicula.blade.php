@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Registrar Nueva Película</h1>

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

    <form method="POST" action="/movie">
        @csrf

        <div class="mb-3">
            <label for="poster_url" class="form-label">URL del Póster:</label>
            <input type="text" class="form-control" id="poster_url" name="poster_url" value="{{ old('poster_url') }}">
        </div>

        <div class="mb-3">
            <label for="title" class="form-label">Título:</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}">
        </div>

        <div class="mb-3">
            <label for="release_year" class="form-label">Año:</label>
            <input type="number" class="form-control" id="release_year" name="release_year" value="{{ old('release_year') }}" min="1900" max="{{ date('Y') + 1 }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Géneros:</label><br>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="genres[]" value="Action" id="genre1">
                <label class="form-check-label" for="genre1">Action</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="genres[]" value="Comedy" id="genre2">
                <label class="form-check-label" for="genre2">Comedy</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="genres[]" value="Drama" id="genre3">
                <label class="form-check-label" for="genre3">Drama</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="genres[]" value="Horror" id="genre4">
                <label class="form-check-label" for="genre4">Horror</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="genres[]" value="Sci-Fi" id="genre5">
                <label class="form-check-label" for="genre5">Sci-Fi</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="genres[]" value="Fantasy" id="genre6">
                <label class="form-check-label" for="genre6">Fantasy</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="genres[]" value="Documentary" id="genre7">
                <label class="form-check-label" for="genre7">Documentary</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="genres[]" value="Romance" id="genre8">
                <label class="form-check-label" for="genre8">Romance</label>
            </div>
        </div>

        <div class="mb-3">
            <label for="synopsis" class="form-label">Sinopsis:</label>
            <textarea class="form-control" id="synopsis" name="synopsis" rows="5">{{ old('synopsis') }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Registrar Película</button>
        <a href="/" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection