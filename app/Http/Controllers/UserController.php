<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    //Crear dos funciones separadas 

    public function index(Request $request)
    {
      if ($request->user()->usertype === 'admin') {
          return view('admin.dashboard');
        } 
      else {
          return redirect()->route('dashboard');
      }  
    }

    public function home(Request $request)
    {
       if ($request->user()->usertype === 'user') {
          return view('dashboard');
        } 
       else {
          return redirect()->route('admin.dashboard');
        }

    }
}

