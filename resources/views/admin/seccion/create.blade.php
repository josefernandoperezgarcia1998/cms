@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Crear Sección</h1>
    <form action="{{ route('secciones.store', $pagina) }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="titulo" class="form-label">Título</label>
            <input type="text" name="titulo" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="ordenamiento" class="form-label">Ordenamiento</label>
            <input type="number" name="ordenamiento" class="form-control" required>
        </div>
        <div class="form-check mb-3">
            <input type="checkbox" name="activo" class="form-check-input" checked>
            <label for="activo" class="form-check-label">Activo</label>
        </div>
        <button type="submit" class="btn btn-primary">Crear</button>
    </form>
</div>
@endsection
