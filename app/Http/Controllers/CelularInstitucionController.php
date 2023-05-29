<?php

namespace App\Http\Controllers;

use App\Models\Bregma;
use App\Models\CelularInstitucion;
use App\Models\Persona;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CelularInstitucionController extends Controller
{
    /**
     * Crear celular - Institución
     * @OA\Post (
     *     path="/api/celular/institucion/create",
     *     summary="Crear Celular institución con sesión iniciado",
     *     security={{ "bearerAuth":{} }},
     *     tags={"Celular Institución"},
     *     @OA\Parameter(description="celular de la institución",
     *         @OA\Schema(type="number"), name="celular", in="query", required=false, example=112223333),
     *
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(type="object",
     *             @OA\Property(property="id", type="number"),
     *             @OA\Property(property="celular", type="number"),
     *             ),
     *             example={
     *                 "celular":11223333,
     *             }
     *         ),
     *     ),
     *     @OA\Response(response=200, description="success",
     *         @OA\JsonContent(
     *             @OA\Property(property="resp", type="string", example="Celular creada correctamente"),
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
            $verificador = CelularInstitucion::where('celular', $request->celular)->first();

            if ($verificador) {
                return response()->json(["resp" => "Número de celular ya existe!"], 401);
            }

            $celular = CelularInstitucion::create([
                'persona_id' => $persona->persona->id,
                'bregma_id' => $userbregma->user_rol[0]->rol->bregma_id,

                'celular' => $request->celular,
                'clinica_id' => $userbregma->user_rol[0]->rol->clinica_id,
                'empresa_id' => $userbregma->user_rol[0]->rol->empresa_id,
            ]);
            DB::commit();
            //return response()->json($celular);
            return response()->json(["resp" => "Celular creado correctamente"]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["resp" => "Error" . $e]);
        }
    }

    /**
     * Actualizar Celular - Institución
     * @OA\Put (
     *     path="/api/celular/institucion/update/{id}",
     *     summary="Actualizar Celular institución con sesión iniciado",
     *     security={{ "bearerAuth":{} }},
     *     tags={"Celular Institución"},
     *     @OA\Parameter(description="ID del celular registrado",
     *         @OA\Schema(type="number"), name="id", in="path", required=true, example=1),
     *     @OA\Parameter(description="celular de la institucion",
     *         @OA\Schema(type="number"), name="celular", in="query", required=false, example=112223333),
     *
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(type="object",
     *             @OA\Property(property="id", type="number"),
     *             @OA\Property(property="celular", type="number"),
     *             ),
     *             example={
     *                 "celular":11223333,
     *             }
     *         ),
     *     ),
     *     @OA\Response(response=200, description="success",
     *         @OA\JsonContent(
     *             @OA\Property(property="resp", type="string", example="Celular actualizado correctamente"),
     *         )
     *      ),
     *      @OA\Response(response=400, description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="Error al actualizar el celular, intente otra vez!"),
     *          )
     *      ),
     *      @OA\Response(response=401, description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="Número de celular ya esta registrado!"),
     *          )
     *      ),
     * )
     */
    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $celular = CelularInstitucion::find($id);
            //$userbregma = User::with('user_rol.rol')->where('id', auth()->user()->id)->first();
            $verificador = CelularInstitucion::where('celular', $request->celular)->first();

            if ($verificador) return response()->json(["resp" => "Número de celular ya esta registrado!"], 401);

            $celular->fill(
                [
                    //"bregma_id" => $userbregma->bregma_id,

                    //"empresa_id" => $userbregma->user_rol[0]->rol->empresa_id,
                    //"persona_id" => $userbregma->user_rol[0]->rol->persona_id,
                    //"clinica_id" => $userbregma->user_rol[0]->rol->clinica_id,
                    "celular" => $request->celular,
                ]
            );
            $celular->save();
            DB::commit();
            return response()->json(["resp" => "Celular actualizado correctamente."], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["resp" => "error", "error" => "Error al actualizar el celular, intente otra vez!" . $e]);
        }
    }

    /**
     * Eliminar celular.
     *  @OA\Delete (
     *      path="/api/celular/institucion/delete/{id}",
     *      summary="Eliminar el celular registrado",
     *      security={{ "bearerAuth": {} }},
     *      tags={"Celular Institución"},
     *      @OA\Parameter(description="ID del celular registrada",
     *          @OA\Schema(type="number"), name="id", in="path", required=true, example=1),
     *      @OA\Response(response=200,description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="Celular eliminada correctamente"),
     *          )
     *      ),
     *      @OA\Response(response=400, description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="Celular a eliminar no encontrado o no existe!"),
     *          )
     *      )
     *  )
     */
    public function delete($id)
    {
        DB::beginTransaction();
        try {
            $celular = CelularInstitucion::find($id);
            if ($celular) {
                $celular->fill([
                    'estado_registro' => 'I',
                ])->save();
                DB::commit();
                return response()->json(["resp" => "Celular eliminada correctamente"], 200);
            } else {
                return response()->json(["resp" => "Celular a eliminar no encontrado o no existe!"], 400);
            }
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(["error" => "error " . $e]);
        }
    }

    /**
     * Mostrar Celular
     * @OA\GET (
     *     path="/api/celular/institucion/show",
     *     summary="Muestra los celular con sesión iniciada",
     *     security={{ "bearerAuth": {} }},
     *     tags={"Celular Institución"},
     *      @OA\Response(response=200,description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="id", type="number", example="1"),
     *              @OA\Property(property="bregma_id", type="number", example="1"),
     *              @OA\Property(property="empresa_id", type="number", example="1"),
     *              @OA\Property(property="persona_id", type="number", example="1"),
     *              @OA\Property(property="clinica_id", type="number", example="1"),
     *              @OA\Property(property="celular", type="number", example="987654321"),
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
            $celular = CelularInstitucion::with('bregma', 'persona')->where('bregma_id', $userbregma->user_rol[0]->rol->bregma_id)->where('estado_registro', 'A')->get();

            if (!$celular) {
                return response()->json(["resp" => "El bregma logeado no tiene celular!"],400);
            }
            return response()->json(["data" => $celular, "size" =>count($celular)],200);
        } catch (Exception $e) {
            return response()->json(["error" => "error", "error" => $e]);
        }
    }

    /**
     * Obtener al  celular registrado.
     *  @OA\Get(
     *      path="/api/celular/institucion/get/{idCelular}",
     *      summary="Obtener el Celular registrado por ID celular",
     *      security={{ "bearerAuth": {} }},
     *      tags={"Celular Institución"},
     *      @OA\Parameter(description="ID del celular registrado",
     *          @OA\Schema(type="number"), name="idCelular", in="path", required=true, example=2),
     *
     *          @OA\Response(response=200,description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="id", type="number", example=1),
     *              @OA\Property(property="bregma_id", type="number", example=1),
     *              @OA\Property(property="empresa_id", type="number", example=1),
     *              @OA\Property(property="persona_id", type="number", example=1),
     *              @OA\Property(property="clinica_id", type="number", example=1),
     *              @OA\Property(property="celular", type="number", example="987654321"),
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
     *              @OA\Property(property="resp", type="string", example="El celular no existe!"),
     *          )
     *      ),
     *  )
     */
    public function get($idCelular)
    {
        try {
            $celular = CelularInstitucion::where('estado_registro', 'A')->with(["persona", "bregma"])->find($idCelular);
            //return response()->json([$celular]);
            if (!$celular) {
                return response()->json(["resp"=> "El celular no existe!"],400);
            }else {
                return response()->json(["data" => $celular],200);
            }
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(["error" => "error " . $e]);
        }
    }
}
