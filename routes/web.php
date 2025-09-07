<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmpresaController;

// Home con tabla
Route::get('/', [EmpresaController::class, 'indexWeb'])->name('empresas.index');

// Solo si usarás formularios Blade:
Route::get('/empresas/create', [EmpresaController::class, 'create'])->name('empresas.create');
Route::get('/empresas/{nit}/edit', [EmpresaController::class, 'edit'])->name('empresas.edit');
Route::put('/empresas/{nit}', [EmpresaController::class, 'updateWeb'])->name('empresas.updateWeb');
Route::get('/empresas', [EmpresaController::class, 'indexWeb'])->name('empresas.indexWeb');


// Si tus formularios Blade quieren POST/PUT/DELETE vía WEB en lugar de API,
// puedes añadir estas rutas web. Si no, omítelas y usa fetch a /api/*.
// Route::post('/empresas', [EmpresaController::class, 'store'])->name('web.empresas.store');
// Route::put('/empresas/{nit}', [EmpresaController::class, 'update'])->name('web.empresas.update');
// Route::delete('/empresas/{nit}', [EmpresaController::class, 'destroy'])->name('web.empresas.destroy');
