@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Editar Sección</h1>
    <form action="{{ route('secciones.update', $seccion) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="titulo" class="form-label">Título</label>
            <input type="text" name="titulo" class="form-control" value="{{ $seccion->titulo }}" required>
        </div>
        <div class="mb-3">
            <label for="ordenamiento" class="form-label">Ordenamiento</label>
            <input type="number" name="ordenamiento" class="form-control" value="{{ $seccion->ordenamiento }}" required>
        </div>
        <div class="form-check mb-3">
            <input type="checkbox" name="activo" class="form-check-input" {{ $seccion->activo ? 'checked' : '' }}>
            <label for="activo" class="form-check-label">Activo</label>
        </div>
        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
    </form>
</div>
@endsection
