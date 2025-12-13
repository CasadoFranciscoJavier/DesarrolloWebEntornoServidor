@extends('layouts.app')
@section('title', 'Autores - CRUD Música')
@section('content')
<div class="container-fluid px-4 ">
    <h1 class="text-center mb-4">Listado de Autores</h1>

    <div class="row row-cols-2 row-cols-md-3 row-cols-lg-5 g-3">
        @foreach($autores as $autor)
        <div class="col">
            <div class="card h-100">
                <img src="{{ $autor->foto_url }}"
                     class="card-img-top"
                     alt="{{ $autor->nombre }}"
                     style="height: 250px; object-fit: cover;">
                <div class="card-body p-2 d-flex flex-column">
                    <h6 class="card-title">{{ $autor->nombre }}</h6>
                    <p class="card-text small mb-2"><strong>Pais:</strong> {{ $autor->pais }}</p>
                    <p class="card-text small mb-2"><strong>Número de obras:</strong> {{ $autor->obras->count() ?? 0 }}</p>
                    <a href="/autor/detalle/{{ $autor->id }}" class="btn btn-primary btn-sm w-100 mt-auto">Ver detalles</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
