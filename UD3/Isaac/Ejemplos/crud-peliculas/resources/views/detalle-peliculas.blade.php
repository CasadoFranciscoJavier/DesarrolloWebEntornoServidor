@extends('layouts.app')

@section('content')

    @if (Auth::user()->role == "admin")
        <a href="/movie/update/{{ $pelicula->id}}"><button>EDITAR PELICULA ✏️</button>
    @endif

    </a>
    <div>
        <img style="width: 100px;" src="{{ $pelicula->poster }}">
        <h2>{{ $pelicula->titulo }}</h2>
        <h3>Año de publicación: {{ $pelicula->anio }}</h3>
        <p>Generos: {{ implode(", ", $pelicula->getGeneros()) }}</p>
        <p>{{ $pelicula->sinopsis }}</p>
    </div>

    <div>
        <h2>Comentarios</h2>
        @foreach ($pelicula->comentarios as $comentario)
            <div>
                <p>EL {{ $comentario->created_at }} {{$comentario->user->name}} HA DICHO: {{ $comentario->texto }}</p>

                @if (Auth::user()->role == "admin")
                    <a href="/comments/delete/{{ $comentario->id }}"><button>BORRAR 🗑</button></a>
                @endif

            </div>
        @endforeach

        <form action="/comments/create" method="POST">
            @csrf
            <input type="hidden" name="pelicula_id" value="{{ $pelicula->id }}">
            <textarea name="texto"></textarea>
            <br>
            <button type="submit">ENVIAR COMENTARIO</button>
        </form>
    </div>
@endsection