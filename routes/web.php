<?php

use App\Http\Controllers\PaginaController;
use App\Http\Controllers\SeccionController;
use App\Http\Controllers\SubseccionController;
use App\Http\Controllers\ArchivoController;
use App\Http\Controllers\EnlaceController;
use Illuminate\Support\Facades\Route;

// Módulo de paginas
Route::resource('paginas', PaginaController::class);

// Módulo de archivos
Route::post('archivos', [ArchivoController::class, 'store'])->name('archivos.store');
Route::resource('archivos', ArchivoController::class)->only([
    'store', 'update', 'destroy'
]);

// Módulo de enlaces
Route::post('{type}/{id}/enlaces', [EnlaceController::class, 'store'])->name('enlaces.store');
Route::put('{type}/{id}/enlaces/{enlace}', [EnlaceController::class, 'update'])->name('enlaces.update');
Route::delete('{type}/{id}/enlaces/{enlace}', [EnlaceController::class, 'destroy'])->name('enlaces.destroy');

/* ---------------------------------------- */

// Rutas anidadas para secciones dentro de páginas
Route::resource('paginas.secciones', SeccionController::class)->except(['index', 'show']);

// Rutas anidadas para subsecciones dentro de secciones
Route::resource('secciones.subsecciones', SubseccionController::class)->except(['index', 'show']);

// Rutas para archivos y enlaces, anidadas dentro de páginas, secciones y subsecciones
Route::resource('paginas.archivos', ArchivoController::class)->only(['store', 'destroy']);

Route::resource('secciones.archivos', ArchivoController::class)->only(['store', 'destroy']);
Route::resource('secciones.enlaces', EnlaceController::class)->only(['store', 'destroy']);
Route::resource('subsecciones.archivos', ArchivoController::class)->only(['store', 'destroy']);
Route::resource('subsecciones.enlaces', EnlaceController::class)->only(['store', 'destroy']);

