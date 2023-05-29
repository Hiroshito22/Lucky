<?php

namespace App\Http\Controllers\Psicologia;

use App\Http\Controllers\Controller;
use App\Models\Afectividad;
use App\Models\Apetito;
use App\Models\Clinica;
use App\Models\ConductaSexual;
use App\Models\Inteligencia;
use App\Models\LucidoAtento;
use App\Models\Memoria;
use App\Models\Pensamiento;
use App\Models\Percepcion;
use App\Models\Personalidad;
// use App\Models\ProcesoCognitivo;
use App\Models\ProcesoCognoscitivo;
use App\Models\Suenno;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProcesoCognoscitivoController extends Controller
{
    /**
     * Permite visualizar un listado de todos los registros de la tabla "Procesos Cognitivos"
     * @OA\Get (path="/api/procesocognoscitivo/get",security={{ "bearerAuth":{} }},tags={"Psicología - ProcesoCognoscitivo"},
     *     @OA\Response(response=200,description="success",
     *         @OA\JsonContent(
     *             @OA\Property(type="array",property="data",
     *                 @OA\Items(type="object",
     *                     @OA\Property(property="id",type="integer",example="1"),
     *                     @OA\Property(property="lucido_atento_id",type="foreignId",example="1"),
     *                     @OA\Property(property="pensamiento_id",type="foreignId",example="1"),
     *                     @OA\Property(property="percepcion_id",type="foreignId",example="1"),
     *                     @OA\Property(property="memoria_id",type="foreignId",example="1"),
     *                     @OA\Property(property="inteligencia_id",type="foreignId",example="1"),
     *                     @OA\Property(property="apetito_id",type="foreignId",example="1"),
     *                     @OA\Property(property="suenno_id",type="foreignId",example="1"),
     *                     @OA\Property(property="personalidad_id",type="foreignId",example="1"),
     *                     @OA\Property(property="afectividad_id",type="foreignId",example="1"),
     *                     @OA\Property(property="conducta_sexual_id",type="foreignId",example="1"),
     *                     @OA\Property(property="estado_registro",type="char",example="A"),
     *                     @OA\Property(type="array",property="lucidos_atentos",
     *                         @OA\Items(type="object",
     *                             @OA\Property(property="id",type="integer",example="1"),
     *                             @OA\Property(property="nombre",type="string",example="Selectivo y sostenido"),
     *                             @OA\Property(property="estado_registro",type="char",example="A"),
     *                         )
     *                     ),
     *                     @OA\Property(type="array",property="pensamientos",
     *                         @OA\Items(type="object",
     *                             @OA\Property(property="id",type="integer",example="1"),
     *                             @OA\Property(property="nombre",type="string",example="Racional"),
     *                             @OA\Property(property="estado_registro",type="char",example="A"),
     *                         )
     *                     ),
     *                     @OA\Property(type="array",property="percepcion",
     *                         @OA\Items(type="object",
     *                             @OA\Property(property="id",type="integer",example="1"),
     *                             @OA\Property(property="nombre",type="string",example="Multisensorial"),
     *                             @OA\Property(property="estado_registro",type="char",example="A"),
     *                         )
     *                     ),
     *                     @OA\Property(type="array",property="memorias",
     *                         @OA\Items(type="object",
     *                             @OA\Property(property="id",type="integer",example="1"),
     *                             @OA\Property(property="nombre",type="string",example="Corto Plazo"),
     *                             @OA\Property(property="estado_registro",type="char",example="A"),
     *                         )
     *                     ),
     *                     @OA\Property(type="array",property="inteligencias",
     *                         @OA\Items(type="object",
     *                             @OA\Property(property="id",type="integer",example="1"),
     *                             @OA\Property(property="nombre",type="string",example="Muy Superior"),
     *                             @OA\Property(property="estado_registro",type="char",example="A"),
     *                         )
     *                     ),
     *                     @OA\Property(type="array",property="apetitos",
     *                         @OA\Items(type="object",
     *                             @OA\Property(property="id",type="integer",example="1"),
     *                             @OA\Property(property="nombre",type="string",example="Adecuado"),
     *                             @OA\Property(property="estado_registro",type="char",example="A"),
     *                         )
     *                     ),
     *                     @OA\Property(type="array",property="suennos",
     *                         @OA\Items(type="object",
     *                             @OA\Property(property="id",type="integer",example="1"),
     *                             @OA\Property(property="nombre",type="string",example="Ciclo REM adecuado"),
     *                             @OA\Property(property="estado_registro",type="char",example="A"),
     *                         )
     *                     ),
     *                     @OA\Property(type="array",property="personalidades",
     *                         @OA\Items(type="object",
     *                             @OA\Property(property="id",type="integer",example="1"),
     *                             @OA\Property(property="nombre",type="string",example="Tendencia a la introversión"),
     *                             @OA\Property(property="estado_registro",type="char",example="A"),
     *                         )
     *                     ),
     *                     @OA\Property(type="array",property="afectividades",
     *                         @OA\Items(type="object",
     *                             @OA\Property(property="id",type="integer",example="1"),
     *                             @OA\Property(property="nombre",type="string",example="Tendencia a la estabilidad"),
     *                             @OA\Property(property="estado_registro",type="char",example="A"),
     *                         )
     *                     ),
     *                     @OA\Property(type="array",property="conductas_sexuales",
     *                         @OA\Items(type="object",
     *                             @OA\Property(property="id",type="integer",example="1"),
     *                             @OA\Property(property="nombre",type="string",example="Orientado a su rol de género"),
     *                             @OA\Property(property="estado_registro",type="char",example="A"),
     *                         )
     *                     )
     *                 )
     *             ),
     *             @OA\Property(type="count",property="size",example="1")
     *         )
     *     ),
     *     @OA\Response(response=400,description="invalid",
     *         @OA\JsonContent(
     *             @OA\Property(property="Error",type="string",example="Error: No se encuentran Registros...")
     *         )
     *     )
     * )
     */

    public function get(){
        try {
            $registro = ProcesoCognoscitivo::with('lucidos_atentos','pensamientos', 'percepcion', 'memorias','inteligencias','apetitos','suennos','personalidades','afectividades','conductas_sexuales')->where('estado_registro', 'A')->get();
            if(count($registro)==0) return response()->json(["Error"=>"Por ahora no hay Registros Activos..."]);
            return response()->json(["data"=>$registro,"size"=>count($registro)]);
        } catch (Exception $e) {
            return response()->json(["Error: No se encuentran Registros..." => $e],500);
        }
    }

    /**
     * Permite crear un registro en la tabla "Procesos Cognitivos"
     * @OA\Post (path="/api/procesocognoscitivo/create",security={{ "bearerAuth":{} }},tags={"Psicología - ProcesoCognoscitivo"},
     *     @OA\Parameter(description="La ID (Llave Primaria) de la tabla 'Clinica Servicio'",
     *         @OA\Schema(type="integer"),name="clinica_servicio_id",in="query",required=true,example="1"),
     *     @OA\Parameter(description="La ID (Llave Primaria) de la tabla 'Lucido Atento'",
     *         @OA\Schema(type="integer"),name="lucido_atento_id",in="query",required=true,example="1"),
     *     @OA\Parameter(description="La ID (Llave Primaria) de la tabla 'Pensamiento'",
     *         @OA\Schema(type="integer"),name="pensamiento_id",in="query",required=true,example="1"),
     *     @OA\Parameter(description="La ID (Llave Primaria) de la tabla 'Percepcion'",
     *         @OA\Schema(type="integer"),name="percepcion_id",in="query",required=true,example="1"),
     *     @OA\Parameter(description="La ID (Llave Primaria) de la tabla 'Memoria'",
     *         @OA\Schema(type="integer"),name="memoria_id",in="query",required=true,example="1"),
     *     @OA\Parameter(description="La ID (Llave Primaria) de la tabla 'Inteligencia'",
     *         @OA\Schema(type="integer"),name="inteligencia_id",in="query",required=true,example="1"),
     *     @OA\Parameter(description="La ID (Llave Primaria) de la tabla 'Apetito'",
     *         @OA\Schema(type="integer"),name="apetito_id",in="query",required=true,example="1"),
     *     @OA\Parameter(description="La ID (Llave Primaria) de la tabla 'Suenno'",
     *         @OA\Schema(type="integer"),name="suenno_id",in="query",required=true,example="1"),
     *     @OA\Parameter(description="La ID (Llave Primaria) de la tabla 'Afectividad'",
     *         @OA\Schema(type="integer"),name="afectividad_id",in="query",required=true,example="1"),
     *     @OA\Parameter(description="La ID (Llave Primaria) de la tabla 'Conducta Sexual'",
     *         @OA\Schema(type="integer"),name="conducta_sexual_id",in="query",required=true,example="1"),
     *     @OA\RequestBody(
     *         @OA\MediaType(mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(property="clinica_servicio_id",type="foreignId",example="1"),
     *                 @OA\Property(property="lucido_atento_id",type="foreignId",example="1"),
     *                 @OA\Property(property="pensamiento_id",type="foreignId",example="1"),
     *                 @OA\Property(property="percepcion_id",type="foreignId",example="1"),
     *                 @OA\Property(property="memoria_id",type="foreignId",example="1"),
     *                 @OA\Property(property="inteligencia_id",type="foreignId",example="1"),
     *                 @OA\Property(property="apetito_id",type="foreignId",example="1"),
     *                 @OA\Property(property="suenno_id",type="foreignId",example="1"),
     *                 @OA\Property(property="afectividad_id",type="foreignId",example="1"),
     *                 @OA\Property(property="conducta_sexual_id",type="foreignId",example="1"),
     *             )
     *         )
     *     ),
     *     @OA\Response(response=200,description="success",
     *         @OA\JsonContent(
     *             @OA\Property(property="resp", type="string", example="Proceso Cognitivo creado correctamente")
     *         )
     *     ),
     *     @OA\Response(response=400,description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="Error", type="string", example="El Proceso Cognitivo no se ha creado...")
     *          )
     *      )
     * )
     */

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $usuario = User::with('user_rol.rol')->where('id', auth()->user()->id)->first();
            $clinica=Clinica::where('id', $usuario->user_rol[0]->rol->clinica_id)->first();
            if($clinica)
            {
                ProcesoCognoscitivo::create([
                    // 'ficha_psicologica_ocupacional_id'=>$request->ficha_psicologica_ocupacional_id,
                    // 'clinica_servicio_id'=>$request->clinica_servicio_id,
                    'lucido_atento_id'=>$request->lucido_atento_id,
                    'pensamiento_id'=>$request->pensamiento_id,
                    'percepcion_id'=>$request->percepcion_id,
                    'memoria_id'=>$request->memoria_id,
                    'inteligencia_id'=>$request->inteligencia_id,
                    'apetito_id'=>$request->apetito_id,
                    'suenno_id'=>$request->suenno_id,
                    'personalidad_id'=>$request->personalidad_id,
                    'afectividad_id'=>$request->afectividad_id,
                    'conducta_sexual_id'=>$request->conducta_sexual_id
                ]);
            }else{
                return response()->json(["Error"=>"No tiene accesos (Clínica)..."]);
            }
            DB::commit();
            return response()->json(["resp" => "Proceso Cognitivo creado correctamente"]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["Error: El Proceso Cognitivo no se ha creado..." => $e]);
        }
    }

    /**
     * Permite actualizar un registro de la tabla "Procesos Cognitivos" mediante un ID
     * @OA\Put (path="/api/procesocognoscitivo/update/{id}",security={{ "bearerAuth":{} }},tags={"Psicología - ProcesoCognoscitivo"},
     *     @OA\Parameter(in="path",name="id",required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(description="La ID (Llave Primaria) de la tabla 'Lucido Atento'",
     *         @OA\Schema(type="integer"),name="lucido_atento_id",in="query",required=true,example="1"),
     *     @OA\Parameter(description="La ID (Llave Primaria) de la tabla 'Pensamiento'",
     *         @OA\Schema(type="integer"),name="pensamiento_id",in="query",required=true,example="1"),
     *     @OA\Parameter(description="La ID (Llave Primaria) de la tabla 'Percepcion'",
     *         @OA\Schema(type="integer"),name="percepcion_id",in="query",required=true,example="1"),
     *     @OA\Parameter(description="La ID (Llave Primaria) de la tabla 'Memoria'",
     *         @OA\Schema(type="integer"),name="memoria_id",in="query",required=true,example="1"),
     *     @OA\Parameter(description="La ID (Llave Primaria) de la tabla 'Inteligencia'",
     *         @OA\Schema(type="integer"),name="inteligencia_id",in="query",required=true,example="1"),
     *     @OA\Parameter(description="La ID (Llave Primaria) de la tabla 'Apetito'",
     *         @OA\Schema(type="integer"),name="apetito_id",in="query",required=true,example="1"),
     *     @OA\Parameter(description="La ID (Llave Primaria) de la tabla 'Suenno'",
     *         @OA\Schema(type="integer"),name="suenno_id",in="query",required=true,example="1"),
     *     @OA\Parameter(description="La ID (Llave Primaria) de la tabla 'Afectividad'",
     *         @OA\Schema(type="integer"),name="afectividad_id",in="query",required=true,example="1"),
     *     @OA\Parameter(description="La ID (Llave Primaria) de la tabla 'Conducta Sexual'",
     *         @OA\Schema(type="integer"),name="conducta_sexual_id",in="query",required=true,example="1"),
     *     @OA\RequestBody(
     *         @OA\MediaType(mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(property="lucido_atento_id",type="foreignId",example="1"),
     *                 @OA\Property(property="pensamiento_id",type="foreignId",example="1"),
     *                 @OA\Property(property="percepcion_id",type="foreignId",example="1"),
     *                 @OA\Property(property="memoria_id",type="foreignId",example="1"),
     *                 @OA\Property(property="inteligencia_id",type="foreignId",example="1"),
     *                 @OA\Property(property="apetito_id",type="foreignId",example="1"),
     *                 @OA\Property(property="suenno_id",type="foreignId",example="1"),
     *                 @OA\Property(property="afectividad_id",type="foreignId",example="1"),
     *                 @OA\Property(property="conducta_sexual_id",type="foreignId",example="1"),
     *             )
     *         )
     *     ),
     *     @OA\Response(response=200,description="success",
     *         @OA\JsonContent(
     *             @OA\Property(property="resp", type="string", example="Proceso Cognitivo actualizado correctamente")
     *         )
     *     ),
     *     @OA\Response(response=400,description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="Error", type="string", example="El Proceso Cognitivo no se ha actualizado...")
     *          )
     *      )
     * )
     */

    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $usuario = User::with('user_rol.rol')->where('id', auth()->user()->id)->first();
            $clinica=Clinica::where('id', $usuario->user_rol[0]->rol->clinica_id)->first();
            if($clinica)
            {
                $registro = ProcesoCognoscitivo::where('estado_registro', 'A')->find($id);
                if(!$registro){
                    return response()->json(["Error" => "El Proceso Cognitivo no se encuentra activo"]);
                }
                $registro->fill([
                    // 'ficha_psicologica_ocupacional_id'=>$request->ficha_psicologica_ocupacional_id,
                    // 'clinica_servicio_id'=>$request->clinica_servicio_id,
                    'lucido_atento_id'=>$request->lucido_atento_id,
                    'pensamiento_id'=>$request->pensamiento_id,
                    'percepcion_id'=>$request->percepcion_id,
                    'memoria_id'=>$request->memoria_id,
                    'inteligencia_id'=>$request->inteligencia_id,
                    'apetito_id'=>$request->apetito_id,
                    'suenno_id'=>$request->suenno_id,
                    'personalidad_id'=>$request->personalidad_id,
                    'afectividad_id'=>$request->afectividad_id,
                    'conducta_sexual_id'=>$request->conducta_sexual_id
                    ])->save();
            }else{
                return response()->json(["Error"=>"No tiene accesos (Clínica)..."]);
            }
            DB::commit();
            return response()->json(["resp" => "Proceso Cognitivo actualizado correctamente"]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["Error: El Proceso Cognitivo no se ha actualizado..." => $e]);
        }
    }

    /**
     * Permite eliminar/inactivar un registro de la tabla "Procesos Cognitivos" mediante un ID
     * @OA\Delete (path="/api/procesocognoscitivo/delete/{id}",security={{ "bearerAuth":{} }},tags={"Psicología - ProcesoCognoscitivo"},
     *     @OA\Parameter(in="path",name="id",required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200,description="success",
     *         @OA\JsonContent(
     *             @OA\Property(property="resp", type="string", example="Proceso Cognitivo eliminado correctamente")
     *         )
     *     ),
     *     @OA\Response(response=400,description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="Error", type="string", example="El Proceso Cognitivo no se ha eliminado...")
     *          )
     *      )
     * )
     */

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $usuario = User::with('user_rol.rol')->where('id', auth()->user()->id)->first();
            $clinica=Clinica::where('id', $usuario->user_rol[0]->rol->clinica_id)->first();
            if($clinica)
            {
                $registro = ProcesoCognoscitivo::where('estado_registro', 'A')->find($id);
                if(!$registro){
                    return response()->json(["Error" => "El Proceso Cognitivo a eliminar ya está inactivado..."]);
                }
                $registro->fill([
                    'estado_registro' => 'I',
                ])->save();
            }else{
                return response()->json(["Error"=>"No tiene accesos (Clínica)..."]);
            }
            DB::commit();
            return response()->json(["resp" => "Proceso Cognitivo eliminado correctamente"]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["Error: El Proceso Cognitivo no se ha eliminado..." => $e]);
        }
    }

    /**
     * Permite activar un registro de la tabla "Procesos Cognitivos" mediante un ID
     * @OA\put (path="/api/procesocognoscitivo/active/{id}",security={{ "bearerAuth":{} }},tags={"Psicología - ProcesoCognoscitivo"},
     *     @OA\Parameter(in="path",name="id",required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200,description="success",
     *         @OA\JsonContent(
     *             @OA\Property(property="resp", type="string", example="Proceso Cognitivo activado correctamente")
     *         )
     *     ),
     *     @OA\Response(response=400,description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="Error", type="string", example="El Proceso Cognitivo no se ha activado..."),
     *          )
     *      )
     * )
     */

    public function activar_datos($id)
    {
        DB::beginTransaction();
        try {
            $usuario = User::with('user_rol.rol')->where('id', auth()->user()->id)->first();
            $clinica=Clinica::where('id', $usuario->user_rol[0]->rol->clinica_id)->first();
            if($clinica)
            {
                $registro = ProcesoCognoscitivo::where('estado_registro', 'I')->find($id);
                if(!$registro){
                    return response()->json(["Error" => "El Proceso Cognitivo a activar ya está activado..."]);
                }
                $registro->fill([
                    'estado_registro' => 'A',
                ])->save();
            }else{
                return response()->json(["Error"=>"No tiene accesos (Clínica)..."]);
            }
            DB::commit();
            return response()->json(["resp" => "Proceso Cognitivo activado correctamente"]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["Error: El Proceso Cognitivo no se ha activado..." => $e]);
        }
    }

    /**
     * Permite visualizar un listado de todos los registros de la tabla "Lucido Atento"
     * @OA\Get (path="/api/procesocognoscitivo/lucidoatento/get",security={{ "bearerAuth":{} }},tags={"Psicología - ProcesoCognoscitivo"},
     *     @OA\Response(response=200,description="success",
     *         @OA\JsonContent(
     *             @OA\Property(type="array",property="data",
     *                 @OA\Items(type="object",
     *                     @OA\Property(property="id",type="integer",example="1"),
     *                     @OA\Property(property="nombre",type="string",example="Selectivo y sostenido"),
     *                     @OA\Property(property="estado_registro",type="char",example="A")
     *                 )
     *             ),
     *             @OA\Property(type="count",property="size",example="1")
     *         )
     *     ),
     *     @OA\Response(response=400,description="invalid",
     *         @OA\JsonContent(
     *             @OA\Property(property="Error",type="string",example="Error: No se encuentran Registros...")
     *         )
     *     )
     * )
     */

    public function getLucidoAtento(){
        try {
            $registro = LucidoAtento::where('estado_registro', 'A')->get();
            if(count($registro)==0) return response()->json(["Error"=>"Por ahora no hay Registros Activos..."]);
            return response()->json(["data"=>$registro,"size"=>count($registro)]);
        } catch (Exception $e) {
            return response()->json(["Error: No se encuentran Registros..." => $e],500);
        }
    }

    /**
     * Permite visualizar un listado de todos los registros de la tabla "Pensamiento"
     * @OA\Get (path="/api/procesocognoscitivo/pensamiento/get",security={{ "bearerAuth":{} }},tags={"Psicología - ProcesoCognoscitivo"},
     *     @OA\Response(response=200,description="success",
     *         @OA\JsonContent(
     *             @OA\Property(type="array",property="data",
     *                 @OA\Items(type="object",
     *                     @OA\Property(property="id",type="integer",example="1"),
     *                     @OA\Property(property="nombre",type="string",example="Racional"),
     *                     @OA\Property(property="estado_registro",type="char",example="A")
     *                 )
     *             ),
     *             @OA\Property(type="count",property="size",example="1")
     *         )
     *     ),
     *     @OA\Response(response=400,description="invalid",
     *         @OA\JsonContent(
     *             @OA\Property(property="Error",type="string",example="Error: No se encuentran Registros...")
     *         )
     *     )
     * )
     */

    public function getPensamiento(){
        try {
            $registro = Pensamiento::where('estado_registro', 'A')->get();
            if(count($registro)==0) return response()->json(["Error"=>"Por ahora no hay Registros Activos..."]);
            return response()->json(["data"=>$registro,"size"=>count($registro)]);
        } catch (Exception $e) {
            return response()->json(["Error: No se encuentran Registros..." => $e],500);
        }
    }

    /**
     * Permite visualizar un listado de todos los registros de la tabla "Percepcion"
     * @OA\Get (path="/api/procesocognoscitivo/percepcion/get",security={{ "bearerAuth":{} }},tags={"Psicología - ProcesoCognoscitivo"},
     *     @OA\Response(response=200,description="success",
     *         @OA\JsonContent(
     *             @OA\Property(type="array",property="data",
     *                 @OA\Items(type="object",
     *                     @OA\Property(property="id",type="integer",example="1"),
     *                     @OA\Property(property="nombre",type="string",example="Multisensorial"),
     *                     @OA\Property(property="estado_registro",type="char",example="A")
     *                 )
     *             ),
     *             @OA\Property(type="count",property="size",example="1")
     *         )
     *     ),
     *     @OA\Response(response=400,description="invalid",
     *         @OA\JsonContent(
     *             @OA\Property(property="Error",type="string",example="Error: No se encuentran Registros...")
     *         )
     *     )
     * )
     */

    public function getPercepcion(){
        try {
            $registro = Percepcion::where('estado_registro', 'A')->get();
            if(count($registro)==0) return response()->json(["Error"=>"Por ahora no hay Registros Activos..."]);
            return response()->json(["data"=>$registro,"size"=>count($registro)]);
        } catch (Exception $e) {
            return response()->json(["Error: No se encuentran Registros..." => $e],500);
        }
    }

    /**
     * Permite visualizar un listado de todos los registros de la tabla "Memoria"
     * @OA\Get (path="/api/procesocognoscitivo/memoria/get",security={{ "bearerAuth":{} }},tags={"Psicología - ProcesoCognoscitivo"},
     *     @OA\Response(response=200,description="success",
     *         @OA\JsonContent(
     *             @OA\Property(type="array",property="data",
     *                 @OA\Items(type="object",
     *                     @OA\Property(property="id",type="integer",example="1"),
     *                     @OA\Property(property="nombre",type="string",example="Corto Plazo"),
     *                     @OA\Property(property="estado_registro",type="char",example="A")
     *                 )
     *             ),
     *             @OA\Property(type="count",property="size",example="1")
     *         )
     *     ),
     *     @OA\Response(response=400,description="invalid",
     *         @OA\JsonContent(
     *             @OA\Property(property="Error",type="string",example="Error: No se encuentran Registros...")
     *         )
     *     )
     * )
     */

    public function getMemoria(){
        try {
            $registro = Memoria::where('estado_registro', 'A')->get();
            if(count($registro)==0) return response()->json(["Error"=>"Por ahora no hay Registros Activos..."]);
            return response()->json(["data"=>$registro,"size"=>count($registro)]);
        } catch (Exception $e) {
            return response()->json(["Error: No se encuentran Registros..." => $e],500);
        }
    }

    /**
     * Permite visualizar un listado de todos los registros de la tabla "Inteligencia"
     * @OA\Get (path="/api/procesocognoscitivo/inteligencia/get",security={{ "bearerAuth":{} }},tags={"Psicología - ProcesoCognoscitivo"},
     *     @OA\Response(response=200,description="success",
     *         @OA\JsonContent(
     *             @OA\Property(type="array",property="data",
     *                 @OA\Items(type="object",
     *                     @OA\Property(property="id",type="integer",example="1"),
     *                     @OA\Property(property="nombre",type="string",example="mMy Superior"),
     *                     @OA\Property(property="estado_registro",type="char",example="A")
     *                 )
     *             ),
     *             @OA\Property(type="count",property="size",example="1")
     *         )
     *     ),
     *     @OA\Response(response=400,description="invalid",
     *         @OA\JsonContent(
     *             @OA\Property(property="Error",type="string",example="Error: No se encuentran Registros...")
     *         )
     *     )
     * )
     */

    public function getInteligencia(){
        try {
            $registro = Inteligencia::where('estado_registro', 'A')->get();
            if(count($registro)==0) return response()->json(["Error"=>"Por ahora no hay Registros Activos..."]);
            return response()->json(["data"=>$registro,"size"=>count($registro)]);
        } catch (Exception $e) {
            return response()->json(["Error: No se encuentran Registros..." => $e],500);
        }
    }

    /**
     * Permite visualizar un listado de todos los registros de la tabla "Apetito"
     * @OA\Get (path="/api/procesocognoscitivo/apetito/get",security={{ "bearerAuth":{} }},tags={"Psicología - ProcesoCognoscitivo"},
     *     @OA\Response(response=200,description="success",
     *         @OA\JsonContent(
     *             @OA\Property(type="array",property="data",
     *                 @OA\Items(type="object",
     *                     @OA\Property(property="id",type="integer",example="1"),
     *                     @OA\Property(property="nombre",type="string",example="Adecuado"),
     *                     @OA\Property(property="estado_registro",type="char",example="A")
     *                 )
     *             ),
     *             @OA\Property(type="count",property="size",example="1")
     *         )
     *     ),
     *     @OA\Response(response=400,description="invalid",
     *         @OA\JsonContent(
     *             @OA\Property(property="Error",type="string",example="Error: No se encuentran Registros...")
     *         )
     *     )
     * )
     */

    public function getApetito(){
        try {
            $registro = Apetito::where('estado_registro', 'A')->get();
            if(count($registro)==0) return response()->json(["Error"=>"Por ahora no hay Registros Activos..."]);
            return response()->json(["data"=>$registro,"size"=>count($registro)]);
        } catch (Exception $e) {
            return response()->json(["Error: No se encuentran Registros..." => $e],500);
        }
    }

    /**
     * Permite visualizar un listado de todos los registros de la tabla "Suenno"
     * @OA\Get (path="/api/procesocognoscitivo/suenno/get",security={{ "bearerAuth":{} }},tags={"Psicología - ProcesoCognoscitivo"},
     *     @OA\Response(response=200,description="success",
     *         @OA\JsonContent(
     *             @OA\Property(type="array",property="data",
     *                 @OA\Items(type="object",
     *                     @OA\Property(property="id",type="integer",example="1"),
     *                     @OA\Property(property="nombre",type="string",example="Ciclo REM adecuado"),
     *                     @OA\Property(property="estado_registro",type="char",example="A")
     *                 )
     *             ),
     *             @OA\Property(type="count",property="size",example="1")
     *         )
     *     ),
     *     @OA\Response(response=400,description="invalid",
     *         @OA\JsonContent(
     *             @OA\Property(property="Error",type="string",example="Error: No se encuentran Registros...")
     *         )
     *     )
     * )
     */

    public function getSuenno(){
        try {
            $registro = Suenno::where('estado_registro', 'A')->get();
            if(count($registro)==0) return response()->json(["Error"=>"Por ahora no hay Registros Activos..."]);
            return response()->json(["data"=>$registro,"size"=>count($registro)]);
        } catch (Exception $e) {
            return response()->json(["Error: No se encuentran Registros..." => $e],500);
        }
    }

    /**
     * Permite visualizar un listado de todos los registros de la tabla "Personalidad"
     * @OA\Get (path="/api/procesocognoscitivo/personalidad/get",security={{ "bearerAuth":{} }},tags={"Psicología - ProcesoCognoscitivo"},
     *     @OA\Response(response=200,description="success",
     *         @OA\JsonContent(
     *             @OA\Property(type="array",property="data",
     *                 @OA\Items(type="object",
     *                     @OA\Property(property="id",type="integer",example="1"),
     *                     @OA\Property(property="nombre",type="string",example="Tendencia a la introversión"),
     *                     @OA\Property(property="estado_registro",type="char",example="A")
     *                 )
     *             ),
     *             @OA\Property(type="count",property="size",example="1")
     *         )
     *     ),
     *     @OA\Response(response=400,description="invalid",
     *         @OA\JsonContent(
     *             @OA\Property(property="Error",type="string",example="Error: No se encuentran Registros...")
     *         )
     *     )
     * )
     */

    public function getPersonalidad(){
        try {
            $registro = Personalidad::where('estado_registro', 'A')->get();
            if(count($registro)==0) return response()->json(["Error"=>"Por ahora no hay Registros Activos..."]);
            return response()->json(["data"=>$registro,"size"=>count($registro)]);
        } catch (Exception $e) {
            return response()->json(["Error: No se encuentran Registros..." => $e],500);
        }
    }

    /**
     * Permite visualizar un listado de todos los registros de la tabla "Afectividad"
     * @OA\Get (path="/api/procesocognoscitivo/afectividad/get",security={{ "bearerAuth":{} }},tags={"Psicología - ProcesoCognoscitivo"},
     *     @OA\Response(response=200,description="success",
     *         @OA\JsonContent(
     *             @OA\Property(type="array",property="data",
     *                 @OA\Items(type="object",
     *                     @OA\Property(property="id",type="integer",example="1"),
     *                     @OA\Property(property="nombre",type="string",example="Tendencia a la estabilidad"),
     *                     @OA\Property(property="estado_registro",type="char",example="A")
     *                 )
     *             ),
     *             @OA\Property(type="count",property="size",example="1")
     *         )
     *     ),
     *     @OA\Response(response=400,description="invalid",
     *         @OA\JsonContent(
     *             @OA\Property(property="Error",type="string",example="Error: No se encuentran Registros...")
     *         )
     *     )
     * )
     */

    public function getAfectividad(){
        try {
            $registro = Afectividad::where('estado_registro', 'A')->get();
            if(count($registro)==0) return response()->json(["Error"=>"Por ahora no hay Registros Activos..."]);
            return response()->json(["data"=>$registro,"size"=>count($registro)]);
        } catch (Exception $e) {
            return response()->json(["Error: No se encuentran Registros..." => $e],500);
        }
    }

    /**
     * Permite visualizar un listado de todos los registros de la tabla "ConductaSexual"
     * @OA\Get (path="/api/procesocognoscitivo/conductasexual/get",security={{ "bearerAuth":{} }},tags={"Psicología - ProcesoCognoscitivo"},
     *     @OA\Response(response=200,description="success",
     *         @OA\JsonContent(
     *             @OA\Property(type="array",property="data",
     *                 @OA\Items(type="object",
     *                     @OA\Property(property="id",type="integer",example="1"),
     *                     @OA\Property(property="nombre",type="string",example="Orientado a su rol de género"),
     *                     @OA\Property(property="estado_registro",type="char",example="A")
     *                 )
     *             ),
     *             @OA\Property(type="count",property="size",example="1")
     *         )
     *     ),
     *     @OA\Response(response=400,description="invalid",
     *         @OA\JsonContent(
     *             @OA\Property(property="Error",type="string",example="Error: No se encuentran Registros...")
     *         )
     *     )
     * )
     */

    public function getConductaSexual(){
        try {
            $registro = ConductaSexual::where('estado_registro', 'A')->get();
            if(count($registro)==0) return response()->json(["Error"=>"Por ahora no hay Registros Activos..."]);
            return response()->json(["data"=>$registro,"size"=>count($registro)]);
        } catch (Exception $e) {
            return response()->json(["Error: No se encuentran Registros..." => $e],500);
        }
    }
}
