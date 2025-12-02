<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Dato;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ReclutasController extends Controller
{
    /**
     * Listar todos los reclutas
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        
        $query = Dato::where('status', 'Recluta');

        // Aplicar búsqueda si existe
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('curp', 'LIKE', "%{$search}%")
                  ->orWhere('nombre', 'LIKE', "%{$search}%")
                  ->orWhere('apellido_paterno', 'LIKE', "%{$search}%")
                  ->orWhere('apellido_materno', 'LIKE', "%{$search}%")
                  ->orWhere('clase', 'LIKE', "%{$search}%")
                  ->orWhere('domicilio', 'LIKE', "%{$search}%");
            });
        }

        $reclutas = $query->orderBy('created_at', 'desc')->get();

        return response()->json([
            'success' => true,
            'data' => $reclutas,
            'total' => $reclutas->count()
        ], 200);
    }

    /**
     * Obtener un recluta por CURP
     * 
     * @param string $curp
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($curp)
    {
        $recluta = Dato::where('curp', $curp)
                       ->where('status', 'Recluta')
                       ->first();

        if (!$recluta) {
            return response()->json([
                'success' => false,
                'message' => 'Recluta no encontrado'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $recluta
        ], 200);
    }

    /**
     * Crear un nuevo recluta
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'curp' => 'required|string|max:18|unique:datos,curp',
                'nombre' => 'required|string|max:50',
                'apellido_paterno' => 'required|string|max:50',
                'apellido_materno' => 'required|string|max:50',
                'clase' => 'nullable|string|max:4',
                'lugar_de_nacimiento' => 'nullable|string|max:100',
                'domicilio' => 'nullable|string|max:100',
                'ocupacion' => 'nullable|string|max:50',
                'nombre_del_padre' => 'nullable|string|max:100',
                'nombre_de_la_madre' => 'nullable|string|max:100',
                'estado_civil' => 'nullable|string|max:40',
                'grado_de_estudios' => 'nullable|string|max:40',
                'acta_nacimiento' => 'required|boolean',
                'copia_curp' => 'required|boolean',
                'certificado_estudios' => 'required|boolean',
                'comprobante_domicilio' => 'required|boolean',
                'fotografias' => 'required|boolean',
            ]);

            $validated['status'] = 'Recluta';
            $validated['matricula'] = null;

            $recluta = Dato::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Recluta creado exitosamente',
                'data' => $recluta
            ], 201);

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        }
    }

    /**
     * Actualizar un recluta
     * 
     * @param Request $request
     * @param string $curp
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $curp)
    {
        $recluta = Dato::where('curp', $curp)
                       ->where('status', 'Recluta')
                       ->first();

        if (!$recluta) {
            return response()->json([
                'success' => false,
                'message' => 'Recluta no encontrado'
            ], 404);
        }

        try {
            $validated = $request->validate([
                'curp' => 'required|string|max:18|unique:datos,curp,' . $curp . ',curp',
                'nombre' => 'required|string|max:50',
                'apellido_paterno' => 'required|string|max:50',
                'apellido_materno' => 'required|string|max:50',
                'clase' => 'nullable|string|max:4',
                'lugar_de_nacimiento' => 'nullable|string|max:100',
                'domicilio' => 'nullable|string|max:100',
                'ocupacion' => 'nullable|string|max:50',
                'nombre_del_padre' => 'nullable|string|max:100',
                'nombre_de_la_madre' => 'nullable|string|max:100',
                'estado_civil' => 'nullable|string|max:40',
                'grado_de_estudios' => 'nullable|string|max:40',
                'matricula' => 'nullable|string|max:20',
                'status' => 'required|in:Recluta,Reserva',
                'acta_nacimiento' => 'required|boolean',
                'copia_curp' => 'required|boolean',
                'certificado_estudios' => 'required|boolean',
                'comprobante_domicilio' => 'required|boolean',
                'fotografias' => 'required|boolean',
            ]);

            // Si el CURP cambió, eliminar el registro viejo y crear uno nuevo
            if ($recluta->curp !== $validated['curp']) {
                $nuevoRecluta = $recluta->replicate();
                $nuevoRecluta->fill($validated);
                $nuevoRecluta->save();
                $recluta->delete();
                $recluta = $nuevoRecluta;
            } else {
                $recluta->update($validated);
            }

            return response()->json([
                'success' => true,
                'message' => 'Recluta actualizado exitosamente',
                'data' => $recluta
            ], 200);

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        }
    }

    /**
     * Eliminar un recluta
     * 
     * @param string $curp
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($curp)
    {
        $recluta = Dato::where('curp', $curp)
                       ->where('status', 'Recluta')
                       ->first();

        if (!$recluta) {
            return response()->json([
                'success' => false,
                'message' => 'Recluta no encontrado'
            ], 404);
        }

        $recluta->delete();

        return response()->json([
            'success' => true,
            'message' => 'Recluta eliminado exitosamente'
        ], 200);
    }

    /**
     * Promover un recluta a reserva
     * 
     * @param Request $request
     * @param string $curp
     * @return \Illuminate\Http\JsonResponse
     */
    public function promoverAReserva(Request $request, $curp)
    {
        $recluta = Dato::where('curp', $curp)
                       ->where('status', 'Recluta')
                       ->first();

        if (!$recluta) {
            return response()->json([
                'success' => false,
                'message' => 'Recluta no encontrado'
            ], 404);
        }

        try {
            $validated = $request->validate([
                'matricula' => 'required|string|max:20|unique:datos,matricula',
            ]);

            $recluta->update([
                'status' => 'Reserva',
                'matricula' => $validated['matricula']
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Recluta promovido a Reserva exitosamente',
                'data' => $recluta
            ], 200);

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        }
    }
}
