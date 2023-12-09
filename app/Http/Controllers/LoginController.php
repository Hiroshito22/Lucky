<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use Auth;
use Illuminate\Support\Facades\Auth as Auth;

class LoginController extends Controller
{
    /*public function mostrar_login(Request $request)
    {
        return view('mostrar_login');
    }
    public function mostrar_menu(Request $request)
    {
        return view('mostrar_menu');
    }*/
    public function traer_user_pass(Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');
        return response()->json($username);
    }
}
