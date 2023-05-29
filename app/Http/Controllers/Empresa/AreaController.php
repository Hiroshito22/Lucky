<?php

namespace App\Http\Controllers\Empresa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Area;
use App\Models\Bregma;
use App\Models\Clinica;
use App\Models\Empresa;
use App\Models\Superarea;
use App\User;
use Exception;
use Illuminate\Support\Facades\DB;

class AreaController extends Controller
{
    public function admin()
    {
        $admin_empresa = User::with('persona', 'user_rol.rol.acceso_rol.acceso', 'roles.accesos')->find(auth()->user()->id);
        $valido = false;
        foreach ($admin_empresa->roles as $roles) {
            foreach ($roles->accesos as $accesos) {
                if ($accesos['tipo_acceso'] == 3 && $accesos['url'] == "/areas") {
                    return $valido = true;
                }
            }
        }
        return $valido;
    }


    /**
     * Mostrar Datos Area
     * @OA\Get (
     *     path="/api/empresas/areas/get",
     *     tags={"Recursos Humanos-Clinica-Area"},
     *         @OA\Response(
     *         response=200,
     *         description="success",
     *         @OA\JsonContent(
     *                @OA\Property(
     *                     type="array",
     *                     property="data",
     *                     @OA\Items(
     *                         type="object",
     *                         @OA\Property(property="id",type="integer",example="1"),
     *                         @OA\Property(property="nombre",type="string",example="fef"),
     *                         @OA\Property(property="estado_registro",type="char",example="A"),
     *                         @OA\Property(property="empresa_id",type="integer",example=""),
     *                         @OA\Property(property="superarea_id",type="integer",example="1"),
     *                         @OA\Property(property="bregma_id",type="integer",example=""),
     *                         @OA\Property(property="clinica_id",type="integer",example="1"),
     *                         @OA\Property(
     *                             type="array",
     *                             property="superarea",
     *                             @OA\Items(
     *                                 type="object",
     *                                 @OA\Property(property="id",type="integer",example="1"),
     *                                 @OA\Property(property="nombre",type="string",example="fef"),
     *                                 @OA\Property(property="estado_registro",type="char",example="A"),
     *                                 @OA\Property(property="clinica_id",type="integer",example="1"),
     *                                 @OA\Property(property="bregma_id",type="integer",example="1"),
     *                                 @OA\Property(property="empresa_id",type="integer",example="1"),
     *                                 @OA\Property(property="empresa",type="integer",example=""),
     *                                 @OA\Property(property="bregma",type="integer",example=""),
     *                                 @OA\Property(
     *                                     type="array",
     *                                     property="clinica",
     *                                     @OA\Items(
     *                                        type="object",
     *                                        @OA\Property(property="id",type="integer",example="1"),
     *                                        @OA\Property(property="bregma_id",type="integer",example=""),
     *                                        @OA\Property(property="tipo_documento_id",type="integer",example="1"),
     *                                        @OA\Property(property="distrito_id",type="integer",example=""),
     *                                        @OA\Property(property="ruc",type="integer",example=""),
     *                                        @OA\Property(property="razon_social",type="string",example=""),
     *                                        @OA\Property(property="numero_documento",type="integer",example="11111111"),
     *                                        @OA\Property(property="responsable",type="string",example=""),
     *                                        @OA\Property(property="nombre_comercial",type="string",example=""),
     *                                        @OA\Property(property="latitud",type="string",example=""),
     *                                        @OA\Property(property="longitud",type="string",example=""),
     *                                        @OA\Property(property="logo",type="string",example=""),
     *                                        @OA\Property(property="estado_registro",type="char",example="A"),
     *                                        @OA\Property(property="hospital_id",type="integer",example="")
     *                                    )
     *                                 )
     *                             )
     *                         )
     *                     )
     *               )
     *          ),
     *                 @OA\Property(
     *                    type="integer",
     *                    property="size",
     *                    example="1"
     *                 )
     *             
     *         
     *      ),
     *         
     *         @OA\Response(
     *         response=400,
     *         description="invalid",
     *         @OA\JsonContent(
     *             @OA\Property(property="resp", type="string", example="ERROR"),
     *             )
     *         )
     * )
     */

    public function get()
    {
        try{
            $usuario = User::with('user_rol.rol')->where('id', auth()->user()->id)->first();
            $clinica_id = $usuario->user_rol[0]->rol->clinica_id;
            $area = Area::with('superarea.empresa','superarea.bregma','superarea.clinica')->where('estado_registro', 'A')->where('clinica_id', $clinica_id)->get();
            if (!$area) {
                return response()->json(['resp' => 'Area no existe'],500);
            }
            return response()->json(["data" => $area, "size" => count($area)]);
        }catch(Exception $e){
            return response()->json(["No se encuentran Registros" => $e],500);
        }
    }


