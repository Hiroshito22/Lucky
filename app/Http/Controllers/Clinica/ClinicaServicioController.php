<?php

namespace App\Http\Controllers\Clinica;

use App\Http\Controllers\Controller;
use App\Models\Bregma;
use App\Models\BregmaPaquete;
use App\Models\Clinica;
use App\Models\ClinicaServicio;
use App\Models\Contrato;
use App\Models\Servicio;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClinicaServicioController extends Controller
{
    /**
     * Mostrar Datos de Clinica Servicio
     * @OA\Get (
     *     path="/api/clinica/servicio/get",
     *     summary="Muestra datos de Clinica-Servicio",
     *     security={{ "bearerAuth": {} }},
     *     tags={"Clinica-Servicio"},
     *      @OA\Response(response=200, description="success",
     *          @OA\JsonContent(
     *              @OA\Property(type="array", property="data",
     *                  @OA\Items(type="object",
     *                      @OA\Property(property="id", type="number", example=1),
     *                      @OA\Property(property="servicio_id", type="number", example=""),
     *                      @OA\Property(property="clinica_id", type="number", example=1),
     *                      @OA\Property(property="nombre", type="string", example="Servicio SuperPadre"),
     *                      @OA\Property(property="icono", type="file", example=""),
     *                      @OA\Property(property="parent_id", type="number", example=""),
     *                      @OA\Property(property="estado_registro", type="char", example="A"),
     *                      @OA\Property(property="depth", type="number", example=0),
     *                      @OA\Property(property="path", type="string", example="1"),
     *                      @OA\Property(property="slug", type="string", example="Servicio SuperPadre"),
     *                      @OA\Property(
     *                          type="array",
     *                          property="clinica",
     *                          @OA\Items(
     *                             type="object",
     *                             @OA\Property(property="id",type="integer",example="1"),
     *                             @OA\Property(property="bregma_id",type="integer",example=""),
     *                             @OA\Property(property="tipo_documento_id",type="integer",example="1"),
     *                             @OA\Property(property="distrito_id",type="integer",example=""),
     *                             @OA\Property(property="ruc",type="integer",example=""),
     *                             @OA\Property(property="razon_social",type="string",example=""),
     *                             @OA\Property(property="numero_documento",type="integer",example="11111111"),
     *                             @OA\Property(property="responsable",type="string",example=""),
     *                             @OA\Property(property="nombre_comercial",type="string",example=""),
     *                             @OA\Property(property="latitud",type="string",example=""),
     *                             @OA\Property(property="longitud",type="string",example=""),
     *                             @OA\Property(property="logo",type="string",example=""),
     *                             @OA\Property(property="estado_registro",type="char",example="A"),
     *                             @OA\Property(property="hospital_id",type="integer",example="")
     *                         )
     *                      ),
     *                      @OA\Property(property="servicio", type="string", example=null),
     *
     *                      @OA\Property(type="array", property="children",
     *                          @OA\Items(type="object",
     *                              @OA\Property(property="id", type="number", example=1),
     *                              @OA\Property(property="servicio_id", type="number", example=""),
     *                              @OA\Property(property="clinica_id", type="number", example=1),
     *                              @OA\Property(property="nombre", type="string", example="Servicio Padre"),
     *                              @OA\Property(property="icono", type="file", example=""),
     *                              @OA\Property(property="parent_id", type="number", example="1"),
     *                              @OA\Property(property="estado_registro", type="char", example="A"),
     *                              @OA\Property(property="depth", type="number", example=1),
     *                              @OA\Property(property="path", type="string", example="1.2"),
     *                              @OA\Property(property="slug", type="string", example="Servicio SuperPadre/Servicio Padre"),
     *                              @OA\Property(
     *                                  type="array",
     *                                  property="clinica",
     *                                  @OA\Items(
     *                                     type="object",
     *                                     @OA\Property(property="id",type="integer",example="1"),
     *                                     @OA\Property(property="bregma_id",type="integer",example=""),
     *                                     @OA\Property(property="tipo_documento_id",type="integer",example="1"),
     *                                     @OA\Property(property="distrito_id",type="integer",example=""),
     *                                     @OA\Property(property="ruc",type="integer",example=""),
     *                                     @OA\Property(property="razon_social",type="string",example=""),
     *                                     @OA\Property(property="numero_documento",type="integer",example="11111111"),
     *                                     @OA\Property(property="responsable",type="string",example=""),
     *                                     @OA\Property(property="nombre_comercial",type="string",example=""),
     *                                     @OA\Property(property="latitud",type="string",example=""),
     *                                     @OA\Property(property="longitud",type="string",example=""),
     *                                     @OA\Property(property="logo",type="string",example=""),
     *                                     @OA\Property(property="estado_registro",type="char",example="A"),
     *                                     @OA\Property(property="hospital_id",type="integer",example="")
     *                                 )
     *                              ),
     *                              @OA\Property(property="servicio", type="string", example=null),
     *
     *                              @OA\Property(type="array", property="children",
     *                                  @OA\Items(type="object",
     *                                      @OA\Property(property="id", type="number", example=1),
     *                                      @OA\Property(property="servicio_id", type="number", example=1),
     *                                      @OA\Property(property="clinica_id", type="number", example=1),
     *                                      @OA\Property(property="nombre", type="string", example="Servicio Hija"),
     *                                      @OA\Property(property="icono", type="file", example=""),
     *                                      @OA\Property(property="parent_id", type="number", example="2"),
     *                                      @OA\Property(property="estado_registro", type="char", example="A"),
     *                                      @OA\Property(property="depth", type="number", example=2),
     *                                      @OA\Property(property="path", type="string", example="1.2.3"),
     *                                      @OA\Property(property="slug", type="string", example="Servicio SuperPadre/Servicio Padre/Servicio Hija"),
     *                                      @OA\Property(
     *                                          type="array",
     *                                          property="clinica",
     *                                          @OA\Items(
     *                                             type="object",
     *                                             @OA\Property(property="id",type="integer",example="1"),
     *                                             @OA\Property(property="bregma_id",type="integer",example=""),
     *                                             @OA\Property(property="tipo_documento_id",type="integer",example="1"),
     *                                             @OA\Property(property="distrito_id",type="integer",example=""),
     *                                             @OA\Property(property="ruc",type="integer",example=""),
     *                                             @OA\Property(property="razon_social",type="string",example=""),
     *                                             @OA\Property(property="numero_documento",type="integer",example="11111111"),
     *                                             @OA\Property(property="responsable",type="string",example=""),
     *                                             @OA\Property(property="nombre_comercial",type="string",example=""),
     *                                             @OA\Property(property="latitud",type="string",example=""),
     *                                             @OA\Property(property="longitud",type="string",example=""),
     *                                             @OA\Property(property="logo",type="string",example=""),
     *                                             @OA\Property(property="estado_registro",type="char",example="A"),
     *                                             @OA\Property(property="hospital_id",type="integer",example="")
     *                                         )
     *                                      ),
     *                                      @OA\Property(
     *                                          type="array",
     *                                          property="servicio",
     *                                          @OA\Items(
     *                                             type="object",
     *                                             @OA\Property(property="id",type="integer",example="1"),
     *                                             @OA\Property(property="nombre",type="string",example="Triaje"),
     *                                             @OA\Property(property="precio",type="double",example="10"),
     *                                             @OA\Property(property="estado_registro",type="char",example="A"),
     *                                             @OA\Property(property="icon",type="string",example="http://127.0.0.1:8000/storage/servicio/icon/2-Triaje.svg")
     *                                         )    
     *                                      ),
     *                                  )
     *                              ),
     *                          )
     *                      ),
     *                  )
     *              ),
     *              @OA\Property(type="count", property="size", example="1")
     *          )
     *      ),
     *      @OA\Response(response=404, description="invalid",
     *         @OA\JsonContent(
     *             @OA\Property(property="resp", type="string", example="Clinica Servicio no se encontro o no existe"),
     *         )
     *      ),
     *      @OA\Response(response=500, description="invalid",
     *         @OA\JsonContent(
     *             @OA\Property(property="resp", type="string", example="Error al llamar Clinica Servicio, intente otra vez!"),
     *         ),
     *      )
     * )
     */
    public function show()
    {
        try {
            $usuario = User::with('user_rol.rol')->where('id', auth()->user()->id)->first();
            $clinica_id = $usuario->user_rol[0]->rol->clinica_id;
            $supePadre = ClinicaServicio::with('servicio')->where('estado_registro', 'A')->where('clinica_id', $clinica_id)->tree()->get();

            if (!$supePadre) {
                return response()->json(['resp' => 'Clinica Servicio no se encontro o no existe'], 404);
            }

            $tree = $supePadre->toTree();
            return response()->json(["data" => $tree, "size" => count($tree)]);
        } catch (Exception $e) {
            return response()->json(["Error"=> "".$e],500);
        }
    }

    /**
     * Crear Datos de Clinica Servicio
     * @OA\Post(
     *     path = "/api/clinica/servicio/create",
     *     summary = "Create Datos de Clinica Servicio",
     *     security={{ "bearerAuth": {} }},
     *     tags={"Clinica-Servicio"},
     *      @OA\Parameter(description="servicio_id",@OA\Schema(type="number"), name="servicio_id", in="query", required=true, example=""),
     *      @OA\Parameter(description="nombre",@OA\Schema(type="string"), name="nombre", in="query", required=false, example="examen Psicológico"),
     *      @OA\Parameter(description="icono",@OA\Schema(type="file"), name="icono", in="query", required=false, example=""),
     *      @OA\Parameter(description="parent_id",@OA\Schema(type="number"), name="parent_id", in="query", required=false, example=""),
     *      @OA\RequestBody(
     *          @OA\MediaType(mediaType="aplication/json",
     *              @OA\Schema(
     *                  @OA\Property(type="object",
     *                      @OA\Property(property="servicio_id", type="number"),
     *                      @OA\Property(property="nombre", type="string"),
     *                      @OA\Property(property="icono", type="file"),
     *                      @OA\Property(property="parent_id", type="number"),
     *                  ),
     *                  example={
     *                      "servicio_id": "",
     *                      "nombre": "examen Psicológico",
     *                      "icono": "",
     *                      "parent_id":"",
     *                  }
     *              )
     *          )
     *      ),
     *      @OA\Response(response=200, description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="Clinica Servicio creado correctamente"),
     *          )
     *      ),
     *      @OA\Response(response=401, description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="El Super Padre no se encontro"),
     *          )
     *      ),
     *      @OA\Response(response=400, description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="Error al crear Clinica Servicio, intente otra vez!"),
     *          )
     *      ),
     * )
     */

    public function create(Request $request)
    {
        DB::beginTransaction();
        try {
            $datos = User::with('persona', 'user_rol.rol')->where('id', auth()->user()->id)->first();

            $superPadre = ClinicaServicio::where('id', $request->parent_id)->first();

            if ($request->parent_id == null) {
                ClinicaServicio::create([
                    "servicio_id" => null,
                    "clinica_id" => $datos->user_rol[0]->rol->clinica_id,
                    "nombre" => $request->nombre,
                    "icono" => $request->icono,
                    "parent_id" => null,
                ]);
                DB::commit();
                return response()->json(["resp" => "Clinica Servicio creado correctamente"], 200);
            } else {
                if (!$superPadre) {
                    return response()->json(["resp" => "El Super Padre no se encontro"], 401);
                }
                ClinicaServicio::create([
                    "servicio_id" => $request->servicio_id,
                    "clinica_id" => $datos->user_rol[0]->rol->clinica_id,
                    "nombre" => $request->nombre,
                    "icono" => $request->icono,
                    "parent_id" => $request->parent_id,
                ]);
                $superPadre->update(['servicio_id'=>null]);
                DB::commit();
                return response()->json(["resp" => "Clinica Servicio creado correctamente"]);
            }
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["resp" => "error", "error" => "Error al crear Clinica Servicio, intente otra vez!" . $e], 400);
        }
    }


    /**
     * Actualizar Datos de Clinica Servicio
     * @OA\Put(
     *     path = "/api/clinica/servicio/update/{idclinicaservicio}",
     *     summary = "Actualiza Datos de Clinica Servicio",
     *     security={{ "bearerAuth": {} }},
     *     tags={"Clinica-Servicio"},
     *      @OA\Parameter(description="idclinicaservicio",@OA\Schema(type="number"), name="idclinicaservicio", in="path", required=true, example=1),
     *      @OA\Parameter(description="servicio_id",@OA\Schema(type="number"), name="servicio_id", in="query", required=true, example=""),
     *      @OA\Parameter(description="nombre",@OA\Schema(type="string"), name="nombre", in="query", required=false, example="examen Psicológico"),
     *      @OA\Parameter(description="icono",@OA\Schema(type="file"), name="icono", in="query", required=false, example=""),
     *      @OA\Parameter(description="parent_id",@OA\Schema(type="number"), name="parent_id", in="query", required=false, example=""),
     *      @OA\RequestBody(
     *          @OA\MediaType(mediaType="aplication/json",
     *              @OA\Schema(
     *                  @OA\Property(type="object",
     *                      @OA\Property(property="servicio_id", type="number"),
     *                      @OA\Property(property="nombre", type="string"),
     *                      @OA\Property(property="icono", type="file"),
     *                      @OA\Property(property="parent_id", type="number"),
     *                  ),
     *                  example={
     *                      "servicio_id": "",
     *                      "nombre": "examen Psicológico",
     *                      "icono": "",
     *                      "parent_id": ""
     *                  }
     *              )
     *          )
     *      ),
     *      @OA\Response(response=200, description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="Clinica Servicio actualizado correctamente"),
     *          )
     *      ),
     *      @OA\Response(response=400, description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="El id del Clinica Servicio no se encontro"),
     *          )
     *      ),
     *      @OA\Response(response=500, description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="Error al actualizar Clinica Servicio, intente otra vez!"),
     *          )
     *      ),
     * )
     */

    public function update(Request $request, $idclinicaservicio)
    {
        DB::beginTransaction();
        try {
            $datos = User::with('persona', 'user_rol.rol')->where('id', auth()->user()->id)->first();

            $superPadre = ClinicaServicio::where('estado_registro', 'A')->find($idclinicaservicio);
            if (!$superPadre) {
                return response()->json(["resp" => "El id del Clinica Servicio no se encontro"], 400);
            }

            $superPadre->fill([
                "servicio_id" => $request->servicio_id,
                "clinica_id" => $datos->user_rol[0]->rol->clinica_id,
                "nombre" => $request->nombre,
                "icono" => $request->icono,
            ])->save();
            DB::commit();
            return response()->json(["resp" => "Clinica Servicio actualizado correctamente"], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["resp" => "error", "error" => "Error al actualizar Clinica Servicio, intente otra vez!" . $e], 500);
        }
    }

    /**
     * Eliminar Datos de Clinica Servicio
     * @OA\Delete (
     *     path="/api/clinica/servicio/delete/{idclinicaservicio}",
     *     summary="Inhabilita Datos de Clinica Servicio",
     *     security={{ "bearerAuth":{} }},
     *     tags={"Clinica-Servicio"},
     *      @OA\Parameter(description="idclinicaservicio",@OA\Schema(type="number"),name="idclinicaservicio",in="path",required= true,example=2),
     *      @OA\Response(
     *          response=200,
     *          description="success",
     *          @OA\JsonContent(
     *          @OA\Property(property="resp", type="string", example="Clinica Servicio inabititado correctamente"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="El id del Clinica Servicio no se encontro"),
     *          ),
     *      ),
     *      @OA\Response(response=500, description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="Error al eliminar Clinica Servicio, intente otra vez!"),
     *          )
     *      ),
     * )
     */

    public function delete($idclinicaservicio)
    {
        DB::beginTransaction();
        try {
            //$usuario = User::with('persona', 'user_rol.rol')->where('id', auth()->user()->id)->first();
            $superPadre = ClinicaServicio::where('estado_registro', 'A')->find($idclinicaservicio);
            if (!$superPadre) {
                return response()->json(["resp" => "El id del Clinica Servicio no se encontro"], 400);
            }
            $superPadre->fill([
                "parent_id" => null,
                "estado_registro" => "I",
            ])->save();

            while ($superPadre->children->count() > 0) {
                foreach ($superPadre->children as $superHijo) {
                    $superPadre = $superHijo;
                    $superHijo->fill([
                        "parent_id" => null,
                        "estado_registro" => "I",
                    ])->save();
                }
            }
            DB::commit();
            return response()->json(["resp" => "Clinica Servicio inabititado correctamente"], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["resp" => "error", "error" => "Error al eliminar Clinica Servicio, intente otra vez!" . $e], 500);
        }
    }


    public function get()
    {
        try {
            $usuario = User::with('user_rol.rol')->where('id', auth()->user()->id)->first();
            // return response()->json($usuario);
            $clinica_id = $usuario->user_rol[0]->rol->clinica_id;
            if($clinica_id==null) return response()->json(["error" => "Clinica no se encontro o no existe"], 404);
            // return response()->json($clinica_id);
            $contrato_breg = Contrato::where('clinica_id', $clinica_id)->where('empresa_id',null)->get();
            $bregma_paquete = BregmaPaquete::with('area_medica','capacitacion','examen','laboratorio')->where('id',$contrato_breg[0]->bregma_paquete_id)->get();

            return response()->json(["data" => $bregma_paquete, "size" => count($bregma_paquete)]);
        } catch (Exception $e) {
            return response()->json(["Error"=> "".$e],500);
        }
    }
    
}
