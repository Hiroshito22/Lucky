<?php

namespace App\Http\Controllers\Hospital;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Clinica;
use App\Models\Hospital;
use App\Models\UserRol;
use App\Models\Rol;
use App\Models\Acceso;
use App\Models\AccesoRol;
use App\Models\Clinica\TrabajadorClinica;
use App\Models\Persona;
use App\Models\Patologia;
use App\Models\HospitalPatologia;
use App\Models\Servicio;
use App\Models\ServicioHospital;
use App\User;
use Illuminate\Support\Facades\DB;
use TheSeer\Tokenizer\Exception;

class HospitalController extends Controller
{
    public function acceso_superadmin()
    {
        $superadmin = User::with('persona', 'user_rol.rol.acceso_rol.acceso', 'roles.accesos')->find(auth()->user()->id);
        $valido = false;
        foreach ($superadmin->roles as $roles) {
            foreach ($roles->accesos as $accesos) {
                if ($accesos['tipo_acceso'] == 1) {
                    return $valido = true;
                }
            }
        }
        return $valido;
    }
    public function index()
    {
        $superadmin = User::with('persona', 'user_rol.rol.acceso_rol.acceso', 'roles.accesos')->find(auth()->user()->id);
        $valido = false;
        foreach ($superadmin->roles as $roles) {
            foreach ($roles->accesos as $accesos) {
                if ($accesos['tipo_acceso'] == 1) {
                    $valido = true;
                }
            }
        }
        if ($valido) {
            $hospital = Hospital::with('tipo_documento', 'distrito.provincia.departamento')->where('estado_registro', '=', 'A')->get();
            return response()->json(['data' => $hospital, 'size' => count($hospital)], 200);
        }
        return response()->json(["resp" => "no tiene accesos"]);
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            if ($this->acceso_superadmin() == false) {
                return response()->json(["resp" => "no tiene accesos"]);
            }
            $hospital = Hospital::updateOrCreate(
                [
                    'tipo_documento_id' => $request->tipo_documento_id,
                    "numero_documento" => $request->numero_documento,

                ],
                [
                    'razon_social' => $request->razon_social,
                    'direccion' => $request->direccion,
                    "distrito_id" => $request->distrito_id,
                    'estado_pago' => $request->estado_pago,
                    'latitud' => $request->latitud,
                    'longitud' => $request->longitud,
                    'estado_registro' => "A"
                ]
            );

            if ($request->hasFile('logo')) {
                $path = $request->file('logo')->storeAs('public/hospital', $hospital->id . '-' . $request->numero_documento . '.' . $request->logo->extension());
                $image = $hospital->id . '-' . $request->numero_documento . '.' . $request->logo->extension();
            } else {
                $image = null;
            }
            $hospital->logo = $image;
            $hospital->save();

            $persona = Persona::firstOrCreate(
                [
                    'tipo_documento_id' => $request->tipo_documento_id,
                    'numero_documento' => $request->numero_documento
                ],
                [

                    'nombres' => $request->razon_social,
                ]
            );

            $usuario = User::firstOrCreate(
                [
                    "username" => $request->numero_documento,
                    "persona_id" => $persona->id,

                ],
                [
                    "password" => $request->numero_documento,

                ]
            );

            $rol = Rol::firstOrCreate(
                [
                    "nombre" => "Administrador Hospital",
                    "tipo_acceso" => 2,

                ],
                [
                    "estado_registro" => "AD"
                ]
            );
            $usuario_rol = UserRol::firstOrCreate(
                [
                    "user_id" => $usuario->id,
                    "rol_id" => $rol->id,
                ],
                [
                    "tipo_rol" => 2
                ]
            );
            $accesos = Acceso::where('tipo_acceso', 2)->get();
            foreach ($accesos as $acceso) {
                $acceso_rol = AccesoRol::firstOrCreate(
                    [
                        "acceso_id" => $acceso["id"],
                        "rol_id" => $rol->id,
                    ],
                    []
                );
            }
            $patologias = Patologia::where('estado_registro', 'SU')->where('hospital_id', null)->get();
            foreach ($patologias as $patologia) {
                $hospital_patologia = HospitalPatologia::updateOrCreate(
                    [
                        "hospital_id" => $hospital->id,
                        "patologia_id" => $patologia['id'],
                    ],
                    [
                        "activo" => 1,
                        "estado_registro" => "SU"
                    ]
                );
            }
            $servicios = Servicio::get();
            foreach ($servicios as $servicio ) {
                ServicioHospital::updateOrCreate(
                    [
                        'hospital_id'=>$hospital->id,
                        'servicio_id' => $servicio->id,
                        'precio'=>0,
                    ],[]
                );
            }
            DB::commit();
            return response()->json(["resp" => "Se creo correctamente"]);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(["resp" => "error", "error" => $e], 500);
        }
    }
    public function update($hospital_id, Request $request)
    {

        if ($this->acceso_superadmin() == false) {
            return response()->json(["resp" => "no tiene accesos"]);
        }

        DB::beginTransaction();
        try {
            $hospital = Hospital::findOrfail($hospital_id);

            if ($hospital->numero_documento == $request->numero_documento) {
                if ($request->hasFile('logo')) {
                    $path = $request->file('logo')->storeAs('public/hospital', $hospital->id . '-' . $request->numero_documento . '.' . $request->logo->extension());
                    $image = $hospital->id . '-' . $request->numero_documento . '.' . $request->logo->extension();
                    $hospital->logo = $image;
                }
                $hospital->fill(
                    [
                        "razon_social" => $request->razon_social,
                        "direccion" => $request->direccion,
                        'latitud' => $request->latitud,
                        "longitud" => $request->longitud,
                        "distrito_id" => $request->distrito_id,
                    ]
                )->save();
            } else {
                $existeHospital = Hospital::where('numero_documento', $request->numero_documento)->first();
                if (!$existeHospital) {

                    $persona = Persona::where('numero_documento', $hospital->numero_documento)->first();
                    $usuario = User::where('username', $hospital->numero_documento)->first();
                    if ($request->hasFile('logo')) {
                        $path = $request->file('logo')->storeAs('public/hospital', $hospital->id . '-' . $request->numero_documento . '.' . $request->logo->extension());
                        $image = $hospital->id . '-' . $request->numero_documento . '.' . $request->logo->extension();
                        $hospital->logo = $image;
                    }
                    $hospital->fill(
                        [
                            "razon_social" => $request->razon_social,
                            "numero_documento" => $request->numero_documento,
                            "direccion" => $request->direccion,
                            'latitud' => $request->latitud,
                            "longitud" => $request->longitud,
                            "distrito_id" => $request->distrito_id,
                        ]
                    )->save();
                    $persona->fill(
                        [
                            "tipos_documento_id" => $request->tipo_documento_id,
                            "numero_documento" => $request->numero_documento,
                            'nombres' => $request->razon_social,
                        ]
                    )->save();
                    $usuario->fill(
                        [
                            "username" => $request->numero_documento,
                            "password" => $request->numero_documento,
                        ]
                    )->save();
                } else {
                }
            }
            DB::commit();
            return response()->json(["resp" => "Se edito correctamente"]);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(["resp" => "error", "error" => $e], 500);
        }
    }

    public function destroy($idClinica)
    {
        $administradormedical = UserRol::where("user_id", auth()->user()->id)->where("rol_id", 1)->first();
        if (!$administradormedical || $administradormedical == 'I') {
            return response()->json(["resp" => "no tiene accesos"]);
        }
        $clinica = Clinica::findOrfail($idClinica);
        $clinica->estado_registro = 'I';

        $clinica->save();
        return response()->json(["resp" => "Se elimino correctamente"]);
    }

    /**public function updateMe(Request $request){
        $administrador_clinica = UserRol::where("user_id",auth()->user()->id)->where("rol_id",3)->where('tipo_rol',3)->first();
        if(!$administrador_clinica || $administrador_clinica->estado_registro == 'I'){
            return response()->json(["resp"=>"no tiene accesos"]);
        }
        $trabajador = TrabajadorClinica::where('user_rol_id',$administrador_clinica->id)->where('estado_registro','A')->orderBy('id','desc')->first();
        if(!$trabajador){
            return response()->json(["resp"=>"no tiene accesos"]);
        }
        $clinica_asociada = Clinica::find($trabajador->clinica_asociada_id);
        $clinica_asociada->fill([
            "razon_social"=>$request->razon_social,
            "direccion"=>$request->direccion,
            "nombre_comercial"=>$request->nombre_comercial,
        ])->save();
        return response()->json(["resp"=>"Se edito correctamente"],200);
    }**/
}