     /**
     * Crear Datos Area
     * @OA\Post (
     *     path="/api/empresas/areas/create",
     *     tags={"Recursos Humanos-Clinica-Area"},
     *     @OA\Parameter(
     *     @OA\Schema(type="string"),
     *         name="nombre",
     *         in="query",
     *         required= false,
     *         example="Administracion"
     *     ),
     *     @OA\Parameter(
     *     @OA\Schema(type="integer"),
     *         name="superarea_id",
     *         in="query",
     *         required= false,
     *         example="1"
     *     ),
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                   @OA\Property(
     *                      property="nombre",
     *                      type="integer",
     *                  ),
     *                  @OA\Property(
     *                      property="superarea_id",
     *                      type="integer",
     *                  )
     *             ),
     *                 example={
     *                      "nombre":"Administracion",
     *                      "superarea_id" : 1
     *                 }
     *         )
     *      ),
     *         @OA\Response(
     *         response=200,
     *         description="success",
     *         @OA\JsonContent(
     *             @OA\Property(property="msg", type="string", example="SuperArea creado correctamente")
     *         )
     *      ),
     *         @OA\Response(
     *         response=400,
     *         description="invalid",
     *         @OA\JsonContent(
     *             @OA\Property(property="resp", type="string", example="ERROR")
     *             )
     *         )
     * )
     * 
     */


