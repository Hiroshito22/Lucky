<?php

namespace App\Http\Controllers\Triaje;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\AntecedenteFamiliar;
use App\Models\AntecedenteFamiliarDetalle;
use App\Models\AntecedentePersonal;
use App\Models\EvaluacionMedica;
use App\Models\SignosVitales;
use App\Models\Habito;
use App\Models\HabitosNocivosDetalles;
use App\Models\HabitosFisicos;

class TriajeController extends Controller
{

    public function createAntecedentesFamiliares(Request $request)
    {
        $antecedente_familiar_cab = AntecedenteFamiliar::updateOrCreate(
            [
                "ficha_ocupacional_id"=>$request->ficha_ocupacional_id,
            ],
            [
                "nombres"=>$request->nombres,
                "apellido_paterno"=>$request->apellido_paterno,
                "apellido_materno"=>$request->apellido_materno,
                "familiar_id"=>$request->familiar_id,
                "estado_registro"=>"A",
            ]);
        $antecedentes_familiares_detalles = $request->antecedentes_familiares_detalles;
            foreach($antecedentes_familiares_detalles as $antecedente_familiar_detalle){
                $antecedente = AntecedenteFamiliarDetalle::updateOrCreate(
                    [
                        "antecedente_familiar_id"=>$antecedente_familiar_cab->id,
                        "patologico_id"=>$antecedente_familiar_detalle['patologico_id'],
                    ],
                    [
                        "comentario"=>$antecedente_familiar_detalle['comentario'],
                        "estado_registro"=>"A",
                    ]);
            }
        return response()->json(["resp"=>"Antecedentes Familiares creados correctamente"]);
    }

    public function createAntecedentesPersonales(Request $request)
    {
        $antecedentes_personales = AntecedentePersonal::updateOrCreate(
            [
                "ficha_ocupacional_id"=>$request->ficha_ocupacional_id,
            ],
            [
                "patologico_id"=>$request->patologico_id,
                "comentario"=>$request->comentario,
                "estado_registro"=>"A",
            ]);
        return response()->json(["resp"=>"Antecedentes Personales creados correctamente"]);
    }

    public function createEvaluacionMedica(Request $request)
    {

        $evaluacion_medica = EvaluacionMedica::updateOrCreate(
            [
                "ficha_ocupacional_id"=>$request->ficha_ocupacional_id,
            ],
            [
                "anamnesis"=>$request->anamnesis,
                "talla"=>$request->talla,
                "peso"=>$request->peso,
                "imc"=>($request->peso)/pow($request->talla,2),
                "cintura"=>$request->cintura,
                "cadera"=>$request->cadera,
                "max_inspiracion"=>$request->max_inspiracion,
                "expiracion_forzada"=>$request->expiracion_forzada,
                "perimetro_cuello"=>$request->perimetro_cuello,
                "observaciones"=>$request->observaciones,
                "estado_registro"=>"A",
            ]
        );
        if($evaluacion_medica->imc < 18.5){
            $evaluacion_medica->fill(
                [
                    "diagnostico_nutricional" =>"Bajo Peso",
                ]
            )->save();
        }
        if($evaluacion_medica->imc >= 18.5 && $evaluacion_medica->imc <= 24.9){
            $evaluacion_medica->fill(
                [
                    "diagnostico_nutricional"=>"Peso Normal",
                ]
            )->save();
        }
        if($evaluacion_medica->imc >=25 && $evaluacion_medica->imc <= 29.9){
            $evaluacion_medica->fill(
                [
                    "diagnostico_nutricional"=>"Sobre Peso",
                ]
            )->save();
        }
        if($evaluacion_medica->imc >=30){
            $evaluacion_medica->fill(
                [
                    "diagnostico_nutricional"=>"Obeso",
                ]
            )->save();
        }
        return response()->json(["resp"=>"Evaluacion Medica creado correctamente"]);
    }

    public function createSignosVitales(Request $request)
    {

        $signos_vitales = SignosVitales::updateOrCreate(
            [
                "ficha_ocupacional_id"=>$request->ficha_ocupacional_id,
            ],
            [
                "frec_cardiaca"=>$request->frec_cardiaca,
                "frec_respiratoria"=>$request->frec_respiratoria,
                "p_sistolica"=>$request->p_sistolica,
                "p_diastolica"=>$request->p_diastolica,
                "p_media"=>$request->p_media,
                "saturacion"=>$request->saturacion,
                "temperatura"=>$request->temperatura,
                "observaciones"=>$request->observaciones,
                "estado_registro"=>"A",
            ]);
        return response()->json(["resp"=>"Signos Vitales creados correctamente"]);
    }

