<?php

namespace App\Http\Controllers\Psicologia;

use App\Http\Controllers\Controller;
use App\Models\Clinica;
use App\Models\Prueba;
use App\Models\PruebaPsicologica;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PruebaPsicologicaController extends Controller
{
    /**
     * Permite visualizar un listado de todos los registros de la tabla "Pruebas Psicológicas"
     * @OA\Get (path="/api/pruebaspsicologicas/get",
     * security={{ "bearerAuth":{} }},
     * tags={"Psicología - PruebasPsicológicas"},
     *     @OA\Response(response=200,description="success",
     *         @OA\JsonContent(
     *             @OA\Property(type="array",property="data",
     *                 @OA\Items(type="object",
     *                     @OA\Property(property="id",type="integer",example="1"),
     *                     @OA\Property(property="psicologia_id",type="foreignId",example="1"),
     *                     @OA\Property(property="prueba_id",type="foreignId",example="1"),
     *                     @OA\Property(property="estado_registro",type="char",example="A"),
     *                     @OA\Property(type="array",property="pruebas",
     *                         @OA\Items(type="object",
     *                             @OA\Property(property="id",type="integer",example="1"),
     *                             @OA\Property(property="nombre",type="string",example="Test rápido de inteligencia"),
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
            $registro=PruebaPsicologica::with(['prueba'])->where('estado_registro', 'A')->get();
            if(count($registro)==0) return response()->json(["Error"=>"Por ahora no hay Registros Activos..."]);
            return response()->json(["data"=>$registro,"size"=>count($registro)]);
        } catch (Exception $e) {
            return response()->json(["Error: No se encuentran Registros..." => $e],500);
        }
    }

    /**
     * Permite crear un registro en la tabla "Pruebas Psicológicas"
     * @OA\Post (
     *     path="/api/pruebaspsicologicas/create",
     *     security={{ "bearerAuth":{} }},
     *     tags={"Psicología - PruebasPsicológicas"},
     *     @OA\Parameter(description="La ID (Llave Primaria) de la tabla 'Psicologia'",
     *         @OA\Schema(type="integer"),name="psicologia_id",in="query",required=false,example="1"),
     *     @OA\Parameter(description="La ID (Llave Primaria) de la tabla 'Pruebas'",
     *         @OA\Schema(type="integer"),name="prueba_id",in="query",required=false,example="1"),
     *     @OA\RequestBody(
     *         @OA\MediaType(mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(property="psicologia_id",type="foreignId",example="1"),
     *                 @OA\Property(property="prueba_id",type="foreignId",example="1")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="success",
     *         @OA\JsonContent(
     *             @OA\Property(property="resp", type="string", example="Prueba Psicológica creado correctamente")
     *         )
     *     ),
     *     @OA\Response(
     *          response=400,
     *          description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="Error", type="string", example="La Prueba Psicológica no se ha creado...")
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
                $pruebapsico=PruebaPsicologica::create([
                    'psicologia_id'=>$request->psicologia_id,
                    'prueba_id'=>$request->prueba_id,
                //]);
                // $prueba=Prueba::where('id',$request->prueba_id)->first();
                //$prueba=Prueba::where('estado_registro','A')->find($request->prueba_id);
                // return response()->json($prueba);
                //$prueba->fill([
                //    'pruebas_psicologicas_id'=>$pruebapsico->id,
                ])->save();
            }else{
                return response()->json(["Error"=>"No tiene accesos (Clínica)..."]);
            }
            DB::commit();
            return response()->json(["resp" => "Prueba Psicológica creado correctamente"]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["Error: La Prueba Psicológica no se ha creado..." => $e]);
        }
    }

    /**
     * Permite actualizar un registro de la tabla "Pruebas Psicológicas" mediante un ID
     * @OA\Put (path="/api/pruebaspsicologicas/update/{id}",
     *      security={{ "bearerAuth":{} }},
     *      tags={"Psicología - PruebasPsicológicas"},
     *     @OA\Parameter(in="path",name="id",required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(description="La ID (Llave Primaria) de la tabla 'Psicologia'",
     *         @OA\Schema(type="integer"),name="psicologia_id",in="query",required=false,example="1"),
     *     @OA\Parameter(description="La ID (Llave Primaria) de la tabla 'Prueba'",
     *         @OA\Schema(type="integer"),name="prueba_id",in="query",required=false,example="2"),
     *     @OA\RequestBody(
     *         @OA\MediaType(mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(property="psicologia_id",type="foreignId",example="1"),
     *                 @OA\Property(property="prueba_id",type="foreignId",example="2")
     *             )
     *         )
     *     ),
     *     @OA\Response(response=200,description="success",
     *         @OA\JsonContent(
     *             @OA\Property(property="resp", type="string", example="Prueba Psicológica actualizado correctamente")
     *         )
     *     ),
     *     @OA\Response(response=400,description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="Error", type="string", example="La Prueba Psicológica no se ha actualizado...")
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
                $pruebapsico=PruebaPsicologica::where('estado_registro','A')->find($id);
                // return response()->json($pruebapsico);
                $pruebapsico->fill([
                    'psicologia_id'=>$request->psicologia_id,
                    'prueba_id'=>$request->prueba_id,
                ])->save();
                //$prueba=Prueba::where('estado_registro','A')->find($request->prueba_id);
                // return response()->json($prueba);
                //$prueba->fill([
                //    'pruebas_psicologicas_id'=>$pruebapsico->id,
                //])->save();
            }else{
                return response()->json(["Error"=>"No tiene accesos (Clínica)..."]);
            }
            DB::commit();
            return response()->json(["resp" => "Prueba Psicológica actualizado correctamente"]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["Error: La Prueba Psicológica no se ha actualizado..." => $e]);
        }
    }

    /**
     * Permite eliminar/inactivar un registro de la tabla "Pruebas Psicológicas" mediante un ID
     * @OA\Delete (
     *     path="/api/pruebaspsicologicas/delete/{id}",
     *     security={{ "bearerAuth":{} }},
     *     tags={"Psicología - PruebasPsicológicas"},
     *     @OA\Parameter(in="path",name="id",required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200,description="success",
     *         @OA\JsonContent(
     *             @OA\Property(property="resp", type="string", example="Prueba Psicológica eliminado correctamente")
     *         )
     *     ),
     *     @OA\Response(response=400,description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="Error", type="string", example="La Prueba Psicológica no se ha eliminado...")
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
                $registro1 = PruebaPsicologica::where('estado_registro', 'I')->find($id);
                if($registro1) return response()->json(["Error" => "La Prueba Psicológica a eliminar ya está inactivado..."]);
                $registro = PruebaPsicologica::where('estado_registro', 'A')->find($id);
                if(!$registro) return response()->json(["Error" => "La Prueba Psicológica a eliminar no se encuentra..."]);
                $registro->fill([
                    'estado_registro' => 'I',
                ])->save();
            }else{
                return response()->json(["Error"=>"No tiene accesos (Clínica)..."]);
            }
            DB::commit();
            return response()->json(["resp" => "Prueba Psicológica eliminado correctamente"]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["Error: La Prueba Psicológica no se ha eliminado..." => $e]);
        }
    }

    /**
     * Permite activar un registro de la tabla "Pruebas Psicológicas" mediante un ID
     * @OA\put (
     *     path="/api/pruebaspsicologicas/active/{id}",
     *     security={{ "bearerAuth":{} }},
     *     tags={"Psicología - PruebasPsicológicas"},
     *     @OA\Parameter(in="path",name="id",required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200,description="success",
     *         @OA\JsonContent(
     *             @OA\Property(property="resp", type="string", example="Prueba Psicológica activado correctamente")
     *         )
     *     ),
     *     @OA\Response(response=400,description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="Error", type="string", example="La Prueba Psicológica no se ha activado..."),
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
                $registro1 = PruebaPsicologica::where('estado_registro', 'A')->find($id);
                if($registro1) return response()->json(["Error" => "La Prueba Psicológica a activar ya está activado..."]);
                $registro = PruebaPsicologica::where('estado_registro', 'I')->find($id);
                if(!$registro) return response()->json(["Error" => "La Prueba Psicológica a activar no se encuentra..."]);

                $registro->fill([
                    'estado_registro' => 'A',
                ])->save();
            }else{
                return response()->json(["Error"=>"No tiene accesos (Clínica)..."]);
            }
            DB::commit();
            return response()->json(["resp" => "Prueba Psicológica activado correctamente"]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["Error: La Prueba Psicológica no se ha activado..." => $e]);
        }
    }

    /**
     * Permite visualizar un listado de todos los registros de la tabla "Pruebas"
     * @OA\Get (path="/api/pruebas/get",
     *      security={{ "bearerAuth":{} }},
     *      tags={"Psicología - PruebasPsicológicas"},
     *     @OA\Response(response=200,description="success",
     *         @OA\JsonContent(
     *             @OA\Property(type="array",property="data",
     *                 @OA\Items(type="object",
     *                     @OA\Property(property="id",type="integer",example="1"),
     *                     @OA\Property(property="nombre",type="string",example="Test rápido de inteligencia"),
     *                     @OA\Property(property="estado_registro",type="char",example="A"),
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

    public function getpruebas(){
        try {
            $registro = Prueba::where('estado_registro', 'A')->get();
            if(count($registro)==0) return response()->json(["Error"=>"Por ahora no hay Registros Activos..."]);
            return response()->json(["data"=>$registro,"size"=>count($registro)]);
        } catch (Exception $e) {
            return response()->json(["Error: No se encuentran Registros..." => $e],500);
        }
    }
}
