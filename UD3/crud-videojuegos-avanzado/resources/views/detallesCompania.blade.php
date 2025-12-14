@extends('layouts.app')

@section('title', 'Detalle - {{ $compania->nombre }}')

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-8">
                <div class="card shadow">
                    <div class="card-body p-4">
                        <h2 class="card-title text-primary mb-3">{{ $compania->nombre }}</h2>

                        <p class="mb-2"><strong>Pais:</strong> {{ $compania->pais ?? 'N/A' }}</p>
                        <p class="mb-3">
                            <strong>Tipo:</strong>
                            <span class="badge bg-success">{{ $compania->tipo ?? 'N/A' }}</span>
                        </p>



                        <h5 class="mt-3 mb-3"><strong>Juegos ({{ $compania->juegos->count() }})</strong></h5>
                        @if($compania->juegos->count() > 0)
                            <div class="list-group">
                                @foreach ($compania->juegos as $juego)
                                    <div class="list-group-item d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center gap-3">
                                            <img src="{{ $juego->cover_url }}" class="rounded"
                                                style="width: 60px; height: 80px; object-fit: cover;" alt="{{ $juego->titulo }}">
                                            <div>
                                                <strong>{{ $juego->titulo }}</strong>
                                                <span
                                                    class="text-muted ms-2">{{ $juego->anio ? '(' . $juego->anio . ')' : '' }}</span>
                                                <br>
                                                @foreach($juego->generos as $genero)
                                                    <span class="badge bg-secondary mt-1">{{ $genero->nombre }}</span>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="d-flex gap-2">
                                            <a href="/juego/edit/{{ $juego->id }}" class="btn btn-warning btn-sm"
                                                class="bi bi-edit"> Editar
                                            </a>
                                            <a href="/juego/delete/{{ $juego->id }}" class="btn btn-danger btn-sm"
                                                onclick="return confirm('¿Seguro que quieres borrar {{ $juego->titulo }}?')">
                                                <i class="bi bi-trash"></i> Borrar
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-muted">No hay juegos registradas</p>
                        @endif


                        <div class="d-flex gap-2 mt-3">
                            <a href="/juego/create/{{ $compania->id }}" class="btn btn-outline-info btn-sm">Añadir juego</a>
                        </div>
                    </div>

                    <div class="card-footer bg-light border-top">
                        <div class="d-flex gap-2 justify-content-between">
                            <a href="/" class="btn btn-secondary btn-sm">Volver</a>
                            <div class="d-flex gap-2">
                                <a href="/compania/edit/{{ $compania->id }}" class="btn btn-warning btn-sm">Editar</a>
                                <a href="/compania/delete/{{ $compania->id }}" class="btn btn-danger btn-sm"
                                    onclick="return confirm('¿Seguro que quieres borrar a {{ $compania->nombre }}?')">
                                    Eliminar
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection