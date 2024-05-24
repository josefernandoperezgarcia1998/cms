<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('paginas', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->string('imagen_destacada')->nullable();
            $table->text('contenido')->nullable();
            $table->string('slug');
            $table->string('seo_titulo')->nullable();
            $table->string('seo_keywords')->nullable();
            $table->string('seo_descripcion')->nullable();
            $table->timestamp('fecha_actualizacion')->nullable();
            $table->string('fuente')->nullable();
            $table->boolean('activo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paginas');
    }
};
