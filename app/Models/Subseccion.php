<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subseccion extends Model
{
    use HasFactory;

    protected $fillable = [
        'seccion_id', 'titulo', 'ordenamiento', 'activo'
    ];

    public function archivos()
    {
        return $this->morphMany(Archivo::class, 'archivable');
    }

    public function seccion()
    {
        return $this->belongsTo(Seccion::class);
    }
}
