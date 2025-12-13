@extends('layouts.app')

@section('title', 'Detalle - {{ $autor->nombre }}')

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-10">
                <div class="card shadow">
                    <div class="row g-0">
                        <!-- Imagen a la izquierda -->
                        <div class="col-md-4">
                            <img src="{{ $autor->foto_url }}" class="img-fluid w-100 h-100" style="object-fit: cover;"
                                alt="{{ $autor->nombre }}">
                        </div>

                        <!-- Contenido a la derecha -->
                        <div class="col-md-8 d-flex flex-column">
                            <div class="card-body p-4 flex-grow-1">
                                <h2 class="card-title text-primary mb-3">{{ $autor->nombre }}</h2>

                                <p class="mb-2"><strong>Pais:</strong> {{ $autor->pais ?? 'N/A' }}</p>
                                <p class="mb-3">
                                    <strong>Periodo:</strong>
                                    <span class="badge bg-success">{{ $autor->periodo ?? 'N/A' }}</span>
                                </p>

                                <hr>

                                <h5 class="mt-3 mb-3"><strong>Obras ({{ $autor->obras->count() }})</strong></h5>
                                @if($autor->obras->count() > 0)
                                    <div class="list-group">
                                        @foreach ($autor->obras as $obra)
                                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                                <div>
                                                    <strong>{{ $obra->titulo }}</strong>
                                                    <span class="text-muted ms-2">{{ $obra->anio ? '(' . $obra->anio . ')' : '' }}</span>
                                                    <span class="badge bg-secondary ms-2">{{ $obra->tipo ?? '' }}</span>
                                                </div>
                                                <a href="/obra/delete/{{ $obra->id }}"
                                                   class="btn btn-danger btn-sm"
                                                   onclick="return confirm('¿Seguro que quieres borrar {{ $obra->titulo }}?')">
                                                    <i class="bi bi-trash"></i> Borrar
                                                </a>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-muted">No hay obras registradas</p>
                                @endif

                               
                                    <div class="d-flex gap-2">
                                        <a href="/obra/create/{{ $autor->id }}" class="btn btn-outline-info btn-sm mt-3">Añadir Obra</a>

                                    </div>
                              

                            </div>

                            <!-- Botones de accion -->
                            <div class="card-footer bg-light border-top">
                                <div class="d-flex gap-2 justify-content-between">
                                    <a href="/" class="btn btn-secondary btn-sm">Volver</a>
                                    <div class="d-flex gap-2">
                                        <a href="/autor/edit/{{ $autor->id }}" class="btn btn-warning btn-sm">Editar</a>
                                        <a href="/autor/delete/{{ $autor->id }}" class="btn btn-danger btn-sm"
                                            onclick="return confirm('¿Seguro que quieres borrar a {{ $autor->nombre }}?')">
                                            Eliminar
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection