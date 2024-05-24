@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-4 text-center">Crear Página</h1>
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
            <form action="{{ route('paginas.store') }}" method="POST" enctype="multipart/form-data">
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
                    <label for="imagen_destacada" class="form-label">Imagen Destacada</label>
                    <input type="file" name="imagen_destacada" class="form-control @error('imagen_destacada') is-invalid @enderror">
                    @error('imagen_destacada')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="contenido" class="form-label">Contenido</label>
                    <textarea name="contenido" id="contenido" class="form-control @error('contenido') is-invalid @enderror">{{ old('contenido') }}</textarea>
                    @error('contenido')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="fecha_actualizacion" class="form-label">Fecha de Actualización</label>
                    <input type="date" name="fecha_actualizacion" class="form-control @error('fecha_actualizacion') is-invalid @enderror" value="{{ old('fecha_actualizacion') }}" required>
                    @error('fecha_actualizacion')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="fuente" class="form-label">Fuente</label>
                    <input type="text" name="fuente" class="form-control @error('fuente') is-invalid @enderror" value="{{ old('fuente') }}" required>
                    @error('fuente')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-check mb-3">
                    <input type="checkbox" name="activo" class="form-check-input" id="activo" {{ old('activo', true) ? 'checked' : '' }}>
                    <label for="activo" class="form-check-label">Activo</label>
                </div>
                <div>
                    <a href="{{ route('paginas.index') }}" class="btn btn-secondary">Regresar</a>
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
            text = text.normalize('NFD').replace(/[\u0300-\u036f]/g, ''); // Remove diacritics
            text = text.replace(/[^a-zA-Z0-9]+/g, '-');
            text = text.replace(/^-+|-+$/g, ''); // Remove leading or trailing hyphens
            $("#slug").val(text);        
        });

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
