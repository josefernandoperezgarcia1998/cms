<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subseccion extends Model
{
    use HasFactory;

    protected $fillable = [
        'seccion_id', 'titulo', 'slug', 'ordenamiento', 'activo'
    ];

    protected $table = 'subsecciones';

    public function archivos()
    {
        return $this->hasMany(Archivo::class);
    }

    public function enlaces()
    {
        return $this->hasMany(Enlace::class);
    }

    public function seccion()
    {
        return $this->belongsTo(Seccion::class);
    }
}
