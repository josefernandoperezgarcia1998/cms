<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pagina extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo', 'imagen_destacada', 'contenido', 'slug', 'seo_titulo', 'seo_descripcion', 'seo_keywords', 'fecha_actualizacion', 'fuente', 'activo'
    ];

    protected $casts = [
        'fecha_actualizacion' => 'datetime',
    ];
    
    public function archivos()
    {
        return $this->hasMany(Archivo::class);
    }

    public function enlaces()
    {
        return $this->hasMany(Enlace::class);
    }

    public function secciones()
    {
        return $this->hasMany(Seccion::class);
    }
}