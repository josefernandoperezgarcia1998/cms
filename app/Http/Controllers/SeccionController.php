<?php

namespace App\Http\Controllers;

use App\Models\Pagina;
use App\Models\Seccion;
use Illuminate\Http\Request;

class SeccionController extends Controller
{
    public function create(Pagina $pagina)
    {
        return view('admin.secciones.create', compact('pagina'));
    }

    public function store(Request $request, Pagina $pagina)
    {
        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'ordenamiento' => 'required|integer',
            'activo' => 'boolean',
        ]);

        $pagina->secciones()->create($validated);
        return redirect()->route('paginas.edit', $pagina);
    }

    public function edit(Seccion $seccion)
    {
        return view('admin.secciones.edit', compact('seccion'));
    }

    public function update(Request $request, Seccion $seccion)
    {
        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'ordenamiento' => 'required|integer',
            'activo' => 'boolean',
        ]);

        $seccion->update($validated);
        return redirect()->route('paginas.edit', $seccion->pagina);
    }

    public function destroy(Seccion $seccion)
    {
        $pagina = $seccion->pagina;
        $seccion->delete();
        return redirect()->route('paginas.edit', $pagina);
    }
}
