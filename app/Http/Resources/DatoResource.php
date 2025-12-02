<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DatoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'curp' => $this->curp,
            'nombre_completo' => trim($this->nombre . ' ' . $this->apellido_paterno . ' ' . $this->apellido_materno),
            'nombre' => $this->nombre,
            'apellido_paterno' => $this->apellido_paterno,
            'apellido_materno' => $this->apellido_materno,
            'clase' => $this->clase,
            'lugar_de_nacimiento' => $this->lugar_de_nacimiento,
            'domicilio' => $this->domicilio,
            'ocupacion' => $this->ocupacion,
            'nombre_del_padre' => $this->nombre_del_padre,
            'nombre_de_la_madre' => $this->nombre_de_la_madre,
            'estado_civil' => $this->estado_civil,
            'grado_de_estudios' => $this->grado_de_estudios,
            'matricula' => $this->matricula,
            'status' => $this->status,
            'documentos' => [
                'acta_nacimiento' => (bool) $this->acta_nacimiento,
                'copia_curp' => (bool) $this->copia_curp,
                'certificado_estudios' => (bool) $this->certificado_estudios,
                'comprobante_domicilio' => (bool) $this->comprobante_domicilio,
                'fotografias' => (bool) $this->fotografias,
            ],
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),
        ];
    }
}
