<?php

namespace App\Http\Controllers;

// use App\Models\Bregma;
use App\Models\Clinica;
use App\Models\ClinicaLocal;
use App\Models\Departamento;
use App\Models\Distrito;
use App\Models\Distritos;
use App\Models\Provincia;
use App\Models\Rol;
use App\Models\UserRol;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClinicaLocalController extends Controller
{
    /**
     * Mostrar Datos Clinica Local
     * @OA\Get (
     *     path="/api/recursoshumanos/local/get",
     *     security={{ "bearerAuth": {} }},
     *     tags={"Clínica - Local"},
     *     @OA\Response( response=200,description="success",     *
     *         @OA\JsonContent(
     *                @OA\Property(type="array",property="data",
     *                     @OA\Items(type="object",
     *                         @OA\Property(property="id",type="number",example="1"),
     *                         @OA\Property(property="clinica_id",type="integer",example="1"),
     *                         @OA\Property(property="departamento_id",type="integer",example="1"),
     *                         @OA\Property(property="provincia_id",type="integer",example="1"),
     *                         @OA\Property(property="distrito_id",type="integer",example="1"),
     *                         @OA\Property(property="nombre",type="string",example="2.4"),
     *                         @OA\Property(property="latitud",type="string",example="1.2"),
     *                         @OA\Property(property="longitud",type="string",example="2.4"),
     *                         @OA\Property(property="estado_registro",type="char",example="A"),
     *                         @OA\Property(type="array",property="distrito",
     *                             @OA\Items(type="object",
     *                                 @OA\Property(property="id",type="integer",example="1"),
     *                                 @OA\Property(property="distrito",type="string",example="CHIQUILIN"),
     *                                 @OA\Property(property="provincia_id",type="integer",example="1"),
     *
     *                             )
     *                         ),
     *                         @OA\Property(type="array", property="provincia",
     *                             @OA\Items( type="object",
     *                                 @OA\Property(property="id",type="integer",example="1"),
     *                                 @OA\Property(property="provincia",type="string",example="CHACHAPOYAS"),
     *                                 @OA\Property(property="departamento_id",type="integer",example="1"),
     *                              )
     *                         ),
     *                         @OA\Property(type="array", property="departamento",
     *                             @OA\Items(type="object",
     *                                 @OA\Property(property="id",type="integer",example="1"),
     *                                 @OA\Property(property="departamento",type="string",example="AMAZONAS")
     *                             )
     *                          ),
     *                          @OA\Property(type="array", property="clinica_areas",
     *                              @OA\Items(type="object",
     *                                  @OA\Property(property="id",type="integer",example="1"),
     *                                  @OA\Property(property="nombre",type="string",example="Administracion"),
     *                                  @OA\Property(property="estado_registro",type="char",example="A"),
     *                                  @OA\Property(property="clinica_id",type="integer",example="1"),
     *                                  @OA\Property(property="bregma_id",type="integer",example=""),
     *                                  @OA\Property(property="empresa_id",type="integer",example=""),
     *                                  @OA\Property(property="clinica_local_id",type="integer",example="1"),
     *                                  @OA\Property(property="parent_id",type="integer",example="1")
     *                              )
     *                          )
     *                     )
     *                 ),
     *              @OA\Property(type="count",property="size",example="1")
     *          )
     *      ),
     *      @OA\Response(response=400,description="invalid",
     *         @OA\JsonContent(
     *             @OA\Property(property="resp", type="string", example="ERROR"),
     *         )
     *      ),
     * )
     */
    public function get()
    {
        $usuario = User::with('user_rol.rol')->where('id', auth()->user()->id)->first();
        $clinica_id = $usuario->user_rol[0]->rol->clinica_id;
        $clinica_local = ClinicaLocal::with('distrito','provincia','departamento','clinica_areas')->where('estado_registro', 'A')->where('clinica_id', $clinica_id)->get();
        if (!$clinica_local) {
            return response()->json(['error' => 'Clinica Local no existe'],500);
        }
        return response()->json(["data" => $clinica_local, "size" => count($clinica_local)]);
    }

    public function getLocales($idClinica)
    {
        $clinica_local = ClinicaLocal::where('estado_registro', 'A')->where('clinica_id', $idClinica)->get();
        if (!$clinica_local) {
            return response()->json(['error' => 'Clinica Local no existe'],500);
        }
        return response()->json(["data" => $clinica_local, "size" => count($clinica_local)]);
    }

    /**
     * Crear Datos para Clinica Local
     * @OA\Post (
     *     path="/api/recursoshumanos/local/create",
     *     security={{ "bearerAuth": {} }},
     *     tags={"Clínica - Local"},
     *     @OA\Parameter( @OA\Schema(type="integer"),name="departamento_id", in="query",required= false,example="1"),
     *     @OA\Parameter(@OA\Schema(type="integer"),name="provincia_id",in="query",required= false,example="1"),
     *     @OA\Parameter(@OA\Schema(type="integer"),name="distrito_id",in="query",required= false,example="1"),
     *     @OA\Parameter(@OA\Schema(type="string"),name="nombre",in="query",required= false,example="efa"),
     *     @OA\Parameter(@OA\Schema(type="string"),name="direccion",in="query",required= false,example="wefesfse"),
     *     @OA\Parameter(@OA\Schema(type="string"),name="latitud",in="query",required= false,example="23.3"),
     *     @OA\Parameter(@OA\Schema(type="string"),name="longitud",in="query",required= false,example="1.3"),
     *     @OA\RequestBody(
     *         @OA\MediaType(mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(type="object",
     *                     @OA\Property(property="departamento_id",type="integer",),
     *                     @OA\Property(property="provincia_id",type="integer",),
     *                     @OA\Property(property="distrito_id",type="integer",),
     *                     @OA\Property(property="nombre",type="integer",),
     *                     @OA\Property(property="direccion",type="string",),
     *                     @OA\Property(property="latitud",type="string",),
     *                     @OA\Property(property="longitud",type="string",)
     *                 ),
     *                 example={
     *                     "departamento_id": 5,
     *                     "provincia_id":23,
     *                     "distrito_id": 54,
     *                     "nombre": "sffse",
     *                     "direccion":"oicoc",
     *                     "latitud":2.3,
     *                     "longitud": 43.4
     *                }
     *             )
     *         )
     *      ),
     *      @OA\Response(response=200,description="success",
     *         @OA\JsonContent(
     *             @OA\Property(property="msg", type="string", example="Local creado correctamente")
     *         )
     *      ),
     *      @OA\Response(response=400,description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="ERROR")
     *          )
     *      ),
     * )
     */
    public function create(Request $request)
    {
        DB::beginTransaction();
        try {

            // if (!is_int($request['clinica_id']) || !is_int($request['departamento_id']) || !is_int($request['provincia_id']) || !is_int($request['distrito_id'])) {
            //     return response()->json(['error' => 'El id debe ser un número entero.'], 400);
            // }

            if (strlen($request->departamento_id) == 0) return response()->json(['error' => 'No ingresaste el id de departamento'], 505);
            if (strlen($request->provincia_id) == 0) return response()->json(['error' => 'No ingresaste el id de provincia'], 505);
            if (strlen($request->distrito_id) == 0) return response()->json(['error' => 'No ingresaste el id de distrito'], 505);
            $departamento = Departamento::find($request->departamento_id);
            $provincia =  Provincia::find($request->provincia_id);
            $distrito = Distritos::find($request->distrito_id);

            if (!$departamento) return response()->json(['error' => 'El id departamento no existe'], 505);
            if (!$provincia) return response()->json(['error' => 'El id  provincia no existe'], 505);
            if (!$distrito) return response()->json(['error' => 'El id distrito no existe'], 505);

            $datos = User::with('persona', 'user_rol.rol')->where('id', auth()->user()->id)->first();

            ClinicaLocal::create([
                'clinica_id' => $datos->user_rol[0]->rol->clinica_id,
                'departamento_id' => intval($request->departamento_id),
                'provincia_id' => intval($request->provincia_id),
                'distrito_id' => intval($request->distrito_id),
                'nombre' => $request->nombre,
                'direccion' => $request->direccion,
                'latitud' => $request->latitud,
                'longitud' => $request->longitud,
            ]);


            DB::commit();
            return response()->json(["resp" => "Local creado correctamente"]);
        } catch (Exception $e) {
            DB::rollBack();

            return response()->json(["Error" => "" . $e], 501);
        }
    }

    /**
     * Modificar Datos Clinica Local teniendo em cuenta el id del local a actualizar
     * @OA\Put (
     *     path="/api/recursoshumanos/local/update/{id}",
     *     security={{ "bearerAuth": {} }},
     *     tags={"Clínica - Local"},
     *     @OA\Parameter(in="path",name="id",required=true,@OA\Schema(type="integer")),
     *     @OA\Parameter(@OA\Schema(type="integer"),name="departamento_id",in="query",required= false,example="1"),
     *     @OA\Parameter(@OA\Schema(type="integer"),name="provincia_id",in="query",required= false,example="1"),
     *     @OA\Parameter(@OA\Schema(type="integer"),name="distrito_id",in="query",required= false,example="1"),
     *     @OA\Parameter(@OA\Schema(type="string"),name="nombre",in="query",required= false,example="efa"),
     *     @OA\Parameter(@OA\Schema(type="string"),name="direccion",in="query",required= false,example="wefesfse"),
     *     @OA\Parameter(@OA\Schema(type="string"),name="latitud",in="query",required= false,example="23.3"),
     *     @OA\Parameter(@OA\Schema(type="string"),name="longitud",in="query",required= false,example="1.3"),
     *     @OA\RequestBody(
     *         @OA\MediaType(mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(type="object",
     *                     @OA\Property(property="departamento_id",type="integer",),
     *                     @OA\Property(property="provincia_id",type="integer",),
     *                     @OA\Property(property="distrito_id",type="integer",),
     *                     @OA\Property(property="nombre",type="string",),
     *                     @OA\Property(property="direccion",type="string",),
     *                     @OA\Property(property="latitud",type="string",),
     *                     @OA\Property(property="longitud",type="string",)
     *                 ),
     *                 example={
     *                     "departamento_id": 5,
     *                     "provincia_id":23,
     *                     "distrito_id": 54,
     *                     "nombre": "sffse",
     *                     "direccion":"oicoc",
     *                     "latitud":2.3,
     *                     "longitud": 43.4
     *                }
     *             )
     *         )
     *      ),
     *      @OA\Response(response=200, description="success",
     *         @OA\JsonContent(
     *             @OA\Property(property="msg", type="string", example="Local actualizado correctamente")
     *         )
     *      ),
     *      @OA\Response(response=400, description="invalid",
     *         @OA\JsonContent(
     *             @OA\Property(property="resp", type="string", example="ERROR")
     *         )
     *      )
     * )
     */
    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {

            if (strlen($request->departamento_id) == 0) return response()->json(['error' => 'No ingresaste el id de departamento'], 404);
            if (strlen($request->provincia_id) == 0) return response()->json(['error' => 'No ingresaste el id de provincia'], 404);
            if (strlen($request->distrito_id) == 0) return response()->json(['error' => 'No ingresaste el id de distrito'], 404);

            $departamento = Departamento::find($request->departamento_id);
            $provincia =  Provincia::find($request->provincia_id);
            $distrito = Distritos::find($request->distrito_id);

            if (!$departamento) return response()->json(['error' => 'El id departamento no existe'], 404);
            if (!$provincia) return response()->json(['error' => 'El id  provincia no existe'], 404);
            if (!$distrito) return response()->json(['error' => 'El id distrito no existe'], 404);

            $datos = User::with('persona', 'user_rol.rol')->where('id', auth()->user()->id)->first();

            $clinica_local = ClinicaLocal::where('estado_registro', 'A')->find($id);
            if (!$clinica_local)  return response()->json(["error" => "El id Local no existe"]);

            $clinica_local->fill([
                'clinica_id' => $datos->user_rol[0]->rol->clinica_id,
                'departamento_id' => $request->departamento_id,
                'provincia_id' => $request->provincia_id,
                'distrito_id' => $request->distrito_id,
                'nombre' => $request->nombre,
                'direccion' => $request->direccion,
                'latitud' => $request->latitud,
                'longitud' => $request->longitud
            ])->save();

            DB::commit();

            return response()->json(["resp" => "Local actualizado correctamente"]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["Error" => "" . $e], 501);
        }
    }

    /**
     * Eliminar local de clínica teniendo como parametro el id del local
     * @OA\Delete (
     *     path="/api/recursoshumanos/local/delete/{id}",
     *     security={{ "bearerAuth": {} }},
     *     tags={"Clínica - Local"},
     *     @OA\Parameter(in="path",name="id",required=true,@OA\Schema(type="string")),
     *     @OA\Response(response=200, description="success",
     *         @OA\JsonContent(
     *             @OA\Property(property="msg", type="string", example="Local eliminada correctamente")
     *         )
     *     )
     * )
     */
    public function delete($id)
    {
        try {
            $usuario = User::with('user_rol.rol')->where('id', auth()->user()->id)->first();
            $clinica_id = $usuario->user_rol[0]->rol->clinica_id;

            if (!$clinica_id || !ClinicaLocal::where('clinica_id', $clinica_id)->find($id)) {
                return response()->json(['error' => 'No tiene acceso al local'], 403);
            }

            $clinica_local = ClinicaLocal::where('estado_registro', 'A')->find($id);

            if (!$clinica_local) return response()->json(['error' => 'Local ya inactivado'], 404);

            $clinica_local->fill([
                'estado_registro' => 'I',
            ])->save();
            return response()->json(["resp" => "Local inactivado correctamente"]);
        } catch (Exception $e) {
            return response()->json(["error" => $e]);
        }
    }
}
