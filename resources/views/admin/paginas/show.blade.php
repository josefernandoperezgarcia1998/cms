@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $pagina->titulo }}</h1>
    <p>{{ $pagina->contenido }}</p>
    <p><strong>Slug:</strong> {{ $pagina->slug }}</p>
    <p><strong>Fecha de Actualización:</strong> {{ $pagina->fecha_actualizacion }}</p>
    <p><strong>Fuente:</strong> {{ $pagina->fuente }}</p>
    <p><strong>Activo:</strong> {{ $pagina->activo ? 'Sí' : 'No' }}</p>
    <a href="{{ route('paginas.edit', $pagina) }}" class="btn btn-warning">Editar</a>
    <form action="{{ route('paginas.destroy', $pagina) }}" method="POST" style="display:inline-block;">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger">Eliminar</button>
    </form>
</div>
@endsection
