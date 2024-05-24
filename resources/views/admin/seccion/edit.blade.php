@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-4 text-center">Editar Sección</h1>
    <div class="card shadow rounded-3">
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            <form action="{{ route('paginas.secciones.update', [$seccion->pagina, $seccion]) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="titulo" class="form-label">Título</label>
                    <input type="text" name="titulo" id="titulo" class="form-control @error('titulo') is-invalid @enderror" value="{{ old('titulo', $seccion->titulo) }}" required>
                    @error('titulo')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="ordenamiento" class="form-label">Ordenamiento</label>
                    <input type="number" name="ordenamiento" id="ordenamiento" class="form-control @error('ordenamiento') is-invalid @enderror" value="{{ old('ordenamiento', $seccion->ordenamiento) }}" required>
                    @error('ordenamiento')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-check mb-3">
                    <input type="checkbox" name="activo" class="form-check-input" id="activo" {{ old('activo', $seccion->activo) ? 'checked' : '' }}>
                    <label for="activo" class="form-check-label">Activo</label>
                </div>
                <div>
                    <a href="{{ route('paginas.secciones.index', $seccion->pagina) }}" class="btn btn-secondary">Regresar</a>
                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
