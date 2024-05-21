<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seccion extends Model
{
    use HasFactory;

    protected $fillable = [
        'pagina_id', 'titulo', 'ordenamiento', 'activo'
    ];

    public function subsecciones()
    {
        return $this->hasMany(Subseccion::class);
    }

    public function archivos()
    {
        return $this->morphMany(Archivo::class, 'archivable');
    }

    public function pagina()
    {
        return $this->belongsTo(Pagina::class);
    }
}