    public function create(Request $request)
    {
        
        DB::beginTransaction();
        try {

            // if (!is_int(intval($request['empresa_id'])) || !is_int(intval($request['superarea_id'])) || !is_int(intval($request['bregma_id'])) || !is_int(intval($request['clinica_id']))) {
            //     return response()->json(['error' => 'El id debe ser un número entero.'], 400);
            // }

            // $empresa = Empresa::find($request->empresa_id);
            // $bregma = Bregma::find($request->bregma_id);
            // $clinica = Clinica::find($request->clinica_id);
            // if (!$empresa) return response()->json(['error' => 'El id empresa no existe'], 404);
            // if (!$bregma) return response()->json(['error' => 'El id bregma no existe'], 404);
            // if (!$clinica) return response()->json(['error' => 'El id clinica no existe'], 404);

            if(strlen($request->superarea_id) == 0) return response()->json(['resp' => 'No ingresaste el id de superarea'], 404);
            

            $datos = User::with('persona', 'user_rol.rol')->where('id', auth()->user()->id)->first();

            if (!Superarea::where('estado_registro', 'A')->find($request->superarea_id)) return response()->json(['error' => 'El id Superarea no existe'], 404);

            $superarea = Superarea::where('estado_registro', 'A')->where('clinica_id',$datos->user_rol[0]->rol->clinica_id)->find($request->superarea_id);
            if (!$superarea) return response()->json(['resp' => 'Superarea no tiene acceso'], 404);
            
            Area::Create([
                "nombre" => $request->nombre,
                "empresa_id" => $datos->user_rol[0]->rol->empresa_id,
                "superarea_id" => intval($request->superarea_id),
                "bregma_id" => $datos->user_rol[0]->rol->bregma_id,
                "clinica_id" => $datos->user_rol[0]->rol->clinica_id,
            ]);
            DB::commit();
            return response()->json(["resp" => "Area creada correctamente"]);

        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["Error"=> "".$e],501);
        }
    }

     /**
     * Modificar Datos Area
     * @OA\Put (
     *     path="/api/empresas/areas/update/{idArea}",
     *     tags={"Recursos Humanos-Clinica-Area"},
     *     @OA\Parameter(
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *     @OA\Schema(type="string"),
     *         name="nombre",
     *         in="query",
     *         required= false,
     *         example="Administracion"
     *     ),
     *     @OA\Parameter(
     *     @OA\Schema(type="integer"),
     *         name="superarea_id",
     *         in="query",
     *         required= false,
     *         example="1"
     *     ),
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                   @OA\Property(
     *                      property="nombre",
     *                      type="integer",
     *                  ),
     *                  @OA\Property(
     *                      property="superarea_id",
     *                      type="integer",
     *                  )
     *             ),
     *                 example={
     *                      "nombre":"Administracion",
     *                      "superarea_id" : 1
     *                 }
     *         )
     *      ),
     *         @OA\Response(
     *         response=200,
     *         description="success",
     *         @OA\JsonContent(
     *             @OA\Property(property="msg", type="string", example="SuperArea actualizada correctamente")
     *         )
     *      ),
     *         @OA\Response(
     *         response=400,
     *         description="invalid",
     *         @OA\JsonContent(
     *             @OA\Property(property="resp", type="string", example="ERROR")
     *             )
     *         )
     * )
     * 
     */


    public function update(Request $request, $idarea)
    {
        
        DB::beginTransaction();
        try {

            // if (!is_int(intval($request['empresa_id'])) || !is_int(intval($request['superarea_id'])) || !is_int(intval($request['bregma_id'])) || !is_int(intval($request['clinica_id']))) {
            //     return response()->json(['error' => 'El id debe ser un número entero.'], 400);
            // }
            
            // $empresa = Empresa::find($request->empresa_id);
            // $bregma = Bregma::find($request->bregma_id);
            // $clinica = Clinica::find($request->clinica_id);
            // if (!$empresa) return response()->json(['error' => 'El id empresa no existe'], 404);
            // if (!$bregma) return response()->json(['error' => 'El id bregma no existe'], 404);
            // if (!$clinica) return response()->json(['error' => 'El id clinica no existe'], 404);


            if(strlen($request->superarea_id) == 0) return response()->json(['error' => 'No ingresaste el id de superarea'], 404);
            $superarea = Superarea::find($request->superarea_id);
            if (!$superarea) return response()->json(['resp' => 'El id superarea no existe'], 404);

            $datos = User::with('persona', 'user_rol.rol')->where('id', auth()->user()->id)->first();
            $area = Area::find($idarea);
            $area->fill([
                "nombre" => $request->nombre,
                "empresa_id" => $datos->user_rol[0]->rol->empresa_id,
                "superarea_id" => intval($request->superarea_id),
                "bregma_id" => $datos->user_rol[0]->rol->bregma_id,
                "clinica_id" => $datos->user_rol[0]->rol->clinica_id,
            ])->save();

            
            DB::commit();
            return response()->json(["resp" => "Area editada correctamente"]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["Error"=> "".$e],501);
        }

    }
    

      /**
     * Delete Todo
     * @OA\Delete (
     *     path="/api/empresas/areas/delete/{idArea}",
     *     tags={"Recursos Humanos-Clinica-Area"},
     *     @OA\Parameter(
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="success",
     *         @OA\JsonContent(
     *             @OA\Property(property="msg", type="string", example="SuperArea eliminada correctamente")
     *         )
     *     )
     * )
     */


    public function delete($idarea)
    {

        DB::beginTransaction();
        try {
            $usuario = User::with('user_rol.rol')->where('id', auth()->user()->id)->first();
            $clinica_id = $usuario->user_rol[0]->rol->clinica_id;
            if (!$clinica_id || !Area::where('clinica_id', $clinica_id)->find($idarea)) {
                return response()->json(['resp' => 'Area no tiene acceso'], 403);
            }
            $area = Area::where('estado_registro', 'A')->find($idarea);
            if (!$area) {
                return response()->json(['resp' => 'Area ya inactivado'],500);
            }
            $area->fill([
                "estado_registro" => "I",
            ])->save();
            DB::commit();
            return response()->json(["resp" => "Area inactivado correctamente"]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["Error"=> "".$e],501);
        }
    }


    // public function get()
    // {
    //     // if ($this->admin() == false) {
    //     //     return response()->json(["resp" => "no tiene accesos"]);
    //     // }
    //     // $usuario = User::with('roles')->find(auth()->user()->id);
    //     // $empresa = Empresa::where('ruc',$usuario->username)->first();
    //     // $area = Area::where('empresa_id',$empresa->id)->where('estado_registro', 'A')->get();
    //     // return response()->json(["data" => $area, "size" => count($area)]);
    //     try{
    //         $usuario = User::with('roles')->find(auth()->user()->id);
    //         $empresa = Empresa::where('ruc',$usuario->username)->first();
    //         $area = Area::with('subareas')->where('empresa_id',$empresa->id)->where('estado_registro', 'A')->get();
    //         if (!$area) {
    //             return response()->json(['resp' => 'area no existe'],500);
    //         }
    //         return response()->json(["data" => $area, "size" => count($area)]);
    //     }catch(Exception $e){
    //         return response()->json(["No se encuentran Registros" => $e],500);
    //     }
    // }

    
    // public function create(Request $request)
    // {
    //     // if ($this->admin() == false) {
    //     //     return response()->json(["resp" => "no tiene accesos"]);
    //     // }
    //     // $usuario = User::with('roles')->find(auth()->user()->id);
    //     // $empresa = Empresa::where('ruc',$usuario->username)->first();
    //     // $area = Area::updateOrCreate(
    //     //     [
    //     //         "nombre" => $request->nombre,
    //     //         "superarea_id" => $request->superarea_id,
    //     //         "empresa_id" => $empresa->id
    //     //     ],
    //     //     [
    //     //         "estado_registro" => "A"
    //     //     ]
    //     // );
    //     // return response()->json(["resp" => "area creada"]);
    //     DB::beginTransaction();
    //     try {

    //         $empresa=Empresa::find($request['empresa_id']);
    //         $superarea=Superarea::find($request['superarea_id']);

    //         if (!is_int($request['empresa_id']) || !is_int($request['superarea_id']) ) {
    //             return response()->json(['error' => 'El id debe ser un número entero.'], 400);


    //         }elseif ($request['empresa_id'] == 0) {
    //             $request['empresa_id'] = null;
    //         }elseif ($request['superarea_id'] == 0) {
    //             $request['superarea_id'] = null;
            

    //         }elseif($empresa === null){
    //             return response()->json(["resp" => "Id no existe"],500);
    //         }elseif($superarea === null){
    //             return response()->json(["resp" => "Id no existe"],500);
    //         }

    //         $usuario = User::with('roles')->find(auth()->user()->id);
    //         $empresa = Empresa::where('ruc',$usuario->username)->first();
    //         $area = Area::updateOrCreate(
    //         [
    //             "nombre" => $request->nombre,
    //             "superarea_id" => $request->superarea_id,
    //             "empresa_id" => $empresa->id,
    //             "bregma_id" => $request->bregma_id
    //         ],
    //         [
    //             "estado_registro" => "A"
    //         ]
    //         );
    //         DB::commit();
    //         return response()->json(["resp" => "area creada"]);

    //     } catch (Exception $e) {
    //         DB::rollBack();
    //         return response()->json(["Error"=> "".$e],501);
    //     }
    // }

    
    // public function update(Request $request, $idarea)
    // {
    //     // if ($this->admin() == false) {
    //     //     return response()->json(["resp" => "no tiene accesos"]);
    //     // }
    //     // $area = Area::find($idarea);
    //     // $area->fill([
    //     //     "nombre" => $request->nombre,
    //     // ])->save();
    //     // return response()->json(["resp" => "area editada"]);
    //     DB::beginTransaction();
    //     try {
    //         $area = Area::find($idarea);
    //         $area->fill([
    //             "nombre" => $request->nombre,
    //         ])->save();
    //         DB::commit();
    //         return response()->json(["resp" => "area editada"]);
    //     } catch (Exception $e) {
    //         DB::rollBack();
    //         return response()->json(["Error"=> "".$e],501);
    //     }

    // }

   
    // public function delete($idarea)
    // {
    //     // if ($this->admin() == false) {
    //     //     return response()->json(["resp" => "no tiene accesos"]);
    //     // }
    //     // $area = Area::find($idarea);
    //     // $area->fill([
    //     //     "estado_registro" => "I",
    //     // ])->save();
    //     // return response()->json(["resp" => "area eliminada"]);

    //     DB::beginTransaction();
    //     try {
    //         $area = Area::find($idarea);
    //         if (!$area) {
    //             return response()->json(['resp' => 'Area ya inactivado'],500);
    //         }
    //         $area->fill([
    //             "estado_registro" => "I",
    //         ])->save();
    //         DB::commit();
    //         return response()->json(["resp" => "area eliminada"]);
    //     } catch (Exception $e) {
    //         DB::rollBack();
    //         return response()->json(["Error"=> "".$e],501);
    //     }
    // }
    // public function getSuperarea($idSuperarea)
    // {
    //     try{
    //     // if ($this->admin() == false) {
    //     //     return response()->json(["resp" => "no tiene accesos"]);
    //     // }
    //     $usuario = User::with('roles')->find(auth()->user()->id);
    //     $empresa = Empresa::where('ruc',$usuario->username)->first();
    //     $area = Area::where('empresa_id',$empresa->id)->where('estado_registro', 'A')->where('superarea_id', $idSuperarea)->get();
    //     if (!$area) {
    //         return response()->json(['resp' => 'area no existe'],500);
    //     }
    //     return response()->json(["data" => $area, "size" => count($area)]);
    // }catch(Exception $e){
    //     return response()->json(["No se encuentran Registros" => $e],500);
    // }
    // }

    
}
