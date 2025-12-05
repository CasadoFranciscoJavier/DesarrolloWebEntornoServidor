@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <h1 class="text-center mb-4">Películas</h1>

    <div class="row row-cols-2 row-cols-md-3 row-cols-lg-5 g-3">
        @foreach($peliculas as $pelicula)
        <div class="col">
            <div class="card">
                <img src="{{ $pelicula->poster_url }}" class="card-img-top" alt="{{ $pelicula->title }}">
                <div class="card-body p-2">
                    <h6 class="card-title">{{ $pelicula->title }}</h6>
                    <p class="card-text small mb-2"><strong>Año:</strong> {{ $pelicula->release_year }}</p>
                    <a href="/movie/detail/{{ $pelicula->id }}" class="btn btn-primary btn-sm w-100">Ver detalles</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $peliculas->links() }}
    </div>
</div>
@endsection
