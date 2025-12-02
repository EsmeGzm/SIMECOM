<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Dato;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ReservaController extends Controller
{
    /**
     * Listar todas las reservas
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        
        $query = Dato::where('status', 'Reserva');

        // Aplicar búsqueda si existe
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('curp', 'LIKE', "%{$search}%")
                  ->orWhere('nombre', 'LIKE', "%{$search}%")
                  ->orWhere('apellido_paterno', 'LIKE', "%{$search}%")
                  ->orWhere('apellido_materno', 'LIKE', "%{$search}%")
                  ->orWhere('matricula', 'LIKE', "%{$search}%")
                  ->orWhere('clase', 'LIKE', "%{$search}%")
                  ->orWhere('domicilio', 'LIKE', "%{$search}%");
            });
        }

        $reservas = $query->orderBy('created_at', 'desc')->get();

        return response()->json([
            'success' => true,
            'data' => $reservas,
            'total' => $reservas->count()
        ], 200);
    }

    /**
     * Obtener una reserva por CURP
     * 
     * @param string $curp
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($curp)
    {
        $reserva = Dato::where('curp', $curp)
                       ->where('status', 'Reserva')
                       ->first();

        if (!$reserva) {
            return response()->json([
                'success' => false,
                'message' => 'Reserva no encontrada'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $reserva
        ], 200);
    }

    /**
     * Buscar reserva por matrícula
     * 
     * @param string $matricula
     * @return \Illuminate\Http\JsonResponse
     */
    public function buscarPorMatricula($matricula)
    {
        $reserva = Dato::where('matricula', $matricula)
                       ->where('status', 'Reserva')
                       ->first();

        if (!$reserva) {
            return response()->json([
                'success' => false,
                'message' => 'Reserva no encontrada con esa matrícula'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $reserva
        ], 200);
    }

    /**
     * Actualizar una reserva
     * 
     * @param Request $request
     * @param string $curp
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $curp)
    {
        $reserva = Dato::where('curp', $curp)
                       ->where('status', 'Reserva')
                       ->first();

        if (!$reserva) {
            return response()->json([
                'success' => false,
                'message' => 'Reserva no encontrada'
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
                'matricula' => 'required|string|max:20|unique:datos,matricula,' . $reserva->matricula . ',matricula',
                'status' => 'required|in:Recluta,Reserva',
                'acta_nacimiento' => 'required|boolean',
                'copia_curp' => 'required|boolean',
                'certificado_estudios' => 'required|boolean',
                'comprobante_domicilio' => 'required|boolean',
                'fotografias' => 'required|boolean',
            ]);

            // Si el CURP cambió, eliminar el registro viejo y crear uno nuevo
            if ($reserva->curp !== $validated['curp']) {
                $nuevaReserva = $reserva->replicate();
                $nuevaReserva->fill($validated);
                $nuevaReserva->save();
                $reserva->delete();
                $reserva = $nuevaReserva;
            } else {
                $reserva->update($validated);
            }

            return response()->json([
                'success' => true,
                'message' => 'Reserva actualizada exitosamente',
                'data' => $reserva
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
     * Obtener estadísticas de reservas
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function estadisticas()
    {
        $totalReservas = Dato::where('status', 'Reserva')->count();
        $totalReclutas = Dato::where('status', 'Recluta')->count();
        $reservasPorClase = Dato::where('status', 'Reserva')
                                 ->selectRaw('clase, COUNT(*) as total')
                                 ->groupBy('clase')
                                 ->get();

        return response()->json([
            'success' => true,
            'data' => [
                'total_reservas' => $totalReservas,
                'total_reclutas' => $totalReclutas,
                'reservas_por_clase' => $reservasPorClase,
                'total_general' => $totalReservas + $totalReclutas
            ]
        ], 200);
    }
}
