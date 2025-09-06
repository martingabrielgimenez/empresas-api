<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmpresaController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Ruta extra para eliminar todas las inactivas (va PRIMERO)
Route::delete('empresas/inactivas', [EmpresaController::class, 'destroyInactivas']);

// CRUD básico sin destroy
Route::apiResource('empresas', EmpresaController::class)->except(['destroy']);

// Borrar empresa por NIT (genérica, va después)
Route::delete('empresas/{nit}', [EmpresaController::class, 'destroy']);
