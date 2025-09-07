<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class EmpresaController extends Controller
{
    // ---------- API (JSON) ----------
    public function index(): JsonResponse
    {
        try {
            $empresas = Empresa::all();
            return response()->json([
                'success' => true,
                'data' => $empresas,
            ], 200);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener las empresas',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'nit'       => 'required|unique:empresas,nit',
            'nombre'    => 'required',
            'direccion' => 'nullable',
            'telefono'  => 'nullable',
            'estado'    => 'in:Activo,Inactivo',
        ]);

    // Valor por defecto si no viene
        if (!isset($validated['estado'])) {
            $validated['estado'] = 'Activo';
        }

        $empresa = Empresa::create($validated);

        return response()->json([
            'success' => true,
            'data' => $empresa,
        ], 201);                                                                                                        
        }


    public function show(string $nit): JsonResponse
    {
        $empresa = Empresa::where('nit', $nit)->first();

        if (!$empresa) {
            return response()->json([
                'success' => false,
                'message' => 'Empresa no encontrada',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $empresa,
        ], 200);
    }

    public function update(Request $request, string $nit): JsonResponse
    {
        $empresa = Empresa::where('nit', $nit)->first();

        if (!$empresa) {
            return response()->json([
                'success' => false,
                'message' => 'Empresa no encontrada',
            ], 404);
        }

        $validated = $request->validate([
            'nit'       => 'sometimes|required|unique:empresas,nit,' . $empresa->id,
            'nombre'    => 'sometimes|required',
            'direccion' => 'nullable',
            'telefono'  => 'nullable',
            'estado'    => 'in:Activo,Inactivo',
        ]);


        $empresa->update($validated);

        return response()->json([
            'success' => true,
            'data' => $empresa,
        ], 200);
    }

    // FRONTEND - Actualizar empresa desde el formulario
    public function updateWeb(Request $request, $nit)
    {
        $empresa = Empresa::where('nit', $nit)->firstOrFail();

        $validated = $request->validate([
            'nombre' =>'required',
            'direccion' =>'nullable',
            'telefono' =>'nullable',
            'estado' =>'in:Activo,Inactivo',
    ]);

        $empresa->update($validated);

        return redirect()->route('empresas.indexWeb')
                        ->with('success', 'Empresa actualizada correctamente');
}

    // Eliminar por NIT solo si está Inactiva (según tus tests)
    public function destroy(string $nit): JsonResponse
    {
        $empresa = Empresa::where('nit', $nit)->first();

        if (!$empresa) {
            return response()->json([
                'success' => false,
                'message' => 'Empresa no encontrada',
            ], 404);
        }

        if ($empresa->estado !== 'Inactivo') {
            return response()->json([
                'success' => false,
                'message' => 'Solo se pueden eliminar empresas inactivas',
            ], 422);
        }

        $empresa->delete();

        return response()->json([
            'success' => true,
            'message' => 'Empresa eliminada correctamente',
        ], 200);
    }

    public function destroyInactivas(): JsonResponse
    {
        $deleted = Empresa::where('estado', 'Inactivo')->delete();

        return response()->json([
            'success' => true,
            'deleted' => $deleted,
        ], 200);
    }

    // ---------- WEB (Blade) ----------
    public function indexWeb()
    {
        $empresas = Empresa::all();
        return view('welcome', compact('empresas'));
    }

    public function create()
    {
        return view('empresas.create');
    }

    public function edit(string $nit)
    {
        $empresa = Empresa::where('nit', $nit)->firstOrFail();
        return view('empresas.edit', compact('empresa'));
    }
}
