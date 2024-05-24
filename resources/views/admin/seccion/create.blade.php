@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-4 text-center">Crear Sección</h1>
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
            <form action="{{ route('paginas.secciones.store', $pagina) }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="titulo" class="form-label">Título</label>
                    <input type="text" name="titulo" id="titulo" class="form-control @error('titulo') is-invalid @enderror" value="{{ old('titulo') }}" required>
                    @error('titulo')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="slug" class="form-label">Slug</label>
                    <input type="text" name="slug" id="slug" class="form-control @error('slug') is-invalid @enderror" value="{{ old('slug') }}" readonly required>
                    @error('slug')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="ordenamiento" class="form-label">Ordenamiento</label>
                    <input type="number" name="ordenamiento" id="ordenamiento" class="form-control @error('ordenamiento') is-invalid @enderror" value="{{ old('ordenamiento') }}" required>
                    @error('ordenamiento')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-check mb-3">
                    <input type="checkbox" name="activo" class="form-check-input" id="activo" {{ old('activo', true) ? 'checked' : '' }}>
                    <label for="activo" class="form-check-label">Activo</label>
                </div>
                <div>
                    <a href="{{ route('paginas.secciones.index', $pagina) }}" class="btn btn-secondary">Regresar</a>
                    <button type="submit" class="btn btn-primary">Crear</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    $(document).ready(function() {
        // Convertir a slug
        $("#titulo").keyup(function() {
            var text = $(this).val();
            text = text.toLowerCase();
            text = text.normalize('NFD').replace(/[\u0300-\u036f]/g, '');
            text = text.replace(/[^a-zA-Z0-9]+/g, '-');
            text = text.replace(/^-+|-+$/g, ''); 
            $("#slug").val(text);        
        });

    });
</script>
@endsection
