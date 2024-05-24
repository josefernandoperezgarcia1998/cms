<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seccion extends Model
{
    use HasFactory;

    protected $fillable = [
        'pagina_id', 'titulo', 'slug', 'ordenamiento', 'activo'
    ];

    protected $table = 'secciones';

    public function subsecciones()
    {
        return $this->hasMany(Subseccion::class);
    }

    public function archivos()
    {
        return $this->hasMany(Archivo::class);
    }

    public function enlaces()
    {
        return $this->hasMany(Enlace::class);
    }

    public function pagina()
    {
        return $this->belongsTo(Pagina::class);
    }
}
