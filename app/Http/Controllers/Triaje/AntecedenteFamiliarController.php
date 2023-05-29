<?php

namespace App\Http\Controllers\Triaje;

use Illuminate\Http\Request;
use TheSeer\Tokenizer\Exception;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\ClinicaPatologiaFamiliar;
use App\Models\AntecedenteFamiliar;
use App\Models\ClinicaPatologia;
use App\Models\Familiar;

class AntecedenteFamiliarController extends Controller
{
      /**
     * Obtener Datos Paciente
     * @OA\Get (
     *     path="/api/triaje/antecedentesFamiliar/get/{id}",
     *     summary="Obtiene los datos de antecedentes familiares",
     *     security={{ "bearerAuth": {} }},
     *     tags={"Triaje - Antecedente Familiar"},
     *     @OA\Parameter(in="path",name="id",required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *      @OA\Response(
     *          response=200,
     *          description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="id", type="foreignId", example="1"),
     *              @OA\Property(property="servicio_clinica_id", type="foreignId", example="1"),
     *              @OA\Property(property="ficha_ocupacional_id", type="foreignId", example="null"),
     *              @OA\Property(property="numero_hijos_vivos", type="integer", example=1),
     *              @OA\Property(property="numero_hijos_fallecidos", type="integer", example=1),
     *               @OA\Property(property="estado_registro", type="string", example="A"),
     *              @OA\Property(
     *                 type="array",
     *                 property="clinicas_patologias_familiares",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property( property="id", type="foreignId", example="1"),
     *                     @OA\Property( property="antecedente_familiar_id", type="foreignId", example="1"),
     *                     @OA\Property( property="clinica_patologia_id", type="foreignId", example="1"),
     *                     @OA\Property( property="familiar_id", type="foreignId", example=1),
     *                     @OA\Property( property="comentario", type="string", example="comentario1"),
     *                     @OA\Property( property="estado_registro", type="string", example="A"),
     *                      @OA\Property(
     *                          type="array",
     *                          property="clinica_patologias",
     *                          @OA\Items(
     *                          type="object",
     *                          @OA\Property( property="id", type="foreignId", example="1"),
     *                          @OA\Property( property="patologia_id", type="string", example="1"),
     *                          @OA\Property( property="clinica_id", type="string", example="1"),
     *                          @OA\Property( property="activo", type="char", example="A"),
     *                          @OA\Property( property="estado_registro", type="string", example="A")
     *                             )
     *                           ),
     *                          @OA\Property(
     *                          type="array",
     *                          property="familiar",
     *                          @OA\Items(
     *                          type="object",
     *                          @OA\Property( property="id", type="foreignId", example="1"),
     *                          @OA\Property( property="antecedente_famiuliar_id", type="string", example="null"),
     *                          @OA\Property( property="tipo_familiar_id", type="string", example="1"),
     *                          @OA\Property( property="hospital_id", type="foreignId", example="null"),
     *                          @OA\Property( property="estado_registro", type="string", example="A")
     *                             )
     *                           )
     *                     )
     *                 )          
     *          )        
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="Antecedente familiar no valido"),
     *          )
     *      )
     * )
     */

