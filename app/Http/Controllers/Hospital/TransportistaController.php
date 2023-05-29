<?php

namespace App\Http\Controllers\Hospital;

use App\Http\Controllers\Controller;
use App\Models\Hospital;
use App\Models\Material;
use App\Models\Persona;
use App\Models\Personal;
use App\Models\Rol;
use App\Models\TransportistaMaterial;
use App\Models\TransportistaVehiculo;
use App\Models\UserRol;
use App\Models\Vehiculo;
use App\User;
use Illuminate\Http\Request;

class TransportistaController extends Controller
{
    public function admin()
    {
        $superadmin = User::with('persona', 'user_rol.rol.acceso_rol.acceso', 'roles.accesos')->find(auth()->user()->id);
        $valido = false;
        foreach ($superadmin->roles as $roles) {
            foreach ($roles->accesos as $accesos) {
                if ($accesos['tipo_acceso'] == 2) {
                    return $valido = true;
                }
            }
        }
        return $valido;
    }

    public function index()
    {
        if ($this->admin() == false) {
            return response()->json(["resp" => "no tiene accesos"]);
        }
        $usuario = User::with('roles')->find(auth()->user()->id);
        $hospital = Hospital::where('numero_documento', $usuario->username)->first();
        $personal = Personal::with('persona.tipo_documento', 'user.roles', 'vehiculo.tipo_vehiculo')->where('hospital_id', $hospital->id)->where('estado_registro', 'A')->get();

        return response()->json(["data" => $personal, "size" => count($personal)]);
    }

    public function create(Request $request)
    {
        if ($this->admin() == false) {
            return response()->json(["resp" => "no tiene accesos"]);
        }
        $usuario = User::with('roles')->find(auth()->user()->id);
        $hospital = Hospital::where('numero_documento', $usuario->username)->first();

        $persona = Persona::firstOrCreate(
            [
                "tipo_documento_id" => $request->tipo_documento_id,
                "numero_documento" => $request->numero_documento,
            ],
            [
                "nombres" => $request->nombres,
                "apellido_paterno" => $request->apellido_paterno,
                "apellido_materno" => $request->apellido_materno,
                "telefono" => $request->telefono,
                "email" => $request->email,
                "grado_instruccion_id" => $request->grado_instruccion_id,

            ]
        );
        $user = User::updateOrCreate(
            [
                "username" => $persona->numero_documento,
                "persona_id" => $persona->id,
            ],
            [
                "password" => $persona->numero_documento,
            ]
        );
        $rol = Rol::find(5);
        $user_rol = UserRol::updateOrCreate(
            [
                "user_id" => $user->id,
                "rol_id" => $rol->id,

            ],
            [

                "estado_registro" => "A",
            ]
        );
        if ($hospital) {
            $personal = Personal::updateOrCreate(
                [
                    "persona_id" => $persona->id,
                    "hospital_id" => $hospital->id,
                    "user_id" => $user->id,
                ],
                [

                    "estado_registro" => "A"
                ]
            );
        }
        if ($personal) {
            $personal = Personal::updateOrCreate(
                [
                    "persona_id" => $persona->id,
                    "hospital_id" => $personal->hospital_id,
                    "user_id" => $user->id,
                ],
                [

                    "estado_registro" => "A"
                ]
            );
        }
        return response()->json(["resp" => "Transportista creado correctamente"]);
    }

    public function setVehiculo(Request $request)
    {
        if ($this->admin() == false) {
            return response()->json(["resp" => "no tiene accesos"]);
        }


        $transportista = Personal::find($request->transportista_id);
        if($transportista->vehiculo_id != null){
            $vehiculo_aux = Vehiculo::find($transportista->vehiculo_id);
            $vehiculo_aux->fill([
                'estado_ocupado' => 0
            ])->save();

            $transportista_vehiculo = TransportistaVehiculo::updateOrCreate(
                [
                    "vehiculo_id" => $request->vehiculo_id,
                    "transportista_id" => $transportista->id,
                ],
                [
                    'estado_registro' => "I"
                ]
            );
        }
        $transportista->fill([
            'vehiculo_id' => $request->vehiculo_id
        ])->save();

        $vehiculo = Vehiculo::find($request->vehiculo_id);
        $vehiculo->fill([
            'estado_ocupado' => 1
        ])->save();

        $transportista_vehiculo = TransportistaVehiculo::create(
            [
                "vehiculo_id" => $request->vehiculo_id,
                "transportista_id" => $transportista->id,
            ],
            []
        );

        return response()->json(["resp" => "Creado correctamente"]);
    }

    public function getAllVehiculos()
    {
        if ($this->admin() == false) {
            return response()->json(["resp" => "no tiene accesos"]);
        }
        $usuario = User::with('roles')->find(auth()->user()->id);
        $hospital = Hospital::where('numero_documento', $usuario->username)->first();
        $vehiculos = Vehiculo::with('tipo_vehiculo')->where('estado_ocupado','0')->where('hospital_id',$hospital->id)->where('estado_registro','A')->get();
        return response()->json(["data" => $vehiculos, "size" => count($vehiculos)]);
    }

    public function getAllMateriales()
    {
        if ($this->admin() == false) {
            return response()->json(["resp" => "no tiene accesos"]);
        }
        $usuario = User::with('roles')->find(auth()->user()->id);
        $hospital = Hospital::where('numero_documento', $usuario->username)->first();
        $materiales = Material::where('hospital_id',$hospital->id)->where('estado_registro','A')->get();
        return response()->json(["data" => $materiales, "size" => count($materiales)]);
    }

    public function getVehiculo($idTransportista)
    {
        if ($this->admin() == false) {
            return response()->json(["resp" => "no tiene accesos"]);
        }
        $transportista_vehiculo = TransportistaVehiculo::with(['vehiculo.tipo_vehiculo', 'transportista'])->where('transportista_id', $idTransportista)->where('estado_registro', 'A')->first();
        return response()->json(["data" => $transportista_vehiculo]);
    }

    public function setMateriales(Request $request)
    {
        if ($this->admin() == false) {
            return response()->json(["resp" => "no tiene accesos"]);
        }

        $transportista_material = TransportistaMaterial::create(
            [
                'transportista_id'=>$request->transportista_id,
                'material_id'=>$request->material_id,
                'estado_registro'=>'A'
            ]
        );

        return response()->json(["resp" => "Creado correctamente"]);
    }
}
