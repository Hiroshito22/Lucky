<?php

use App\Models\Acceso;
use App\Models\AccesoRol;
use App\Models\Clinica;
use App\Models\Persona;
use App\Models\Rol;
use App\Models\UserRol;
use App\User;
use Illuminate\Database\Seeder;

class ClinicaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $persona = Persona::firstOrCreate(
            [
                "tipo_documento_id"=>1,
                "numero_documento"=>"11111111",
            ],
            [
                "nombres"=>"Administrador",
                "apellido_paterno"=>"Super",
                "apellido_materno"=>"Admin",
            ]
        );
        $usuario = User::firstOrCreate(
            [
                "persona_id"=>$persona->id,
                "username"=>$persona->numero_documento,

            ],
            [
                "password"=>$persona->numero_documento,
            ]
        );
        $clinica = Clinica::firstOrCreate(
            [
                "tipo_documento_id"=>$persona->tipo_documento_id,
                "numero_documento"=>$persona->numero_documento
            ],[]
        );
        $rol = Rol::firstOrCreate(
            [
                "nombre"=>"Administrador Clinica",
                "tipo_acceso"=>2,
                "clinica_id"=>$clinica->id,
            ],
            [
                "estado_registro"=>"SU",
            ]
        );
        UserRol::firstOrCreate(
            [
                "user_id"=>$usuario->id,
                "rol_id"=>$rol->id,
            ],
            [
                "tipo_rol"=>1
            ]
        );

        $accesos = Acceso::where('tipo_acceso',2)->where('parent_id',null)->get();
        foreach ($accesos as $acceso ) {
            AccesoRol::firstOrCreate(
                [
                    "acceso_id"=>$acceso['id'],
                    "rol_id"=>$rol->id
                ],[]
            );
        }

        // $clinica = Clinica::firstOrCreate(
        //     [
        //         "ruc"=>"20602028501"

        //     ],
        //     [
        //         "razon_social"=>"GETBYTE SAC",
        //         "direccion"=>"Lima",
        //         "tipo_clinica_id"=>1,
        //         "distrito_id"=>1,
        //         "estado_registro"=>"A"
        //     ]
        // );
        // $persona = Persona::firstOrCreate(
        //     [
        //         "tipo_documento_id"=>2,
        //         "numero_documento"=>$clinica->ruc,
        //     ],
        //     [
        //         "nombres"=>$clinica->razon_social,
        //     ]
        // );
        // $user = User::updateOrCreate(
        //     [
        //         "username"=>$clinica->ruc,
        //         "persona_id"=>$persona->id,
        //     ],
        //     [
        //         "password"=>$clinica->ruc,
        //     ]
        // );
        // $user_rol = UserRol::updateOrCreate(
        //     [
        //         "user_id"=>$user->id,
        //         "rol_id"=>3,
        //         "tipo_rol"=>3,
        //     ],
        //     [
        //         "estado_registro"=>"A"
        //     ]
        // );
        // $rol_clinica = RolClinica::firstOrCreate(
        //     [
        //         "nombre"=>"Administrador",
        //         "clinica_id"=>$clinica->id,
        //         "estado_registro"=>"A"
        //     ]
        // );
        // $sucursal = SucursalClinica::firstOrCreate(
        //     [
        //         "nombre_sucursal"=>"Principal",
        //     ],
        //     [
        //         "direccion_sucursal"=>"Cal. J Mza. T1 Lote. 4 Asc. Familiar Santa Rosa (Coop. La Fragata)",
        //         "clinica_id"=>$clinica->id,
        //         "estado_registro"=>"A"
        //     ]
        // );
        // $horario_clinica = HorarioClinica::firstOrCreate(
        //     [
        //         "dia_id"=>1,
        //         "sucursal_clinica_id"=>$sucursal->id,

        //     ],[
        //         "horario_inicio"=>"06:00:00",
        //         "horario_fin"=>"18:00:00",
        //         "estado_registro"=>"A"
        //     ]
        // );
        // $horario_clinica = HorarioClinica::firstOrCreate(
        //     [
        //         "dia_id"=>2,
        //         "sucursal_clinica_id"=>$sucursal->id,

        //     ],[
        //         "horario_inicio"=>"06:00:00",
        //         "horario_fin"=>"18:00:00",
        //         "estado_registro"=>"A"
        //     ]
        // );
        // $horario_clinica = HorarioClinica::firstOrCreate(
        //     [
        //         "dia_id"=>3,
        //         "sucursal_clinica_id"=>$sucursal->id,

        //     ],[
        //         "horario_inicio"=>"06:00:00",
        //         "horario_fin"=>"18:00:00",
        //         "estado_registro"=>"A"
        //     ]
        // );
        // $horario_clinica = HorarioClinica::firstOrCreate(
        //     [
        //         "dia_id"=>4,
        //         "sucursal_clinica_id"=>$sucursal->id,

        //     ],[
        //         "horario_inicio"=>"06:00:00",
        //         "horario_fin"=>"18:00:00",
        //         "estado_registro"=>"A"
        //     ]
        // );
        // $horario_clinica = HorarioClinica::firstOrCreate(
        //     [
        //         "dia_id"=>5,
        //         "sucursal_clinica_id"=>$sucursal->id,

        //     ],[
        //         "horario_inicio"=>"06:00:00",
        //         "horario_fin"=>"18:00:00",
        //         "estado_registro"=>"A"
        //     ]
        // );
        // $horario_clinica = HorarioClinica::firstOrCreate(
        //     [
        //         "dia_id"=>6,
        //         "sucursal_clinica_id"=>$sucursal->id,

        //     ],[
        //         "horario_inicio"=>"06:00:00",
        //         "horario_fin"=>"12:00:00",
        //         "estado_registro"=>"A"
        //     ]
        // );
        // $trabajador_clinica = TrabajadorClinica::updateOrCreate(
        //     [

        //         "persona_id"=>$persona->id
        //     ],
        //     [
        //         "sucursal_clinica_id"=>$sucursal->id,
        //         "clinica_id"=>$clinica->id,
        //         "estado_registro"=>"A",
        //         "user_rol_id"=>$user_rol->id,
        //     ]
        // );

        // Clinica::firstOrCreate([
        //     "bregma_id"=>null,
        //     "tipo_documento_id"=>null,
        //     "distrito_id"=>null,
        //     "ruc"=>"ruc example1",
        //     "razon_social"=>"razon social example1",
        //     "responsable"=>"responsable example1",
        //     "nombre_comercial"=>"nombre comercial example1",
        //     "latitud"=>"latitud example1",
        //     "longitud"=>"longitud example1",
        //     "direccion"=>"direccion example1",
        //     "logo"=>"logo example1",
        //     "estado_registro"=>"A"
        // ]);
        // Clinica::firstOrCreate([
        //     "bregma_id"=>null,
        //     "tipo_documento_id"=>null,
        //     "distrito_id"=>null,
        //     "ruc"=>"ruc example2",
        //     "razon_social"=>"razon social example2",
        //     "responsable"=>"responsable example2",
        //     "nombre_comercial"=>"nombre comercial example2",
        //     "latitud"=>"latitud example2",
        //     "longitud"=>"longitud example2",
        //     "direccion"=>"direccion example12",
        //     "logo"=>"logo example2",
        //     "estado_registro"=>"A"
        // ]);
        // Clinica::firstOrCreate([
        //     "bregma_id"=>null,
        //     "tipo_documento_id"=>null,
        //     "distrito_id"=>null,
        //     "ruc"=>"ruc example3",
        //     "razon_social"=>"razon social example3",
        //     "responsable"=>"responsable example3",
        //     "nombre_comercial"=>"nombre comercial example3",
        //     "latitud"=>"latitud example3",
        //     "longitud"=>"longitud example3",
        //     "direccion"=>"direccion example3",
        //     "logo"=>"logo example3",
        //     "estado_registro"=>"A"
        // ]);


    }
}