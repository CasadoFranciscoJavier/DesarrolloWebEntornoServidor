@extends('layout')

@section('titulo', 'Lista de Usuarios')

@section('contenido')

    <h1>Lista de Usuarios</h1>

    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Email</th>
            <th>Acciones</th>
        </tr>
        @foreach($usuarios as $usuario)
        <tr>
            <td>{{ $usuario->id }}</td>
            <td>{{ $usuario->nombre }}</td>
            <td>{{ $usuario->email }}</td>
            <td>
                <a href="/usuario/{{ $usuario->id }}/editar">Editar</a>
                <form action="/usuario/{{ $usuario->id }}/delete" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('¿Estás seguro de eliminar este usuario?')">Eliminar</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>

    <br>
    <a href="/nuevo_usuario">Registrar nuevo usuario</a>

@endsection