@extends('layouts.app')

@section('content')
    <div class="container-fluid px-4">
        <h1 class="text-center mb-4">{{ $pelicula->title }}</h1>

        <div class="row justify-content-center"> {{-- para centrar --}}
            <div class="col-12 col-md-8 col-lg-3">
                <div class="card shadow"> 
                    
                    <img src="{{ $pelicula->poster_url }}" class="card-img-top" alt="{{ $pelicula->title }}"> 
                    
                    
                    <div class="card-body p-3">
                        <h5 class="card-title text-primary"><strong>{{ $pelicula->title }}</strong></h5>
                        <hr class="mt-0 mb-3"> {{-- Separador visual --}}
                        
                        <p class="card-text small mb-2"><strong>Año:</strong> {{ $pelicula->release_year }}</p>
                        <!-- <p class="card-text small mb-2"><strong>Género:</strong> {{ implode(', ', $pelicula->genres) }}</p> -->
                        <p class="card-text small mb-2">
                            <strong>Género:</strong>
                            @foreach ($pelicula->genres as $genero)
                                <span class="badge bg-secondary me-1">{{ $genero }}</span>
                            @endforeach
                        </p>
                        
                        <h6 class="mt-3"><strong>Sinopsis:</strong></h6>
                        <p class="card-text small">{{ $pelicula->synopsis }}</p>

                    </div>

                    
                    @if (Auth::user()->role == "admin")
                        <div class="card-footer bg-light border-top">
                            <div class="d-grid gap-2">
                                <a href="/movie/edit/{{ $pelicula->id }}" class="btn btn-warning btn-sm">
                                    Editar Película
                                </a>
                                <a
                                    href="/movie/delete/{{ $pelicula->id }}"
                                    class="btn btn-danger btn-sm"
                                    onclick="return confirm('¿Estás seguro de que quieres borrar la película: {{ $pelicula->title }}?')"
                                >
                                    Borrar Película
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <div class="col-12 col-md-8 col-lg-6 mt-4 mt-lg-0">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Comentarios</h5>
                    </div>
                    <div class="card-body">
                        @if ($comentarios->count() > 0)
                            @foreach ($comentarios as $comentario)
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <h6 class="card-subtitle mb-2 text-muted">
                                                    {{ $comentario->user->name }} - {{ $comentario->created_at->format('d/m/Y H:i') }}
                                                </h6>
                                                <p class="card-text">{{ $comentario->content }}</p>
                                            </div>
                                            @if (Auth::user()->role == "admin")
                                                <a
                                                    href="/comments/delete/{{ $comentario->id }}"
                                                    class="btn btn-danger btn-sm"
                                                    onclick="return confirm('¿Estás seguro de que quieres borrar este comentario?')"
                                                >
                                                    Borrar
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <p class="text-muted">No hay comentarios todavía. ¡Sé el primero en comentar!</p>
                        @endif
                    </div>
                </div>

                <div class="card shadow mt-3">
                    <div class="card-header bg-secondary text-white">
                        <h5 class="mb-0">Añadir Comentario</h5>
                    </div>
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <h6>Errores:</h6>
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $mensajeError)
                                        <li>{{ $mensajeError }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST" action="/comments/create">
                            @csrf
                            <input type="hidden" name="pelicula_id" value="{{ $pelicula->id }}">

                            <div class="mb-3">
                                <label for="content" class="form-label">Tu comentario:</label>
                                <textarea class="form-control" id="content" name="content" rows="3" placeholder="Escribe tu comentario aquí...">{{ old('content') }}</textarea>
                            </div>

                            <button type="submit" class="btn btn-primary">Enviar Comentario</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection