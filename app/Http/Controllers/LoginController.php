<?php

namespace App\Http\Controllers;

use App\Models\Persona;
use App\User;
use Illuminate\Http\Request;
//use Auth;
use Illuminate\Support\Facades\Auth as Auth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth as FacadesJWTAuth;
use Tymon\JWTAuth\JWTAuth;

class LoginController extends Controller
{
    public function mostrar_login()
    {
        return view('mostrar_login');
    }
    public static function cambiarDuracionToken()
    {
        JWTAuth::factory()->setTTL(60 * 24 * 30);
    }


    public function mostrar_menu($username)
    {
        $usernameu = User::where('id', $username)->first();

        if (!$usernameu) {
            return redirect()->route('login');
            //return response()->json(["error" => "El nombre de usuario no existe"], 400);
        }

        $user = User::with('persona')->where('id', $username)->where('estado_registro', 'A')->first();

        if (!$user) {
            return redirect()->route('login');
            //return response()->json(['error' => 'Usuario bloqueado'], 402);
        }
        $response = [
            "nombres" => $user->persona->nombres,
            "apellido_paterno" => $user->persona->apellido_paterno,
            "apellido_materno" => $user->persona->apellido_materno,
            "username" => $user->username,
            "celular" =>$user->persona->celular,
            "correo" => $user->persona->correo,
        ];

        //$response['token'] = $token;
        //return response()->json($response);
        return view('menu_principal',$response);
    }
    public function mostrar_usuario()
    {
        return view('crear_login');
    }
}
