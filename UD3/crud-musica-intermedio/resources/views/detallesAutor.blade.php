@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="row g-0">
                    <!-- Imagen a la izquierda -->
                    <div class="col-md-4">
                        <img src="{{ $autor->foto_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($autor->nombre) . '&size=400&background=random' }}"
                             class="img-fluid w-100 h-100"
                             style="object-fit: cover;"
                             alt="{{ $autor->nombre }}">
                    </div>

                    <!-- Contenido a la derecha -->
                    <div class="col-md-8 d-flex flex-column">
                        <div class="card-body p-4 flex-grow-1">
                            <h2 class="card-title text-primary mb-3">{{ $autor->nombre }}</h2>

                            <p class="mb-2"><strong>País:</strong> {{ $autor->pais ?? 'N/A' }}</p>

                            <p class="mb-3">
                                <strong>Periodo:</strong>
                                @if($autor->periodo)
                                    <span class="badge bg-success">{{ $autor->periodo->nombre }}</span>
                                @else
                                    <span class="text-muted">Sin periodo</span>
                                @endif
                            </p>

                            <hr>

                            <h5 class="mt-3 mb-3"><strong>Obras ({{ $autor->obras->count() }})</strong></h5>
                            @if($autor->obras->count() > 0)
                                <div class="list-group mb-3">
                                    @foreach ($autor->obras as $obra)
                                        <div class="list-group-item d-flex justify-content-between align-items-center">
                                            <div>
                                                <strong>{{ $obra->titulo }}</strong>
                                                @if($obra->anio)
                                                    <span class="text-muted">({{ $obra->anio }})</span>
                                                @endif
                                                <br>
                                                @if($obra->tipo)
                                                    <small><strong>Tipo:</strong> <span class="badge bg-info">{{ $obra->tipo->nombre }}</span></small>
                                                @endif
                                            </div>
                                            <a href="/obra/delete/{{ $obra->id }}"
                                               class="btn btn-danger btn-sm"
                                               onclick="return confirm('¿Seguro que quieres borrar esta obra?')">
                                                Eliminar
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-muted">No hay obras registradas</p>
                            @endif

                            <a href="/obra/create/{{ $autor->id }}" class="btn btn-success btn-sm">Añadir Obra</a>
                        </div>

                        <!-- Botones de acción -->
                        <div class="card-footer bg-light border-top">
                            <div class="d-flex gap-2 justify-content-between">
                                <a href="/" class="btn btn-secondary btn-sm">Volver</a>
                                <div class="d-flex gap-2">
                                    <a href="/autor/edit/{{ $autor->id }}" class="btn btn-warning btn-sm">Editar</a>
                                    <a href="/autor/delete/{{ $autor->id }}"
                                       class="btn btn-danger btn-sm"
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
