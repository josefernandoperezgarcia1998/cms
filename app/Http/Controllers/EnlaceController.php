<?php

namespace App\Http\Controllers;

use App\Models\Enlace;
use App\Models\Pagina;
use App\Models\Seccion;
use App\Models\Subseccion;
use Illuminate\Http\Request;

class EnlaceController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'url' => 'required|string|url',
            'ordenamiento' => 'required|integer',
            'entity_id' => 'required|integer',
            'entity_type' => 'required|string|in:pagina,seccion,subseccion'
        ]);
    
        $validated['activo'] = $request->has('activoEnlace');
    
        $entityType = $request->input('entity_type');
        $entityId = $request->input('entity_id');
        $entity = $this->getEnlaceable($entityType, $entityId);
    
        $entity->enlaces()->create($validated);
    
        return redirect()->back()->with('success', 'Enlace agregado correctamente');
    }

    public function update(Request $request, $type, $id, Enlace $enlace)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'url' => 'required|string|url',
            'ordenamiento' => 'required|integer',
        ]);

        $validated['activo'] = $request->has('activoEnlaceEditar');

        $enlace->update($validated);
        return redirect()->back()->with('success', 'Enlace actualizado correctamente');
    }

    public function destroy($type, $id, Enlace $enlace)
    {
        $enlace->delete();
        return redirect()->back()->with('success', 'Enlace eliminado correctamente');
    }

    private function getEnlaceable($type, $id)
    {
        switch ($type) {
            case 'pagina':
                return Pagina::findOrFail($id);
            case 'seccion':
                return Seccion::findOrFail($id);
            case 'subseccion':
                return Subseccion::findOrFail($id);
            default:
                throw new \Exception("Invalid type");
        }
    }
}