    public function createHabitos(Request $request)
    {
        $habito = Habito::updateOrCreate(
            [
                "ficha_ocupacional_id"=>$request->ficha_ocupacional_id,
            ],
            [
                "medicamento"=>$request->medicamento,
                "observaciones"=>$request->observaciones,
                "estado_registro"=>"A",
            ]
        );
        $habitos_nocivos_detalles = $request->habitos_nocivos_detalles;
            foreach($habitos_nocivos_detalles as $habito_nocivo_detalle){
                $habito_nocivo=HabitosNocivosDetalles::updateOrCreate(
                    [
                        "habito_id"=>$habito->id,
                        "habito_nocivo_id"=>$habito_nocivo_detalle['habito_nocivo_id'],
                    ],
                    [
                        "frecuencia_id"=>$habito_nocivo_detalle['frecuencia_id'],
                        "tiempo"=>$habito_nocivo_detalle['tiempo'],
                        "tipo"=>$habito_nocivo_detalle['tipo'],
                        "unidad"=>$habito_nocivo_detalle['unidad'],
                        "cantidad"=>$habito_nocivo_detalle['cantidad'],
                        "observaciones"=>$habito_nocivo_detalle['observaciones'],
                        "estado_registro"=>"A",
                    ]);
            }
        return response()->json(["resp"=>"Habitos creados correctamente"]);
    }

    public function createHabitosFisicos(Request $request)
    {

        $habitos_fisicos = HabitosFisicos::updateOrCreate(
            [
                "ficha_ocupacional_id"=>$request->ficha_ocupacional_id,
            ],
            [
                "frecuencia_id"=>$request->frecuencia_id,
                "deporte_id"=>$request->deporte_id,
                "tiempo"=>$request->tiempo,
                "observaciones"=>$request->observaciones,
                "estado_registro"=>"A",
            ]);

        return response()->json(["resp"=>"Habitos Fisicos creados correctamente"]);
    }

    public function show($idTriaje){
        /**$administradorclinica = UserRol::where("user_id",auth()->user()->id)->where("rol_id",3)->first();
        if(!$administradorclinica || $administradorclinica=='I'){
            return response()->json(["resp"=>"no tiene accesos"]);
        }
        $trabajador_clinica = TrabajadorClinica::where("user_rol_id", $administradorclinica->id)->orderBy('id','desc')->first();
        if(!$trabajador_clinica || $trabajador_clinica->estado_registro=='I'){
            return response()->json(["resp"=>"no tiene accesos"]);
        }**/
        //$triaje = Triaje::with(['antecedente_familiar.pariente','antecedente_familiar.enfermedad'])->where('estado_registro','=','A')->find($idTriaje);
        //return response()->json($triaje);
    }

    /**public function update($idEspecialidad, Request $request)
    {
        /**$administradorclinica = UserRol::where("user_id",auth()->user()->id)->where("rol_id",3)->first();
        if(!$administradorclinica || $administradorclinica=='I'){
            return response()->json(["resp"=>"no tiene accesos"]);
        }
        $trabajador_clinica = TrabajadorClinica::where("user_rol_id", $administradorclinica->id)->orderBy('id', 'desc')->first();
        if(!$trabajador_clinica || $trabajador_clinica->estado_registro=='I'){
            return response()->json(["resp"=>"no tiene accesos"], 400);
        }
        $especialidad = EspecialidadClinica::findOrfail($idEspecialidad);
        $especialidad->fill(
            [
                "nombre"=>$request->nombre
            ])->save();

        return response()->json(["resp"=>"Se edito correctamente"]);
    }

    public function destroy($idEspecialidad)
    {
        $administradorclinica = UserRol::where("user_id",auth()->user()->id)->where("rol_id",3)->first();
        if(!$administradorclinica || $administradorclinica=='I'){
            return response()->json(["resp"=>"no tiene accesos"]);
        }
        $trabajador_clinica = TrabajadorClinica::where("user_rol_id", $administradorclinica->id)->orderBy('id', 'desc')->first();
        if(!$trabajador_clinica || $trabajador_clinica->estado_registro=='I'){
            return response()->json(["resp"=>"no tiene accesos"], 400);
        }
        $especialidad = EspecialidadClinica::findOrfail($idEspecialidad);
        if($trabajador_clinica->clinica_id!=$especialidad->clinica_id){
            return response()->json(["resp"=>"no tiene accesos para eliminar"], 400);
        }
        $especialidad->estado_registro = 'I';

        $especialidad->save();
        return response()->json(["resp"=>"Se elimino correctamente"]);
    }**/
}
