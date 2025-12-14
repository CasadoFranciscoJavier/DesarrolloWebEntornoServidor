@extends('layouts.app')
@section('title', 'companiaes - CRUD Música')
@section('content')
<div class="container-fluid px-4 ">
    <h1 class="text-center mb-4">Listado de Compañías</h1>

    <div class="row row-cols-2 row-cols-md-3 row-cols-lg-5 g-3">
        @foreach($companias as $compania)
        <div class="col">
            <div class="card h-100">
                
                <div class="card-body p-2 d-flex flex-column">
                    <h6 class="card-title badge bg-warning">{{ $compania->nombre }}</h6>
                    <p class="card-text small mb-2"><strong>Pais:</strong> {{ $compania->pais }}</p>
                    <p class="card-text  small mb-2 "><strong>Tipo:</strong> {{ $compania->tipo }}</p>
                    <p class="card-text small mb-2"><strong>Número de juegos:</strong> {{ $compania->juegos->count() ?? 0 }}</p>
                    <a href="/compania/detalle/{{ $compania->id }}" class="btn btn-primary btn-sm w-100 mt-auto">Ver detalles</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
