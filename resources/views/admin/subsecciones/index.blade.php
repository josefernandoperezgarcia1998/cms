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
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('paginas.index') }}">Páginas</a></li>
            <li class="breadcrumb-item"><a href="{{ route('paginas.secciones.index', $seccion->pagina) }}">Secciones</a></li>
            <li class="breadcrumb-item active" aria-current="page">Subsecciones de la Sección: {{ $seccion->titulo }}</li>
        </ol>
    </nav>

    <h1 class="my-4 text-center">Subsecciones de la Sección: {{ $seccion->titulo }}</h1>

    <div class="d-flex justify-content-between mb-4">
        <a href="{{ route('paginas.secciones.index', $seccion->pagina) }}" class="btn btn-secondary">Regresar a Secciones</a>
        <div class="d-flex ms-auto">
            <button type="button" class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#createSubseccionModal">
                Crear Subsección
            </button>
            <form action="{{ route('secciones.subsecciones.index', $seccion) }}" method="GET" class="d-flex">
                <input type="text" name="search" class="form-control me-2" placeholder="Buscar..." value="{{ $search }}">
                <button type="submit" class="btn btn-outline-secondary">Buscar</button>
            </form>
        </div>
    </div>

    <div class="card shadow rounded-3">
        <div class="card-body">
            @if($subsecciones->isEmpty())
                <p class="text-center">No hay subsecciones.</p>
            @else
                <table class="table table-hover table-responsive-sm text-center">
                    <thead class="table-dark">
                        <tr>
                            <th>Título</th>
                            <th>Slug</th>
                            <th>Ordenamiento</th>
                            <th>Activo</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($subsecciones as $subseccion)
                        <tr>
                            <td>{{ $subseccion->titulo }}</td>
                            <td>{{ $subseccion->slug }}</td>
                            <td>{{ $subseccion->ordenamiento }}</td>
                            <td>{{ $subseccion->activo ? 'Sí' : 'No' }}</td>
                            <td class="d-flex justify-content-center flex-wrap">
                                <button type="button" class="btn btn-warning btn-sm me-1 mb-1" data-bs-toggle="modal" data-bs-target="#editSubseccionModal{{ $subseccion->id }}">Editar</button>
                                <a href="{{ route('subsecciones.contenido', [$seccion->id, $subseccion->id]) }}" class="btn btn-info btn-sm mb-1">Contenido</a>
                                &nbsp;
                                <button type="button" class="btn btn-danger btn-sm mb-1" data-bs-toggle="modal" data-bs-target="#deleteSubseccionModal{{ $subseccion->id }}">Eliminar</button>
                            </td>
                        </tr>

                        <!-- Modal para editar subsección -->
                        <div class="modal fade" id="editSubseccionModal{{ $subseccion->id }}" tabindex="-1" aria-labelledby="editSubseccionModalLabel{{ $subseccion->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editSubseccionModalLabel{{ $subseccion->id }}">Editar Subsección</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="{{ route('secciones.subsecciones.update', [$seccion, $subseccion]) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="titulo{{ $subseccion->id }}" class="form-label">Título</label>
                                                <input type="text" name="titulo" class="form-control @error('titulo') is-invalid @enderror" id="titulo{{ $subseccion->id }}" value="{{ old('titulo', $subseccion->titulo) }}" required>
                                                @error('titulo')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="mb-3">
                                                <label for="slug{{ $subseccion->id }}" class="form-label">Slug</label>
                                                <input type="text" name="slug" class="form-control @error('slug') is-invalid @enderror" id="slug{{ $subseccion->id }}" value="{{ old('slug', $subseccion->slug) }}" readonly required>
                                                @error('slug')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="mb-3">
                                                <label for="ordenamiento{{ $subseccion->id }}" class="form-label">Ordenamiento</label>
                                                <input type="number" name="ordenamiento" class="form-control @error('ordenamiento') is-invalid @enderror" id="ordenamiento{{ $subseccion->id }}" value="{{ old('ordenamiento', $subseccion->ordenamiento) }}" required>
                                                @error('ordenamiento')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-check mb-3">
                                                <input type="checkbox" name="activoEditar" class="form-check-input @error('activoEditar') is-invalid @enderror" id="activoEditar{{ $subseccion->id }}" {{ old('activoEditar', $subseccion->activo) ? 'checked' : '' }}>
                                                <label for="activoEditar{{ $subseccion->id }}" class="form-check-label">Activo</label>
                                                @error('activoEditar')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Modal para confirmar eliminación -->
                        <div class="modal fade" id="deleteSubseccionModal{{ $subseccion->id }}" tabindex="-1" aria-labelledby="deleteSubseccionModalLabel{{ $subseccion->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="deleteSubseccionModalLabel{{ $subseccion->id }}">Confirmar Eliminación</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>¿Está seguro de que desea eliminar la subsección "<strong>{{ $subseccion->titulo }}</strong>" de la sección "<strong>{{ $seccion->titulo }}</strong>" de la página "<strong>{{ $seccion->pagina->titulo }}</strong>"?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                        <form action="{{ route('secciones.subsecciones.destroy', [$seccion, $subseccion]) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Eliminar</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
        <div class="card-footer d-flex justify-content-center">
            {{ $subsecciones->links('pagination::bootstrap-5') }}
        </div>
    </div>

    <!-- Modal para crear subsecciones -->
    <div class="modal fade" id="createSubseccionModal" tabindex="-1" aria-labelledby="createSubseccionModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createSubseccionModalLabel">Crear Subsección</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('secciones.subsecciones.store', $seccion) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="titulo" class="form-label">Título</label>
                            <input type="text" name="titulo" class="form-control @error('titulo') is-invalid @enderror" id="titulo" value="{{ old('titulo') }}" required>
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
                            <input type="number" name="ordenamiento" class="form-control @error('ordenamiento') is-invalid @enderror" id="ordenamiento" value="{{ old('ordenamiento') }}" required>
                            @error('ordenamiento')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-check mb-3">
                            <input type="checkbox" name="activoCrear" class="form-check-input @error('activoCrear') is-invalid @enderror" id="activoCrear" {{ old('activoCrear', true) ? 'checked' : '' }}>
                            <label for="activoCrear" class="form-check-label">Activo</label>
                            @error('activoCrear')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Crear Subsección</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    $(document).ready(function() {
        // Convertir a slug
        $("#titulo").keyup(function() {
            let text = $(this).val();
            text = text.toLowerCase();
            text = text.normalize('NFD').replace(/[\u0300-\u036f]/g, '');
            text = text.replace(/[^a-zA-Z0-9]+/g, '-');
            text = text.replace(/^-+|-+$/g, ''); 
            console.log('Slugified text: ' + text); // Muestra el texto slugificado
            $("#slug").val(text); 
        });
    });
</script>
@endsection
