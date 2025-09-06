<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class EmpresaController extends Controller
{
    // GET /api/empresas → lista todas las empresas
    public function index()
    {
        try {
            $empresas = Empresa::all();
            return response()->json([
                'success' => true,
                'data' => $empresas
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener las empresas',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // POST /api/empresas → crea una empresa nueva
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'nit' => 'required|string|unique:empresas,nit',
                'nombre' => 'required|string|max:255',
                'direccion' => 'nullable|string|max:255',
                'telefono' => 'nullable|string|max:20',
            ]);

            // estado = Activo por defecto usando constante
            $validated['estado'] = Empresa::ESTADO_ACTIVO;

            $empresa = Empresa::create($validated);

            return response()->json([
                'success' => true,
                'data' => $empresa
            ], 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al crear la empresa',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // GET /api/empresas/{nit} → consulta empresa por NIT
    public function show($nit)
    {
        try {
            $empresa = Empresa::where('nit', $nit)->firstOrFail();

            return response()->json([
                'success' => true,
                'data' => $empresa
            ], 200);

        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Empresa no encontrada'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al consultar la empresa',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // PUT/PATCH /api/empresas/{nit} → actualiza datos de empresa
    public function update(Request $request, $nit)
    {
        try {
            $empresa = Empresa::where('nit', $nit)->firstOrFail();

            $validated = $request->validate([
                'nombre' => 'sometimes|required|string|max:255',
                'direccion' => 'nullable|string|max:255',
                'telefono' => 'nullable|string|max:20',
                'estado' => 'in:' . Empresa::ESTADO_ACTIVO . ',' . Empresa::ESTADO_INACTIVO,
            ]);

            $empresa->update($validated);

            return response()->json([
                'success' => true,
                'data' => $empresa
            ], 200);

        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Empresa no encontrada'
            ], 404);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar la empresa',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // DELETE /api/empresas/{nit} → elimina empresa solo si está inactiva
    public function destroy($nit)
    {
        try {
            $empresa = Empresa::where('nit', $nit)->firstOrFail();

            if ($empresa->estado !== Empresa::ESTADO_INACTIVO) {
                return response()->json([
                    'success' => false,
                    'message' => 'Solo se pueden eliminar empresas inactivas'
                ], 400);
            }

            $empresa->delete();

            return response()->json([
                'success' => true,
                'message' => 'Empresa eliminada correctamente'
            ], 200);

        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Empresa no encontrada'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar la empresa',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // DELETE /api/empresas/inactivas → elimina todas las empresas inactivas
    public function destroyInactivas()
    {
        try {
            // usamos scope del modelo
            $deleted = Empresa::inactivas()->delete();

            return response()->json([
                'success' => true,
                'message' => "$deleted empresas eliminadas"
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar empresas inactivas',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
