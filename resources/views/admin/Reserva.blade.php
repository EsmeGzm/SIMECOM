<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>SIMECOM Reserva</title>
    <link rel="stylesheet" href="{{ asset('dashboardstyle.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>

<body>
    <x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('RESERVA') }}
            </h2>
        </x-slot>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <!-- Barra de búsqueda -->
                        <div class="search-container">
                            <form method="GET" action="{{ route('admin.reserva') }}" style="display: flex; width: 100%; align-items: center;">
                                <input 
                                    type="text" 
                                    name="search" 
                                    class="search-input" 
                                    placeholder="Buscar por CURP, nombre, apellidos, matrícula, clase, domicilio..." 
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
                                <a href="{{ route('admin.reserva') }}" style="color: #8B4513; margin-left: 15px; text-decoration: none; font-weight: bold;">
                                    <i class="fa fa-times-circle"></i> Limpiar búsqueda
                                </a>
                            </div>
                        @endif

                        <!-- Modal para editar datos -->
                        <div id="modal-editar" class="modal-bg" style="display:none;">
                            <div class="modal-content">
                                <span class="close-modal" onclick="document.getElementById('modal-editar').style.display='none'">&times;</span>
                                
                                <form method="POST" id="form-editar">
                                    @csrf
                                    @method('PUT')
                                    
                                    <!-- DATOS PERSONALES -->
                                    <div class="modal-section">
                                        <h3 class="section-title">EDITAR DATOS PERSONALES</h3>
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
                                                <label>Matrícula:</label>
                                                <input type="text" name="matricula" id="edit-matricula" required>
                                            </div>
                                            <div class="input-group">
                                                <label>Status:</label>
                                                <select name="status" id="edit-status" required onchange="toggleMatricula()">
                                                    <option value="Recluta">Recluta</option>
                                                    <option value="Reserva">Reserva</option>
                                                </select>
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
                                    <h3 class="section-title">INFORMACIÓN DE RESERVA</h3>
                                    
                                    <div class="info-row">
                                        <div class="info-item">
                                            <label>CURP:</label>
                                            <span id="ver-curp"></span>
                                        </div>
                                        <div class="info-item">
                                            <label>Matrícula:</label>
                                            <span id="ver-matricula"></span>
                                        </div>
                                    </div>
                                    
                                    <div class="info-row">
                                        <div class="info-item">
                                            <label>Nombre:</label>
                                            <span id="ver-nombre"></span>
                                        </div>
                                        <div class="info-item">
                                            <label>Apellido paterno:</label>
                                            <span id="ver-apellido-paterno"></span>
                                        </div>
                                    </div>
                                    
                                    <div class="info-row">
                                        <div class="info-item">
                                            <label>Apellido materno:</label>
                                            <span id="ver-apellido-materno"></span>
                                        </div>
                                        <div class="info-item">
                                            <label>Clase:</label>
                                            <span id="ver-clase"></span>
                                        </div>
                                    </div>
                                    
                                    <div class="info-row">
                                        <div class="info-item">
                                            <label>Lugar de nacimiento:</label>
                                            <span id="ver-lugar"></span>
                                        </div>
                                        <div class="info-item">
                                            <label>Domicilio:</label>
                                            <span id="ver-domicilio"></span>
                                        </div>
                                    </div>
                                    
                                    <div class="info-row">
                                        <div class="info-item">
                                            <label>Ocupación:</label>
                                            <span id="ver-ocupacion"></span>
                                        </div>
                                        <div class="info-item">
                                            <label>Nombre del padre:</label>
                                            <span id="ver-padre"></span>
                                        </div>
                                    </div>
                                    
                                    <div class="info-row">
                                        <div class="info-item">
                                            <label>Nombre de la madre:</label>
                                            <span id="ver-madre"></span>
                                        </div>
                                        <div class="info-item">
                                            <label>Estado civil:</label>
                                            <span id="ver-estado-civil"></span>
                                        </div>
                                    </div>
                                    
                                    <div class="info-row">
                                        <div class="info-item">
                                            <label>Grado de estudios:</label>
                                            <span id="ver-grado"></span>
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

                        <!-- Tabla de datos -->
                        <div class="table-container">
                            <table class="styled-table">
                                <thead>
                                    <tr>
                                        <th>CURP</th>
                                        <th>Matrícula</th>
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
                                            <td colspan="14" style="text-align: center; padding: 40px; color: #b7b084; font-size: 1.2em;">
                                                <i class="fa fa-search" style="font-size: 3em; display: block; margin-bottom: 15px;"></i>
                                                @if(isset($search) && $search)
                                                    No se encontraron resultados para "{{ $search }}"
                                                @else
                                                    No hay registros de reserva
                                                @endif
                                            </td>
                                        </tr>
                                    @else
                                        @foreach($datos as $dato)
                                            <tr>
                                                <td>{{ $dato->curp }}</td>
                                                <td>{{ $dato->matricula }}</td>
                                                <td>{{ $dato->nombre }}</td>
                                                <td>{{ $dato->apellido_paterno }}</td>
                                                <td>{{ $dato->apellido_materno }}</td>
                                                <td>{{ $dato->clase }}</td>
                                                <td>{{ $dato->domicilio }}</td>
                                                <td>{{ $dato->status }}</td>
                                                <td>{!! $dato->acta_nacimiento ? '<i class="fa fa-check" style="color: white;"></i>' : '<i class="fa fa-times" style="color: white;"></i>' !!}</td>
                                                <td>{!! $dato->copia_curp ? '<i class="fa fa-check" style="color: white;"></i>' : '<i class="fa fa-times" style="color: white;"></i>' !!}</td>
                                                <td>{!! $dato->certificado_estudios ? '<i class="fa fa-check" style="color: white;"></i>' : '<i class="fa fa-times" style="color: white;"></i>' !!}</td>
                                                <td>{!! $dato->comprobante_domicilio ? '<i class="fa fa-check" style="color: white;"></i>' : '<i class="fa fa-times" style="color: white;"></i>' !!}</td>
                                                <td>{!! $dato->fotografias ? '<i class="fa fa-check" style="color: white;"></i>' : '<i class="fa fa-times" style="color: white;"></i>' !!}</td>
                                                <td>
                                                    <i class="fa fa-eye" onclick="abrirModalVer('{{ $dato->curp }}')"></i>
                                                    <i class="fa fa-edit" onclick="abrirModalEditar('{{ $dato->curp }}')"></i>
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

    <script>
    // Modal VER
    function abrirModalVer(curp) {
        fetch('/admin/reserva/' + curp + '/edit')
            .then(response => response.json())
            .then(dato => {
                document.getElementById('ver-curp').textContent = dato.curp;
                document.getElementById('ver-matricula').textContent = dato.matricula || 'N/A';
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
    function abrirModalEditar(curp) {
        fetch('/admin/reserva/' + curp + '/edit')
            .then(response => response.json())
            .then(dato => {
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
                
                document.getElementById('edit-acta-' + (dato.acta_nacimiento ? 'si' : 'no')).checked = true;
                document.getElementById('edit-curp-' + (dato.copia_curp ? 'si' : 'no')).checked = true;
                document.getElementById('edit-cert-' + (dato.certificado_estudios ? 'si' : 'no')).checked = true;
                document.getElementById('edit-comp-' + (dato.comprobante_domicilio ? 'si' : 'no')).checked = true;
                document.getElementById('edit-fotos-' + (dato.fotografias ? 'si' : 'no')).checked = true;
                
                document.getElementById('form-editar').action = '/admin/reserva/' + dato.curp;
                document.getElementById('modal-editar').style.display = 'flex';
            });
    }

    // Habilitar/deshabilitar matrícula
    function toggleMatricula() {
        const status = document.getElementById('edit-status').value;
        const matriculaInput = document.getElementById('edit-matricula');
        
        if (status === 'Reserva') {
            matriculaInput.disabled = false;
            matriculaInput.style.background = '#fff';
            matriculaInput.required = true;
        } else {
            matriculaInput.disabled = true;
            matriculaInput.style.background = '#ddd';
            matriculaInput.value = '';
            matriculaInput.required = false;
        }
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
