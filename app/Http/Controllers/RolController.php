<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Models\Rol;
use App\Models\Hospital;
use App\Models\Acceso;
use App\Models\AccesoRol;
use App\Models\UserRol;
use Exception;
use Illuminate\Support\Facades\DB;

class RolController extends Controller
{
    public function validar_acceso($tipo_acceso,$url){
        $admin_hospital = User::with('persona','user_rol.rol.acceso_rol.acceso','roles.accesos')->find(auth()->user()->id);
        $valido = false;
        foreach($admin_hospital->roles as $roles){
            foreach($roles->accesos as $accesos){
                if($accesos['tipo_acceso']==$tipo_acceso && $accesos["url"]==$url){
                    return $valido=true;
                }
            }
        }
        return $valido;
    }
    /**
     * Get
     * @OA\Get (
     *     path="/api/roles/get",
     *     tags={"Rol"},
     *     @OA\Response(
     *         response=200,
     *         description="success",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 type="array",
     *                 property="data",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(
     *                        property="id",
     *                        type="number",
     *                        example=1
     *                     ),
     *                     @OA\Property(
     *                         property="empresa_id",
     *                         type="foreignId",
     *                         example=null
     *                     ),
     *                     @OA\Property(
     *                         property="clinica_id",
     *                         type="foreignId",
     *                         example=null
     *                     ),
     *                     @OA\Property(
     *                         property="nombre",
     *                         type="string",
     *                         example="example nombre"
     *                     ),
     *                     @OA\Property(
     *                         property="tipo_acceso",
     *                         type="number",
     *                         example=2
     *                     ),
     *                     @OA\Property(
     *                        property="estado_registro",
     *                        type="char",
     *                        example="A"
     *                     ),@OA\Property(
     *                                 type="array",
     *                                 property="acceso_rol",
     *                                 @OA\Items(
     *                                     type="object",
     *                                     @OA\Property(
     *                                         property="id",
     *                                         type="number",
     *                                         example="1"
     *                                     ),
     *                                     @OA\Property(
     *                                         property="acceso_id",
     *                                         type="number",
     *                                         example="1"
     *                                     ),
     *                                     @OA\Property(
     *                                         property="rol_id",
     *                                         type="foreignId",
     *                                         example="1"
     *                                     ),
     *                                     @OA\Property(
     *                                         property="nombre",
     *                                         type="string",
     *                                         example="example nombre"
     *                                     ),
     *                                     @OA\Property(
     *                                         property="estado_registro",
     *                                         type="char",
     *                                         example="A"
     *                                     )
     *                                 )
     *                            )
     *                 )
     *             ),
     *               @OA\Property(
     *               property="size",
     *               type="count",
     *               example="1"
     *             )
     *         )
     *     ),
     *          @OA\Response(
     *          response=400,
     *          description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="ERROR"),
     *              )
     *          )
     * )
     */
    public function get(){
        try{
            $user_rol = UserRol::with('rol')->where('user_id',auth()->user()->id)->first();
            $bregma_id = $user_rol->rol->bregma_id;
            $clinica_id = $user_rol->rol->clinica_id;
            $empresa_id = $user_rol->rol->empresa_id;
            $roles = Rol::with(['accesos'])
            ->where('bregma_id',$bregma_id)
            ->where('clinica_id',$clinica_id)
            ->where('empresa_id',$empresa_id)->where('estado_registro','!=','I')->get();
            return response()->json(["data" => $roles, "size" => count($roles)]);
        }catch(Exception $e){
            return response()->json(["No se encuentran Registros" => $e],500);
        }
    }
    /**
     * Create
     * @OA\Post (
     *     path="/api/roles/create",
     *     tags={"Rol"},
     *      @OA\Parameter(
     *          description="El nombre del Rol",
     *          @OA\Schema(type="string"),
     *          name="nombre",
     *          in="query",
     *          required= false,
     *          example="example nombre"
     *      ),
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                      type="object",
     *                     @OA\Property(
     *                         property="nombre",
     *                         type="string",
     *                         example="example nombre"
     *                     )
     *                 ),
     *                 example={
     *                     "nombre": "example nombre",
     *                }
     *             )
     *         )
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="success",
     *         @OA\JsonContent(
     *             @OA\Property(property="msg", type="string", example="Registro creado correctamente")
     *         )
     *     ),
     *          @OA\Response(
     *          response=400,
     *          description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="ERROR"),
     *              )
     *          )
     * )
     */
    public function create(Request $request)
    {
        DB::beginTransaction();
        try {
            $verificar = User::with('user_rol.rol')->where('id', auth()->user()->id)->first();
            if (!$verificar)return response()->json(["resp" => "No tiene acceso"]);
            Rol::firstOrCreate([
                "empresa_id" => $verificar->user_rol[0]->rol->empresa_id,
                "bregma_id" =>$verificar->user_rol[0]->rol->bregma_id,
                "clinica_id" => $verificar->user_rol[0]->rol->clinica_id,
                'nombre' => $request->nombre,
                'tipo_acceso' => $verificar->user_rol[0]->rol->tipo_acceso,
            ]);
            DB::commit();
            return response()->json(["resp" => "Dato creado correctamente"]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["error" => $e]);
        }
    }

