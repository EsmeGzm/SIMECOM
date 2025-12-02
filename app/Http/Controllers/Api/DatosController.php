<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Dato;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class DatosController extends Controller
{
    /**
     * Listar todos los datos con filtrado opcional
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status'); // Filtrar por status: Recluta o Reserva
        
        $query = Dato::query();

        // Aplicar búsqueda si existe
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('curp', 'like', "%$search%")
                  ->orWhere('nombre', 'like', "%$search%")
                  ->orWhere('apellido_paterno', 'like', "%$search%")
                  ->orWhere('apellido_materno', 'like', "%$search%")
                  ->orWhere('matricula', 'like', "%$search%")
                  ->orWhere('clase', 'like', "%$search%");
            });
        }

        // Filtrar por status si se proporciona
        if ($status && in_array($status, ['Recluta', 'Reserva'])) {
            $query->where('status', $status);
        }

        $datos = $query->orderBy('created_at', 'desc')->get();

        return response()->json([
            'success' => true,
            'data' => $datos,
            'total' => $datos->count()
        ], 200);
    }

    /**
     * Obtener un dato por CURP
     * 
     * @param string $curp
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($curp)
    {
        $dato = Dato::find($curp);

        if (!$dato) {
            return response()->json([
                'success' => false,
                'message' => 'Registro no encontrado'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $dato
        ], 200);
    }

    /**
     * Crear un nuevo dato (Recluta)
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

            $dato = Dato::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Recluta creado exitosamente',
                'data' => $dato
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
     * Actualizar un dato existente
     * 
     * @param Request $request
     * @param string $curp
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $curp)
    {
        $dato = Dato::find($curp);

        if (!$dato) {
            return response()->json([
                'success' => false,
                'message' => 'Registro no encontrado'
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
            if ($dato->curp !== $validated['curp']) {
                $nuevoDato = $dato->replicate();
                $nuevoDato->fill($validated);
                $nuevoDato->save();
                $dato->delete();
                $dato = $nuevoDato;
            } else {
                $dato->update($validated);
            }

            return response()->json([
                'success' => true,
                'message' => 'Registro actualizado exitosamente',
                'data' => $dato
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
     * Eliminar un dato
     * 
     * @param string $curp
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($curp)
    {
        $dato = Dato::find($curp);

        if (!$dato) {
            return response()->json([
                'success' => false,
                'message' => 'Registro no encontrado'
            ], 404);
        }

        $dato->delete();

        return response()->json([
            'success' => true,
            'message' => 'Registro eliminado exitosamente'
        ], 200);
    }
}
