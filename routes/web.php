<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DatosController;
use Illuminate\Support\Facades\Route;
/*
Route::get('/', function () {
    return view('welcome');
});
*/

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');


Route::get('/dashboard', [AdminController::class, 'home'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

/*
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
*/
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

require __DIR__.'/auth.php';
