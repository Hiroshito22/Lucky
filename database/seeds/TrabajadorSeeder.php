<?php

use App\Models\Persona;
use App\Models\Trabajador;
use App\Models\HistoriaClinica;
use App\Models\UserRol;
use App\User;
use Illuminate\Database\Seeder;

class TrabajadorSeeder extends Seeder
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
                    "numero_documento"=>"12345678",
                ],
                [
                    "nombres"=>"David",
                    "apellido_paterno"=>"Peña",
                    "apellido_materno"=>"Ugarte",
                    "fecha_nacimiento"=>"1995-12-14",
                    "telefono"=>"921757621",
                    "email"=>"david@gmail.com",
                    "direccion"=>"Mariano Melgar",
                    "distrito_id"=>1,
                    "estado_civil_id"=>1,
                    "sexo_id"=>1,
                    "grado_instruccion_id"=>1
                ]
                );

            $user = User::firstOrCreate(
                [
                    "username"=>$persona->numero_documento,
                    "persona_id"=>$persona->id,
                ],
                [
                    "password"=>$persona->numero_documento,
                ]
            );

            $user_rol_trabajador = UserRol::updateOrCreate(
                [
                    "user_id"=>$user->id,
                    "rol_id"=>3,
                ],
                [
                    "estado_registro"=>"A"
                ]
            );

            $trabajador= Trabajador::updateOrCreate(
                [
                    "empresa_id"=>1,
                    "persona_id"=>$persona->id,
                    "user_rol_id"=>$user_rol_trabajador->id,
                ],
                [
                    "subarea_id"=>1,
                    "sucursal_id"=>1,
                    "estado_registro"=>"A",
                    "estado_trabajador"=>null,
                ]
            );

            $persona2 = Persona::firstOrCreate(
                [
                    "tipo_documento_id"=>1,
                    "numero_documento"=>"87654321",
                ],
                [
                    "nombres"=>"Andre",
                    "apellido_paterno"=>"Cruz",
                    "apellido_materno"=>"Gonzales",
                    "fecha_nacimiento"=>"1996-01-24",
                    "telefono"=>"987654321",
                    "email"=>"andre@gmail.com",
                    "direccion"=>"Yanahuara",
                    "distrito_id"=>2,
                    "estado_civil_id"=>2,
                    "sexo_id"=>1,
                    "grado_instruccion_id"=>4
                ]
                );
               
            $user = User::firstOrCreate(
                [
                    "username"=>$persona2->numero_documento,
                    "persona_id"=>$persona2->id,
                ],
                [
                    "password"=>$persona2->numero_documento,
                ]
            );
                
            $user_rol_trabajador = UserRol::updateOrCreate(
                [
                    "user_id"=>$user->id,
                    "rol_id"=>3,
                ],
                [
                    "estado_registro"=>"A"
                ]
            );
            
            $trabajador2= Trabajador::updateOrCreate(
                [
                    "empresa_id"=>1,
                    "persona_id"=>$persona2->id,
                    "user_rol_id"=>$user_rol_trabajador->id,
                ],
                [
                    "subarea_id"=>3,
                    "sucursal_id"=>1,
                    "estado_registro"=>"A",
                    "estado_trabajador"=>null,
                ]
            );
    }
}
