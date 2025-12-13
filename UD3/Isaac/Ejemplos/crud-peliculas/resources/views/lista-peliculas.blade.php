@extends('layouts.app')

@section('content')
    <div>
        @foreach ($peliculas as $pelicula)
            <a href="/movie/detail/{{ $pelicula->id }}">
                <div>
                    <img style="width: 100px;" src="{{ $pelicula->poster }}">
                    <h2>{{ $pelicula->titulo }}</h2>
                </div>
            </a>

        @endforeach
    </div>
@endsection