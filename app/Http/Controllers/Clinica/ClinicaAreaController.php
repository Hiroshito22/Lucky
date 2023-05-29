<?php

namespace App\Http\Controllers\Clinica;

use App\Http\Controllers\Controller;
use App\Models\Bregma;
use App\Models\Clinica;
use App\Models\ClinicaArea;
use App\Models\ClinicaLocal;
use App\Models\ClinicaPersonal;
use App\Models\Empresa;
use App\Models\Superarea;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClinicaAreaController extends Controller
{
    public function admin()
    {
        $superadmin = User::with('persona', 'user_rol.rol.acceso_rol.acceso', 'roles.accesos')->find(auth()->user()->id);
        $valido = false;
        foreach ($superadmin->roles as $roles) {
            foreach ($roles->accesos as $accesos) {
                if ($accesos['tipo_acceso'] == 3 && $accesos['url'] == "/areas") {
                    return $valido = true;
                }
            }
        }
        return $valido;
    }

    /**
     * Mostrar Datos Clinica Área segùn el id de Clinica Local
     * @OA\Get (
     *     path="/api/clinica/local/{idlocal}/areas/get",
     *     security={{ "bearerAuth": {} }},
     *     tags={"Clínica - Área"},
     *     @OA\Parameter(in="path",name="idlocal",required=true,@OA\Schema(type="integer")),
     *         @OA\Response(response=200, description="success",
     *         @OA\JsonContent(
     *             @OA\Property(type="array", property="data",
     *                 @OA\Items(type="object",
     *                     @OA\Property(property="id",type="integer",example="1"),
     *                     @OA\Property(property="nombre",type="string",example="Area Padre General"),
     *                     @OA\Property(property="estado_registro",type="char",example="A"),
     *                     @OA\Property(property="clinica_id",type="integer",example="1"),
     *                     @OA\Property(property="bregma_id",type="integer",example=""),
     *                     @OA\Property(property="empresa_id",type="integer",example=""),
     *                     @OA\Property(property="clinica_local_id",type="integer",example="1"),
     *                     @OA\Property(property="parent_id",type="integer",example=""),
     *                     @OA\Property(property="depth",type="integer",example=""),
     *                     @OA\Property(property="path",type="integer",example="1"),
     *                     @OA\Property(property="slug",type="integer",example="Area Padre General"),
     *                     @OA\Property(type="array", property="clinica_local",
     *                         @OA\Items(type="object",
     *                             @OA\Property(property="id",type="integer",example="1"),
     *                             @OA\Property(property="clinica_id",type="integer",example="1"),
     *                             @OA\Property(property="departamento_id",type="integer",example="Lima"),
     *                             @OA\Property(property="provincia_id",type="integer",example="Lima"),
     *                             @OA\Property(property="distrito_id",type="integer",example="Lima"),
     *                             @OA\Property(property="nombre",type="string",example="local nuevo"),
     *                             @OA\Property(property="direccion",type="integer",example="Av.Brasil"),
     *                             @OA\Property(property="latitud",type="string",example="12S"),
     *                             @OA\Property(property="longitud",type="string",example="12E"),
     *                             @OA\Property(property="estado_registro",type="string",example="A")
     *                          )
     *                     ),
     *                     @OA\Property(type="array", property="children",
     *                         @OA\Items( type="object",
     *                             @OA\Property(property="id",type="integer",example="2"),
     *                             @OA\Property(property="nombre",type="string",example="fef"),
     *                             @OA\Property(property="estado_registro",type="char",example="A"),
     *                             @OA\Property(property="clinica_id",type="integer",example="1"),
     *                             @OA\Property(property="bregma_id",type="integer",example="1"),
     *                             @OA\Property(property="empresa_id",type="integer",example="1"),
     *                             @OA\Property(property="clinica_local_id",type="integer",example="1"),
     *                             @OA\Property(property="parent_id",type="integer",example="1"),
     *                             @OA\Property(property="depth",type="integer",example="1"),
     *                             @OA\Property(property="path",type="integer",example="1.2"),
     *                             @OA\Property(property="slug",type="integer",example="Area Padre General/Area Padre"),
     *                             @OA\Property(type="array", property="clinica_local",
     *                                 @OA\Items(type="object",
     *                                     @OA\Property(property="id",type="integer",example="1"),
     *                                     @OA\Property(property="clinica_id",type="integer",example="1"),
     *                                     @OA\Property(property="departamento_id",type="integer",example="Lima"),
     *                                     @OA\Property(property="provincia_id",type="integer",example="Lima"),
     *                                     @OA\Property(property="distrito_id",type="integer",example="Lima"),
     *                                     @OA\Property(property="nombre",type="string",example="local nuevo"),
     *                                     @OA\Property(property="direccion",type="integer",example="Av.Brasil"),
     *                                     @OA\Property(property="latitud",type="string",example="12S"),
     *                                     @OA\Property(property="longitud",type="string",example="12E"),
     *                                     @OA\Property(property="estado_registro",type="string",example="A")
     *                                  )
     *                             ),
     *                             @OA\Property(type="array", property="children",
     *                                 @OA\Items(type="object",
     *                                     @OA\Property(property="id",type="integer",example="3"),
     *                                     @OA\Property(property="nombre",type="string",example="fef"),
     *                                     @OA\Property(property="estado_registro",type="char",example="A"),
     *                                     @OA\Property(property="clinica_id",type="integer",example="1"),
     *                                     @OA\Property(property="bregma_id",type="integer",example="1"),
     *                                     @OA\Property(property="empresa_id",type="integer",example="1"),
     *                                     @OA\Property(property="clinica_local_id",type="integer",example="1"),
     *                                     @OA\Property(property="parent_id",type="integer",example="2"),
     *                                     @OA\Property(property="depth",type="integer",example="2"),
     *                                     @OA\Property(property="path",type="integer",example="1.2.3"),
     *                                     @OA\Property(property="slug",type="integer",example="Area Padre General/Area PadreArea Hija"),
     *                                         @OA\Property(type="array", property="clinica_local",
     *                                             @OA\Items(type="object",
     *                                                 @OA\Property(property="id",type="integer",example="1"),
     *                                                 @OA\Property(property="clinica_id",type="integer",example="1"),
     *                                                 @OA\Property(property="departamento_id",type="integer",example="Lima"),
     *                                                 @OA\Property(property="provincia_id",type="integer",example="Lima"),
     *                                                 @OA\Property(property="distrito_id",type="integer",example="Lima"),
     *                                                 @OA\Property(property="nombre",type="string",example="local nuevo"),
     *                                                 @OA\Property(property="direccion",type="integer",example="Av.Brasil"),
     *                                                 @OA\Property(property="latitud",type="string",example="12S"),
     *                                                 @OA\Property(property="longitud",type="string",example="12E"),
     *                                                 @OA\Property(property="estado_registro",type="string",example="A")
     *                                              )
     *                                         )
     *                                   )
     *                             )
     *                       )
     *                    )
     *                 ),
     *                 @OA\Property(type="count", property="size", example="1")
     *              )
     *          )
     *      ),
     *      @OA\Response(response=400, description="invalid",
     *         @OA\JsonContent(
     *             @OA\Property(property="resp", type="string", example="ERROR"),
     *         )
     *      )
     * )
     */
    public function get($idlocal)
    {
        try{
            $usuario = User::with('user_rol.rol')->where('id', auth()->user()->id)->first();
            $clinica_id = $usuario->user_rol[0]->rol->clinica_id;
            $clinica_Local = ClinicaLocal::where('estado_registro', 'A')->where('clinica_id',$clinica_id)->find($idlocal);
            if(!$clinica_Local) return response()->json(['error' => 'El id CLinca Local no existe'],404);
            // return response()->json($clinica_Local);
            $superarea = ClinicaArea::where('estado_registro', 'A')
            ->where('clinica_id', $clinica_id)
            ->where('clinica_local_id', $idlocal)
            ->with('clinica_local')
            ->tree()->get();
            if (!$superarea) return response()->json(['error' => 'ClinicaArea no existe'],500);
            $tree = $superarea->toTree();
            return response()->json(["data" => $tree, "size" => count($tree)]);
        }catch(Exception $e){
            return response()->json(["No se encuentran Registros" => $e],500);
        }

    }

    /**
     * Crear Datos de Clínica Área asignando el id de Clínica local
     * @OA\Post (
     *     path="/api/clinica/areas/create/{idLocal}",
     *     security={{ "bearerAuth": {} }},
     *     tags={"Clínica - Área"},
     *     @OA\Parameter(description="El id de clinica local existente",in="path",name="idLocal",required=true,@OA\Schema(type="integer")),
     *     @OA\Parameter(description="El nombre del area padre o la hija",
     *          @OA\Schema(type="string"),name="nombre",in="query",required= false,example="Administracion"),
     *     @OA\Parameter(description="Se coloca el id de padre o null",
     *          @OA\Schema(type="string"),name="parent_id",in="query",required= false,example="null"),
     *     @OA\RequestBody(
     *         @OA\MediaType(mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(property="nombre",type="string",example="nuevo superarea"),
     *                 @OA\Property(property="parent_id",type="integer",example=null)
     *             ),
     *         )
     *      ),
     *      @OA\Response(response=200, description="success",
     *         @OA\JsonContent(
     *             @OA\Property(property="msg", type="string", example="SuperArea creado correctamente")
     *         )
     *      ),
     *      @OA\Response(response=400, description="invalid",
     *         @OA\JsonContent(
     *             @OA\Property(property="resp", type="string", example="ERROR")
     *         )
     *      )
     * )
     *
     */
    public function create(Request $request, $idLocal)
    {
        DB::beginTransaction();
        try {

            $datos = User::with('persona', 'user_rol.rol')->where('id', auth()->user()->id)->first();

            if (!$idLocal || !ClinicaLocal::where('estado_registro', 'A')->find($idLocal)) {
                return response()->json(['error' => 'El id clinica local no existe'], 404);
            }

            $clinica_Local = ClinicaLocal::where('estado_registro', 'A')->where('clinica_id',$datos->user_rol[0]->rol->clinica_id)->find($idLocal);
            if (!$clinica_Local) {
                return response()->json(['error' => 'clinica local no tiene acceso'], 404);
            }

            $superareaPadre = ClinicaArea::where('id', $request->parent_id)->first();


            if ($request->parent_id == null) {
                ClinicaArea::create([
                    "nombre" => $request->nombre,
                    "clinica_local_id" => $clinica_Local->id,
                    "empresa_id" => $datos->user_rol[0]->rol->empresa_id,
                    "bregma_id" =>$datos->user_rol[0]->rol->bregma_id,
                    "clinica_id" => $datos->user_rol[0]->rol->clinica_id,
                    "parent_id" => $request->parent_id == 0 ? null:null
                ]);
                DB::commit();
                return response()->json(["resp" => "ClinicaArea creada correctamenete"]);
            }else{
                if (!$superareaPadre) {
                    return response()->json(['error' => 'El id del Superarea padre no existe'], 404);
                }
                ClinicaArea::create([
                    "nombre" => $request->nombre,
                    "clinica_local_id" => $clinica_Local->id,
                    "empresa_id" => $datos->user_rol[0]->rol->empresa_id,
                    "bregma_id" =>$datos->user_rol[0]->rol->bregma_id,
                    "clinica_id" => $datos->user_rol[0]->rol->clinica_id,
                    "parent_id" => $request->parent_id
                ]);

                DB::commit();
                return response()->json(["resp" => "ClinicaArea creada correctamenete"]);
            }

        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["Error"=> "".$e],501);
        }
    }

    /**
     * Modificar Datos de Clínica Área teniendo como parametro el id de área a modificar
     * @OA\Put (
     *     path="/api/clinica/areas/update/{idarea}",
     *     security={{ "bearerAuth": {} }},
     *     tags={"Clínica - Área"},
     *     @OA\Parameter(description="El id de area existente",in="path",name="idarea", required=true, @OA\Schema(type="integer")),
     *     @OA\Parameter(description="El nombre del area padre o la hija",
     *          @OA\Schema(type="string"),name="nombre",in="query",required= false,example="Administracion"),
     *     @OA\Parameter(description="Se coloca el id de padre o null",
     *          @OA\Schema(type="integer"),name="parent_id",in="query",required= false,example="null"),
     *     @OA\RequestBody(
     *         @OA\MediaType( mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(property="nombre",type="integer",),
     *                 @OA\Property(property="parent_id",type="null")
     *             ),
     *             example={
     *                   "nombre":"nuevo superarea",
     *                   "parent_id":"null"
     *             }
     *         )
     *      ),
     *      @OA\Response(response=200, description="success",
     *         @OA\JsonContent(
     *             @OA\Property(property="msg", type="string", example="SuperArea actualizada correctamente")
     *         )
     *      ),
     *      @OA\Response(response=400, description="invalid",
     *         @OA\JsonContent(
     *             @OA\Property(property="resp", type="string", example="ERROR")
     *         )
     *      )
     * )
     *
    */
    public function update(Request $request, $idarea)
    {

        DB::beginTransaction();
        try {

            $datos = User::with('persona', 'user_rol.rol')->where('id', auth()->user()->id)->first();
            $superarea = ClinicaArea::where('estado_registro', 'A')->find($idarea);
            if (!$superarea) return response()->json(['error' => 'El id ClinicaArea no existe'], 404);
            $superarea->fill([
                "nombre" => $request->nombre,
                "empresa_id" => $datos->user_rol[0]->rol->empresa_id,
                "bregma_id" =>$datos->user_rol[0]->rol->bregma_id,
                "clinica_id" => $datos->user_rol[0]->rol->clinica_id,
            ])->save();

            DB::commit();
            return response()->json(["resp" => "ClinicaArea editada correctamente"]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["Error"=> "".$e],501);
        }
    }

    /**
     * Eliminar clínica área temiendo como parametro el id del área  a eliminar
     * @OA\Delete (
     *     path="/api/clinica/areas/delete/{idarea}",
     *     security={{ "bearerAuth": {} }},
     *     tags={"Clínica - Área"},
     *     @OA\Parameter(in="path",name="idarea",required=true,@OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="success",
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
            if (!$clinica_id || !ClinicaArea::where('clinica_id', $clinica_id)->find($idarea)) {
                return response()->json(['error' => 'ClinicaArea no tiene acceso'], 403);
            }
            $superarepadre = ClinicaArea::where('estado_registro', 'A')->find($idarea);
            if (!$superarepadre) return response()->json(['error' => 'ClinicaArea ya inactivado'],500);
            $superarepadre->fill([
                "parent_id" => null,
                "estado_registro" => "I",
            ])->save();
            while ($superarepadre->children->count() > 0) {

                foreach ($superarepadre->children as $superarehija) {
                    $superarepadre = $superarehija;
                    $superarehija->fill([
                        "parent_id" => null,
                        "estado_registro" => "I",
                    ])->save();
                }

            }

            // $superarepadre = ClinicaArea::find($idSuperarea);


            // while($superarepadre->children->count() > 0){
            //     $clinica_padre = $superarepadre;
            //     while ($superarepadre->children->count() > 0) {

            //         foreach ($superarepadre->children as $superarehija) {
            //             $superarepadre = $superarehija;
            //         }
            //     }
            //     //  return response()->json($superarepadre);
            //     $superarepadre->fill([
            //         "parent_id" => null,
            //         "estado_registro" => "I",
            //     ])->save();
            //     $superarepadre = $clinica_padre;
            // }
            // $superarepadre->fill([
            //     "parent_id" => null,
            //     "estado_registro" => "I",
            // ])->save();

            DB::commit();
            return response()->json(["resp" => "ClinicaArea inactivado correctamente"]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["Error"=> "".$e],501);
        }

    }



    /**
     * Eliminar una clínica área temiendo como parametro el id del área a eliminar
     * @OA\Delete (
     *      path="/api/clinica/areas/destroy/{idarea}",
     *      summary="Elimina por completo una area de clinica teniendo como parametro el id de la area clinica con sesión iniciada",
     *      security={{ "bearerAuth": {} }},
     *      tags={"Clínica - Área"},
     *     @OA\Parameter(in="path",name="idarea",required=true,@OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="success",
     *         @OA\JsonContent(
     *             @OA\Property(property="msg", type="string", example="SuperArea eliminada correctamente")
     *         )
     *     )
     * )
     */
    public function destroy($id){
        try {
            $user = User::with('user_rol.rol')->where('id', auth()->user()->id)->first();
            $clinica_id = $user->user_rol[0]->rol->clinica_id;
            if (!$clinica_id) return response()->json(["error" => "No inicio sesión como clinica"]);
            $clinica_area = ClinicaArea::find($id);
            if (!$clinica_area) return response()->json(["error" => "No existe el area de clinica"]);
            $clinica_area->fill([
                "bregma_id" => null,
                "bregma_local_id" => null,
                "clinica_id" => null,
                "empresa_id" => null,
                "clinica_local_id" => null,
            ]);
            ClinicaPersonal::where('clinica_area_id',$id)->update(["clinica_area_id" => null]);
            $clinica_area->save();
            $clinica_area->delete();
            return response()->json(["Area Clinica eliminada exitosamente"]);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(["error" => "error " . $e]);
        }

    }

