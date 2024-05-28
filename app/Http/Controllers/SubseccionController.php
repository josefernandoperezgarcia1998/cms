<?php

namespace App\Http\Controllers;

use App\Models\Seccion;
use App\Models\Subseccion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SubseccionController extends Controller
{
    public function index(Request $request, Seccion $seccion)
    {
        // Validar el campo de búsqueda
        $request->validate([
            'search' => 'nullable|string|max:255',
        ]);

        $search = $request->input('search', '');

        $query = $seccion->subsecciones();
        
        if (!empty($search)) {
            $query->where('titulo', 'like', "%{$search}%");
        }
        
        $subsecciones = $query->paginate(10);
    
        return view('admin.subsecciones.index', compact('seccion', 'subsecciones', 'search'));
    }

    public function create(Seccion $seccion)
    {
        return view('admin.subsecciones.create', compact('seccion'));
    }

    public function store(Request $request, Seccion $seccion)
    {
        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'slug' => 'required|string',
            'ordenamiento' => 'required|integer',
        ]);

        $validated['activo'] = $request->has('activoCrear');

        $seccion->subsecciones()->create($validated);
        return redirect()->route('secciones.subsecciones.index', $seccion)->with('success', 'Subsección creada correctamente.');
    }

    public function edit(Seccion $seccion, Subseccion $subseccion)
    {
        return view('admin.subsecciones.edit', compact('seccion', 'subseccion'));
    }

    public function update(Request $request, Seccion $seccion, Subseccion $subseccion)
    {
        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'ordenamiento' => 'required|integer',
        ]);
        
        $validated['activo'] = $request->has('activoEditar');
        
        $subseccion->update($validated);
        return redirect()->route('secciones.subsecciones.index', $seccion)->with('success', 'Subsección actualizada correctamente.');
    }

    public function destroy(Seccion $seccion, Subseccion $subseccion)
    {
        try {
            // Eliminar archivos relacionados
            foreach ($subseccion->archivos as $archivo) {
                Storage::disk('public')->delete($archivo->path); // Eliminar archivo del almacenamiento
                $archivo->delete(); // Eliminar registro del archivo
            }

            // Eliminar enlaces relacionados
            foreach ($subseccion->enlaces as $enlace) {
                $enlace->delete(); // Eliminar registro del enlace
            }

            // Eliminar el directorio de la subsección en el almacenamiento
            $paginaSlug = Str::slug($seccion->pagina->slug);
            $seccionSlug = Str::slug($seccion->slug);
            $subseccionSlug = Str::slug($subseccion->slug);
            $directoryPath = "paginas/{$paginaSlug}/secciones/{$seccionSlug}/subsecciones/{$subseccionSlug}";
            if (Storage::disk('public')->exists($directoryPath)) {
                Storage::disk('public')->deleteDirectory($directoryPath);
            }

            // Finalmente, eliminar la subsección
            $subseccion->delete();

            return redirect()->route('secciones.subsecciones.index', $seccion)->with('success', 'Subsección y sus archivos eliminados correctamente.');
        } catch (\Exception $e) {
            return redirect()->route('secciones.subsecciones.index', $seccion)->with('error', 'Hubo un problema al eliminar la subsección: ' . $e->getMessage());
        }
    }

    public function contenido(Seccion $seccion, Subseccion $subseccion)
    {
        $archivos = $subseccion->archivos()->paginate(10);
        $enlaces = $subseccion->enlaces()->paginate(10);

        return view('admin.subsecciones.contenido', compact('seccion', 'subseccion', 'archivos', 'enlaces'));
    }
}
