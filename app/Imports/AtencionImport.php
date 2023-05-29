<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use App\Models\UserRol;
use App\Models\Empresa;
use App\Models\Persona;
use App\Models\Trabajador;
use App\User;
use Maatwebsite\Excel\Row;
use App\Models\HistoriaClinica;
use App\Models\HCTrabajador;
class AtencionImport implements WithHeadingRow,SkipsEmptyRows
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        //
    }
    /*public function onRow(Row $row){
        $user_rol=UserRol::where('user_id',auth()->user()->id)->where('rol_id',1)->first();
        $empresa = Empresa::where('user_rol_id',$user_rol->id)->first();
        if($row['dni']!=NULL){
            
            if(strtoupper($row['tipo_documento'])=="DNI"){
                $tipo_documento_id=1;
            }
            if(strtoupper($row['tipo_documento'])=="PASAPORTE"){
                $tipo_documento_id=4;
            }
            if(strtoupper($row['tipo_documento'])=="CE"){
                $tipo_documento_id=3;
            }
            $persona=Persona::firstOrCreate([
                "numero_documento"=>$row['dni'],
                "tipo_documento_id"=>$tipo_documento_id
            ],[
                "nombres"=>$row['nombre'],
                "apellido_paterno"=>$row['apellido_paterno'],
                "apellido_materno"=>$row['apellido_materno'],
            ]);
            $usuario = User::firstOrCreate([
                "username"=>$persona->numero_documento,
            ],[
                "password"=>$persona->numero_documento,
                "estado_registro"=>"A"
            ]);
            $usuario_rol=UserRol::updateOrCreate([
                "user_id"=>$usuario->id,
                "rol_id"=>3
            ],[
                "estado_registro"=>"A"
            ]);
            $trabajador=Trabajador::updateOrCreate([
                "user_rol_id"=>$usuario_rol->id,
                "empresa_id"=>$empresa->id,
                "persona_id"=>$persona->id,
            ],[
                "estado_registro"=>"A",
                "estado_trabajador"=>null,
            ]);
            $historia_clinica=HistoriaClinica::firstOrCreate([
                "persona_id"=>$persona->id,
                "fecha_emision"=>date('Y-m-d'),
            ],[]);
            $hc_trabajador=HCTrabajador::firstOrCreate([
                "trabajador_id"=>$trabajador->id,
                "historia_clinica_id"=>$historia_clinica->id,
            ][]);

        }
    }*/
    public function headingRow():int{
        return 4;
    }
}
