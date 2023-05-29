<?php

namespace App\Http\Controllers\Triaje;

use App\Http\Controllers\Controller;

use App\Models\AntecedentePersonal;
use App\Models\ClinicaPatologiaPersonal;
use App\Models\Antecedente;
use App\Models\ClinicaPatologia;
use App\Models\ClinicaServicio;
use App\Models\ServicioClinica;
use App\Models\TipoAntecedente;
use App\Models\Trabajador;
use TheSeer\Tokenizer\Exception;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class AntecedentesPersonalesController extends Controller
{

    /**
     *  Obtener Datos Antecedente Personal
     *  @OA\Get(
     *      path="/api/triaje/antecedentespersonal/{id_antecedente_personal}",
     *      summary="Mostar datos de los antecedentes del personal",
     *      security={{ "bearerAuth":{} }},
     *      tags={"Antecedente_Personal"},
     *      @OA\Parameter(description="ID del antecedente",
     *          @OA\Schema(type="number"), in="path", name="id_antecedente_personal",required=true,
     *      ),
     *      @OA\Response(response=200, description="success",
     *          @OA\JsonContent(
     *              @OA\Property(type="array",property="data",
     *                  @OA\Items(type="object",
     *                      @OA\Property(property="id", type="integer", example="1"),
     *                      @OA\Property(property="servicio_clinica_id", type="foreignId", example="1"),
     *                      @OA\Property(property="trabajador_id", type="foreignId", example="1"),
     *                      @OA\Property(property="inmunizaciones", type="string", example="inmunizacion"),
     *                      @OA\Property(property="estado_registro", type="char", example="A"),
     *                      @OA\Property(type="array",property="clinicas_patologias_personal",
     *                          @OA\Items(type="object",
     *                              @OA\Property(property="id", type="integer", example="1"),
     *                              @OA\Property(property="antecedente_personal_id", type="foreignId", example="1"),
     *                              @OA\Property(property="clinica_patologica_id", type="foreignId", example="1"),
     *                              @OA\Property(property="descripcion", type="string", example="descripcion"),
     *                              @OA\Property(property="estado_registro", type="char", example="A")
     *                          )
     *                      )
     *                  )
     *              ),
     *                   @OA\Property(type="count", property="size", example="1")
     *          )
     *      ),
     *      @OA\Response(response=500,description="error",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="Antecedentes personal no existe")
     *          )
     *      )
     *  )
     */

    public function get($idantecedentepersonal){
        $antecedente_personal = AntecedentePersonal::with(['clinica_patologia_personal'])->where('estado_registro', 'A')->where('id',$idantecedentepersonal)->first();
        if (!$antecedente_personal) {
            return response()->json(['resp' => 'Antecedentes personal no existe'],500);
        }
        //return response()->json($antecedente_personal);
        return response()->json(["data"=>$antecedente_personal, "size"=>count($antecedente_personal)]);
    }



    /**
     * Crear Datos Antecedente Personal
     * @OA\Post (
     *     path="/api/triaje/antecedentespersonal/create",
     *     tags={"Antecedente_Personal"},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *             @OA\Property(property="clinica_servicio_id", type="foreignId", example=1),
     *                 @OA\Property(property="trabajador_id", type="foreignId", example=1),
     *                 @OA\Property(property="inmunizaciones", type="string", example="inmunizaciones"),
     *                 @OA\Property(
     *                     type="array",
     *                     property="clinica_patologia_personal",
     *                     @OA\Items(
     *                         type="object",
     *                         @OA\Property(property="clinica_patologia_id",type="foreignId",example=1),
     *                         @OA\Property(property="comentario",type="string",example="comentario")
     *                     )
     *                 )
     *             )
     *         )
     *      ),
     *         @OA\Response(
     *         response=200,
     *         description="success",
     *         @OA\JsonContent(
     *             @OA\Property(property="msg", type="string", example="Antecedente Personal creado correctamente")
     *         )
     *      ),
     *         @OA\Response(
     *         response=400,
     *         description="invalid",
     *         @OA\JsonContent(
     *             @OA\Property(property="resp", type="string", example="Antecedente no creado"),
     *             )
     *         )
     * )
     */

    public function store(Request $request)
    {

        DB::beginTransaction();
        try {

            $clinica_servicio=ClinicaServicio::find($request['clinica_servicio_id']);
            $trabajo=Trabajador::find($request['trabajador_id']);

            if (!is_int($request['clinica_servicio_id']) || !is_int($request['trabajador_id'])) {
                return response()->json(['error' => 'El id debe ser un número entero.'], 400);
            }
            elseif ($request['clinica_servicio_id'] == 0 && $request['trabajador_id'] == 0) {
                $request['clinica_servicio_id'] = null;
                $request['trabajador_id'] = null;
            }elseif($request['clinica_servicio_id'] == 0){
                $request['clinica_servicio_id'] = null;
            }elseif($request['trabajador_id'] == 0){
                $request['trabajador_id'] = null;

            }elseif($clinica_servicio === null){
                return response()->json(["resp" => "Id no existe"],500);
            }elseif($trabajo === null){
                return response()->json(["resp" => "Id no existe"],500);
            }

            $antecedentes_personales=AntecedentePersonal::create([
                'clinica_servicio_id' => $request->clinica_servicio_id,
                'trabajador_id' => $request->trabajador_id,
                'inmunizaciones'=> $request->inmunizaciones
            ]);
            $clinica_patologia_personal = $request->clinica_patologia_personal;
            foreach ($clinica_patologia_personal as $clinica){

                $clinica_patologia=ClinicaPatologia::find($clinica['clinica_patologia_id']);


                if (!is_int($clinica['clinica_patologia_id'])) {
                    return response()->json(['error' => 'El id debe ser un número entero.'], 400);
                }
                elseif($clinica['clinica_patologia_id'] == 0){
                    $clinicas['clinica_patologia_id'] = null;

                }elseif($clinica_patologia === null){
                    return response()->json(["resp" => "Id no existe"],500);
                }

                ClinicaPatologiaPersonal::create([
                    'antecedente_personal_id' => $antecedentes_personales->id,
                    'clinica_patologia_id' => $clinica['clinica_patologia_id'],
                    'comentario' => $clinica['comentario'],
                ]);
            }


            DB::commit();
            return response()->json(["resp" => "Antcedente Personal creado correctamente"]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["Error"=> "".$e],501);
        }
    }


    /**
     * Modificar Datos Antecedente Personal
     * @OA\Put (
     *     path="/api/triaje/antecedentespersonal/update/{idantecedentepersonal}",
     *     tags={"Antecedente_Personal"},
     *     @OA\Parameter(
     *         in="path",
     *         name="idantecedentepersonal",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *
     *          @OA\RequestBody(
     *              @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(property="trabajador_id", type="foreignId", example="1"),
     *                  @OA\Property(property="inmunizaciones", type="string", example="inmunizaciones"),
     *                  @OA\Property(
     *                      type="array",
     *                      property="clinica_patologia_personal",
     *                      @OA\Items(
     *                          type="object",
     *                          @OA\Property(property="clinica_patologia_id",type="foreignId",example="1"),
     *                          @OA\Property(property="comentario",type="string",example="comentario")
     *                      )
     *                  )
     *               )
     *
     *          )
     *      ),
     *      @OA\Response(
     *         response=200,
     *         description="success",
     *         @OA\JsonContent(
     *             @OA\Property(property="msg", type="string", example="Registro actualizado correctamente")
     *         )
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="Antecedente no actualizado"),
     *          )
     *      )
     *  )
     */




    public function update(Request $request, $idAntePe)
    {

        DB::beginTransaction();
        try {

            $clinica_servicio=ClinicaServicio::find($request['clinica_servicio_id']);
            $trabajo=Trabajador::find($request['trabajador_id']);

            if (!is_int($request['clinica_servicio_id']) || !is_int($request['trabajador_id'])) {
                return response()->json(['error' => 'El id debe ser un número entero.'], 400);
            }
            elseif ($request['clinica_servicio_id'] == 0 && $request['trabajador_id'] == 0) {
                $request['clinica_servicio_id'] = null;
                $request['trabajador_id'] = null;
            }elseif($request['clinica_servicio_id'] == 0){
                $request['clinica_servicio_id'] = null;
            }elseif($request['trabajador_id'] == 0){
                $request['trabajador_id'] = null;

            }elseif($clinica_servicio === null){
                return response()->json(["resp" => "Id no existe"],500);
            }elseif($trabajo === null){
                return response()->json(["resp" => "Id no existe"],500);
            }


            $antecedentes_personales=AntecedentePersonal::find($idAntePe);

            $antecedentes_personales->fill([
                'clinica_servicio_id' => $request->clinica_servicio_id,
                'trabajador_id' => $request->trabajador_id,
                'inmunizaciones'=> $request->inmunizaciones
            ])->save();


            DB::table('clinica_patologia_personal')->where('antecedente_personal_id',$antecedentes_personales->id)->update(['estado_registro' => 'I']);

            $clinica_patologia_personal = $request->clinica_patologia_personal;

            foreach ($clinica_patologia_personal as $clinicas){

                $clinica_patologia=ClinicaPatologia::find($clinicas['clinica_patologia_id']);


                if (!is_int($clinicas['clinica_patologia_id'])) {
                    return response()->json(['error' => 'El id debe ser un número entero.'], 400);
                }
                elseif($clinicas['clinica_patologia_id'] == 0){
                    $clinicas['clinica_patologia_id'] = null;

                }elseif($clinica_patologia === null){
                    return response()->json(["resp" => "Id no existe"],500);
                }


                $clinicas = ClinicaPatologiaPersonal::updateOrCreate(
                    [
                        'clinica_patologia_id' => $clinicas['clinica_patologia_id'],
                        'antecedente_personal_id'=>$antecedentes_personales->id
                    ],
                    [
                        'comentario' => $clinicas['comentario'],
                        'estado_registro' => 'A',
                    ])->save();
            }
            DB::commit();
            return response()->json(["resp" => "Antcedente Personal actualizado correctamente"]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["Error"=> "".$e],501);
        }
    }


    /**
     * Delete Todo
     * @OA\Delete (
     *     path="/api/triaje/antecedentespersonal/delete/{idantecedentepersonal}",
     *     tags={"Antecedente_Personal"},
     *     @OA\Parameter(in="path",name="id",required=true,@OA\Schema(type="string")),
     *     @OA\Response(
     *         response=200,
     *         description="success",
     *         @OA\JsonContent(
     *             @OA\Property(property="msg", type="string", example="Antecedente Personal eliminada correctamente")
     *         )
     *     )
     * )
     */

    public function delete($id)
    {
        try {
            $datos = AntecedentePersonal::where('estado_registro', 'A')->find($id);
            if (!$datos) {
                return response()->json(['resp' => 'Antecedentes personal ya inactivado'],500);
            }
            $datos->fill([
                'estado_registro' => 'I',
            ])->save();
            return response()->json(["resp" => "Antecedente Personal inactivado correctamente"]);
        } catch (Exception $e) {
            return response()->json(["error" => $e]);
        }
    }




    //ANTECEDENTE

    /**
     * Obtener Datos Antecedente
     * @OA\Get (
     *     path="/api/triaje/antecedentespersonal/antecedentes/get",
     *     tags={"Antecedente"},
     *      @OA\Response(
     *          response=200,
     *          description="success",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                 type="array",
     *                 property="antecedentes",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="id",type="number",example="1"),
     *                     @OA\Property(property="antecedente_personal_id",type="foreignId",example="1"),
     *                     @OA\Property(property="tipo_antecedente_id",type="foreignId",example="1"),
     *                     @OA\Property(property="asociado_trabajo",type="string",example="asociado_trabajo"),
     *                     @OA\Property(property="descripcion",type="string",example="descripcion"),
     *                     @OA\Property(property="fecha_inicio",type="date",example="2022-01-02"),
     *                     @OA\Property(property="fecha_final",type="date",example="2023-03-02"),
     *                     @OA\Property(property="dias_incapacidad",type="number",example="1"),
     *                     @OA\Property(property="menoscabo",type="string",example="menoscabo"),
     *                     @OA\Property(property="estado_registro",type="char",example="A")
     *                 )
     *              ),
     *              @OA\Property(
     *               type="count",
     *               property="size",
     *               example="1"
     *             )
     *          )
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="Antecedente no mostrado"),
     *          )
     *      )
     *  )
     */

    public function getantecedente(){
        $antecedente = Antecedente::where('estado_registro', 'A')->get();
        if (!$antecedente) {
            return response()->json(["resp" => "Antecedente no existe"],400);
        }
        return response()->json(["antecedentes"=>$antecedente,"size"=>count($antecedente)]);

    }

    /**
     * Crear Datos Antecedente
     * @OA\Post (
     *     path="/api/triaje/antecedentespersonal/antecedentes/create",
     *     tags={"Antecedente"},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     type="array",
     *                     property="antecedentes",
     *                     @OA\Items(
     *                         type="object",
     *                         @OA\Property(property="antecedente_personal_id",type="foreignId",example="2"),
     *                         @OA\Property(property="tipo_antecedente_id",type="foreignId",example="1"),
     *                         @OA\Property(property="asociado_trabajo",type="string",example="fsf"),
     *                         @OA\Property(property="descripcion",type="string",example="descripcion"),
     *                         @OA\Property(property="fecha_inicio",type="date",example="2022-1-2"),
     *                         @OA\Property(property="fecha_final",type="date",example="2023-3-2"),
     *                         @OA\Property(property="dias_incapacidad",type="number",example="2"),
     *                         @OA\Property(property="menoscabo",type="string",example="algo")
     *                     )
     *                 )
     *             )
     *         )
     *      ),
     *         @OA\Response(
     *         response=200,
     *         description="success",
     *         @OA\JsonContent(
     *             @OA\Property(property="msg", type="string", example="Registro actualizado correctamente")
     *         )
     *      ),
     *         @OA\Response(
     *         response=400,
     *         description="invalid",
     *         @OA\JsonContent(
     *             @OA\Property(property="resp", type="string", example="ERROR"),
     *             )
     *         )
     * )
     */

    public function storeantecedente(Request $request)
    {
        DB::beginTransaction();
        try {
            $antecedentes = $request->antecedentes;

            foreach ($antecedentes as $antecedente){

                $antecedente_personal=AntecedentePersonal::find($antecedente['antecedente_personal_id']);
                $tipo_antecedente=TipoAntecedente::find($antecedente['tipo_antecedente_id']);


                if (!is_int($antecedente['antecedente_personal_id']) || !is_int($antecedente['tipo_antecedente_id'])) {
                    return response()->json(['error' => 'El id debe ser un número entero.'], 400);
                }elseif (!is_int($antecedente['dias_incapacidad'])) {
                    return response()->json(['error' => 'El tipo de dato debe ser un número entero.'], 400);
                }elseif (strtotime($antecedente['fecha_inicio']) === false || strtotime($antecedente['fecha_final']) === false) {
                    return response()->json(['error' => 'El tipo de dato debe ser una fecha.'], 400);
                }
                elseif ($antecedente['antecedente_personal_id'] == 0 && $antecedente['tipo_antecedente_id'] == 0) {
                    $antecedente['antecedente_personal_id'] = null;
                    $antecedente['tipo_antecedente_id'] = null;
                }elseif ($antecedente['antecedente_personal_id'] == 0){
                    $antecedente['antecedente_personal_id'] = null;
                }elseif ($antecedente['tipo_antecedente_id'] == 0){
                    $antecedente['tipo_antecedente_id'] = null;
                }
                elseif ($antecedente_personal === null){
                    return response()->json(["resp" => "Id no existe"],500);
                }elseif ($tipo_antecedente === null){
                    return response()->json(["resp" => "Id no existe"],500);
                }



                Antecedente::create([
                    'antecedente_personal_id' => $antecedente['antecedente_personal_id'],
                    'tipo_antecedente_id' => $antecedente['tipo_antecedente_id'],
                    'asociado_trabajo' => $antecedente['asociado_trabajo'],
                    'descripcion' => $antecedente['descripcion'],
                    'fecha_inicio' => $antecedente['fecha_inicio'],
                    'fecha_final' => $antecedente['fecha_final'],
                    'dias_incapacidad' => $antecedente['dias_incapacidad'],
                    'menoscabo' => $antecedente['menoscabo'],
                ]);

            }

            DB::commit();
            return response()->json(["resp" => "Antcdente Personal creado correctamente"]);

        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["Error"=> "".$e],501);
        }

    }



    /**
     * Modificar Datos Antecedente
     * @OA\Put (
     *     path="/api/triaje/antecedentes/update/{id}",
     *     tags={"Antecedente"},
     *     @OA\Parameter(in="path",name="id",required=true,@OA\Schema(type="string")),
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     type="array",
     *                     property="antecedentes",
     *                     @OA\Items(
     *                         type="object",
     *                         @OA\Property(property="antecedente_personal_id",type="foreignId",example="2"),
     *                         @OA\Property(property="tipo_antecedente_id",type="foreignId",example="1"),
     *                         @OA\Property(property="asociado_trabajo",type="string",example="fsf"),
     *                         @OA\Property(property="descripcion",type="string",example="descripcion"),
     *                         @OA\Property(property="fecha_inicio",type="date",example="2022-1-2"),
     *                         @OA\Property(property="fecha_final",type="date",example="2023-3-2"),
     *                         @OA\Property(property="dias_incapacidad",type="number",example="2"),
     *                         @OA\Property(property="menoscabo",type="string",example="algo")
     *                     )
     *                 )
     *             )
     *         )
     *      ),
     *         @OA\Response(
     *         response=200,
     *         description="success",
     *         @OA\JsonContent(
     *             @OA\Property(property="msg", type="string", example="Registro actualizado correctamente")
     *         )
     *      ),
     *         @OA\Response(
     *         response=400,
     *         description="invalid",
     *         @OA\JsonContent(
     *             @OA\Property(property="resp", type="string", example="ERROR"),
     *             )
     *         )
     * )
     */


    public function updateantecedente(Request $request,$id)
    {
        DB::beginTransaction();
        try {
            $antecedentes = $request->antecedentes;
            foreach ($antecedentes as $antecedente){

                $antecedente_personal_id=AntecedentePersonal::find($antecedente['antecedente_personal_id']);
                $tipo_antecedente_id=TipoAntecedente::find($antecedente['tipo_antecedente_id']);

                if (!is_int($antecedente['antecedente_personal_id']) || !is_int($antecedente['tipo_antecedente_id'])) {
                    return response()->json(['error' => 'El id debe ser un número entero.'], 400);
                }elseif (!is_int($antecedente['dias_incapacidad'])) {
                    return response()->json(['error' => 'El tipo de dato debe ser un número entero.'], 400);
                }elseif (strtotime($antecedente['fecha_inicio']) === false || strtotime($antecedente['fecha_final']) === false) {
                    return response()->json(['error' => 'El tipo de dato debe ser una fecha.'], 400);
                }
                elseif ($antecedente['antecedente_personal_id'] == 0 && $antecedente['tipo_antecedente_id'] == 0) {
                    $antecedente['antecedente_personal_id'] = null;
                    $antecedente['tipo_antecedente_id'] = null;
                }elseif ($antecedente['antecedente_personal_id'] == 0){
                    $antecedente['antecedente_personal_id'] = null;
                }elseif ($antecedente['tipo_antecedente_id'] == 0){
                    $antecedente['tipo_antecedente_id'] = null;
                }
                elseif ($antecedente_personal_id === null){
                    return response()->json(["resp" => "Id no existe"],500);
                }elseif ($tipo_antecedente_id === null){
                    return response()->json(["resp" => "Id no existe"],500);
                }



                $Antecedente=Antecedente::where('estado_registro', 'A')->find($id);

                $Antecedente->fill([
                    'antecedente_personal_id' => $antecedente['antecedente_personal_id'],
                    'tipo_antecedente_id' => $antecedente['tipo_antecedente_id'],
                    'asociado_trabajo' => $antecedente['asociado_trabajo'],
                    'descripcion' => $antecedente['descripcion'],
                    'fecha_inicio' => $antecedente['fecha_inicio'],
                    'fecha_final' => $antecedente['fecha_final'],
                    'dias_incapacidad' => $antecedente['dias_incapacidad'],
                    'menoscabo' => $antecedente['menoscabo'],

                ])->save();
            }

            DB::commit();
            return response()->json(["resp" => "Antcedente actualizado correctamente"]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["Error"=> "".$e],501);
        }

    }


    /**
     * Delete Todo
     * @OA\Delete (
     *     path="/api/triaje/antecedentespersonal/antecedentes/delete/{id}",
     *     tags={"Antecedente"},
     *     @OA\Parameter(in="path",name="id",required=true,@OA\Schema(type="string")),
     *     @OA\Response(
     *         response=200,
     *         description="success",
     *         @OA\JsonContent(
     *             @OA\Property(property="msg", type="string", example="Antecedente eliminada correctamente")
     *         )
     *     )
     * )
     */

    public function deleteantecdedente($id)
    {
        try {
            $datos = Antecedente::where('estado_registro', 'A')->find($id);
            if (!$datos) {
                return response()->json(['resp' => 'Antecedentes personal ya inactivado'],404);
            }
            $datos->fill([
                'estado_registro' => 'I',
            ])->save();
            return response()->json(["resp" => "Antecedente eliminada correctamente"]);
        } catch (Exception $e) {
            return response()->json(["error" => $e]);
        }
    }



}
