<?php
namespace App\Http\Controllers;

use App\Models\Seccion;
use App\Models\Subseccion;
use Illuminate\Http\Request;

class SubseccionController extends Controller
{
    public function create(Seccion $seccion)
    {
        return view('admin.subsecciones.create', compact('seccion'));
    }

    public function store(Request $request, Seccion $seccion)
    {
        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'ordenamiento' => 'required|integer',
            'activo' => 'boolean',
        ]);

        $seccion->subsecciones()->create($validated);
        return redirect()->route('paginas.edit', $seccion->pagina);
    }

    public function edit(Subseccion $subseccion)
    {
        return view('admin.subsecciones.edit', compact('subseccion'));
    }

    public function update(Request $request, Subseccion $subseccion)
    {
        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'ordenamiento' => 'required|integer',
            'activo' => 'boolean',
        ]);

        $subseccion->update($validated);
        return redirect()->route('paginas.edit', $subseccion->seccion->pagina);
    }

    public function destroy(Subseccion $subseccion)
    {
        $pagina = $subseccion->seccion->pagina;
        $subseccion->delete();
        return redirect()->route('paginas.edit', $pagina);
    }
}