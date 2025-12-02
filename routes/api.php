<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DatosController;
use App\Http\Controllers\Api\ReclutasController;
use App\Http\Controllers\Api\ReservaController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes - SIMECON
|--------------------------------------------------------------------------
| Rutas de API para el sistema SIMECON
| Todas las rutas protegidas requieren autenticación con Sanctum
*/

// ===== RUTAS PÚBLICAS (Sin autenticación) =====
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

// ===== RUTAS PROTEGIDAS (Requieren token de autenticación) =====
Route::middleware('auth:sanctum')->group(function () {
    
    // Autenticación
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);
    
    // ===== DATOS GENERALES =====
    Route::prefix('datos')->group(function () {
        Route::get('/', [DatosController::class, 'index']);           // Listar todos con filtros
        Route::post('/', [DatosController::class, 'store']);          // Crear nuevo
        Route::get('/{curp}', [DatosController::class, 'show']);      // Ver uno específico
        Route::put('/{curp}', [DatosController::class, 'update']);    // Actualizar
        Route::delete('/{curp}', [DatosController::class, 'destroy']); // Eliminar
    });
    
    // ===== RECLUTAS =====
    Route::prefix('reclutas')->group(function () {
        Route::get('/', [ReclutasController::class, 'index']);                      // Listar reclutas
        Route::post('/', [ReclutasController::class, 'store']);                     // Crear recluta
        Route::get('/{curp}', [ReclutasController::class, 'show']);                 // Ver recluta
        Route::put('/{curp}', [ReclutasController::class, 'update']);               // Actualizar recluta
        Route::delete('/{curp}', [ReclutasController::class, 'destroy']);           // Eliminar recluta
        Route::post('/{curp}/promover', [ReclutasController::class, 'promoverAReserva']); // Promover a reserva
    });
    
    // ===== RESERVAS =====
    Route::prefix('reserva')->group(function () {
        Route::get('/', [ReservaController::class, 'index']);                       // Listar reservas
        Route::get('/estadisticas', [ReservaController::class, 'estadisticas']);    // Estadísticas
        Route::get('/matricula/{matricula}', [ReservaController::class, 'buscarPorMatricula']); // Buscar por matrícula
        Route::get('/{curp}', [ReservaController::class, 'show']);                  // Ver reserva
        Route::put('/{curp}', [ReservaController::class, 'update']);                // Actualizar reserva
    });
});