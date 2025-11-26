<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
  public function index(Request $request)
  {
    $search = $request->get('search');
    
    $datos = \App\Models\Dato::where('status', 'Recluta')
        ->when($search, function($query, $search) {
            return $query->where(function($q) use ($search) {
                $q->where('curp', 'LIKE', "%{$search}%")
                  ->orWhere('nombre', 'LIKE', "%{$search}%")
                  ->orWhere('apellido_paterno', 'LIKE', "%{$search}%")
                  ->orWhere('apellido_materno', 'LIKE', "%{$search}%")
                  ->orWhere('matricula', 'LIKE', "%{$search}%")
                  ->orWhere('clase', 'LIKE', "%{$search}%")
                  ->orWhere('domicilio', 'LIKE', "%{$search}%");
            });
        })
        ->get();
    
    return view('admin.dashboard', compact('datos', 'search'));
  }

  public function reclutas(Request $request)
  {
    if ($request->user()->usertype === 'admin') {
      $search = $request->get('search');
      
      $datos = \App\Models\Dato::where('status', 'Recluta')
          ->when($search, function($query, $search) {
              return $query->where(function($q) use ($search) {
                  $q->where('curp', 'LIKE', "%{$search}%")
                    ->orWhere('nombre', 'LIKE', "%{$search}%")
                    ->orWhere('apellido_paterno', 'LIKE', "%{$search}%")
                    ->orWhere('apellido_materno', 'LIKE', "%{$search}%")
                    ->orWhere('clase', 'LIKE', "%{$search}%")
                    ->orWhere('domicilio', 'LIKE', "%{$search}%");
              });
          })
          ->get();
      
      return view('admin.Reclutas', compact('datos', 'search'));
    } else {
      return redirect()->route('dashboard');
    }
  }

  public function reserva(Request $request)
  {
    if ($request->user()->usertype === 'admin') {
      return view('admin.Reserva');
    } else {
      return redirect()->route('dashboard');
    }
  }

  public function home()
  {
    $datos = \App\Models\Dato::all();
    return view('admin.dashboard', compact('datos'));
  }
}
