<?php

use App\Models\Persona;
use App\Models\UserRol;
use Illuminate\Database\Seeder;
use App\User;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $persona = Persona::firstOrCreate([
            "numero_documento"=>"11111111",
            "tipo_documento_id"=>1,
            "nombres"=>"Coorporativo",
            "apellido_paterno"=>"Adm Cooporativo",
            "apellido_materno"=>"Adm Cooporativo",
        ]);
        $user = User::firstOrCreate(
            [
                "persona_id"=>$persona->id,
                "username"=>$persona->numero_documento,
            ],
            [
                "password"=>$persona->numero_documento,
            ]
        );

        $user_rol = UserRol::updateOrCreate(
            [
                "user_id"=>$user->id,
                "rol_id"=>1,
                "tipo_rol"=>1,

            ],
            [
                "estado_registro"=>"A"
            ]
        );
        $user_rol = UserRol::updateOrCreate(
            [
                "user_id"=>$user->id,
                "rol_id"=>2,
                "tipo_rol"=>2,

            ],
            [
                "estado_registro"=>"A"
            ]
        );
        $user_rol = UserRol::updateOrCreate(
            [
                "user_id"=>$user->id,
                "rol_id"=>3,
                "tipo_rol"=>3,
            ],
            [
                "estado_registro"=>"A"
            ]
        );
    }
}
