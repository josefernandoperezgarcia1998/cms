@extends('layouts.app')

@section('content')
<div class="container">
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <h1 class="my-4 text-center">Editar Página</h1>
    <div class="card shadow rounded-3 mb-4">
        <div class="card-body">
            <form action="{{ route('paginas.update', $pagina) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="titulo" class="form-label">Título</label>
                    <input type="text" name="titulo" class="form-control @error('titulo') is-invalid @enderror" value="{{ old('titulo', $pagina->titulo) }}" required>
                    @error('titulo')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="slug" class="form-label">Slug</label>
                    <input type="text" name="slug" class="form-control @error('slug') is-invalid @enderror" value="{{ old('slug', $pagina->slug) }}" readonly required>
                    @error('slug')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="imagen_destacada" class="form-label">Imagen Destacada</label>
                    <div class="d-flex">
                        <input type="file" name="imagen_destacada" class="form-control @error('imagen_destacada') is-invalid @enderror">
                    </div>
                    @if ($pagina->imagen_destacada)
                        <label class="bg-success text-white rounded-3" data-bs-toggle="modal" data-bs-target="#viewImageModal">&nbsp;Ver Imagen&nbsp;</label>
                    @endif
                    @error('imagen_destacada')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="contenido" class="form-label">Contenido</label>
                    <textarea name="contenido" id="contenido" class="form-control @error('contenido') is-invalid @enderror">{{ old('contenido', $pagina->contenido) }}</textarea>
                    @error('contenido')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="fecha_actualizacion" class="form-label">Fecha de Actualización</label>
                    <input type="date" name="fecha_actualizacion" class="form-control @error('fecha_actualizacion') is-invalid @enderror" value="{{ old('fecha_actualizacion', $pagina->fecha_actualizacion ? \Illuminate\Support\Carbon::parse($pagina->fecha_actualizacion)->format('Y-m-d') : '') }}">
                    @error('fecha_actualizacion')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="fuente" class="form-label">Fuente</label>
                    <input type="text" name="fuente" class="form-control @error('fuente') is-invalid @enderror" value="{{ old('fuente', $pagina->fuente) }}">
                    @error('fuente')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-check mb-3">
                    <input type="checkbox" name="activo" class="form-check-input @error('activo') is-invalid @enderror" id="activo" {{ old('activo', $pagina->activo) ? 'checked' : '' }}>
                    <label for="activo" class="form-check-label">Activo</label>
                    @error('activo')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
            </form>
        </div>
    </div>

    @if ($pagina->imagen_destacada)
        <!-- Modal para ver imagen destacada -->
        <div class="modal fade" id="viewImageModal" tabindex="-1" aria-labelledby="viewImageModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="viewImageModalLabel">Imagen Destacada</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                        <img src="{{ asset('storage/' . $pagina->imagen_destacada) }}" alt="Imagen Destacada" class="img-fluid">
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Sección de Secciones -->
    {{-- <h2 class="my-4 text-center">Secciones</h2>
    <div class="row">
        <div class="col-md-6">
            <div class="card shadow rounded-3 mb-4">
                <div class="card-header">
                    <h3>Crear Sección</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('paginas.secciones.store', $pagina) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="titulo" class="form-label">Título de la Sección</label>
                            <input type="text" name="titulo" class="form-control @error('titulo') is-invalid @enderror" value="{{ old('titulo') }}" required>
                            @error('titulo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="ordenamiento" class="form-label">Ordenamiento</label>
                            <input type="number" name="ordenamiento" class="form-control @error('ordenamiento') is-invalid @enderror" value="{{ old('ordenamiento') }}" required>
                            @error('ordenamiento')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-check mb-3">
                            <input type="checkbox" name="activo" class="form-check-input @error('activo') is-invalid @enderror" id="activoSeccion" {{ old('activo', true) ? 'checked' : '' }}>
                            <label for="activoSeccion" class="form-check-label">Activo</label>
                            @error('activo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Crear Sección</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow rounded-3 mb-4">
                <div class="card-header">
                    <h3>Lista de Secciones</h3>
                </div>
                <div class="card-body">
                    @if ($pagina->secciones->count())
                    <ul class="list-group">
                        @foreach($pagina->secciones as $seccion)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ $seccion->titulo }}
                            <div>
                                <a href="{{ route('paginas.secciones.edit', [$pagina, $seccion]) }}" class="btn btn-warning btn-sm">Editar</a>
                                <form action="{{ route('paginas.secciones.destroy', [$pagina, $seccion]) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                                </form>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                    @else
                    <p>No se encontraron secciones.</p>
                    @endif
                </div>
            </div>
        </div>
    </div> --}}

    <!-- Sección de Archivos -->
    <h2 class="my-4 text-center">Archivos</h2>
    <div class="row">
        <div class="col-md-6">
            <div class="card shadow rounded-3 mb-4">
                <div class="card-header">
                    <h3>Archivos</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('archivos.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="entity_id" value="{{ $pagina->id }}">
                        <input type="hidden" name="entity_type" value="pagina">
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre del Archivo</label>
                            <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror" value="{{ old('nombre') }}" required>
                            @error('nombre')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="archivo" class="form-label">Archivo <small><b>(Tamaño MÁXIMO 20MB)</b></small></label>
                            <input type="file" name="archivo" class="form-control @error('archivo') is-invalid @enderror" required>
                            @error('archivo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="ordenamiento" class="form-label">Ordenamiento</label>
                            <input type="number" name="ordenamiento" class="form-control @error('ordenamiento') is-invalid @enderror" value="{{ old('ordenamiento') }}" required>
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
                        <button type="submit" class="btn btn-primary">Agregar Archivo</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow rounded-3 mb-4">
                <div class="card-header">
                    <h3>Lista de Archivos</h3>
                </div>
                <div class="card-body">
                    @if ($archivos->count())
                    <ul class="list-group mb-3">
                        @foreach($archivos as $archivo)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ $archivo->nombre }} ({{ $archivo->tipo }})
                            <div>
                                <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#viewFileModal{{ $archivo->id }}">Ver</button>
                                <a href="{{ asset('storage/' . $archivo->path) }}" class="btn btn-primary btn-sm" download>Descargar</a>
                                <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#updateFileModal{{ $archivo->id }}">Actualizar</button>
                                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteFileModal{{ $archivo->id }}">Eliminar</button>
                            </div>
                        </li>

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
                                        <p>¿Está seguro de que desea eliminar el archivo "<strong>{{ $archivo->nombre }}</strong>" de la página "<strong>{{ $pagina->titulo }}</strong>"?</p>
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
                    </ul>
                    <div class="d-flex justify-content-center">
                        {{ $archivos->appends(['enlacesPage' => request()->enlacesPage])->links('pagination::bootstrap-5') }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Sección de Enlaces -->
    <h2 class="my-4 text-center">Enlaces</h2>
    <div class="row">
        <div class="col-md-6">
            <div class="card shadow rounded-3 mb-4">
                <div class="card-header">
                    <h3>Enlaces</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('enlaces.store', ['type' => 'pagina', 'id' => $pagina->id]) }}" method="POST">
                        @csrf
                        <input type="hidden" name="entity_id" value="{{ $pagina->id }}">
                        <input type="hidden" name="entity_type" value="pagina">
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre del Enlace</label>
                            <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror" value="{{ old('nombre') }}" required>
                            @error('nombre')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="url" class="form-label">URL del Enlace</label>
                            <input type="url" name="url" class="form-control @error('url') is-invalid @enderror" value="{{ old('url') }}" required>
                            @error('url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="ordenamiento" class="form-label">Ordenamiento</label>
                            <input type="number" name="ordenamiento" class="form-control @error('ordenamiento') is-invalid @enderror" value="{{ old('ordenamiento') }}" required>
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
            <div class="card shadow rounded-3 mb-4">
                <div class="card-header">
                    <h3>Lista de Enlaces</h3>
                </div>
                <div class="card-body">
                    @if ($enlaces->count())
                    <ul class="list-group">
                        @foreach($enlaces as $enlace)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <a href="{{ $enlace->url }}" target="_blank">{{ $enlace->nombre }}</a>
                            <div>
                                <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#updateEnlaceModal{{ $enlace->id }}">Actualizar</button>
                                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteEnlaceModal{{ $enlace->id }}">Eliminar</button>
                            </div>
                        </li>

                        <!-- Modal para actualizar enlace -->
                        <div class="modal fade" id="updateEnlaceModal{{ $enlace->id }}" tabindex="-1" aria-labelledby="updateEnlaceModalLabel{{ $enlace->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="updateEnlaceModalLabel{{ $enlace->id }}">Actualizar Enlace: {{ $enlace->nombre }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="{{ route('enlaces.update', ['type' => 'pagina', 'id' => $pagina->id, 'enlace' => $enlace->id]) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="nombre" class="form-label">Nombre del Enlace</label>
                                                <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror" value="{{ old('nombre', $enlace->nombre) }}" required>
                                                @error('nombre')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="mb-3">
                                                <label for="url" class="form-label">URL del Enlace</label>
                                                <input type="url" name="url" class="form-control @error('url') is-invalid @enderror" value="{{ old('url', $enlace->url) }}" required>
                                                @error('url')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="mb-3">
                                                <label for="ordenamiento" class="form-label">Ordenamiento</label>
                                                <input type="number" name="ordenamiento" class="form-control @error('ordenamiento') is-invalid @enderror" value="{{ old('ordenamiento', $enlace->ordenamiento) }}" required>
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

                        <!-- Modal para confirmar eliminación -->
                        <div class="modal fade" id="deleteEnlaceModal{{ $enlace->id }}" tabindex="-1" aria-labelledby="deleteEnlaceModalLabel{{ $enlace->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="deleteEnlaceModalLabel{{ $enlace->id }}">Confirmar Eliminación</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>¿Está seguro de que desea eliminar el enlace "<strong>{{ $enlace->nombre }}</strong>" de la página "<strong>{{ $pagina->titulo }}</strong>"?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                        <form action="{{ route('enlaces.destroy', ['type' => 'pagina', 'id' => $pagina->id, 'enlace' => $enlace->id]) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Eliminar</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </ul>
                    <div class="d-flex justify-content-center">
                        {{ $enlaces->appends(['archivosPage' => request()->archivosPage])->links('pagination::bootstrap-5') }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection

@section('js')
<script>
    $(document).ready(function() {
        // Cargar CKEditor
        ClassicEditor.create(document.querySelector("#contenido"), {
            ckfinder: {
                uploadUrl: "{{ route('ckeditor.upload') . '?_token=' . csrf_token() }}"
            },
            toolbar: [
                "heading", "|", "bold", "italic", "link", "bulletedList", "numberedList", "blockQuote", "|", "insertTable", "tableColumn", "tableRow", "mergeTableCells", "|", "undo", "redo", "imageUpload"
            ]
        })
        .then(editor => {
            const model = editor.model;
            const doc = model.document;

            doc.on("change:data", () => {
                model.change(writer => {
                    for (const item of doc.getRoot().getChildren()) {
                        if (item.is("element", "paragraph")) {
                            for (const link of item.getChildren()) {
                                if (link.is("element", "a")) {
                                    const href = link.getAttribute("href");
                                    if (href && !href.startsWith("http://") && !href.startsWith("https://")) {
                                        writer.setAttribute("href", "http://" + href, link);
                                    }
                                }
                            }
                        }
                    }
                });
            });
        })
        .catch(error => {
            console.error(error);
        });
    });
</script>
@endsection
