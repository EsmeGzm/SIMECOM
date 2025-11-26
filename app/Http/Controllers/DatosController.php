<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dato;

class DatosController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
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
            'acta_nacimiento' => 'required|in:si,no',
            'copia_curp' => 'required|in:si,no',
            'certificado_estudios' => 'required|in:si,no',
            'comprobante_domicilio' => 'required|in:si,no',
            'fotografias' => 'required|in:si,no',
        ]);

        $data = [
            'curp' => $request->curp,
            'nombre' => $request->nombre,
            'apellido_paterno' => $request->apellido_paterno,
            'apellido_materno' => $request->apellido_materno,
            'clase' => $request->clase,
            'lugar_de_nacimiento' => $request->lugar_de_nacimiento,
            'domicilio' => $request->domicilio,
            'ocupacion' => $request->ocupacion,
            'nombre_del_padre' => $request->nombre_del_padre,
            'nombre_de_la_madre' => $request->nombre_de_la_madre,
            'estado_civil' => $request->estado_civil,
            'grado_de_estudios' => $request->grado_de_estudios,
            'matricula' => null,
            'status' => 'Recluta',
            'acta_nacimiento' => $request->acta_nacimiento === 'si',
            'copia_curp' => $request->copia_curp === 'si',
            'certificado_estudios' => $request->certificado_estudios === 'si',
            'comprobante_domicilio' => $request->comprobante_domicilio === 'si',
            'fotografias' => $request->fotografias === 'si',
        ];

        Dato::create($data);

        return redirect()->route('admin.dashboard')->with('success', 'Registro guardado correctamente.');
    }

    public function edit($curp)
    {
        $dato = Dato::findOrFail($curp);
        return response()->json($dato);
    }

    public function update(Request $request, $curp)
    {
        $dato = Dato::findOrFail($curp);
        
        // Validar el nuevo CURP solo si cambió
        $request->validate([
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
            'acta_nacimiento' => 'required|in:si,no',
            'copia_curp' => 'required|in:si,no',
            'certificado_estudios' => 'required|in:si,no',
            'comprobante_domicilio' => 'required|in:si,no',
            'fotografias' => 'required|in:si,no',
        ]);
        
        // Si el CURP cambió, eliminar el registro viejo y crear uno nuevo
        if ($dato->curp !== $request->curp) {
            $nuevoDato = $dato->replicate();
            $nuevoDato->curp = $request->curp;
            $nuevoDato->nombre = $request->nombre;
            $nuevoDato->apellido_paterno = $request->apellido_paterno;
            $nuevoDato->apellido_materno = $request->apellido_materno;
            $nuevoDato->clase = $request->clase;
            $nuevoDato->lugar_de_nacimiento = $request->lugar_de_nacimiento;
            $nuevoDato->domicilio = $request->domicilio;
            $nuevoDato->ocupacion = $request->ocupacion;
            $nuevoDato->nombre_del_padre = $request->nombre_del_padre;
            $nuevoDato->nombre_de_la_madre = $request->nombre_de_la_madre;
            $nuevoDato->estado_civil = $request->estado_civil;
            $nuevoDato->grado_de_estudios = $request->grado_de_estudios;
            $nuevoDato->matricula = $request->matricula;
            $nuevoDato->status = $request->status;
            $nuevoDato->acta_nacimiento = $request->acta_nacimiento === 'si';
            $nuevoDato->copia_curp = $request->copia_curp === 'si';
            $nuevoDato->certificado_estudios = $request->certificado_estudios === 'si';
            $nuevoDato->comprobante_domicilio = $request->comprobante_domicilio === 'si';
            $nuevoDato->fotografias = $request->fotografias === 'si';
            $nuevoDato->save();
            
            $dato->delete();
        } else {
            // Si el CURP no cambió, actualizar normalmente
            $dato->update([
                'nombre' => $request->nombre,
                'apellido_paterno' => $request->apellido_paterno,
                'apellido_materno' => $request->apellido_materno,
                'clase' => $request->clase,
                'lugar_de_nacimiento' => $request->lugar_de_nacimiento,
                'domicilio' => $request->domicilio,
                'ocupacion' => $request->ocupacion,
                'nombre_del_padre' => $request->nombre_del_padre,
                'nombre_de_la_madre' => $request->nombre_de_la_madre,
                'estado_civil' => $request->estado_civil,
                'grado_de_estudios' => $request->grado_de_estudios,
                'matricula' => $request->matricula,
                'status' => $request->status,
                'acta_nacimiento' => $request->acta_nacimiento === 'si',
                'copia_curp' => $request->copia_curp === 'si',
                'certificado_estudios' => $request->certificado_estudios === 'si',
                'comprobante_domicilio' => $request->comprobante_domicilio === 'si',
                'fotografias' => $request->fotografias === 'si',
            ]);
        }

        return redirect()->route('admin.dashboard')->with('success', 'Registro actualizado correctamente.');
    }

    public function destroy($curp)
    {
        $dato = Dato::findOrFail($curp);
        $dato->delete();

        return redirect()->route('admin.dashboard')->with('success', 'Registro eliminado correctamente.');
    }
}