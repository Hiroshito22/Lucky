<?php

namespace App\Http\Controllers\Empresa;

use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\Bregma;
use App\Models\Clinica;
use App\Models\Empresa;
use App\Models\Subarea;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SubAreaController extends Controller
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
     * Mostrar Datos SubArea
     * @OA\Get (
     *     path="/api/empresas/subareas/get",
     *     tags={"Recursos Humanos-Clinica-SubArea"},
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
     *                         @OA\Property(property="nombre", type="string",example="fef"),
     *                         @OA\Property(property="estado_registro",type="char",example="A"),
     *                         @OA\Property(property="empresa_id",type="integer",example=""),
     *                         @OA\Property(property="area_id",type="integer",example="1"),
     *                         @OA\Property(property="bregma_id",type="integer",example=""),
     *                         @OA\Property(property="clinica_id",type="integer",example="1"),
     *                         @OA\Property(
     *                              type="array",
     *                              property="area",
     *                              @OA\Items(
     *                                  type="object",
     *                                  @OA\Property(property="id",type="integer",example="1"),
     *                                  @OA\Property(property="nombre",type="string",example="fef"),
     *                                  @OA\Property(property="estado_registro",type="char",example="A"),
     *                                  @OA\Property(property="empresa_id",type="integer",example=""),
     *                                  @OA\Property(property="superarea_id",type="integer",example="1"),
     *                                  @OA\Property(property="bregma_id",type="integer",example=""),
     *                                  @OA\Property(property="clinica_id",type="integer",example="1"),
     *                                  @OA\Property(
     *                                      type="array",
     *                                      property="superarea",
     *                                      @OA\Items(
     *                                          type="object",
     *                                          @OA\Property(property="id",type="integer",example="1"),
     *                                          @OA\Property(property="nombre",type="string",example="fef"),
     *                                          @OA\Property(property="estado_registro",type="char",example="A"),
     *                                          @OA\Property(property="clinica_id",type="integer",example="1"),
     *                                          @OA\Property(property="bregma_id",type="integer",example="1"),
     *                                          @OA\Property(property="empresa_id",type="integer",example="1"),
     *                                          @OA\Property(property="empresa",type="integer",example=""),
     *                                          @OA\Property(property="bregma",type="integer",example=""),
     *                                          @OA\Property(
     *                                              type="array",
     *                                              property="clinica",
     *                                              @OA\Items(
     *                                                 type="object",
     *                                                 @OA\Property(property="id",type="integer",example="1"),
     *                                                 @OA\Property(property="bregma_id",type="integer",example=""),
     *                                                 @OA\Property(property="tipo_documento_id",type="integer",example="1"),
     *                                                 @OA\Property(property="distrito_id",type="integer",example=""),
     *                                                 @OA\Property(property="ruc",type="integer",example=""),
     *                                                 @OA\Property(property="razon_social",type="string",example=""),
     *                                                 @OA\Property(property="numero_documento",type="integer",example="11111111"),
     *                                                 @OA\Property(property="responsable",type="string",example=""),
     *                                                 @OA\Property(property="nombre_comercial",type="string",example=""),
     *                                                 @OA\Property(property="latitud",type="string",example=""),
     *                                                 @OA\Property(property="longitud",type="string",example=""),
     *                                                 @OA\Property(property="logo",type="string",example=""),
     *                                                 @OA\Property(property="estado_registro",type="char",example="A"),
     *                                                 @OA\Property(property="hospital_id",type="integer",example="")
     *                                           )
     *                                      )
     *                                  )
     *                              )
     *                          )
     *                     )
     *                 )
     *             )
     *          ),
     *             @OA\Property(
     *                type="count",
     *                property="size",
     *                example="1"
     *             )
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
            $subarea = Subarea::with('area.superarea.empresa','area.superarea.bregma','area.superarea.clinica')->where('estado_registro', 'A')->where('clinica_id', $clinica_id)->get();
            if (!$subarea) {
                return response()->json(['error' => 'Subarea no existe'],500);
            }
            return response()->json(["data" => $subarea, "size" => count($subarea)]);
        }catch(Exception $e){
            return response()->json(["No se encuentran Registros" => $e],500);
        }
    }

     /**
     * Crear Datos SubArea
     * @OA\Post (
     *     path="/api/empresas/subareas/create",
     *     tags={"Recursos Humanos-Clinica-SubArea"},
     *     @OA\Parameter(
     *     @OA\Schema(type="string"),
     *         name="nombre",
     *         in="query",
     *         required= false,
     *         example="Administracion"
     *     ),
     *     @OA\Parameter(
     *     @OA\Schema(type="integer"),
     *         name="area_id",
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
     *                      property="area_id",
     *                      type="integer",
     *                  )
     *             ),
     *                 example={
     *                      "nombre":"Administracion",
     *                      "area_id" : 1
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

            
            // if (!is_int(intval($request['empresa_id'])) || !is_int(intval($request['area_id'])) || !is_int(intval($request['bregma_id'])) || !is_int(intval($request['clinica_id']))) {
            //     return response()->json(['error' => 'El id debe ser un número entero.'], 400);
            // }
            
            // $empresa = Empresa::find($request->empresa_id);
            // $bregma = Bregma::find($request->bregma_id);
            // $clinica = Clinica::find($request->clinica_id);
            // if (!$empresa) return response()->json(['error' => 'El id empresa no existe'], 404);
            // if (!$bregma) return response()->json(['error' => 'El id bregma no existe'], 404);
            // if (!$clinica) return response()->json(['error' => 'El id clinica no existe'], 404);

            if(strlen($request->area_id) == 0) return response()->json(['resp' => 'No ingresaste el id de area'], 404);
            
            $datos = User::with('persona', 'user_rol.rol')->where('id', auth()->user()->id)->first();

            if (!Area::where('estado_registro', 'A')->find($request->area_id)) return response()->json(['error' => 'El id Area no existe'], 404);

            $area = Area::where('estado_registro', 'A')->where('clinica_id',$datos->user_rol[0]->rol->clinica_id)->find($request->area_id);
            if (!$area) return response()->json(['resp' => 'Area no tiene acceso'], 404);

            Subarea::Create([
                "nombre" => $request->nombre,
                "empresa_id" => $datos->user_rol[0]->rol->empresa_id,
                "area_id" => intval($request->area_id),
                "bregma_id" => $datos->user_rol[0]->rol->bregma_id,
                "clinica_id" => $datos->user_rol[0]->rol->clinica_id,
            ]);
            
            DB::commit();
            return response()->json(["resp" => "Subarea creada correctamente"]);

        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["Error"=> "".$e],501);
        }
    }

      /**
     * Modificar Datos SubArea
     * @OA\Put (
     *     path="/api/empresas/subareas/update/{idSubarea}",
     *     tags={"Recursos Humanos-Clinica-SubArea"},
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
     *         name="area_id",
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
     *                      property="area_id",
     *                      type="integer",
     *                  )
     *             ),
     *                 example={
     *                      "nombre":"Administracion",
     *                      "area_id" : 1
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


        
    public function update(Request $request, $idSubarea)
    {
        
        DB::beginTransaction();
        try {

            
            // if (!is_int(intval($request['empresa_id'])) || !is_int(intval($request['area_id'])) || !is_int(intval($request['bregma_id'])) || !is_int(intval($request['clinica_id']))) {
            //     return response()->json(['error' => 'El id debe ser un número entero.'], 400);
            // }
            

            // $empresa = Empresa::find($request->empresa_id);
            
            // $bregma = Bregma::find($request->bregma_id);
            // $clinica = Clinica::find($request->clinica_id);

            // if (!$empresa) return response()->json(['error' => 'El id empresa no existe'], 404);
            
            // if (!$bregma) return response()->json(['error' => 'El id bregma no existe'], 404);
            // if (!$clinica) return response()->json(['error' => 'El id clinica no existe'], 404);
            if(strlen($request->area_id) == 0) return response()->json(['resp' => 'No ingresaste el id de area'], 404);
            $area = Area::find($request->area_id);
            if (!$area) return response()->json(['resp' => 'El id area no existe'], 404);

            $datos = User::with('persona', 'user_rol.rol')->where('id', auth()->user()->id)->first();
            $subarea = Subarea::find($idSubarea);
            $subarea->fill([
                "nombre" => $request->nombre,
                "empresa_id" => $datos->user_rol[0]->rol->empresa_id,
                "area_id" => intval($request->area_id),
                "bregma_id" => $datos->user_rol[0]->rol->bregma_id,
                "clinica_id" => $datos->user_rol[0]->rol->clinica_id,
            ])->save();
            DB::commit();
            return response()->json(["resp" => "Subarea editada correctamente"]);

        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["Error"=> "".$e],501);
        }
    }


     /**
     * Delete Todo
     * @OA\Delete (
     *     path="/api/empresas/subareas/delete/{idSubarea}",
     *     tags={"Recursos Humanos-Clinica-SubArea"},
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

        
    public function delete($idSubarea)
    {
        
        DB::beginTransaction();
        try {
            $usuario = User::with('user_rol.rol')->where('id', auth()->user()->id)->first();
            $clinica_id = $usuario->user_rol[0]->rol->clinica_id;
            if (!$clinica_id || !Subarea::where('clinica_id', $clinica_id)->find($idSubarea)) {
                return response()->json(['resp' => 'Subarea no tiene acceso'], 403);
            }
            $subarea = Subarea::where('estado_registro', 'A')->find($idSubarea);
            if (!$subarea) return response()->json(['resp' => 'Subarea ya inactivado'],500);

            $subarea->fill([
                "estado_registro" => "I",
            ])->save();
            DB::commit();
            return response()->json(["resp" => "Subarea inactivado correctamente"]);

        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["Error"=> "".$e],501);
        }
    }

//     public function get()
//     {
//         // if ($this->admin() == false) {
//         //     return response()->json(["resp" => "no tiene accesos"]);
//         // }
//         // $usuario = User::with('roles')->find(auth()->user()->id);
//         // $empresa = Empresa::where('ruc',$usuario->username)->first();
//         // $subarea = Subarea::where('empresa_id',$empresa->id)->where('estado_registro', 'A')->get();
//         // return response()->json(["data" => $subarea, "size" => count($subarea)]);
//         try{
//             $usuario = User::with('roles')->find(auth()->user()->id);
//             $empresa = Empresa::where('ruc',$usuario->username)->first();
//             $subarea = Subarea::where('empresa_id',$empresa->id)->where('estado_registro', 'A')->get();
//             if (!$subarea) {
//                 return response()->json(['resp' => 'Subarea no existe'],500);
//             }
//             return response()->json(["data" => $subarea, "size" => count($subarea)]);
//         }catch(Exception $e){
//             return response()->json(["No se encuentran Registros" => $e],500);
//         }
//     }

    
//     public function create(Request $request)
//     {
//         // if ($this->admin() == false) {
//         //     return response()->json(["resp" => "no tiene accesos"]);
//         // }
//         // $usuario = User::with('roles')->find(auth()->user()->id);
//         // $empresa = Empresa::where('ruc',$usuario->username)->first();
//         // $subarea = Subarea::updateOrCreate(
//         //     [
//         //         "nombre" => $request->nombre,
//         //         "area_id" => $request->area_id,
//         //         "empresa_id" => $empresa->id
//         //     ],
//         //     [
//         //         "estado_registro" => "A"
//         //     ]
//         // );
//         // return response()->json(["resp" => "subarea creada"]);
//         DB::beginTransaction();
//         try {

//             $empresa=Empresa::find($request['empresa_id']);
//             $area=Area::find($request['area_id']);

//             if (!is_int($request['empresa_id']) || !is_int($request['area_id']) ) {
//                 return response()->json(['error' => 'El id debe ser un número entero.'], 400);


//             }elseif ($request['empresa_id'] == 0) {
//                 $request['empresa_id'] = null;
//             }elseif ($request['area_id'] == 0) {
//                 $request['area_id'] = null;
            

//             }elseif($empresa === null){
//                 return response()->json(["resp" => "Id no existe"],500);
//             }elseif($area === null){
//                 return response()->json(["resp" => "Id no existe"],500);
//             }
//             $usuario = User::with('roles')->find(auth()->user()->id);
//             $empresa = Empresa::where('ruc',$usuario->username)->first();
//             $subarea = Subarea::updateOrCreate(
//             [
//                 "nombre" => $request->nombre,
//                 "area_id" => $request->area_id,
//                 "clinica_id" => $request->clinica_id,
//                 "bregma_id" => $request->bregma_id,
//                 "empresa_id" => $empresa->id
//             ],
//             [
//                 "estado_registro" => "A"
//             ]
//         );
//             DB::commit();
//             return response()->json(["resp" => "Subarea creada"]);

//         } catch (Exception $e) {
//             DB::rollBack();
//             return response()->json(["Error"=> "".$e],501);
//         }
//     }

   
//     public function update(Request $request, $idSubarea)
//     {
//         // if ($this->admin() == false) {
//         //     return response()->json(["resp" => "no tiene accesos"]);
//         // }
//         // $subarea = Subarea::find($idSubarea);
//         // $subarea->fill([
//         //     "nombre" => $request->nombre,
//         // ])->save();
//         // return response()->json(["resp" => "subarea editada"]);
//         DB::beginTransaction();
//         try {
//             $subarea = Subarea::find($idSubarea);
//             $subarea->fill([
//                 "nombre" => $request->nombre,
//             ])->save();
//             DB::commit();
//             return response()->json(["resp" => "Subarea editada"]);

//         } catch (Exception $e) {
//             DB::rollBack();
//             return response()->json(["Error"=> "".$e],501);
//         }
//     }

    
//     public function delete($idSubarea)
//     {
//         // if ($this->admin() == false) {
//         //     return response()->json(["resp" => "no tiene accesos"]);
//         // }
//         // $subarea = Subarea::find($idSubarea);
//         // $subarea->fill([
//         //     "estado_registro" => "I",
//         // ])->save();
//         // return response()->json(["resp" => "subarea eliminada"]);
//         DB::beginTransaction();
//         try {
//             $subarea = Subarea::find($idSubarea);
//             if (!$subarea) {
//                 return response()->json(['resp' => 'Subarea ya inactivado'],500);
//             }
//             $subarea->fill([
//                 "estado_registro" => "I",
//             ])->save();
//             DB::commit();
//             return response()->json(["resp" => "Subarea eliminada"]);

//         } catch (Exception $e) {
//             DB::rollBack();
//             return response()->json(["Error"=> "".$e],501);
//         }
//     }
//     public function getArea($idArea)
//     {
//         // if ($this->admin() == false) {
//         //     return response()->json(["resp" => "no tiene accesos"]);
//         // }
//         // $usuario = User::with('roles')->find(auth()->user()->id);
//         // $empresa = Empresa::where('ruc',$usuario->username)->first();
//         // $subarea = Subarea::where('empresa_id',$empresa->id)->where('estado_registro', 'A')->where('area_id', $idArea)->get();
//         // return response()->json(["data" => $subarea, "size" => count($subarea)]);
//         try{
//             $usuario = User::with('roles')->first();
//             $empresa = Empresa::where('ruc',$usuario->username)->first();
//             $subarea = Subarea::where('empresa_id',$empresa->id)->where('estado_registro', 'A')->where('area_id', $idArea)->get();
//             if (!$subarea) {
//                 return response()->json(['resp' => 'subarea no existe'],500);
//             }
//             return response()->json(["data" => $subarea, "size" => count($subarea)]);
//         }catch(Exception $e){
//             return response()->json(["No se encuentran Registros" => $e],500);
//         }
        
//     }
   
}