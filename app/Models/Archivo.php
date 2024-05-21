<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Archivo extends Model
{
    use HasFactory;

    protected $fillable = [
        'pagina_id', 'seccion_id', 'subseccion_id', 'nombre', 'path', 'tipo', 'tamaño', 'ordenamiento', 'activo'
    ];

    public function pagina()
    {
        return $this->belongsTo(Pagina::class);
    }

    public function seccion()
    {
        return $this->belongsTo(Seccion::class);
    }

    public function subseccion()
    {
        return $this->belongsTo(Subseccion::class);
    }
}
