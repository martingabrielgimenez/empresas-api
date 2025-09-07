<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmpresaController;

// Eliminar todas las inactivas
Route::delete('empresas/inactivas', [EmpresaController::class, 'destroyInactivas']);

// CRUD API (excepto destroy porque lo definimos personalizado por NIT)
Route::apiResource('empresas', EmpresaController::class)->except(['destroy']);

// Eliminar por NIT
Route::delete('empresas/{nit}', [EmpresaController::class, 'destroy']);