//     public function get()
//     {
//         // if ($this->admin() == false) {
//         //     return response()->json(["resp" => "no tiene accesos"]);
//         // }
//         // $usuario = User::with('roles')->find(auth()->user()->id);
//         // $empresa = Empresa::where('ruc',$usuario->username)->first();
//         // $superarea = SuperArea::with('areas.subareas')->where('empresa_id',$empresa->id)->where('estado_registro', 'A')->get();
//         // return response()->json(["data" => $superarea, "size" => count($superarea)]);
//         try{
//             $usuario = User::with('roles')->find(auth()->user()->id);
//             $empresa = Empresa::where('ruc',$usuario->username)->first();
//             $superarea = Superarea::with('areas.subareas','bregma','empresa')->where('empresa_id',$empresa->id)->where('estado_registro', 'A')->get();
//             if (!$superarea) {
//                 return response()->json(['resp' => 'SuperArea no existe'],500);
//             }
//             return response()->json(["data" => $superarea, "size" => count($superarea)]);
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
//         // $superarea = Superarea::updateOrCreate(
//         //     [
//         //         "nombre" => $request->nombre,
//         //         "empresa_id" => $empresa->id,
//         //     ],
//         //     [
//         //         "estado_registro" => "A"
//         //     ]
//         // );
//         // return response()->json(["resp" => "superarea creada"]);


