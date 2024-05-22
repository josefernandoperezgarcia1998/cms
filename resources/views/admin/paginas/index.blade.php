@extends('layouts.app')

@section('content')
<div class="container">
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

    <h1 class="my-4 text-center">Listado de Páginas</h1>
    <div class="d-flex justify-content-between mb-4">
        <a href="{{ route('paginas.create') }}" class="btn btn-primary">Crear Página</a>
        <form action="{{ route('paginas.index') }}" method="GET" class="d-flex">
            <input type="text" name="search" class="form-control me-2" placeholder="Buscar..." value="{{ $search }}">
            <button type="submit" class="btn btn-outline-secondary">Buscar</button>
        </form>
    </div>
    <div class="card shadow rounded-3">
        <div class="card-body">
            <table class="table table-hover table-responsive-sm text-center">
                <thead class="table-dark">
                    <tr>
                        <th>Título</th>
                        <th>Slug</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($paginas as $pagina)
                    <tr>
                        <td>{{ $pagina->titulo }}</td>
                        <td>{{ $pagina->slug }}</td>
                        <td class="d-flex justify-content-center flex-wrap">
                            <a href="{{ route('paginas.edit', $pagina) }}" class="btn btn-warning btn-sm me-1 mb-1">Editar</a>
                            <button type="button" class="btn btn-danger btn-sm mb-1" data-bs-toggle="modal" data-bs-target="#deletePageModal{{ $pagina->id }}">Eliminar</button>
                        </td>
                    </tr>

                    <!-- Modal para confirmar eliminación -->
                    <div class="modal fade" id="deletePageModal{{ $pagina->id }}" tabindex="-1" aria-labelledby="deletePageModalLabel{{ $pagina->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="deletePageModalLabel{{ $pagina->id }}">Confirmar Eliminación</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p>¿Está seguro de que desea eliminar la página "<strong>{{ $pagina->titulo }}</strong>"?</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                    <form action="{{ route('paginas.destroy', $pagina) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Eliminar</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <tr>
                        <td colspan="3">No se encontraron páginas.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer d-flex justify-content-center">
            {{ $paginas->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection
