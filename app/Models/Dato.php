<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dato extends Model
{
    use HasFactory;

    protected $table = 'datos';
    protected $primaryKey = 'curp';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'curp',
        'nombre',
        'apellido_paterno',
        'apellido_materno',
        'clase',
        'lugar_de_nacimiento',
        'domicilio',
        'ocupacion',
        'nombre_del_padre',
        'nombre_de_la_madre',
        'estado_civil',
        'grado_de_estudios',
        'matricula',
        'status',
        'acta_nacimiento',
        'copia_curp',
        'certificado_estudios',
        'comprobante_domicilio',
        'fotografias',
    ];

    protected $casts = [
        'acta_nacimiento' => 'boolean',
        'copia_curp' => 'boolean',
        'certificado_estudios' => 'boolean',
        'comprobante_domicilio' => 'boolean',
        'fotografias' => 'boolean',
    ];
}