//         DB::beginTransaction();
//         try {

//             $empresa=Empresa::find($request['empresa_id']);


//             if (!is_int($request['empresa_id']) ) {
//                 return response()->json(['error' => 'El id debe ser un número entero.'], 400);


//             }elseif ($request['empresa_id'] == 0) {
//                 $request['empresa_id'] = null;


//             }elseif($empresa === null){
//                 return response()->json(["resp" => "Id no existe"],500);
//             }

//             $usuario = User::with('roles')->find(auth()->user()->id);
//             $empresa = Empresa::where('ruc',$usuario->username)->first();
//             $superarea = Superarea::updateOrCreate(
//                 [
//                     "nombre" => $request->nombre,
//                     "bregma_id" => $request->bregma_id,
//                     "clinica_id" => $request->clinica_id,
//                     "empresa_id" => $empresa->id,
//                 ],
//                 [
//                     "estado_registro" => "A"
//                 ]
//             );
//             DB::commit();
//             return response()->json(["resp" => "superarea creada"]);

//         } catch (Exception $e) {
//             DB::rollBack();
//             return response()->json(["Error"=> "".$e],501);
//         }


//     }



//     public function update(Request $request, $idSuperarea)
//     {
//         // if ($this->admin() == false) {
//         //     return response()->json(["resp" => "no tiene accesos"]);
//         // }
//         // $superarea = Superarea::find($idSuperarea);
//         // $superarea->fill([
//         //     "nombre" => $request->nombre,
//         // ])->save();
//         // return response()->json(["resp" => "superarea editada"]);
//         // $superarea = Superarea::find($idSuperarea);


