<?php

use Illuminate\Database\Seeder;
use App\Models\Persona;
use App\User;
use App\Models\Rol;
use App\Models\Acceso;
use App\Models\UserRol;
use App\Models\AccesoRol;
use App\Models\Bregma;

class SuperadminSeeder extends Seeder
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
                "numero_documento"=>"00000000",
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
        $bregma = Bregma::firstOrCreate(
            [
                "tipo_documento_id"=>$persona->tipo_documento_id,
                "numero_documento"=>$persona->numero_documento
            ],[]
        );
        $rol = Rol::firstOrCreate(
            [
                "nombre"=>"Administrador Bregma",
                "tipo_acceso"=>1,
                "bregma_id"=>$bregma->id,
            ],
            [
                "estado_registro"=>"SU",
            ]
        );
        $usuario_rol = UserRol::firstOrCreate(
            [
                "user_id"=>$usuario->id,
                "rol_id"=>$rol->id,
            ],
            [
                "tipo_rol"=>1
            ]
        );


        // $persona1 = Persona::firstOrCreate(
        //     [
        //         "tipo_documento_id"=>1,
        //         "numero_documento"=>"0000",
        //     ],
        //     [
        //         "nombres"=>"Administrador",
        //         "apellido_paterno"=>"Super",
        //         "apellido_materno"=>"Visor",
        //     ]
        // );
        // $usuario1 = User::firstOrCreate(
        //     [
        //         "persona_id"=>$persona1->id,
        //         "username"=>$persona1->numero_documento,

        //     ],
        //     [
        //         "password"=>$persona1->numero_documento,
        //     ]
        // );
        // $rol1 = Rol::firstOrCreate(
        //     [
        //         "nombre"=>"Supervisor",
        //         "tipo_acceso"=>2,
        //     ],
        //     [
        //         "estado_registro"=>"SU",
        //     ]
        // );
        // UserRol::firstOrCreate(
        //     [
        //         "user_id"=>$usuario1->id,
        //         "rol_id"=>$rol1->id,
        //     ],
        //     [
        //         "tipo_rol"=>1
        //     ]
        // );

        $accesos = Acceso::where('tipo_acceso',1)->where('parent_id',null)->get();
        foreach ($accesos as $acceso ) {
            AccesoRol::firstOrCreate(
                [
                    "acceso_id"=>$acceso['id'],
                    "rol_id"=>$rol->id
                ],[]
            );
        }
    }
}
