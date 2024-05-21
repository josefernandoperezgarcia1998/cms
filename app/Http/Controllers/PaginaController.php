<?php

namespace App\Http\Controllers;

use App\Models\Pagina;
use Illuminate\Http\Request;

class PaginaController extends Controller
{
    public function index()
    {
        $paginas = Pagina::all();
        return view('admin.paginas.index', compact('paginas'));
    }

    public function create()
    {
        return view('admin.paginas.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'imagen_destacada' => 'nullable|string',
            'contenido' => 'nullable|string',
            'slug' => 'required|string',
            'fecha_actualizacion' => 'nullable|date',
            'fuente' => 'nullable|string|max:255',
        ]);
    
        $validated['activo'] = $request->has('activo');
    
        Pagina::create($validated);
        return redirect()->route('paginas.index');
    }
    

    public function edit(Pagina $pagina)
    {
        // Cargar relaciones
        $pagina->load('archivos', 'enlaces');
        return view('admin.paginas.edit', compact('pagina'));
    }

    public function show(Pagina $pagina)
    {
        return view('admin.paginas.show', compact('pagina'));
    }

    public function update(Request $request, Pagina $pagina)
    {
        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'imagen_destacada' => 'nullable|string',
            'contenido' => 'nullable|string',
            'slug' => 'required|string|unique:paginas,slug,' . $pagina->id,
            'fecha_actualizacion' => 'nullable|date',
            'fuente' => 'nullable|string|max:255',
        ]);
    
        $validated['activo'] = $request->has('activo');
    
        $pagina->update($validated);
    
        return redirect()->route('paginas.edit', $pagina->id)->with('success', 'Cambios aplicados a la página de forma correcta');
    }
    

    public function destroy(Pagina $pagina)
    {
        $pagina->delete();
        return redirect()->route('paginas.index');
    }
}
