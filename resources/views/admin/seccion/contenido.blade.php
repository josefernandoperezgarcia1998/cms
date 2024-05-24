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
            <li class="breadcrumb-item"><a href="{{ route('paginas.secciones.index', $pagina) }}">Secciones</a></li>
            <li class="breadcrumb-item active" aria-current="page">Contenido</li>
        </ol>
    </nav>

    <h1 class="my-4 text-center">Contenido de la Sección: {{ $seccion->titulo }}</h1>

    <!-- Información de la página y sección -->
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Página: {{ $pagina->titulo }}</h5>
            <h6 class="card-subtitle mb-2 text-muted">Sección: {{ $seccion->titulo }}</h6>
        </div>
    </div>

    <!-- Archivos -->
    <h2 class="my-4 text-center">Archivos</h2>
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card shadow rounded-3">
                <div class="card-header">Subir Archivo</div>
                <div class="card-body">
                    <form action="{{ route('archivos.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="entity_id" value="{{ $seccion->id }}">
                        <input type="hidden" name="entity_type" value="seccion">
                        <div class="mb-3">
                            <label for="nombreArchivo" class="form-label">Nombre del Archivo</label>
                            <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror" id="nombreArchivo" value="{{ old('nombre') }}" required>
                            @error('nombre')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="archivo" class="form-label">Archivo</label>
                            <input type="file" name="archivo" class="form-control @error('archivo') is-invalid @enderror" id="archivo" required>
                            @error('archivo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="ordenamientoArchivo" class="form-label">Ordenamiento</label>
                            <input type="number" name="ordenamiento" class="form-control @error('ordenamiento') is-invalid @enderror" id="ordenamientoArchivo" value="{{ old('ordenamiento') }}" required>
                            @error('ordenamiento')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-check mb-3">
                            <input type="checkbox" name="activoArchivo" class="form-check-input @error('activoArchivo') is-invalid @enderror" id="activoArchivo" {{ old('activoArchivo', true) ? 'checked' : '' }}>
                            <label for="activoArchivo" class="form-check-label">Activo</label>
                            @error('activoArchivo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Subir Archivo</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow rounded-3">
                <div class="card-header">Listado de Archivos</div>
                <div class="card-body">
                    @if($archivos->isEmpty())
                        <p class="text-center">No hay archivos.</p>
                    @else
                        <table class="table table-hover table-responsive-sm text-center">
                            <thead class="table-dark">
                                <tr>
                                    <th>Nombre</th>
                                    <th>Ordenamiento</th>
                                    <th>Activo</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($archivos as $archivo)
                                <tr>
                                    <td>{{ $archivo->nombre }}</td>
                                    <td>{{ $archivo->ordenamiento }}</td>
                                    <td>{{ $archivo->activo ? 'Sí' : 'No' }}</td>
                                    <td class="d-flex justify-content-center flex-wrap">
                                        <button type="button" class="btn btn-info btn-sm me-1 mb-1" data-bs-toggle="modal" data-bs-target="#viewFileModal{{ $archivo->id }}">Ver</button>
                                        <a href="{{ asset('storage/' . $archivo->path) }}" class="btn btn-success btn-sm me-1 mb-1" download>Descargar</a>
                                        <button type="button" class="btn btn-warning btn-sm me-1 mb-1" data-bs-toggle="modal" data-bs-target="#updateFileModal{{ $archivo->id }}">Actualizar</button>
                                        <button type="button" class="btn btn-danger btn-sm mb-1" data-bs-toggle="modal" data-bs-target="#deleteFileModal{{ $archivo->id }}">Eliminar</button>
                                    </td>
                                </tr>

                                <!-- Modal para ver archivo -->
                                <div class="modal fade" id="viewFileModal{{ $archivo->id }}" tabindex="-1" aria-labelledby="viewFileModalLabel{{ $archivo->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="viewFileModalLabel{{ $archivo->id }}">{{ $archivo->nombre }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                @if(in_array($archivo->tipo, ['pdf']))
                                                    <iframe src="{{ asset('storage/' . $archivo->path) }}" frameborder="0" width="100%" height="500px"></iframe>
                                                @else
                                                    <p>Tipo de archivo no soportado para vista previa.</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Modal para actualizar archivo -->
                                <div class="modal fade" id="updateFileModal{{ $archivo->id }}" tabindex="-1" aria-labelledby="updateFileModalLabel{{ $archivo->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="updateFileModalLabel{{ $archivo->id }}">Actualizar Archivo: {{ $archivo->nombre }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form action="{{ route('archivos.update', $archivo->id) }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label for="nombre" class="form-label">Nombre del Archivo</label>
                                                        <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror" value="{{ old('nombre', $archivo->nombre) }}" required>
                                                        @error('nombre')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="archivo" class="form-label">Archivo (opcional) <small><b>(Tamaño MÁXIMO 20MB)</b></small></label>
                                                        <input type="file" name="archivo" class="form-control @error('archivo') is-invalid @enderror">
                                                        @error('archivo')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="ordenamiento" class="form-label">Ordenamiento</label>
                                                        <input type="number" name="ordenamiento" class="form-control @error('ordenamiento') is-invalid @enderror" value="{{ old('ordenamiento', $archivo->ordenamiento) }}" required>
                                                        @error('ordenamiento')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="form-check mb-3">
                                                        <input type="checkbox" name="activoArchivoEditar" class="form-check-input @error('activoArchivoEditar') is-invalid @enderror" id="activoArchivoEditar{{ $archivo->id }}" {{ old('activoArchivoEditar', $archivo->activo) ? 'checked' : '' }}>
                                                        <label for="activoArchivoEditar{{ $archivo->id }}" class="form-check-label">Activo</label>
                                                        @error('activoArchivoEditar')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                                    <button type="submit" class="btn btn-primary">Actualizar Archivo</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!-- Modal para confirmar eliminación -->
                                <div class="modal fade" id="deleteFileModal{{ $archivo->id }}" tabindex="-1" aria-labelledby="deleteFileModalLabel{{ $archivo->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deleteFileModalLabel{{ $archivo->id }}">Confirmar Eliminación</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p>¿Está seguro de que desea eliminar el archivo "<strong>{{ $archivo->nombre }}</strong>" de la sección "<strong>{{ $seccion->titulo }}</strong>" de la página "<strong>{{ $pagina->titulo }}</strong>"?</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                <form action="{{ route('archivos.destroy', $archivo->id) }}" method="POST" style="display:inline;">
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
                    {{ $archivos->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>

    <!-- Enlaces -->
    <h2 class="my-4 text-center">Enlaces</h2>
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card shadow rounded-3">
                <div class="card-header">Agregar Enlace</div>
                <div class="card-body">
                    <form action="{{ route('enlaces.store', ['type' => 'seccion', 'id' => $seccion->id]) }}" method="POST">
                        @csrf
                        <input type="hidden" name="entity_id" value="{{ $seccion->id }}">
                        <input type="hidden" name="entity_type" value="seccion">
                        <div class="mb-3">
                            <label for="nombreEnlace" class="form-label">Nombre del Enlace</label>
                            <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror" id="nombreEnlace" value="{{ old('nombre') }}" required>
                            @error('nombre')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="urlEnlace" class="form-label">URL del Enlace</label>
                            <input type="url" name="url" class="form-control @error('url') is-invalid @enderror" id="urlEnlace" value="{{ old('url') }}" required>
                            @error('url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="ordenamientoEnlace" class="form-label">Ordenamiento</label>
                            <input type="number" name="ordenamiento" class="form-control @error('ordenamiento') is-invalid @enderror" id="ordenamientoEnlace" value="{{ old('ordenamiento') }}" required>
                            @error('ordenamiento')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-check mb-3">
                            <input type="checkbox" name="activoEnlace" class="form-check-input @error('activoEnlace') is-invalid @enderror" id="activoEnlace" {{ old('activoEnlace', true) ? 'checked' : '' }}>
                            <label for="activoEnlace" class="form-check-label">Activo</label>
                            @error('activoEnlace')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Agregar Enlace</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow rounded-3">
                <div class="card-header">Listado de Enlaces</div>
                <div class="card-body">
                    @if($enlaces->isEmpty())
                        <p class="text-center">No hay enlaces.</p>
                    @else
                        <table class="table table-hover table-responsive-sm text-center">
                            <thead class="table-dark">
                                <tr>
                                    <th>Nombre</th>
                                    <th>URL</th>
                                    <th>Activo</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($enlaces as $enlace)
                                <tr>
                                    <td>{{ $enlace->nombre }}</td>
                                    <td><a href="{{ $enlace->url }}" target="_blank">{{ $enlace->url }}</a></td>
                                    <td>{{ $enlace->activo ? 'Sí' : 'No' }}</td>
                                    <td class="d-flex justify-content-center flex-wrap">
                                        <button type="button" class="btn btn-warning btn-sm me-1 mb-1" data-bs-toggle="modal" data-bs-target="#editEnlaceModal{{ $enlace->id }}">Editar</button>
                                        <form action="{{ route('enlaces.destroy', ['type' => 'seccion', 'id' => $seccion->id, 'enlace' => $enlace->id]) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm mb-1">Eliminar</button>
                                        </form>
                                    </td>
                                </tr>

                                <!-- Modal para editar enlace -->
                                <div class="modal fade" id="editEnlaceModal{{ $enlace->id }}" tabindex="-1" aria-labelledby="editEnlaceModalLabel{{ $enlace->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editEnlaceModalLabel{{ $enlace->id }}">Editar Enlace</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form action="{{ route('enlaces.update', ['type' => 'seccion', 'id' => $seccion->id, 'enlace' => $enlace->id]) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label for="nombreEnlace{{ $enlace->id }}" class="form-label">Nombre del Enlace</label>
                                                        <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror" id="nombreEnlace{{ $enlace->id }}" value="{{ old('nombre', $enlace->nombre) }}" required>
                                                        @error('nombre')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="urlEnlace{{ $enlace->id }}" class="form-label">URL del Enlace</label>
                                                        <input type="url" name="url" class="form-control @error('url') is-invalid @enderror" id="urlEnlace{{ $enlace->id }}" value="{{ old('url', $enlace->url) }}" required>
                                                        @error('url')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="ordenamientoEnlace{{ $enlace->id }}" class="form-label">Ordenamiento</label>
                                                        <input type="number" name="ordenamiento" class="form-control @error('ordenamiento') is-invalid @enderror" id="ordenamientoEnlace{{ $enlace->id }}" value="{{ old('ordenamiento', $enlace->ordenamiento) }}" required>
                                                        @error('ordenamiento')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="form-check mb-3">
                                                        <input type="checkbox" name="activoEnlaceEditar" class="form-check-input @error('activoEnlaceEditar') is-invalid @enderror" id="activoEnlaceEditar{{ $enlace->id }}" {{ old('activoEnlaceEditar', $enlace->activo) ? 'checked' : '' }}>
                                                        <label for="activoEnlaceEditar{{ $enlace->id }}" class="form-check-label">Activo</label>
                                                        @error('activoEnlaceEditar')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                                    <button type="submit" class="btn btn-primary">Actualizar Enlace</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
                <div class="card-footer d-flex justify-content-center">
                    {{ $enlaces->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
