<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmpresaController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::delete('empresas/inactivas', [EmpresaController::class, 'destroyInactivas']);

// sin destroy
Route::apiResource('empresas', EmpresaController::class)->except(['destroy']);

// Borrar empresa por NIT
Route::delete('empresas/{nit}', [EmpresaController::class, 'destroy']);