    /**
     * Update
     * @OA\Put (
     *     path="/api/roles/update/{id}",
     *     tags={"Rol"},
     *     @OA\Parameter(
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *      @OA\Parameter(
     *          description="El nombre del Rol",
     *          @OA\Schema(type="string"),
     *          name="nombre",
     *          in="query",
     *          required= false,
     *          example="example nombre"
     *      ),
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                      type="object",
     *                     @OA\Property(
     *                         property="nombre",
     *                         type="string",
     *                         example="example nombre"
     *                     )
     *                 ),
     *                 example={
     *                     "nombre": "example nombre",
     *                }
     *             )
     *         )
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="success",
     *         @OA\JsonContent(
     *             @OA\Property(property="msg", type="string", example="Registro creado correctamente")
     *         )
     *     ),
     *          @OA\Response(
     *          response=400,
     *          description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="ERROR"),
     *              )
     *          )
     * )
     */
    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $registro = Rol::whereIn('estado_registro', ['A','SU'])->findOrFail($id);

            $registro->fill([
                'nombre' => $request->nombre,
            ])->save();
            DB::commit();
            return response()->json(["resp" => "Datos actualizados correctamente"]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["resp" => "No se encontro el rol", "error"=>"".$e]);
        }
    }

    /**
     * Delete
     * @OA\Delete (
     *     path="/api/roles/delete/{id}",
     *     tags={"Rol"},
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
     *             @OA\Property(property="msg", type="string", example="delete todo success")
     *         )
     *     ),
     *          @OA\Response(
     *          response=400,
     *          description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="ERROR"),
     *              )
     *          )
     * )
     */
    public function delete($id)
    {
        DB::beginTransaction();
        try {
            $datos = Rol::where('estado_registro', 'A')->find($id);
            if(!$datos){
                return response()->json(["resp"=>"Usuario ya Inactivado"]);
            }
            $datos->fill([
                'estado_registro' => 'I',
            ])->save();
            DB::commit();
            return response()->json(["resp" => "Dato inactivo correctamente"]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["error" => $e]);
        }
    }
    /**
     * Asignar
     * @OA\Post(
     *     path="/api/roles/asignar",
     *     tags={"Rol"},
     *     @OA\Parameter(
     *         description="La ID del ROL",
     *         @OA\Schema(type="integer"),
     *         name="rol_id",
     *         in="query",
     *         required=true,
     *         example="1"
     *     ),
     *     @OA\Parameter(
     *         description="La ID del Accesos",
     *         @OA\Schema(type="integer"),
     *         name="acceso_id",
     *         in="query",
     *         required=false,
     *         example="1"
     *     ),
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     type="object",
     *                     @OA\Property(
     *                         property="rol_id",
     *                         type="integer",
     *                         example="1"
     *                     ),
     *                     @OA\Property(
     *                         type="array",
     *                         property="accesos",
     *                         @OA\Items(
     *                             type="object",
     *                             @OA\Property(
     *                                 property="id",
     *                                 type="integer",
     *                                 example="1"
     *                             )
     *                         )
     *                     )
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="success",
     *         @OA\JsonContent(
     *             @OA\Property(property="msg", type="string", example="Accesos asignados correctamente")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="invalid",
     *         @OA\JsonContent(
     *             @OA\Property(property="resp", type="string", example="ERROR")
     *         )
     *     )
     * )
     */
    public function asignarAcceso(Request $request){
        DB::beginTransaction();
        try {
            $rol = Rol::where('estado_registro', 'A')->find($request['rol_id']);
            // return response()->json($rol);
            if(!$rol) return response()->json(["Error:"=>"El rol ingresado no existe"]);
            // $accesos = Acceso::where('tipo_acceso',2)->where('parent_id',null)->get();
            // $buscar = Acceso::where('estado_registro', 'A');

            $accesos = $request->accesos;
            foreach ($accesos as $acceso ) {
                $buscar=Acceso::where("id",$acceso['id'])->first();
                // return response()->json($buscar);
                if (!$buscar)return response()->json(["resp"=>"Acceso no existe"]);

                if($buscar->tipo_acceso==1 && $rol->tipo_acceso==1){
                    AccesoRol::create([
                        "acceso_id"=>$acceso['id'],
                        "rol_id"=>$rol->id
                    ]);
                }else if($buscar->tipo_acceso==2 && $rol->tipo_acceso==2){
                    AccesoRol::create([
                        "acceso_id"=>$acceso['id'],
                        "rol_id"=>$rol->id
                    ]);
                }else if($buscar->tipo_acceso==3 && $rol->tipo_acceso==3){
                    AccesoRol::create([
                        "acceso_id"=>$acceso['id'],
                        "rol_id"=>$rol->id
                    ]);
                }else return response()->json(["resp" => "Acceso no compatible"]);
            }
            DB::commit();
            return response()->json(["resp" => "Accesos asignados correctamente"]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["error" => "".$e]);
        }
    }
        // if($this->validar_acceso(2,"/rolHospital")==false){
        //     return response()->json(["resp"=>"no tiene accesos"]);
        // }
        // $admin_hospital = User::with('persona','user_rol.rol.acceso_rol.acceso','roles.accesos')->find(auth()->user()->id);
        // $hospital = Hospital::where("numero_documento",$admin_hospital->persona->numero_documento)->first();
        // $rol = Rol::find($request->rol_id);
        // $accesos = $request->accesos;
        // if($hospital){
        //     //return response()->json($rol);
        //     if($rol->hospital_id){
        //         $accesos_roles=AccesoRol::where("rol_id",$rol->id)->get();
        //         foreach($accesos_roles as $acceso_rol){
        //             $acc_rol=AccesoRol::find($acceso_rol['id']);
        //             $acc_rol->estado_registro="I";
        //             $acc_rol->save();
        //         }
        //         foreach($accesos as $acceso){

    /**
     * Editar
     * @OA\Put(
     *     path="/api/roles/editar",
     *     tags={"Rol"},
     *     @OA\Parameter(
     *         description="La ID del ROL",
     *         @OA\Schema(type="integer"),
     *         name="rol_id",
     *         in="query",
     *         required=true,
     *         example="1"
     *     ),
     *     @OA\Parameter(
     *         description="La ID del Accesos",
     *         @OA\Schema(type="integer"),
     *         name="acceso_id",
     *         in="query",
     *         required=false,
     *         example="1"
     *     ),
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     type="object",
     *                     @OA\Property(
     *                         property="rol_id",
     *                         type="integer",
     *                         example="1"
     *                     ),
     *                     @OA\Property(
     *                         type="array",
     *                         property="accesos",
     *                         @OA\Items(
     *                             type="object",
     *                             @OA\Property(
     *                                 property="id",
     *                                 type="integer",
     *                                 example="1"
     *                             )
     *                         )
     *                     )
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="success",
     *         @OA\JsonContent(
     *             @OA\Property(property="msg", type="string", example="Accesos asignados correctamente")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="invalid",
     *         @OA\JsonContent(
     *             @OA\Property(property="resp", type="string", example="ERROR")
     *         )
     *     )
     * )
     */
    public function editarAcceso(Request $request){
        DB::beginTransaction();
        try {
            $rol = Rol::with('acceso_rol')->where('estado_registro', 'A')->find($request['rol_id']);

            // return response()->json($request);
            if(!$rol) return response()->json(["Error:"=>"El rol ingresado existe..."]);
            // return response()->json($rol->acceso_rol);
            if($rol->acceso_rol==null) return response()->json(["Error:"=>"El rol ingresado no tiene accesos para editar..."]);
            // $acceso_rol = AccesoRol::find($rol->acceso_rol->rol_id);
            // return response()->json($acceso_rol);
            // $acceso_rol->delete();
            DB::table('acceso_rol')->where('rol_id',$rol->acceso_rol->rol_id)->update(['estado_registro' => 'I']);

            $accesos = $request->accesos;
            foreach ($accesos as $acceso ) {
                $buscar=Acceso::where("id",$acceso['id'])->first();
                if (!$buscar)return response()->json(["resp"=>"Acceso no existe"]);

                if($buscar->tipo_acceso==1 && $rol->tipo_acceso==1){

                    AccesoRol::updateOrCreate([
                        "acceso_id"=>$acceso['id'],
                        "rol_id"=>$rol->id
                    ],[
                        "estado_registro"=>'A'
                    ])->save();
                }else if($buscar->tipo_acceso==2 && $rol->tipo_acceso==2){

                    AccesoRol::updateOrCreate([
                        "acceso_id"=>$acceso['id'],
                        "rol_id"=>$rol->id
                    ],[
                        "estado_registro"=>'A'
                    ])->save();
                }else if($buscar->tipo_acceso==3 && $rol->tipo_acceso==3){

                    AccesoRol::updateOrCreate([
                        "acceso_id"=>$acceso['id'],
                        "rol_id"=>$rol->id
                    ],[
                        "estado_registro"=>'A'
                    ])->save();
                }else return response()->json(["resp" => "Acceso no compatible"]);
            }
            DB::commit();
            return response()->json(["resp" => "Accesos actualizados correctamente"]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["error" => $e]);
        }
    }
}
