<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use Auth;
use Illuminate\Support\Facades\Auth as Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Procesar el inicio de sesión
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // El usuario ha iniciado sesión correctamente
            return redirect()->intended('/dashboard');
        }

        // El inicio de sesión falló, redirigir de nuevo al formulario de inicio de sesión con un mensaje de error
        return redirect()->back()->withInput($request->only('email'))->withErrors([
            'email' => 'Credenciales incorrectas',
        ]);
    }
}
