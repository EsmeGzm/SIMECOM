<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>SIMECOM Dashboard</title>
    <link rel="stylesheet" href="{{ asset('dashboardstyle.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>

<body>
    <x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('SIMECOM') }}
            </h2>
        </x-slot>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <!-- Barra de búsqueda -->
                        <div class="search-container">
                            <form method="GET" action="{{ route('admin.dashboard') }}" style="display: flex; width: 100%; align-items: center;">
                                <input 
                                    type="text" 
                                    name="search" 
                                    class="search-input" 
                                    placeholder="Buscar por CURP, nombre, apellidos, matrícula, clase..." 
                                    value="{{ $search ?? '' }}"
                                    id="search-input"
                                >
                                <button type="submit" class="search-btn">
                                    <i class="fa fa-search"></i>
                                </button>
                            </form>
                        </div>

                        @if(isset($search) && $search)
                            <div style="text-align: center; margin: 10px 0;">
                                <span style="color: #3A4D39; font-weight: bold;">
                                    Resultados para: "{{ $search }}"
                                </span>
                                <a href="{{ route('admin.dashboard') }}" style="color: #8B4513; margin-left: 15px; text-decoration: none; font-weight: bold;">
                                    <i class="fa fa-times-circle"></i> Limpiar búsqueda
                                </a>
                            </div>
                        @endif

                        <!-- Botón Nuevo -->
                        <button class="nuevo-btn" onclick="document.getElementById('modal-nuevo').style.display='flex'">
                            NUEVO <i class="fa fa-plus"></i>
                        </button>

                        <!-- Modal para agregar datos -->
                        <div id="modal-nuevo" class="modal-bg" style="display:none;">
                            <div class="modal-content">
                                <span class="close-modal" onclick="document.getElementById('modal-nuevo').style.display='none'">&times;</span>
                                
                                <form method="POST" action="{{ route('datos.store') }}">
                                    @csrf
                                    
                                    <!-- DATOS PERSONALES -->
                                    <div class="modal-section">
                                        <h3 class="section-title">DATOS PERSONALES</h3>
                                        <div class="modal-row">
                                            <div class="input-group">
                                                <label>CURP:</label>
                                                <input type="text" name="curp" required>
                                            </div>
                                            <div class="input-group">
                                                <label>Nombre:</label>
                                                <input type="text" name="nombre" required>
                                            </div>
                                        </div>
                                        
                                        <div class="modal-row">
                                            <div class="input-group">
                                                <label>Apellido paterno:</label>
                                                <input type="text" name="apellido_paterno" required>
                                            </div>
                                            <div class="input-group">
                                                <label>Apellido materno:</label>
                                                <input type="text" name="apellido_materno" required>
                                            </div>
                                        </div>
                                        
                                        <div class="modal-row">
                                            <div class="input-group">
                                                <label>Clase:</label>
                                                <input type="text" name="clase">
                                            </div>
                                            <div class="input-group">
                                                <label>Lugar de nacimiento:</label>
                                                <input type="text" name="lugar_de_nacimiento">
                                            </div>
                                        </div>
                                        
                                        <div class="modal-row">
                                            <div class="input-group">
                                                <label>Domicilio:</label>
                                                <input type="text" name="domicilio">
                                            </div>
                                            <div class="input-group">
                                                <label>Ocupación:</label>
                                                <input type="text" name="ocupacion">
                                            </div>
                                        </div>
                                        
                                        <div class="modal-row">
                                            <div class="input-group">
                                                <label>Nombre del padre:</label>
                                                <input type="text" name="nombre_del_padre">
                                            </div>
                                            <div class="input-group">
                                                <label>Nombre de la madre:</label>
                                                <input type="text" name="nombre_de_la_madre">
                                            </div>
                                        </div>
                                        
                                        <div class="modal-row">
                                            <div class="input-group">
                                                <label>Estado civil:</label>
                                                <select name="estado_civil">
                                                    <option value="">Seleccione</option>
                                                    <option value="Soltero">Soltero</option>
                                                    <option value="Casado">Casado</option>
                                                </select>
                                            </div>
                                            <div class="input-group">
                                                <label>Grado de estudios:</label>
                                                <select name="grado_de_estudios">
                                                    <option value="">Seleccione</option>
                                                    <option value="Primaria">Primaria</option>
                                                    <option value="Secundaria">Secundaria</option>
                                                    <option value="Bachillerato">Bachillerato</option>
                                                    <option value="Universidad">Universidad</option>
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <div class="modal-row">
                                            
                                            <div class="input-group">
                                                <label>Status:</label>
                                                <input type="text" name="status" value="Recluta" readonly style="background: #ddd; text-align: center; font-weight: bold; color: #3A4D39;">
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- DOCUMENTACIÓN -->
                                    <div class="modal-section">
                                        <h3 class="section-title">DOCUMENTACIÓN</h3>
                                        
                                        <div class="doc-item">
                                            <label>Original y copia de acta de nacimiento:</label>
                                            <div class="radio-group">
                                                <label><input type="radio" name="acta_nacimiento" value="si" required> Sí</label>
                                                <label><input type="radio" name="acta_nacimiento" value="no"> No</label>
                                            </div>
                                        </div>
                                        
                                        <div class="doc-item">
                                            <label>Copia de CURP:</label>
                                            <div class="radio-group">
                                                <label><input type="radio" name="copia_curp" value="si" required> Sí</label>
                                                <label><input type="radio" name="copia_curp" value="no"> No</label>
                                            </div>
                                        </div>
                                        
                                        <div class="doc-item">
                                            <label>Constancia o certificado de estudios:</label>
                                            <div class="radio-group">
                                                <label><input type="radio" name="certificado_estudios" value="si" required> Sí</label>
                                                <label><input type="radio" name="certificado_estudios" value="no"> No</label>
                                            </div>
                                        </div>
                                        
                                        <div class="doc-item">
                                            <label>Comprobante de domicilio:</label>
                                            <div class="radio-group">
                                                <label><input type="radio" name="comprobante_domicilio" value="si" required> Sí</label>
                                                <label><input type="radio" name="comprobante_domicilio" value="no"> No</label>
                                            </div>
                                        </div>
                                        
                                        <div class="doc-item">
                                            <label>4 fotografías:</label>
                                            <div class="radio-group">
                                                <label><input type="radio" name="fotografias" value="si" required> Sí</label>
                                                <label><input type="radio" name="fotografias" value="no"> No</label>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="modal-actions">
                                        <button type="submit" class="guardar-btn">
                                            GUARDAR <i class="fa fa-save"></i>
                                        </button>
                                        <button type="button" class="cancelar-btn" onclick="document.getElementById('modal-nuevo').style.display='none'">
                                            CANCELAR <i class="fa fa-times-circle"></i>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Modal para editar datos -->
                        <div id="modal-editar" class="modal-bg" style="display:none;">
                            <div class="modal-content">
                                <span class="close-modal" onclick="document.getElementById('modal-editar').style.display='none'">&times;</span>
                                
                                <form method="POST" action="{{ isset($dato) ? route('datos.update', $dato->curp) : '#' }}" id="form-editar">
                                    @csrf
                                    @method('PUT')
                                    
                                    <!-- DATOS PERSONALES -->
                                    <div class="modal-section">
                                        <h3 class="section-title">DATOS PERSONALES</h3>
                                        <div class="modal-row">
                                            <div class="input-group">
                                                <label>CURP:</label>
                                                <input type="text" name="curp" id="edit-curp" required maxlength="18">
                                                <input type="hidden" name="curp_original" id="edit-curp-original">
                                            </div>
                                            <div class="input-group">
                                                <label>Nombre:</label>
                                                <input type="text" name="nombre" id="edit-nombre" required>
                                            </div>
                                        </div>
                                        
                                        <div class="modal-row">
                                            <div class="input-group">
                                                <label>Apellido paterno:</label>
                                                <input type="text" name="apellido_paterno" id="edit-apellido-paterno" required>
                                            </div>
                                            <div class="input-group">
                                                <label>Apellido materno:</label>
                                                <input type="text" name="apellido_materno" id="edit-apellido-materno" required>
                                            </div>
                                        </div>
                                        
                                        <div class="modal-row">
                                            <div class="input-group">
                                                <label>Clase:</label>
                                                <input type="text" name="clase" id="edit-clase">
                                            </div>
                                            <div class="input-group">
                                                <label>Lugar de nacimiento:</label>
                                                <input type="text" name="lugar_de_nacimiento" id="edit-lugar">
                                            </div>
                                        </div>
                                        
                                        <div class="modal-row">
                                            <div class="input-group">
                                                <label>Domicilio:</label>
                                                <input type="text" name="domicilio" id="edit-domicilio">
                                            </div>
                                            <div class="input-group">
                                                <label>Ocupación:</label>
                                                <input type="text" name="ocupacion" id="edit-ocupacion">
                                            </div>
                                        </div>
                                        
                                        <div class="modal-row">
                                            <div class="input-group">
                                                <label>Nombre del padre:</label>
                                                <input type="text" name="nombre_del_padre" id="edit-padre">
                                            </div>
                                            <div class="input-group">
                                                <label>Nombre de la madre:</label>
                                                <input type="text" name="nombre_de_la_madre" id="edit-madre">
                                            </div>
                                        </div>
                                        
                                        <div class="modal-row">
                                            <div class="input-group">
                                                <label>Estado civil:</label>
                                                <select name="estado_civil" id="edit-estado-civil">
                                                    <option value="">Seleccione</option>
                                                    <option value="Soltero">Soltero</option>
                                                    <option value="Casado">Casado</option>
                                                </select>
                                            </div>
                                            <div class="input-group">
                                                <label>Grado de estudios:</label>
                                                <select name="grado_de_estudios" id="edit-grado">
                                                    <option value="">Seleccione</option>
                                                    <option value="Primaria">Primaria</option>
                                                    <option value="Secundaria">Secundaria</option>
                                                    <option value="Bachillerato">Bachillerato</option>
                                                    <option value="Universidad">Universidad</option>
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <div class="modal-row">
                                            <div class="input-group">
                                                <label>Status:</label>
                                                <select name="status" id="edit-status" required onchange="toggleMatricula()">
                                                    <option value="Recluta">Recluta</option>
                                                    <option value="Reserva">Reserva</option>
                                                </select>
                                            </div>
                                            <div class="input-group">
                                                <label>Matrícula:</label>
                                                <input type="text" name="matricula" id="edit-matricula" placeholder="Solo para Reserva" disabled style="background: #ddd;">
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- DOCUMENTACIÓN -->
                                    <div class="modal-section">
                                        <h3 class="section-title">DOCUMENTACIÓN</h3>
                                        
                                        <div class="doc-item">
                                            <label>Original y copia de acta de nacimiento:</label>
                                            <div class="radio-group">
                                                <label><input type="radio" name="acta_nacimiento" id="edit-acta-si" value="si" required> Sí</label>
                                                <label><input type="radio" name="acta_nacimiento" id="edit-acta-no" value="no"> No</label>
                                            </div>
                                        </div>
                                        
                                        <div class="doc-item">
                                            <label>Copia de CURP:</label>
                                            <div class="radio-group">
                                                <label><input type="radio" name="copia_curp" id="edit-curp-si" value="si" required> Sí</label>
                                                <label><input type="radio" name="copia_curp" id="edit-curp-no" value="no"> No</label>
                                            </div>
                                        </div>
                                        
                                        <div class="doc-item">
                                            <label>Constancia o certificado de estudios:</label>
                                            <div class="radio-group">
                                                <label><input type="radio" name="certificado_estudios" id="edit-cert-si" value="si" required> Sí</label>
                                                <label><input type="radio" name="certificado_estudios" id="edit-cert-no" value="no"> No</label>
                                            </div>
                                        </div>
                                        
                                        <div class="doc-item">
                                            <label>Comprobante de domicilio:</label>
                                            <div class="radio-group">
                                                <label><input type="radio" name="comprobante_domicilio" id="edit-comp-si" value="si" required> Sí</label>
                                                <label><input type="radio" name="comprobante_domicilio" id="edit-comp-no" value="no"> No</label>
                                            </div>
                                        </div>
                                        
                                        <div class="doc-item">
                                            <label>4 fotografías:</label>
                                            <div class="radio-group">
                                                <label><input type="radio" name="fotografias" id="edit-fotos-si" value="si" required> Sí</label>
                                                <label><input type="radio" name="fotografias" id="edit-fotos-no" value="no"> No</label>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="modal-actions">
                                        <button type="submit" class="guardar-btn">
                                            ACTUALIZAR <i class="fa fa-save"></i>
                                        </button>
                                        <button type="button" class="cancelar-btn" onclick="document.getElementById('modal-editar').style.display='none'">
                                            CANCELAR <i class="fa fa-times-circle"></i>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Modal para VER datos -->
                        <div id="modal-ver" class="modal-bg" style="display:none;">
                            <div class="modal-content">
                                <span class="close-modal" onclick="document.getElementById('modal-ver').style.display='none'">&times;</span>
                                
                                <div class="modal-section">
                                    <h3 class="section-title">INFORMACIÓN DEL REGISTRO</h3>
                                    
                                    <div class="info-row">
                                        <div class="info-item">
                                            <label>CURP:</label>
                                            <span id="ver-curp"></span>
                                        </div>
                                        <div class="info-item">
                                            <label>Nombre:</label>
                                            <span id="ver-nombre"></span>
                                        </div>
                                    </div>
                                    
                                    <div class="info-row">
                                        <div class="info-item">
                                            <label>Apellido paterno:</label>
                                            <span id="ver-apellido-paterno"></span>
                                        </div>
                                        <div class="info-item">
                                            <label>Apellido materno:</label>
                                            <span id="ver-apellido-materno"></span>
                                        </div>
                                    </div>
                                    
                                    <div class="info-row">
                                        <div class="info-item">
                                            <label>Clase:</label>
                                            <span id="ver-clase"></span>
                                        </div>
                                        <div class="info-item">
                                            <label>Lugar de nacimiento:</label>
                                            <span id="ver-lugar"></span>
                                        </div>
                                    </div>
                                    
                                    <div class="info-row">
                                        <div class="info-item">
                                            <label>Domicilio:</label>
                                            <span id="ver-domicilio"></span>
                                        </div>
                                        <div class="info-item">
                                            <label>Ocupación:</label>
                                            <span id="ver-ocupacion"></span>
                                        </div>
                                    </div>
                                    
                                    <div class="info-row">
                                        <div class="info-item">
                                            <label>Nombre del padre:</label>
                                            <span id="ver-padre"></span>
                                        </div>
                                        <div class="info-item">
                                            <label>Nombre de la madre:</label>
                                            <span id="ver-madre"></span>
                                        </div>
                                    </div>
                                    
                                    <div class="info-row">
                                        <div class="info-item">
                                            <label>Estado civil:</label>
                                            <span id="ver-estado-civil"></span>
                                        </div>
                                        <div class="info-item">
                                            <label>Grado de estudios:</label>
                                            <span id="ver-grado"></span>
                                        </div>
                                    </div>
                                    
                                    <div class="info-row">
                                        <div class="info-item">
                                            <label>Matrícula:</label>
                                            <span id="ver-matricula"></span>
                                        </div>
                                        <div class="info-item">
                                            <label>Status:</label>
                                            <span id="ver-status"></span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="modal-section">
                                    <h3 class="section-title">DOCUMENTACIÓN</h3>
                                    
                                    <div class="doc-check">
                                        <label>Acta de nacimiento:</label>
                                        <span id="ver-acta"></span>
                                    </div>
                                    <div class="doc-check">
                                        <label>Copia de CURP:</label>
                                        <span id="ver-curp-doc"></span>
                                    </div>
                                    <div class="doc-check">
                                        <label>Certificado de estudios:</label>
                                        <span id="ver-certificado"></span>
                                    </div>
                                    <div class="doc-check">
                                        <label>Comprobante de domicilio:</label>
                                        <span id="ver-comprobante"></span>
                                    </div>
                                    <div class="doc-check">
                                        <label>4 fotografías:</label>
                                        <span id="ver-fotos"></span>
                                    </div>
                                </div>
                                
                                <div class="modal-actions">
                                    <button type="button" class="cancelar-btn" onclick="document.getElementById('modal-ver').style.display='none'">
                                        CERRAR <i class="fa fa-times-circle"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Modal para ELIMINAR -->
                        <div id="modal-eliminar" class="modal-bg" style="display:none;">
                            <div class="modal-content modal-eliminar">
                                <span class="close-modal" onclick="document.getElementById('modal-eliminar').style.display='none'">&times;</span>
                                
                                <div class="modal-section">
                                    <h3 class="section-title" style="background: #8B4513;">CONFIRMAR ELIMINACIÓN</h3>
                                    
                                    <div style="text-align: center; padding: 30px;">
                                        <i class="fa fa-exclamation-triangle" style="font-size: 4em; color: #ff6b6b; margin-bottom: 20px;"></i>
                                        <p style="color: #b7b084; font-size: 1.2em; margin-bottom: 10px;">
                                            ¿Estás seguro de eliminar este registro?
                                        </p>
                                        <p style="color: #b7b084; font-size: 1em;">
                                            <strong id="eliminar-nombre"></strong>
                                        </p>
                                        <p style="color: #ff6b6b; font-size: 0.9em; margin-top: 15px;">
                                            Esta acción no se puede deshacer.
                                        </p>
                                    </div>
                                </div>
                                
                                <form method="POST" id="form-eliminar">
                                    @csrf
                                    @method('DELETE')
                                    <div class="modal-actions">
                                        <button type="submit" class="eliminar-btn">
                                            ELIMINAR <i class="fa fa-trash"></i>
                                        </button>
                                        <button type="button" class="cancelar-btn" onclick="document.getElementById('modal-eliminar').style.display='none'">
                                            CANCELAR <i class="fa fa-times-circle"></i>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Tabla de datos -->
                        <div class="table-container">
                            <table class="styled-table">
                                <thead>
                                    <tr>
                                        <th>CURP</th>
                                        <th>Nombre</th>
                                        <th>A. paterno</th>
                                        <th>A. materno</th>
                                        <th>Clase</th>
                                        <th>Domicilio</th>
                                        <th>Status</th>
                                        <th>Acta</th>
                                        <th>CURP</th>
                                        <th>Certificado</th>
                                        <th>Comprobante</th>
                                        <th>Fotos</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($datos->isEmpty())
                                        <tr>
                                            <td colspan="13" style="text-align: center; padding: 40px; color: #b7b084; font-size: 1.2em;">
                                                <i class="fa fa-search" style="font-size: 3em; display: block; margin-bottom: 15px;"></i>
                                                @if(isset($search) && $search)
                                                    No se encontraron resultados para "{{ $search }}"
                                                @else
                                                    No hay registros de reclutas
                                                @endif
                                            </td>
                                        </tr>
                                    @else
                                        @foreach($datos as $dato)
                                            <tr>
                                                <td>{{ $dato->curp }}</td>
                                                <td>{{ $dato->nombre }}</td>
                                                <td>{{ $dato->apellido_paterno }}</td>
                                                <td>{{ $dato->apellido_materno }}</td>
                                                <td>{{ $dato->clase }}</td>
                                                <td>{{ $dato->domicilio }}</td>
                                                <td>{{ $dato->status }}</td>
                                                <td>{!! $dato->acta_nacimiento ? '<i class="fa fa-check" style="color: white;"></i>' : '<i class="fa fa-times" style="color: red;"></i>' !!}</td>
                                                <td>{!! $dato->copia_curp ? '<i class="fa fa-check" style="color: white;"></i>' : '<i class="fa fa-times" style="color: red;"></i>' !!}</td>
                                                <td>{!! $dato->certificado_estudios ? '<i class="fa fa-check" style="color: white;"></i>' : '<i class="fa fa-times" style="color: red;"></i>' !!}</td>
                                                <td>{!! $dato->comprobante_domicilio ? '<i class="fa fa-check" style="color: white;"></i>' : '<i class="fa fa-times" style="color: red;"></i>' !!}</td>
                                                <td>{!! $dato->fotografias ? '<i class="fa fa-check" style="color: white;"></i>' : '<i class="fa fa-times" style="color: red;"></i>' !!}</td>
                                                <td>
                                                    <i class="fa fa-eye" onclick="abrirModalVer('{{ $dato->curp }}')"></i>
                                                    <i class="fa fa-edit" onclick="abrirModalEditar('{{ $dato->curp }}', '{{ $dato->nombre }} {{ $dato->apellido_paterno }} {{ $dato->apellido_materno }}', '{{ $dato->status }}', '{{ $dato->matricula }}')"></i>
                                                    <i class="fa fa-trash" onclick="abrirModalEliminar('{{ $dato->curp }}', '{{ $dato->nombre }} {{ $dato->apellido_paterno }} {{ $dato->apellido_materno }}')"></i>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>

                        <!-- Mensajes de éxito o error -->
                        @if ($errors->any())
                            <div style="background: #ff6b6b; color: white; padding: 15px; border-radius: 10px; margin: 20px 0;">
                                <strong>Errores:</strong>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if (session('success'))
                            <div style="background: #4CAF50; color: white; padding: 15px; border-radius: 10px; margin: 20px 0;">
                                {{ session('success') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </x-app-layout>

    <!-- filepath: resources/views/admin/dashboard.blade.php -->
<script>
// Modal VER
function abrirModalVer(curp) {
    fetch('/datos/' + curp + '/edit')
        .then(response => response.json())
        .then(dato => {
            document.getElementById('ver-curp').textContent = dato.curp;
            document.getElementById('ver-nombre').textContent = dato.nombre;
            document.getElementById('ver-apellido-paterno').textContent = dato.apellido_paterno;
            document.getElementById('ver-apellido-materno').textContent = dato.apellido_materno;
            document.getElementById('ver-clase').textContent = dato.clase || 'N/A';
            document.getElementById('ver-lugar').textContent = dato.lugar_de_nacimiento || 'N/A';
            document.getElementById('ver-domicilio').textContent = dato.domicilio || 'N/A';
            document.getElementById('ver-ocupacion').textContent = dato.ocupacion || 'N/A';
            document.getElementById('ver-padre').textContent = dato.nombre_del_padre || 'N/A';
            document.getElementById('ver-madre').textContent = dato.nombre_de_la_madre || 'N/A';
            document.getElementById('ver-estado-civil').textContent = dato.estado_civil || 'N/A';
            document.getElementById('ver-grado').textContent = dato.grado_de_estudios || 'N/A';
            document.getElementById('ver-matricula').textContent = dato.matricula || 'N/A';
            document.getElementById('ver-status').textContent = dato.status || 'N/A';
            
            document.getElementById('ver-acta').innerHTML = dato.acta_nacimiento ? '<i class="fa fa-check" style="color: #4CAF50;"></i> Sí' : '<i class="fa fa-times" style="color: #ff6b6b;"></i> No';
            document.getElementById('ver-curp-doc').innerHTML = dato.copia_curp ? '<i class="fa fa-check" style="color: #4CAF50;"></i> Sí' : '<i class="fa fa-times" style="color: #ff6b6b;"></i> No';
            document.getElementById('ver-certificado').innerHTML = dato.certificado_estudios ? '<i class="fa fa-check" style="color: #4CAF50;"></i> Sí' : '<i class="fa fa-times" style="color: #ff6b6b;"></i> No';
            document.getElementById('ver-comprobante').innerHTML = dato.comprobante_domicilio ? '<i class="fa fa-check" style="color: #4CAF50;"></i> Sí' : '<i class="fa fa-times" style="color: #ff6b6b;"></i> No';
            document.getElementById('ver-fotos').innerHTML = dato.fotografias ? '<i class="fa fa-check" style="color: #4CAF50;"></i> Sí' : '<i class="fa fa-times" style="color: #ff6b6b;"></i> No';
            
            document.getElementById('modal-ver').style.display = 'flex';
        });
}

// Modal EDITAR
function abrirModalEditar(curp, nombre, status, matricula) {
    fetch('/datos/' + curp + '/edit')
        .then(response => response.json())
        .then(dato => {
            // Datos personales
            document.getElementById('edit-curp').value = dato.curp;
            document.getElementById('edit-curp-original').value = dato.curp;
            document.getElementById('edit-nombre').value = dato.nombre;
            document.getElementById('edit-apellido-paterno').value = dato.apellido_paterno;
            document.getElementById('edit-apellido-materno').value = dato.apellido_materno;
            document.getElementById('edit-clase').value = dato.clase || '';
            document.getElementById('edit-lugar').value = dato.lugar_de_nacimiento || '';
            document.getElementById('edit-domicilio').value = dato.domicilio || '';
            document.getElementById('edit-ocupacion').value = dato.ocupacion || '';
            document.getElementById('edit-padre').value = dato.nombre_del_padre || '';
            document.getElementById('edit-madre').value = dato.nombre_de_la_madre || '';
            document.getElementById('edit-estado-civil').value = dato.estado_civil || '';
            document.getElementById('edit-grado').value = dato.grado_de_estudios || '';
            document.getElementById('edit-matricula').value = dato.matricula || '';
            document.getElementById('edit-status').value = dato.status;
            
            // Habilitar/deshabilitar matrícula según el status
            toggleMatricula();
            
            // Documentación
            if (dato.acta_nacimiento) {
                document.getElementById('edit-acta-si').checked = true;
            } else {
                document.getElementById('edit-acta-no').checked = true;
            }
            
            if (dato.copia_curp) {
                document.getElementById('edit-curp-si').checked = true;
            } else {
                document.getElementById('edit-curp-no').checked = true;
            }
            
            if (dato.certificado_estudios) {
                document.getElementById('edit-cert-si').checked = true;
            } else {
                document.getElementById('edit-cert-no').checked = true;
            }
            
            if (dato.comprobante_domicilio) {
                document.getElementById('edit-comp-si').checked = true;
            } else {
                document.getElementById('edit-comp-no').checked = true;
            }
            
            if (dato.fotografias) {
                document.getElementById('edit-fotos-si').checked = true;
            } else {
                document.getElementById('edit-fotos-no').checked = true;
            }
            
            document.getElementById('form-editar').action = '/datos/' + dato.curp;
            document.getElementById('modal-editar').style.display = 'flex';
        });
}

// Función para habilitar/deshabilitar matrícula según el status
function toggleMatricula() {
    const status = document.getElementById('edit-status').value;
    const matriculaInput = document.getElementById('edit-matricula');
    
    if (status === 'Reserva') {
        matriculaInput.disabled = false;
        matriculaInput.style.background = '#fff';
        matriculaInput.placeholder = 'Asignar matrícula';
        matriculaInput.required = true;
    } else {
        matriculaInput.disabled = true;
        matriculaInput.style.background = '#ddd';
        matriculaInput.placeholder = 'Solo para Reserva';
        matriculaInput.value = '';
        matriculaInput.required = false;
    }
}

// Modal ELIMINAR
function abrirModalEliminar(curp, nombre) {
    document.getElementById('eliminar-nombre').textContent = nombre;
    document.getElementById('form-eliminar').action = '/datos/' + curp;
    document.getElementById('modal-eliminar').style.display = 'flex';
}

// Búsqueda con Enter
document.getElementById('search-input').addEventListener('keypress', function(event) {
    if (event.key === 'Enter') {
        event.preventDefault();
        this.form.submit();
    }
});
</script>
</body>

</html>

