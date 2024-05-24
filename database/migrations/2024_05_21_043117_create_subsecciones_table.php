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
        Schema::create('subsecciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seccion_id')->constrained('secciones');
            $table->string('titulo');
            $table->string('slug');
            $table->integer('ordenamiento');
            $table->boolean('activo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subsecciones');
    }
};
