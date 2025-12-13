@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Listado de Autores</h1>

    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-5 g-3">
        @foreach ($autores as $autor)
            <div class="col">
                <div class="card h-100">
                    <img src="{{ $autor->foto_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($autor->nombre) . '&size=250&background=random' }}"
                         class="card-img-top"
                         alt="{{ $autor->nombre }}"
                         style="height: 250px; object-fit: cover;">
                    <div class="card-body p-2 d-flex flex-column">
                        <h6 class="card-title">{{ $autor->nombre }}</h6>
                        <p class="card-text small mb-2">
                            <strong>País:</strong> {{ $autor->pais ?? 'N/A' }}
                        </p>
                        <p class="card-text small mb-2">
                            <strong>Periodos:</strong>
                            @foreach ($autor->periodos as $periodo)
                                <span class="badge bg-success">{{ $periodo->nombre }}</span>
                            @endforeach
                        </p>
                        <p class="card-text small mb-2">
                            <strong>Obras:</strong> {{ $autor->obras->count() }}
                        </p>
                        <a href="/autor/detalle/{{ $autor->id }}" class="btn btn-primary btn-sm w-100 mt-auto">
                            Ver detalles
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
