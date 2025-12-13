@extends('layouts.app')

@section('content')
    <div>
        @if ($errors->any())
            <h3>Errores</h3>
            <ol>
                @foreach ($errors->all() as $mensajeError)
                    <li style="color: red">{{ $mensajeError }} </li>
                @endforeach
            </ol>
        @endif
        <form method="POST">
            @csrf
            <label>Titulo: <input type="text" name="titulo" value="{{ old("titulo") }}"></label>
            <label>Poster (URL): <input type="text" name="poster" value="{{ old("poster") }}"></label>
            <label>Año de estreno: <input type="number" name="anio" value="{{ old("anio") }}"></label>
            <label>Sinopsis: <textarea name="sinopsis">{{ old("sinopsis") }}</textarea></label>

            <fieldset>
                <legend>Géneros:</legend>
                @foreach ($generos as $genero)
                    <label>
                        <input type="checkbox" name="generos[]" value="{{ $genero->genero }}"
                        @if (in_array($genero->genero, old('generos', []))) checked @endif>
                        {{ $genero->genero }}
                    </label>
                @endforeach
            </fieldset>

            <input type="submit">
        </form>
    </div>
@endsection