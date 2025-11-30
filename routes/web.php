<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DatosController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::get('/dashboard', function () {
    if (Auth::check() && Auth::user()->usertype === 'admin') {
        return redirect()->route('admin.dashboard');
    }
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::post('/datos', [DatosController::class, 'store'])
    ->middleware(['auth'])
    ->name('datos.store');

Route::get('admin/dashboard', [AdminController::class, 'index'])
    ->middleware(['auth', 'admin'])
    ->name('admin.dashboard');

Route::get('/admin/reclutas', [AdminController::class, 'reclutas'])
    ->middleware(['auth', 'admin'])
    ->name('admin.reclutas');

Route::get('/admin/reserva', [AdminController::class, 'reserva'])
    ->middleware(['auth', 'admin'])
    ->name('admin.reserva');

Route::get('/datos/{curp}/edit', [DatosController::class, 'edit'])
    ->name('datos.edit');

Route::put('/datos/{curp}', [DatosController::class, 'update'])
    ->name('datos.update');

Route::delete('/datos/{curp}', [DatosController::class, 'destroy'])
    ->name('datos.destroy');

// Rutas para Reclutas
Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/reclutas', [App\Http\Controllers\ReclutasController::class, 'index'])->name('admin.reclutas');
    Route::post('/reclutas', [App\Http\Controllers\ReclutasController::class, 'store'])->name('reclutas.store');
    Route::get('/reclutas/{curp}/edit', [App\Http\Controllers\ReclutasController::class, 'edit'])->name('reclutas.edit');
    Route::put('/reclutas/{curp}', [App\Http\Controllers\ReclutasController::class, 'update'])->name('reclutas.update');
    Route::delete('/reclutas/{curp}', [App\Http\Controllers\ReclutasController::class, 'destroy'])->name('reclutas.destroy');
});

// Rutas para Reserva
Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/reserva', [App\Http\Controllers\ReservaController::class, 'index'])->name('admin.reserva');
    Route::get('/reserva/{curp}/edit', [App\Http\Controllers\ReservaController::class, 'edit'])->name('reserva.edit');
    Route::put('/reserva/{curp}', [App\Http\Controllers\ReservaController::class, 'update'])->name('reserva.update');
});

require __DIR__.'/auth.php';
