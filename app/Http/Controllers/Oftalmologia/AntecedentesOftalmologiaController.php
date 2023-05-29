<?php

namespace App\Http\Controllers\Oftalmologia;

use App\Models\AntecedentesOftalmologia;
use App\Http\Controllers\Controller;
use App\Models\AntecedentesOculares;
use App\Models\AntecedentesSistemico;
use App\Models\Clinica;
use App\Models\Conductor;
use App\Models\Correctores;
use App\User;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Database\Query\Builder;

class AntecedentesOftalmologiaController extends Controller
{
    /**
     * Get
     * @OA\Get (
     *     path="/api/oftalmologia/antecedentes/get",
     *     tags={"Oftalmologia-Antecedentes"},
     *     @OA\Response(
     *         response=200,
     *         description="success",
     *         @OA\JsonContent(
     *             @OA\Property(type="array",property="data",
     *                 @OA\Items(type="object",
     *                     @OA\Property(property="id",type="number",example=1),
     *                     @OA\Property(property="clinica_servicio_id",type="foreignId",example= 1),
     *                     @OA\Property(property="conductor_id",type="foreignId",example= 1),
     *                     @OA\Property(property="correctores_id",type="foreignId",example= 1),
     *                     @OA\Property(property="tipo",type="String",example="Example tipo"),
     *                     @OA\Property(property="estado_registro",type="char",example="A"),
     *                     @OA\Property(type="array",property="clinica_servicio",
     *                         @OA\Items(type="object",@OA\Property(property="id",type="number",example="1"),
     *                               @OA\Property(property="servicio_id",type="foreignId",example= null),
     *                               @OA\Property(property="paquete_clinica_id",type="foreignId",example= null),
     *                               @OA\Property(property="clinica_id",type="foreignId",example= 1),
     *                               @OA\Property(property="ficha_medico_ocupacional_id",type="foreignId",example= null),
     *                               @OA\Property(property="nombre",type="String",example= "Padre General 1"),
     *                               @OA\Property(property="icono",type="string",example= null),
     *                               @OA\Property(property="parent_id",type="unsignedBigInteger",example= null),
     *                               @OA\Property(property="estado_registro",type="char",example="A"),),),
     *                      @OA\Property(type="array",property="conductor",
     *                         @OA\Items(type="object",
     *                               @OA\Property(property="id",type="number",example="1"),
     *                               @OA\Property(property="respuesta",type="string",example="Si"),
     *                               @OA\Property(property="estado_registro",type="char",example="A"),),),
     *                      @OA\Property(type="array",property="correctores",
     *                         @OA\Items(type="object",
     *                               @OA\Property(property="id",type="number",example="1"),
     *                               @OA\Property(property="respuesta",type="string", example="Si"),
     *                               @OA\Property(property="estado_registro",type="char",example="A"),),),
     *                      @OA\Property(type="array",property="antecedentes_oculares",
     *                         @OA\Items(type="object",
     *                               @OA\Property(property="id",type="number",example="1"),
     *                               @OA\Property(property="antecedentes_oftalmologias_id",type="foreignId",example="1"),
     *                               @OA\Property(property="enfermedades_oculares_id",type="foreignId",example="1"),
     *                               @OA\Property(property="estado_registro",type="char",example="A"),
     *                               @OA\Property(type="array",property="enfermedades_oculares",
     *                                  @OA\Items(type="object",
     *                                  @OA\Property(property="id",type="number",example="1"),
     *                                  @OA\Property(property="patologia_id",type="foreignId",example= 1),
     *                                  @OA\Property(property="clinica_id",type="foreignId",example= 1),
     *                                  @OA\Property(property="activo",type="char",example= "0"),
     *                                  @OA\Property(property="estado_registro",type="char",example= "A"),),),),),
     *                      @OA\Property(type="array",property="antecedentes_sistemico",
     *                         @OA\Items(type="object",
     *                               @OA\Property(property="id",type="number",example="1"),
     *                               @OA\Property(property="antecedentes_oftalmologias_id",type="foreignId",example="1"),
     *                               @OA\Property(property="enfermedades_sistemicos_id",type="foreignId",example="1"),
     *                               @OA\Property(property="estado_registro",type="char",example="A"),
     *                               @OA\Property(type="array",property="enfermedades_sistemico",
     *                                  @OA\Items(type="object",
     *                                  @OA\Property(property="id",type="number",example="1"),
     *                                  @OA\Property(property="patologia_id",type="foreignId",example= 1),
     *                                  @OA\Property(property="clinica_id",type="foreignId",example= 1),
     *                                  @OA\Property(property="activo",type="char",example= "0"),
     *                                  @OA\Property(property="estado_registro",type="char",example= "A"),),),),),),),
     *               @OA\Property(property="size",type="count",example="1"),),),
     *          @OA\Response(response=400,description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="ERROR"),),),)
     */
    public function get()
    {
        try{
            $datos = AntecedentesOftalmologia::with(
                'clinica_servicio',
                'conductor','correctores',
                'antecedentes_oculares.enfermedades_oculares.patologias',
                'antecedentes_sistemico.enfermedades_sistemico.patologias'
                )->where('estado_registro', 'A')->get();
            return response()->json(["data" => $datos, "size" => count($datos)]);
        }catch(Exception $e){
            // return response()->json(["No se encuentran Registros" => $e],500);
            return response()->json(["error" => "".$e]);
        }
    }
    /**
     * @OA\Post(
     *     path="/api/oftalmologia/antecedentes",
     *     tags={"Oftalmologia-Antecedentes"},
     *     summary="Create",
     *     @OA\Parameter(name="patologia_id",in="query",description="La ID (Llave Primaria) de la tabla 'Patologia'",required=true,
     *         @OA\Schema(type="integer",example=1),),
     *     @OA\Parameter(name="clinica_servicio_id",in="query",description="La ID (Llave Primaria) de la tabla 'Clinica_Servicio'",required=true,
     *         @OA\Schema(type="integer",example=1),),
     *     @OA\Parameter(name="conductor_id",in="query",description="La ID (Llave Primaria) de la tabla 'Conductor'",required=true,@OA\Schema(type="integer",example=1),),
     *     @OA\Parameter(name="correctores_id",in="query",description="La ID (Llave Primaria) de la tabla 'Correctores'",required=true,
     *         @OA\Schema(type="integer",example=1),),
     *     @OA\Parameter(name="tipo",in="query",description="Ingrese el tipo de Antecedentes",required=true,
     *         @OA\Schema(type="string",example="example tipo")),
     *     @OA\RequestBody(
     *         @OA\JsonContent(type="object",
     *             @OA\Property(property="enfermedades_oculares",type="array",
     *                 @OA\Items(type="object",
     *                     @OA\Property(property="patologia_id",type="integer",example=1),),
     *                 @OA\Items(type="object",
     *                     @OA\Property(property="patologia_id",type="integer",example=2),),),
     *             @OA\Property(property="enfermedades_sistemicos",type="array",
     *                 @OA\Items(type="object",
     *                     @OA\Property(property="patologia_id",type="integer",example=2),),
     *                 @OA\Items(type="object",
     *                     @OA\Property(property="patologia_id",type="integer",example=2),),),
     *             @OA\Property(property="clinica_servicio_id",type="foreignId",example= 1),
     *             @OA\Property(property="conductor_id",type="foreignId",example= 1),
     *             @OA\Property(property="correctores_id",type="foreignId",example= 1),
     *             @OA\Property(property="tipo",type="String",example= "example tipo"),),),
     *     @OA\Response(response=200,description="success",
     *         @OA\JsonContent(
     *             @OA\Property(property="msg", type="string", example="Registro creado correctamente"),),),
     *     @OA\Response(response=400,description="invalid",
     *         @OA\JsonContent(
     *             @OA\Property(property="resp", type="string", example="ERROR"),),),)
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $usuario = User::with('user_rol.rol')->where('id', auth()->user()->id)->first();
            $clinica=Clinica::where('id', $usuario->user_rol[0]->rol->clinica_id)->first();
            if($clinica)
            {
            if (strlen($request->conductor_id) == 0) return response()->json(['resp' => 'No ingresaste el id de conductor'], 404);
            if (strlen($request->correctores_id) == 0) return response()->json(['resp' => 'No ingresaste el id de correctores'], 404);
            if (!Conductor::where('estado_registro', 'A')->find($request->conductor_id)) return response()->json(['error' => 'El id Conductor no existe'], 404);
            if (!Correctores::where('estado_registro', 'A')->find($request->correctores_id)) return response()->json(['error' => 'El id Correctores no existe'], 404);

            $AOftalmologia  = AntecedentesOftalmologia::create([
                'clinica_servicio_id' => $request->clinica_servicio_id,
                'conductor_id' => $request->conductor_id,
                'correctores_id' => $request->correctores_id,
                'tipo' => $request->tipo,
            ]);

            $antecedentes_oculares=$request->antecedentes_oculares;
            // return response()->json($antecedentes_oculares);
            foreach ($antecedentes_oculares as $antecedente_ocular) {
                AntecedentesOculares::create([
                    'antecedentes_oftalmologias_id'=>$AOftalmologia->id,
                    'enfermedades_oculares_id'=>$antecedente_ocular['enfermedades_oculares_id'],
                ]);
            }

            $antecedentes_sistemicos=$request->antecedentes_sistemicos;
            // return response()->json($antecedentes_sistemicos);
            foreach ($antecedentes_sistemicos as $antecedente_sistemico) {
                AntecedentesSistemico::create([
                    'antecedentes_oftalmologias_id'=>$AOftalmologia->id,
                    'enfermedades_sistemicos_id'=>$antecedente_sistemico['enfermedades_sistemicos_id'],
                ]);
            }
        }else{
            return response()->json(["Error"=>"No tiene accesos..."]);
        }
        DB::commit();
            return response()->json(["resp" => "Dato creado correctamente"]);

        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["Error: El dato no se ha creado..." => $e]);
        }
    }
    /**
     * @OA\Put(
     *     path="/api/oftalmologia/antecedentes/update/{id}",
     *     tags={"Oftalmologia-Antecedentes"},
     *     summary="Update",
     *     @OA\Parameter(name="patologia_id",in="query",description="La ID (Llave Primaria) de la tabla 'Patologia'",required=true,
     *         @OA\Schema(type="integer",example=1),),
     *     @OA\Parameter(name="clinica_servicio_id",in="query",description="La ID (Llave Primaria) de la tabla 'Clinica_Servicio'",required=true,
     *         @OA\Schema(type="integer",example=1),),
     *     @OA\Parameter(name="conductor_id",in="query",description="La ID (Llave Primaria) de la tabla 'Conductor'",required=true,
     *         @OA\Schema(type="integer",example=1),),
     *     @OA\Parameter(name="correctores_id",in="query",description="La ID (Llave Primaria) de la tabla 'Correctores'",required=true,
     *         @OA\Schema(type="integer",example=1),),
     *     @OA\Parameter(name="tipo",in="query",description="Ingrese el tipo de Antecedentes",required=true,
     *         @OA\Schema(type="string",example="example tipo"),),
     *     @OA\RequestBody(
     *         @OA\JsonContent(type="object",
     *             @OA\Property(property="enfermedades_oculares",type="array",
     *                 @OA\Items(type="object",
     *                     @OA\Property(property="patologia_id",type="integer",example=1),),
     *                 @OA\Items(type="object",
     *                     @OA\Property(property="patologia_id",type="integer",example=2),),),
     *             @OA\Property(property="enfermedades_sistemicos",type="array",
     *                 @OA\Items(type="object",
     *                     @OA\Property(property="patologia_id",type="integer",example=2),),
     *                 @OA\Items(type="object",
     *                     @OA\Property(property="patologia_id",type="integer",example=2),),),
     *             @OA\Property(property="clinica_servicio_id",type="foreignId",example= 1),
     *             @OA\Property(property="conductor_id",type="foreignId",example= 1),
     *             @OA\Property(property="correctores_id",type="foreignId",example= 1),
     *             @OA\Property(property="tipo",type="String",example= "example tipo"),),),
     *     @OA\Response(response=200,description="success",
     *         @OA\JsonContent(
     *             @OA\Property(property="msg", type="string", example="Registro actualizado correctamente"),),),
     *     @OA\Response(response=400,description="invalid",@OA\JsonContent(
     *             @OA\Property(property="resp", type="string", example="ERROR"),),),)
     */
    public function update(Request $request,$id)
    {
        DB::beginTransaction();
        try {
            $usuario = User::with('user_rol.rol')->where('id', auth()->user()->id)->first();
            $clinica=Clinica::where('id', $usuario->user_rol[0]->rol->clinica_id)->first();
            if($clinica)
            {
            if (strlen($request->conductor_id) == 0) return response()->json(['resp' => 'No ingresaste el id de conductor'], 404);
            if (strlen($request->correctores_id) == 0) return response()->json(['resp' => 'No ingresaste el id de correctores'], 404);
            if (!Conductor::where('estado_registro', 'A')->find($request->conductor_id)) return response()->json(['error' => 'El id Conductor no existe'], 404);
            if (!Correctores::where('estado_registro', 'A')->find($request->correctores_id)) return response()->json(['error' => 'El id Correctores no existe'], 404);

            $anteOftal=AntecedentesOftalmologia::where('estado_registro', 'A')->find($id);
            if(!$anteOftal) return response()->json(['Error' => 'El Registro no se encuentra activo o no existe...']);
            // return response()->json($anteOftal);
            $anteOftal->fill([
                'clinica_servicio_id' => $request->clinica_servicio_id,
                'conductor_id' => $request->conductor_id,
                'correctores_id' => $request->correctores_id,
                'tipo' => $request->tipo,
            ])->save();

            // $anteocu=AntecedentesOculares::where('antecedentes_oftalmologias_id',$id)->get();
            // return response()->json($anteocu);
            // $anteocu->delete(); // xq no funciona...
            // $antesis=AntecedentesSistemico::where('antecedentes_oftalmologias_id',$id)->get();
            // return response()->json($antesis);
            // $antesis->delete

            DB::table('antecedentes_oculares')->where('antecedentes_oftalmologias_id',$id)->update(['estado_registro' => 'I']);
            DB::table('antecedentes_sistemicos')->where('antecedentes_oftalmologias_id',$id)->update(['estado_registro' => 'I']);

            $antecedentes_oculares=$request->antecedentes_oculares;
            // return response()->json($antecedentes_oculares);
            foreach ($antecedentes_oculares as $antecedente_ocular) {
                AntecedentesOculares::updateOrcreate([
                    'antecedentes_oftalmologias_id'=>$id,
                    'enfermedades_oculares_id'=>$antecedente_ocular['enfermedades_oculares_id'],
                ],[
                    'estado_registro'=>'A'
                ]);
            }

            $antecedentes_sistemicos=$request->antecedentes_sistemicos;
            // return response()->json($antecedentes_sistemicos);
            foreach ($antecedentes_sistemicos as $antecedente_sistemico) {
                AntecedentesSistemico::updateOrcreate([
                    'antecedentes_oftalmologias_id'=>$id,
                    'enfermedades_sistemicos_id'=>$antecedente_sistemico['enfermedades_sistemicos_id'],
                ],[
                    'estado_registro'=>'A'
                ]);
            }
        }else{
            return response()->json(["Error"=>"No tiene accesos..."]);
        }
        DB::commit();
        return response()->json(["resp" => "Dato actualizado correctamente"]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["error" => "".$e]);
            // return response()->json(["error" => $e]);
        }
    }
    /**
     * Delete
     * @OA\Delete (
     *     path="/api/oftalmologia/antecedentes/delete/{id}",
     *     tags={"Oftalmologia-Antecedentes"},
     *     @OA\Parameter(in="path",name="id",required=true,
     *         @OA\Schema(type="string"),),
     *     @OA\Response(response=200,description="success",
     *         @OA\JsonContent(
     *             @OA\Property(property="msg", type="string", example="delete todo success"),),),
     *          @OA\Response(response=400,description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="ERROR"),),),)
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $datos = AntecedentesOftalmologia::where('estado_registro', 'A')->find($id);
            if(!$datos){
                return response()->json(["resp"=>"Usuario ya Inactivado"]);
            }
            $datos->fill([
                'estado_registro'=>'I'
            ])->save();
            DB::commit();
            return response()->json(["resp" => "Dato inactivo correctamente"]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["error" => "".$e,501]);
        }
    }
    /**
     * Reintegrar
     * @OA\Put (
     *     path="/api/oftalmologia/antecedentes/reintegrar/{id}",
     *     tags={"Oftalmologia-Antecedentes"},
     *     @OA\Parameter(in="path",name="id",required=true,
     *         @OA\Schema(type="string"),),
     *     @OA\Response(response=200,description="success",
     *         @OA\JsonContent(
     *             @OA\Property(property="msg", type="string", example="active todo success"),),),
     *          @OA\Response(response=400,description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="ERROR"),),),)
     */
    public function reintegrar($id) // ... no se me ocurre nada si no me funciona el delete() en el update :'v Firma:RockiiScorpio ...
    {
        DB::beginTransaction();
        try {
            $datos = AntecedentesOftalmologia::where('estado_registro', 'I')->find($id);
            if(!$datos){
                return response()->json(["resp"=>"Registro ya ha sido Activado"]);
            }
            $datos->fill([
                'estado_registro'=>'A'
            ])->save();
            DB::commit();
            return response()->json(["resp" => "Registro Activado correctamente"]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["error" => $e]);
        }
    }
    /**
     * ConductoresGet
     * @OA\Get (
     *     path="/api/oftalmologia/antecedentes/Con/get",
     *     tags={"Oftalmologia-Antecedentes"},
     *     @OA\Response(response=200,description="OK",
     *         @OA\JsonContent(
     *             @OA\Property(type="array",property="data",
     *                 @OA\Items(type="object",
     *                     @OA\Property(property="id",type="integer",example=1),
     *                     @OA\Property(property="respuesta",type="string",example="Si"),
     *                     @OA\Property(property="estado_registro",type="string",example="A"),),),
     *             @OA\Property(property="size",type="integer",example=1),),),
     *     @OA\Response(response=400,description="Solicitud inválida",
     *         @OA\JsonContent(
     *             @OA\Property(property="resp", type="string", example="ERROR"),),),)
     */
    public function getCon()
    {
        try{
            $datos = Conductor::where('estado_registro', 'A')->get();
            if (!$datos)return response()->json(["No hay registros activos"]);
            return response()->json(["data" => $datos, "size" => count($datos)]);
        }catch(Exception $e){
            return response()->json(["No se encuentran Registros" => $e],500);
        }
    }
    /**
     * CorrectoresGet
     * @OA\Get (
     *     path="/api/oftalmologia/antecedentes/Cor/get",
     *     tags={"Oftalmologia-Antecedentes"},
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\JsonContent(
     *             @OA\Property(type="array",property="data",
     *                 @OA\Items(type="object",
     *                     @OA\Property(property="id",type="integer",example=1),
     *                     @OA\Property(property="respuesta",type="string",example="Si"),
     *                     @OA\Property(property="estado_registro",type="string",example="A"),),),
     *             @OA\Property(property="size",type="integer",example=1),),),
     *     @OA\Response(response=400,description="Solicitud inválida",
     *         @OA\JsonContent(
     *             @OA\Property(property="resp", type="string", example="ERROR"),),),)
     */
    public function getCor()
    {
        try{
            $datos = Correctores::where('estado_registro', 'A')->get();
            if (!$datos)return response()->json(["No hay registros activos"]);
            return response()->json(["data" => $datos, "size" => count($datos)]);
        }catch(Exception $e){
            return response()->json(["No se encuentran Registros" => $e],500);
        }
    }
}
