<?php

namespace App\Http\Controllers;

use App\Models\Bregma;
use App\Models\CorreoInstitucion;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CorreoInstitucionController extends Controller
{
    /**
     * Crear Correo - institución
     * @OA\Post (
     *     path="/api/correo/institucion/create",
     *     summary="Crear Correo institución con sesión iniciado",
     *     security={{ "bearerAuth":{} }},
     *     tags={"Correo Institución"},
     *     @OA\Parameter(description="Correo de la institución",
     *         @OA\Schema(type="string"), name="correo", in="query", required=false, example="11222@gmail.com"),
     *
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(type="object",
     *             @OA\Property(property="id", type="number"),
     *             @OA\Property(property="correo", type="string"),
     *             ),
     *             example={
     *                 "celular":"11222@gmail.com",
     *             }
     *         ),
     *     ),
     *     @OA\Response(response=200, description="success",
     *         @OA\JsonContent(
     *             @OA\Property(property="resp", type="string", example="Correo creada correctamente"),
     *         )
     *     ),
     * )
     */
    public function create(Request $request)
    {
        DB::beginTransaction();
        try {
            $userbregma = User::with('user_rol.rol')->where('id', auth()->user()->id)->first();
            $persona = User::first("persona_id");
            $verificador = CorreoInstitucion::where('correo', $request->correo)->first();

            if ($verificador) {
                return response()->json(["resp" => "El correo ya existe!"], 401);
            }

            $celular = CorreoInstitucion::create([
                'persona_id' => $persona->persona->id,
                'bregma_id' => $userbregma->user_rol[0]->rol->bregma_id,
                'correo' => $request->correo,
                'clinica_id' => $userbregma->user_rol[0]->rol->clinica_id,
                'empresa_id' => $userbregma->user_rol[0]->rol->empresa_id,
            ]);
            DB::commit();
            //return response()->json($correo);
            return response()->json(["resp" => "Correo creado correctamente"]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["resp" => "Error" . $e]);
        }
    }

    /**
     * Actualizar Correo - Institución
     * @OA\Put (
     *     path="/api/correo/institucion/update/{id}",
     *     summary="Actualizar Correo institución con sessión iniciado",
     *     security={{ "bearerAuth":{} }},
     *     tags={"Correo Institución"},
     *     @OA\Parameter(description="ID del correo registrado",
     *         @OA\Schema(type="number"), name="id", in="path", required=true, example=1),
     *     @OA\Parameter(description="correo de la institución",
     *         @OA\Schema(type="string"), name="correo", in="query", required=false, example="11222@gmail.com"),
     *
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(type="object",
     *             @OA\Property(property="id", type="number"),
     *             @OA\Property(property="correo", type="string"),
     *             ),
     *             example={
     *                 "celular":"11222@gmail.com",
     *             }
     *         ),
     *     ),
     *     @OA\Response(response=200, description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="Correo actualizado correctamente"),
     *          )
     *      ),
     *      @OA\Response(response=400, description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="Error al actualizar el correo, intente otra vez!"),
     *          )
     *      ),
     *      @OA\Response(response=401, description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="El correo ya esta registrado!"),
     *          )
     *      ),
     * )
     */
    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $correo = CorreoInstitucion::find($id);
            //$userbregma = User::with('user_rol.rol')->where('id', auth()->user()->id)->first();
            $verificador = CorreoInstitucion::where('correo', $request->correo)->first();

            if ($verificador) return response()->json(["resp" => "El correo ya esta registrado!"], 401);

            $correo->fill(
                [
                    //"bregma_id" => $userbregma->bregma_id,
                    //"empresa_id" => $userbregma->user_rol[0]->rol->empresa_id,
                    //"persona_id" => $userbregma->user_rol[0]->rol->persona_id,
                    //"clinica_id" => $userbregma->user_rol[0]->rol->clinica_id,
                    "correo" => $request->correo,
                ]
            );
            $correo->save();
            DB::commit();
            return response()->json(["resp" => "Correo actualizado correctamente."], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["resp" => "error", "error" => "Error al actualizar el correo, intente otra vez!" . $e]);
        }
    }

    /**
     * Eliminar correo.
     *  @OA\Delete (
     *      path="/api/correo/institucion/delete/{id}",
     *      summary="Eliminar el correo registrado",
     *      security={{ "bearerAuth": {} }},
     *      tags={"Correo Institución"},
     *      @OA\Parameter(description="ID del correo registrada",
     *          @OA\Schema(type="number"), name="id", in="path", required=true, example=1),
     *      @OA\Response(response=200,description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="Correo eliminada correctamente"),
     *          )
     *      ),
     *      @OA\Response(response=400, description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="Correo a eliminar no encontrado o no existe!"),
     *          )
     *      )
     *  )
     */
    public function delete($id)
    {
        DB::beginTransaction();
        try {
            $correo = CorreoInstitucion::find($id);
            if ($correo) {
                $correo->fill([
                    'estado_registro' => 'I',
                ])->save();
                DB::commit();
                return response()->json(["resp" => "Correo eliminada correctamente"]);
            } else {
                return response()->json(["resp" => "Correo a eliminar no encontrado o no existe!"]);
            }
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(["error" => "error " . $e]);
        }
    }

    /**
     * Mostrar el Correo
     * @OA\GET (
     *     path="/api/correo/institucion/show",
     *     summary="Muestra los correos con sesión iniciada",
     *     security={{ "bearerAuth": {} }},
     *     tags={"Correo Institución"},
     *      @OA\Response(response=200,description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="id", type="number", example=1),
     *              @OA\Property(property="bregma_id", type="number", example=1),
     *              @OA\Property(property="empresa_id", type="number", example=1),
     *              @OA\Property(property="persona_id", type="number", example=1),
     *              @OA\Property(property="clinica_id", type="number", example=1),
     *              @OA\Property(property="correo", type="string", example="123prueba@gmail.com"),
     *              @OA\Property(property="estado_registro", type="string", example="A"),
     *
     *              @OA\Property(type="array", property="bregma",
     *                  @OA\Items(type="object",
     *                      @OA\Property(property="id", type="number", example=1),
     *                      @OA\Property(property="tipo_documento_id", type="number", example=1),
     *                      @OA\Property(property="distrito_id", type="number", example=1),
     *                      @OA\Property(property="numero_documento", type="number", example=00000000),
     *                      @OA\Property(property="razon_social", type="string", example=""),
     *                      @OA\Property(property="direccion", type="string", example=""),
     *                      @OA\Property(property="estado_pago", type="string", example="0"),
     *                      @OA\Property(property="latitud", type="string", example="19° 25′ 42″ N"),
     *                      @OA\Property(property="longitud", type="string", example="99° 7′ 39″ O"),
     *                      @OA\Property(property="estado_registro", type="string", example="A")
     *                  )
     *              ),
     *              @OA\Property(type="array", property="persona",
     *                  @OA\Items(type="object",
     *                      @OA\Property(property="id", type="number", example=1),
     *                      @OA\Property(property="numero_documento", type="string", example="00000000"),
     *                      @OA\Property(property="nombres",type="string", example="Administrador"),
     *                      @OA\Property(property="apellido_paterno", type="string", example="Super"),
     *                      @OA\Property(property="apellido_materno", type="string", example="Admin"),
     *                      @OA\Property(property="fecha_nacimiento", type="string", example=""),
     *                      @OA\Property(property="celular",type="string",example=""),
     *                      @OA\Property(property="telefono",type="string",example="1245"),
     *                      @OA\Property(property="email", type="string", example=""),
     *                      @OA\Property(property="direccion",type="string", example=""),
     *                      @OA\Property(property="telefono_emergencia", type="string", example=""),
     *                      @OA\Property(property="contacto_emergencia", type="string", example=""),
     *                      @OA\Property(property="tipo_documento_id", type="number", example=1),
     *                      @OA\Property(property="distrito_id", type="number", example=1),
     *                      @OA\Property(property="distrito_domicilio_id", type="number", example=""),
     *                      @OA\Property(property="estado_civil_id", type="number", example=""),
     *                      @OA\Property(property="religion_id", type="number", example=""),
     *                      @OA\Property(property="sexo_id", type="number", example=""),
     *                      @OA\Property(property="grado_instruccion_id", type="number", example="")
     *                  )
     *              ),
     *          )
     *      ),
     *
     *      @OA\Response(response=400,description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="El bregma logeado no tiene correo!"),
     *          )
     *      ),
     * )
     */
    public function show()
    {
        try {
            $userbregma = User::with('user_rol.rol')->where('id', auth()->user()->id)->first();
            $correo = CorreoInstitucion::with('bregma', 'persona')->where('bregma_id', $userbregma->user_rol[0]->rol->bregma_id)->where('estado_registro', 'A')->get();

            if (!$correo) {
                return response()->json(["resp" => "El bregma logeado no tiene correo!"], 400);
            }
            return response()->json(["data" => $correo, "size" => count($correo)], 200);
        } catch (Exception $e) {
            return response()->json(["error" => "error", "error" => $e]);
        }
    }

    /**
     * Obtener al  correo registrado.
     *  @OA\Get(
     *      path="/api/correo/institucion/get/{idCorreo}",
     *      summary="Obtener el correo registrado por ID correo",
     *      security={{ "bearerAuth": {} }},
     *      tags={"Correo Institución"},
     *      @OA\Parameter(description="ID del correo registrado",
     *          @OA\Schema(type="string"), name="idCorreo", in="path", required=true, example=2),
     *
     *          @OA\Response(response=200,description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="id", type="number", example=1),
     *              @OA\Property(property="bregma_id", type="number", example=1),
     *              @OA\Property(property="empresa_id", type="number", example=1),
     *              @OA\Property(property="persona_id", type="number", example=1),
     *              @OA\Property(property="clinica_id", type="number", example=1),
     *              @OA\Property(property="correo", type="string", example="123prueba@gmail.com"),
     *              @OA\Property(property="estado_registro", type="string", example="A"),
     *
     *              @OA\Property(type="array", property="bregma",
     *                  @OA\Items(type="object",
     *                      @OA\Property(property="id", type="number", example=1),
     *                      @OA\Property(property="tipo_documento_id", type="number", example=1),
     *                      @OA\Property(property="distrito_id", type="number", example=1),
     *                      @OA\Property(property="numero_documento", type="number", example=00000000),
     *                      @OA\Property(property="razon_social", type="string", example=""),
     *                      @OA\Property(property="direccion", type="string", example=""),
     *                      @OA\Property(property="estado_pago", type="string", example="0"),
     *                      @OA\Property(property="latitud", type="string", example="19° 25′ 42″ N"),
     *                      @OA\Property(property="longitud", type="string", example="99° 7′ 39″ O"),
     *                      @OA\Property(property="estado_registro", type="string", example="A")
     *                  )
     *              ),
     *              @OA\Property(type="array", property="persona",
     *                  @OA\Items(type="object",
     *                      @OA\Property(property="id", type="number", example=1),
     *                      @OA\Property(property="numero_documento", type="string", example="00000000"),
     *                      @OA\Property(property="nombres",type="string", example="Administrador"),
     *                      @OA\Property(property="apellido_paterno", type="string", example="Super"),
     *                      @OA\Property(property="apellido_materno", type="string", example="Admin"),
     *                      @OA\Property(property="fecha_nacimiento", type="string", example=""),
     *                      @OA\Property(property="celular",type="string",example=""),
     *                      @OA\Property(property="telefono",type="string",example="1245"),
     *                      @OA\Property(property="email", type="string", example=""),
     *                      @OA\Property(property="direccion",type="string", example=""),
     *                      @OA\Property(property="telefono_emergencia", type="string", example=""),
     *                      @OA\Property(property="contacto_emergencia", type="string", example=""),
     *                      @OA\Property(property="tipo_documento_id", type="number", example=1),
     *                      @OA\Property(property="distrito_id", type="number", example=1),
     *                      @OA\Property(property="distrito_domicilio_id", type="number", example=""),
     *                      @OA\Property(property="estado_civil_id", type="number", example=""),
     *                      @OA\Property(property="religion_id", type="number", example=""),
     *                      @OA\Property(property="sexo_id", type="number", example=""),
     *                      @OA\Property(property="grado_instruccion_id", type="number", example="")
     *                  )
     *              ),
     *          )
     *      ),
     *
     *      @OA\Response(response=400,description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="El correo no existe."),
     *          )
     *      ),
     *  )
     */
    public function get($idCorreo)
    {
        try {
            $correo = CorreoInstitucion::where('estado_registro', 'A')->with(['persona', 'bregma'])->find($idCorreo);
            if($correo){
                return response()->json(["data" => $correo], 200);
            }else {
                return response()->json(["resp"=> "El correo no existe."], 400);
            }
        } catch (Exception $e) {
            return response()->json(["error" => "error", "error" => $e]);
        }
    }
}
