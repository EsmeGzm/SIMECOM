<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>SIMECOM Reclutas</title>
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
                            <input type="text" class="search-input" placeholder="Introduzca su búsqueda">
                            <button class="search-btn"><i class="fa fa-search"></i></button>
                        </div>

                        <!-- Botón Nuevo -->
                        <button class="nuevo-btn">
                            NUEVO <i class="fa fa-plus"></i>
                        </button>

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
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>GUVE0205</td>
                                        <td>Eduardo</td>
                                        <td>Guzmán</td>
                                        <td>Vega</td>
                                        <td>2002</td>
                                        <td>La Ciénega</td>
                                        <td>Recluta</td>
                                        <td>
                                            <i class="fa fa-eye"></i>
                                            <i class="fa fa-edit"></i>
                                            <i class="fa fa-trash"></i>
                                        </td>
                                    </tr>
                                    <!-- Más filas aquí -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-app-layout>
</body>

</html>
