<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use Auth;
use Illuminate\Support\Facades\Auth as Auth;

class LoginController extends Controller
{
    public function mostrar_login()
    {
        return view('mostrar_login');
    }
    public function mostrar_menu()
    {
        return view('menu_principal');
    }
    public function mostrar_usuario()
    {
        return view('crear_login');
    }
}