//         DB::beginTransaction();
//         try {
//             $superarea = Superarea::find($idSuperarea);
//             $superarea->fill([
//                 "nombre" => $request->nombre,
//             ])->save();
//             DB::commit();
//             return response()->json(["resp" => "superarea editada"]);
//         } catch (Exception $e) {
//             DB::rollBack();
//             return response()->json(["Error"=> "".$e],501);
//         }

//     }



//     public function delete($idSuperarea)
//     {
//         // if ($this->admin() == false) {
//         //     return response()->json(["resp" => "no tiene accesos"]);
//         // }
//         // $superarea = Superarea::find($idSuperarea);
//         // $superarea->fill([
//         //     "estado_registro" => "I",
//         // ])->save();
//         // return response()->json(["resp" => "superarea eliminada"]);
//         // $superarea = Superarea::find($idSuperarea);


//         DB::beginTransaction();
//         try {
//             $superarea = Superarea::find($idSuperarea);
//             if (!$superarea) {
//                 return response()->json(['resp' => 'superarea ya inactivado'],500);
//             }
//             $superarea->fill([
//                 "estado_registro" => "I",
//             ])->save();
//             DB::commit();
//             return response()->json(["resp" => "superarea eliminada correctamente"]);
//         } catch (Exception $e) {
//             DB::rollBack();
//             return response()->json(["Error"=> "".$e],501);
//         }
//     }
}