    public function get($idAntecedenteFamiliar)
    {
        $antecedente_familiar = AntecedenteFamiliar::with(['clinicas_patologias_familiares','clinicas_patologias_familiares.patologias','clinicas_patologias_familiares.familiares'])
        ->where('estado_registro', 'A')
        ->find($idAntecedenteFamiliar);
        if($antecedente_familiar == null){
            return response()->json(['resp'=> 'Antecedente Familiar no existe']);
        }
        if (!$antecedente_familiar) {
            return response()->json(['resp' => 'Antecedente Familiar esta inactivo']);
        }
        $antecedente_familiar = $antecedente_familiar->toArray();
        foreach ($antecedente_familiar['clinicas_patologias_familiares'] as &$clinica_patologia_familiar) {
            $clinica_patologia_familiar['familiar'] = $clinica_patologia_familiar['familiares'];
            unset($clinica_patologia_familiar['familiares']);
        }
        unset($clinica_patologia_familiar);
        return response()->json($antecedente_familiar);
    }

/**
     * Crear Datos Antecedente Familiar
     * @OA\Post (
     *     path="/api/triaje/antecedentesFamiliar/store",
     *     tags={"Triaje - Antecedente Familiar"},
     *          @OA\RequestBody(
     *          @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *              @OA\Property(property="numero_hijos_vivos", type="integer", example=1),
     *              @OA\Property(property="numero_hijos_fallecidos", type="integer", example=1),
     *              @OA\Property(type="array",property="antecedentes_familiares",
     *                 @OA\Items(type="object",
     *                     @OA\Property(property="tipo_familiar_id",type="integer",example=null),
     *                     @OA\Property(type="array",property="patologias",
     *                          @OA\Items(type="object",
     *                              @OA\Property(property="patologia_id",type="integer",example="1"),
     *                              @OA\Property(property="comentario",type="string",example="esto es un comentario")
     *                             )
     *                          )
     *                     )
     *                )
     *            )
     *        ),
     *      @OA\Response(
     *          response=200,
     *          description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="numero_hijos_vivos", type="integer", example=1),
     *              @OA\Property(property="numero_hijos_fallecidos", type="integer", example=1),
     *              @OA\Property(
     *                 type="array",
     *                 property="antecedentes_familiares",
     *                 @OA\Items(
     *                     type="object",
     *                      @OA\Property(
     *                         property="tipo_familiar_id",
     *                         type="integer",
     *                         example=null
     *                     ),
     *                          @OA\Property(
     *                          type="array",
     *                          property="patologias",
     *                          @OA\Items(
     *                          type="object",
     *                          @OA\Property(
     *                              property="patologia_id",
     *                              type="integer",
     *                              example="1"
     *                              ),
     *                          @OA\Property(
     *                              property="comentario",
     *                              type="string",
     *                              example="esto es un comentario"
     *                              )
     *                             )
     *                           )
     *                     )
     *                 )
     *              )
     *
     *          )
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="Fallo al crear el registro"),
     *          )
     *      )
     *  )
     */

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            // if(!is_int($request['servicio_clinica_id']) || !is_int($request['ficha_ocupacional_id'])){
            //     return response()->json(["resp" => "El ID debe ser un número entero."]);
            // }
            $antecedente_familiar = AntecedenteFamiliar::create([
                "patologia_id" => $request->patologia_id,
                "numero_hijos_vivos" => $request->numero_hijos_vivos,
                "numero_hijos_fallecidos" => $request->numero_hijos_fallecidos
            ]);

            $familiares = $request->antecedentes_familiares;

            foreach ($familiares as $familiar) {
                $familiar_aux = Familiar::create([
                    'antecedente_familiar_id' => $antecedente_familiar->id,
                    // "numeros_hijos_vivos"=>$familiar['numeros_hijos_vivos'],
                    // "numeros_hijos_fallecidos"=>$familiar['numeros_hijos_fallecidos'],
                    "tipo_familiar_id"=>$familiar['tipo_familiar_id'],
                ]);
                foreach ($familiar['patologias'] as $patologia) {
                    ClinicaPatologiaFamiliar::create([
                        'antecedente_familiar_id' => $antecedente_familiar->id,
                        'patologia_id' => $patologia['patologia_id'],
                        'familiar_id' => $familiar_aux->id,
                        'comentario' => $patologia['comentario'],
                    ]);
                }
            }
            $antecedente_familiar->save();
            DB::commit();
            return response()->json(["resp" => "antecedente creado Correctamente"]);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(["Error" => "" . $e], 501);
        }
    }

    /**
     * Crear Datos Antecedente Familiar
     * @OA\Put (
     *     path="/api/triaje/antecedentesFamiliar/update/{id}",
     *     tags={"Triaje - Antecedente Familiar"},
     *       @OA\Parameter(in="path",name="id",required=true,
     *         @OA\Schema(type="string")
     *     ),
     *          @OA\RequestBody(
     *         @OA\MediaType(mediaType="application/json",
     *             @OA\Schema(
     *              @OA\Property(property="numero_hijos_vivos", type="integer", example=1),
     *              @OA\Property(property="numero_hijos_fallecidos", type="integer", example=1),
     *              @OA\Property(
     *                 type="array",
     *                 property="antecedentes_familiares",
     *                 @OA\Items(type="object",
     *                     @OA\Property(property="tipo_familiar_id",type="foreignId",example=null),
     *                     @OA\Property(type="array",property="patologias",
     *                          @OA\Items(type="object",
     *                              @OA\Property(property="patologia_id",type="foreignId",example=1),
     *                              @OA\Property(property="comentario",type="string",example="esto es un comentario actualizado")
     *                             )
     *                        )
     *                     )
     *                 )
     *
     *
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="numero_hijos_vivos", type="integer", example=1),
     *              @OA\Property(property="numero_hijos_fallecidos", type="integer", example=1),
     *              @OA\Property(
     *                 type="array",
     *                 property="antecedentes_familiares",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="tipo_familiar_id",type="foreignId",example=null),
     *                     @OA\Property(
     *                        type="array",
     *                        property="patologias",
     *                          @OA\Items(
     *                          type="object",
     *                              @OA\Property(property="patologia_id",type="foreignId",example=null),
     *                              @OA\Property(property="comentario",type="string",example="esto es un comentario")
     *                             )
     *                        )
     *                     )
     *                 )
     *              )
     *
     *          )
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="Fallo al crear el registro"),
     *          )
     *      )
     *  )
     */


    public function update(Request $request, $idAnteFa)
    {

        DB::beginTransaction();
        try {
            $antecedente_familiar=AntecedenteFamiliar::find($idAnteFa);
            $antecedente_familiar->fill([
                "patologia_id" => $request->patologia_id,
                "numero_hijos_vivos" => $request->numero_hijos_vivos,
                "numero_hijos_fallecidos" => $request->numero_hijos_fallecidos
                ])->save();

            DB::table('familiar')->where('antecedente_familiar_id',$antecedente_familiar->id)->update(['estado_registro' => 'I']);

            $familiares = $request->antecedentes_familiares;
            // return response()->json($clinica_patologia_familiar);
            // return response()->json($request);
            foreach ($familiares as $familiar){
              
                $familiar_aux = Familiar::updateOrCreate(
                    [
                        'antecedente_familiar_id' => $antecedente_familiar->id,
                        // "nombre" => $familiar['nombre'],
                        // "apellido_paterno" => $familiar['apellido_paterno'],
                        // "apellido_materno" => $familiar['apellido_materno'],
                        "tipo_familiar_id" => $familiar['tipo_familiar_id'],
                    ],
                    [
                        // "tipo_familiar_id" => $familiar['tipo_familiar_id'],
                        'estado_registro'=>'A',
                    ]);
                    
                    DB::table('clinica_patologia_familiar')->where('familiar_id', $familiar_aux->id)->where('antecedente_familiar_id',$antecedente_familiar->id)->update(['estado_registro' => 'I']);
                    foreach ($familiar['patologias'] as $patologia) {
                        // return response()->json($clinica_patologia);
                        ClinicaPatologiaFamiliar::updateOrCreate([
                            'antecedente_familiar_id' => $antecedente_familiar->id,
                            'familiar_id' => $familiar_aux->id,

                        ],
                        [
                            'patologia_id' => $patologia['patologia_id'],
                            'comentario' => $patologia['comentario'],
                            'estado_registro'=>'A',
                        ]);
                        
                    }
                }
            DB::commit();
            return response()->json(["resp" => "Antecedente Familiar actualizado correctamente"]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["Error"=> "".$e],501);
        }
    }
