@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-warning text-dark">
                    <h4 class="mb-0">Editar Autor</h4>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="/autor/edit/{{ $autor->id }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre *</label>
                            <input type="text"
                                   class="form-control"
                                   id="nombre"
                                   name="nombre"
                                   value="{{ old('nombre', $autor->nombre) }}"
                                   required>
                        </div>

                        <div class="mb-3">
                            <label for="foto_url" class="form-label">URL de la Foto</label>
                            <input type="url"
                                   class="form-control"
                                   id="foto_url"
                                   name="foto_url"
                                   value="{{ old('foto_url', $autor->foto_url) }}"
                                   onchange="actualizarPreview()">
                            <div class="mt-2">
                                <img id="preview"
                                     src="{{ $autor->foto_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($autor->nombre) . '&size=200&background=random' }}"
                                     alt="Preview"
                                     style="width: 200px; height: 200px; object-fit: cover; border-radius: 8px;">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="pais" class="form-label">País</label>
                            <input type="text"
                                   class="form-control"
                                   id="pais"
                                   name="pais"
                                   value="{{ old('pais', $autor->pais) }}">
                        </div>

                        <div class="mb-3">
                            <label for="periodo" class="form-label">Periodo</label>
                            <select class="form-control" id="periodo" name="periodo">
                                <option value="">Selecciona un periodo</option>
                                @foreach($periodos as $periodo)
                                    <option value="{{ $periodo }}"
                                        {{ old('periodo', $autor->periodo?->nombre) == $periodo ? 'selected' : '' }}>
                                        {{ $periodo }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-warning">Actualizar Autor</button>
                            <a href="/autor/detalle/{{ $autor->id }}" class="btn btn-secondary">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function actualizarPreview() {
    const url = document.getElementById('foto_url').value;
    const preview = document.getElementById('preview');
    if (url) {
        preview.src = url;
    } else {
        preview.src = 'https://ui-avatars.com/api/?name={{ urlencode($autor->nombre) }}&size=200&background=random';
    }
}
</script>
@endsection
