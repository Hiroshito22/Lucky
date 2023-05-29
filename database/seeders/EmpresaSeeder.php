<?php

use App\Models\Acceso;
use App\Models\AccesoRol;
use Illuminate\Database\Seeder;
use App\Models\Sucursal;
use App\Models\Empresa;
use App\Models\Superarea;
use App\Models\Area;
use App\Models\Persona;
use App\Models\Rol;
use App\Models\Subarea;
use App\Models\UserRol;
use App\User;

class EmpresaSeeder extends Seeder
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
                "numero_documento"=>"22222222",
            ],
            [
                "nombres"=>"Administrador_Empresa",
                "apellido_paterno"=>"Admin",
                "apellido_materno"=>"Empresa",
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
        $empresa = Empresa::firstOrCreate(
            [
                "tipo_documento_id"=>$persona->tipo_documento_id,
                "numero_documento"=>$persona->numero_documento
            ],[]
        );
        //comentar creo...
        $rol = Rol::firstOrCreate(
            [
                "nombre"=>"Administrador Empresa",
                "tipo_acceso"=>3,
                "empresa_id"=>$empresa->id,
            ],
            [
                //corroborar el tipo de "estado_registro"
                "estado_registro"=>"SU",
            ]
        );
        UserRol::firstOrCreate(
            [
                "user_id"=>$usuario->id,
                // "rol_id"=>3,
                "rol_id"=>$rol->id,
            ],
            [
                "tipo_rol"=>1
            ]
        );

        $accesos = Acceso::where('tipo_acceso',3)->where('parent_id',null)->get();
        foreach ($accesos as $acceso ) {
            AccesoRol::firstOrCreate(
                [
                    "acceso_id"=>$acceso['id'],
                    "rol_id"=>$rol->id
                ],[]
            );
        }

    //     $empresa=Empresa::updateOrCreate(
    //         [
    //             'ruc'=>"10987867560",
    //         ],
    //         [
    //             'razon_social'=>"Empresa 1",
    //             'tipo_documento_id'=>1,
    //             'user_rol_id'=>1,
    //         ]);
    //     Sucursal::firstOrCreate([
    //         "empresa_id"=>$empresa->id,
    //         "nombre"=>"sucursal 1",
    //         "direccion"=>"direccion 1",
    //         "distrito_id"=>1,
    //     ],[]);

    //     $superarea=SuperArea::firstOrCreate([
    //         "empresa_id"=>1,
    //         "nombre"=>"Administrativo",
    //     ],[
    //         "estado_registro"=>"A"
    //     ]);
    //         $area = Area::firstOrCreate([
    //             "empresa_id"=>1,
    //             "nombre"=>"Finanza",
    //             "superarea_id"=>$superarea->id,
    //         ],[
    //             "estado_registro"=>"A"
    //         ]);
    //             $subarea = Subarea::firstOrCreate([
    //                 "empresa_id"=>1,
    //                 "nombre"=>"Cobranzas",
    //                 "area_id"=>$area->id,
    //             ],[
    //                 "estado_registro"=>"A"
    //             ]);
    //             $subarea = Subarea::firstOrCreate([
    //                 "empresa_id"=>1,
    //                 "nombre"=>"Contabilidad",
    //                 "area_id"=>$area->id,
    //             ],[
    //                 "estado_registro"=>"A"
    //             ]);
    //         $area = Area::firstOrCreate([
    //             "empresa_id"=>1,
    //             "nombre"=>"Venta",
    //             "superarea_id"=>$superarea->id,
    //         ],[
    //             "estado_registro"=>"A"
    //         ]);
    //             $subarea = Subarea::firstOrCreate([
    //                 "empresa_id"=>1,
    //                 "nombre"=>"Postventa",
    //                 "area_id"=>$area->id,
    //             ],[
    //                 "estado_registro"=>"A"
    //             ]);
    //             $subarea = Subarea::firstOrCreate([
    //                 "empresa_id"=>1,
    //                 "nombre"=>"Venta",
    //                 "area_id"=>$area->id,
    //             ],[
    //                 "estado_registro"=>"A"
    //             ]);
    //         $area = Area::firstOrCreate([
    //             "empresa_id"=>1,
    //             "nombre"=>"Recursos Humanos",
    //             "superarea_id"=>$superarea->id,
    //         ],[
    //             "estado_registro"=>"A"
    //         ]);
    //             $subarea = Subarea::firstOrCreate([
    //                 "empresa_id"=>1,
    //                 "nombre"=>"Reclutamiento",
    //                 "area_id"=>$area->id,
    //             ],[
    //                 "estado_registro"=>"A"
    //             ]);
    //             $subarea = Subarea::firstOrCreate([
    //                 "empresa_id"=>1,
    //                 "nombre"=>"Bienestar Social",
    //                 "area_id"=>$area->id,
    //             ],[
    //                 "estado_registro"=>"A"
    //             ]);
    //     $superarea=SuperArea::firstOrCreate([
    //         "empresa_id"=>1,
    //         "nombre"=>"Operativo",
    //     ],[
    //         "estado_registro"=>"A"
    //     ]);
    //         $area = Area::firstOrCreate([
    //             "empresa_id"=>1,
    //             "nombre"=>"Produccion",
    //             "superarea_id"=>$superarea->id,
    //         ],[
    //             "estado_registro"=>"A"
    //         ]);
    //             $subarea = Subarea::firstOrCreate([
    //                 "empresa_id"=>1,
    //                 "nombre"=>"Recepcion",
    //                 "area_id"=>$area->id,
    //             ],[
    //                 "estado_registro"=>"A"
    //             ]);
    //             $subarea = Subarea::firstOrCreate([
    //                 "empresa_id"=>1,
    //                 "nombre"=>"Molienda",
    //                 "area_id"=>$area->id,
    //             ],[
    //                 "estado_registro"=>"A"
    //             ]);
    //             $subarea = Subarea::firstOrCreate([
    //                 "empresa_id"=>1,
    //                 "nombre"=>"Envasado",
    //                 "area_id"=>$area->id,
    //             ],[
    //                 "estado_registro"=>"A"
    //             ]);
    //         $area = Area::firstOrCreate([
    //             "empresa_id"=>1,
    //             "nombre"=>"Calidad",
    //             "superarea_id"=>$superarea->id,
    //         ],[
    //             "estado_registro"=>"A"
    //         ]);
    //             $subarea = Subarea::firstOrCreate([
    //                 "empresa_id"=>1,
    //                 "nombre"=>"Aseguramiento de la calidad",
    //                 "area_id"=>$area->id,
    //             ],[
    //                 "estado_registro"=>"A"
    //             ]);
    //             $subarea = Subarea::firstOrCreate([
    //                 "empresa_id"=>1,
    //                 "nombre"=>"Gestion de la calidad",
    //                 "area_id"=>$area->id,
    //             ],[
    //                 "estado_registro"=>"A"
    //             ]);
    //         $area = Area::firstOrCreate([
    //             "empresa_id"=>1,
    //             "nombre"=>"Logistica",
    //             "superarea_id"=>$superarea->id,
    //         ],[
    //             "estado_registro"=>"A"
    //         ]);
    //             $subarea = Subarea::firstOrCreate([
    //                 "empresa_id"=>1,
    //                 "nombre"=>"Operario de carga",
    //                 "area_id"=>$area->id,
    //             ],[
    //                 "estado_registro"=>"A"
    //             ]);
    //             $subarea = Subarea::firstOrCreate([
    //                 "empresa_id"=>1,
    //                 "nombre"=>"Transportista",
    //                 "area_id"=>$area->id,
    //             ],[
    //                 "estado_registro"=>"A"
    //             ]);
    }
}
