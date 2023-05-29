<?php

namespace App\Http\Controllers\Hospital;

use App\Http\Controllers\Controller;
use App\Models\Atencion;
use App\Models\AtencionServicio;
use App\Models\Familiar;
use App\Models\FichaOcupacional;
use App\Models\FoAFamiliar;
use App\Models\FoFamiliarPatologia;
use App\Models\HistoriaClinica;
use App\Models\Hospital;
use App\Models\HospitalFamiliar;
use App\Models\HospitalPatologia;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use TheSeer\Tokenizer\Exception;

class FoAFamiliarController extends Controller
{
    public function admin()
    {
        $superadmin = User::with('persona', 'user_rol.rol.acceso_rol.acceso', 'roles.accesos')->find(auth()->user()->id);
        $valido = false;
        foreach ($superadmin->roles as $roles) {
            foreach ($roles->accesos as $accesos) {
                if ($accesos['tipo_acceso'] == 2 && $accesos['url'] == '/paquetes') {
                    return $valido = true;
                }
            }
        }
        return $valido;
    }
    public function createFichaFamiliar($request)
    {

        DB::beginTransaction();
        try {
            $ficha_ocupacional = FichaOcupacional::firstOrCreate(
                [
                    'atencion_id' => $request->atencion_id
                ],
                [
                    "fecha_emision"=>date("Y-m-d"),
                    "estado_registro" => 'A',
                ]
            );
            if (!$ficha_ocupacional->historia_clinica_id) {
                $atencion = Atencion::find($request->atencion_id);
                $historia_clinica = HistoriaClinica::firstOrCreate(
                    [
                        'persona_id' => $atencion->persona_id
                    ],
                    [
                        "fecha_emision"=>date("Y-m-d"),
                    ]
                );
                $ficha_ocupacional->historia_clinica = $historia_clinica->id;
                $ficha_ocupacional->save();
            }
            $usuario = User::with('roles')->find(auth()->user()->id);
            $hospital = Hospital::where('numero_documento', $usuario->username)->first();
            $familiares = $request->familiares;
            foreach ($familiares as $familiar) {
                $newFamiliar = Familiar::create(
                    [
                        'nombre' => $familiar['nombre'],
                        'hospital_id' => $hospital->id
                    ]
                );
                $hospital_familiar = HospitalFamiliar::create(
                    [
                        'familiar_id' => $newFamiliar->id,
                        'hospital_id' => $hospital->id
                    ]
                );
                $fo_a_familiar = FoAFamiliar::firstOrCreate(
                    [
                        'ficha_ocupacional_id' => $ficha_ocupacional->id,
                        'familiar_id' => $newFamiliar->id
                    ],
                    [
                        'hospital_familiar_id' => $hospital_familiar->id,
                        'observaciones_finales' => $familiar['observaciones_finales']
                    ]
                );
                $patologias = $familiar['patologias'];
                foreach ($patologias as $patologia) {
                    $hospital_patologia = HospitalPatologia::find($patologia['hospital_patologia_id']);

                    $fo_familiar_patologia = FoFamiliarPatologia::create(
                        [
                            'fo_a_familair' => $fo_a_familiar->id,
                            'hospital_patologia_id' => $hospital_patologia->id,
                            'patologi' => $hospital_patologia->id,
                            'observaciones' => $patologia['observaciones']
                        ]
                    );
                }
            }
            $atencion_servicio = AtencionServicio::where('servicio_id',$request->servicio_id)->where('atencion_id',$request->atencion_id)->first();
            $atencion_servicio->fill([
                "estado_atencion"=>2,
                "hora_fin"=>date('H:i:s'),
            ])->save();
            DB::commit();
            return response()->json(["res" => "Creado Correctamente"]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["error" => $e]);
        }


    }
}
