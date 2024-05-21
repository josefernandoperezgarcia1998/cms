@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Listado de Páginas</h1>
    <a href="{{ route('paginas.create') }}" class="btn btn-primary mb-3">Crear Página</a>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Título</th>
                <th>Slug</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($paginas as $pagina)
            <tr>
                <td>{{ $pagina->id }}</td>
                <td>{{ $pagina->titulo }}</td>
                <td>{{ $pagina->slug }}</td>
                <td>
                    <a href="{{ route('paginas.show', $pagina) }}" class="btn btn-info">Mostrar</a>
                    <a href="{{ route('paginas.edit', $pagina) }}" class="btn btn-warning">Editar</a>
                    <form action="{{ route('paginas.destroy', $pagina) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
