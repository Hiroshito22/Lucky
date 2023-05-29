<?php

namespace App\Http\Controllers\Psicologia;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\MotivoEvaluacion;
use App\Models\DatoOcupacional;
use App\Models\AnteriorEmpresa;
use App\Models\ObservacionConducta;
use App\Models\ProcesoCognitivo;
use App\Models\ProcesoCognoscitivo;

class PsicologiaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function createMotivoEvaluacion(Request $request)
    {
        $motivo_evaluacion = MotivoEvaluacion::updateOrCreate(
            [
                "ficha_psicologica_ocupacional_id"=>$request->ficha_psicologica_ocupacional_id,
            ],
            [
                "motivo_evaluacion" => $request->motivo_evaluacion,
            ]
        );
        return response()->json(["resp"=>"Motivo de Evaluacion creado correctamente"]);
    }

    public function createDatosOcupacionales(Request $request)
    {
        $datos_ocupacionales = DatoOcupacional::updateOrCreate(
            [
                "ficha_psicologica_ocupacional_id"=>$request->ficha_psicologica_ocupacional_id,
                "empresa_id"=>$request->empresa_id,
            ],
            [
                "nombre_empresa"=>$request->nombre_empresa,
                "actividad_empresa"=>$request->actividad_empresa,
                "area_trabajo"=>$request->area_trabajo,
                "tiempo_laborando"=>$request->tiempo_laborando,
                "puesto"=>$request->puesto,
                "principales_riesgos_id"=>$request->principales_riesgos_id,
                "medidas_seguridad_id"=>$request->medidas_seguridad_id,
            ]
        );
        return response()->json(["resp"=>"Datos Ocupacionales creados correctamente"]);
    }

    public function createAnterioresEmpresas(Request $request)
    {
        $anteriores_empresas = AnteriorEmpresa::updateOrCreate(
            [
                "ficha_psicologica_ocupacional_id"=>$request->ficha_psicologica_ocupacional_id,
            ],
            [
                "nombre_empresa"=>$request->nombre_empresa,
                "fecha"=>$request->fecha,
                "actividad_empresa"=>$request->actividad_empresa,
                "puesto"=>$request->puesto,
                "causa_retiro"=>$request->causa_retiro,
            ]
        );
        return response()->json(["resp"=>"Anterior Empresa creado correctamente"]);
    }

    public function createObservacionConductas(Request $request)
    {
        $observacion_conducta = ObservacionConducta::updateOrCreate(
            [
                "ficha_psicologica_ocupacional_id"=>$request->ficha_psicologica_ocupacional_id,
            ],
            [
                "presentacion_id"=>$request->presentacion_id,
                "postura_id"=>$request->postura_id,
                "ritmo_id"=>$request->ritmo_id,
                "tono_id"=>$request->tono_id,
                "articulacion_id"=>$request->articulacion_id,
                "tiempo_id"=>$request->tiempo_id,
                "espacio_id"=>$request->espacio_id,
                "estado_registro"=>"A",
            ]
        );
        return response()->json(["resp"=>"Observacion de Conducta creado correctamente"]);
    }

    public function createProcesosCognitivos(Request $request)
    {
        $procesos_cognitivos = ProcesoCognoscitivo::updateOrCreate(
            [
                "ficha_psicologica_ocupacional_id"=>$request->ficha_psicologica_ocupacional_id,
            ],
            [
                "lucido_atento"=>$request->lucido_atento,
                "pensamiento"=>$request->pensamiento,
                "percepcion"=>$request->percepcion,
                "memoria_id"=>$request->memoria_id,
                "inteligencia_id"=>$request->inteligencia_id,
                "apetito"=>$request->apetito,
                "sueño"=>$request->sueño,
                "personalidad"=>$request->personalidad,
                "afectividad"=>$request->afectividad,
                "estado_registro"=>"A",
            ]
        );
        return response()->json(["resp"=>"Procesos Cognitivos creados correctamente"]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
