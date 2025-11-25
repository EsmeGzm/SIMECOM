<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
  //Crear dos funciones separadas 

  public function index(Request $request)
  {
    if ($request->user()->usertype === 'admin') {
      return view('admin.dashboard');
    } else {
      return redirect()->route('dashboard');
    }
  }

  public function reclutas(Request $request)
  {
    if ($request->user()->usertype === 'admin') {
      return view('admin.Reclutas');
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
    return view('admin.dashboard');
  }
}