/**
     * Desactiva datos de Antecedente Familiar
     * @OA\Delete (
     *     path="/api/triaje/antecedentesfamiliares/delete/{id}",
     *     tags={"Triaje - Antecedente Familiar"},
     *     @OA\Parameter(in="path",name="id",required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response=200,description="success",
     *         @OA\JsonContent(
     *             @OA\Property(property="resp", type="string", example="Antecedente Familiar eliminado correctamente")
     *         )
     *     ),
     *     @OA\Response(response=400,description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="Antecedente Familiar no se ha eliminado..."),
     *          )
     *      )
     * )
     */
    public function delete($id)
    {
        try {
            $datos = AntecedenteFamiliar::where('estado_registro', 'A')->find($id);
            if (!$datos) {
                return response()->json(['resp' => 'Antecedentes Familiar ya inactivado']);
            }
            $datos->fill([
                'estado_registro' => 'I',
            ])->save();
            return response()->json(["resp" => "Antecedente Familiar inactivado correctamente"]);
        } catch (Exception $e) {
            return response()->json(["error" => $e]);
        }
    }
        /**
     * Activar
     * @OA\Put (
     *     path="/api/triaje/antecedentesfamiliares/activate/{id}",
     *     summary = "Activando Datos de Antecedente familiar",
     *     tags={"Triaje - Antecedente Familiar"},
     *     @OA\Parameter(in="path",name="id",required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response=200,description="success",
     *         @OA\JsonContent(
     *             @OA\Property(property="resp", type="string", example="Antecedente familiar activado correctamente")
     *         )
     *     ),
     *     @OA\Response(response=401,description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="El Antecedente familiar no existe"),
     *              )
     *          ),

     *     @OA\Response(response=402,description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="El Antecedente familiar a activar ya está activado..."),
     *              )
     *          ),
     *     @OA\Response(response=501,description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="Error: Antecedente familiar no se ha activado"),
     *              )
     *          ),
     * )
*/
public function activate($id)
{
    DB::beginTransaction();
    try {
        $activate = AntecedenteFamiliar::where('estado_registro', 'I')->find($id);
        $exists = AntecedenteFamiliar::find($id);
        if(!$exists){
            return response()->json(["error"=>"El antecedente familiar no existe"],401);
        }
        if(!$activate){
            return response()->json(["error" => "El antecedente familiar a activar ya está activado..."],402);
        }
        $activate->fill([
            'estado_registro' => 'A',
        ])->save();
        DB::commit();
        return response()->json(["resp" => "Antecedente familiar activado correctamente"],200);
    } catch (Exception $e) {
        DB::rollBack();
        return response()->json(["Error: Antecedente familiar no se ha activado" => $e],501);
    }
}
 }
