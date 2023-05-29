<?php

namespace App\Http\Controllers;

use App\Models\Bregma;
use App\Models\Clinica;
use App\Models\Detraccion;
use Exception;
use App\Models\Persona;
use App\Models\Rol;
use App\Models\UserRol;
use App\User;
use Illuminate\Http\Client\ResponseSequence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use function PHPUnit\Framework\returnSelf;

class DetraccionController extends Controller
{
    /**
     *  Obtener a la detraccion registrada.
     *  @OA\Get(
     *      path="/api/detraccion/show/{iddetraccion}",
     *      summary="Obtener la detraccion registrada por ID detraccion",
     *      security={{ "bearerAuth": {} }},
     *      tags={"Bregma Detracción"},
     *      @OA\Parameter(description="ID de la detraccion registrada", @OA\Schema(type="number"), name="iddetraccion", in="path", required=true, example=2),
     *      @OA\response(response=200,description="success",
     *          @OA\JsonContent(
     *              @OA\Property(type="array", property="data",
     *                  @OA\Items(type="object",
     *                      @OA\Property(property="id", type="number", example=1),
     *                      @OA\Property(property="numero_cuenta", type="string", example="11111111111"),
     *                      @OA\Property(property="persona_id", type="number", example=1),
     *                      @OA\Property(property="bregma_id", type="number", example=1),
     *                      @OA\Property(property="clinica_id", type="number", example=1),
     *                      @OA\Property(property="user_rol_id", type="number", example=1),
     *                      @OA\Property(type="array", property="persona",
     *                          @OA\Items(type="object",
     *                              @OA\Property(property="id", type="number", example=1),
     *                              @OA\Property(property="numero_documento", type="string", example="12345678"),
     *                              @OA\Property(property="nombres",type="string", example="Juan"),
     *                              @OA\Property(property="apellido_paterno", type="string", example="Perez"),
     *                              @OA\Property(property="apellido_materno", type="string", example="Lopez"),
     *                              @OA\Property(property="fecha_nacimiento", type="string", example="1998-12-12"),
     *                              @OA\Property(property="celular",type="string",example="987654321"),
     *                              @OA\Property(property="telefono",type="string",example="12345"),
     *                              @OA\Property(property="email", type="string", example="juan@gmail.com"),
     *                              @OA\Property(property="direccion",type="string", example="calle los alisos"),
     *                              @OA\Property(property="telefono_emergencia", type="string", example="54321"),
     *                              @OA\Property(property="contacto_emergencia", type="string", example="Maria Silva"),
     *                              @OA\Property(property="tipo_documento_id", type="number", example=1),
     *                              @OA\Property(property="distrito_id", type="number", example=1),
     *                              @OA\Property(property="distrito_domicilio_id", type="number", example="341"),
     *                              @OA\Property(property="estado_civil_id", type="number", example=1),
     *                              @OA\Property(property="religion_id", type="number", example=1),
     *                              @OA\Property(property="sexo_id", type="number", example=1),
     *                              @OA\Property(property="grado_instruccion_id", type="number", example=3)
     *                          )
     *                      ),
     *                      @OA\Property(type="array", property="bregma",
     *                          @OA\Items(type="object",
     *                              @OA\Property(property="id", type="number", example=1),
     *                              @OA\Property(property="tipo_documento_id", type="number", example=1),
     *                              @OA\Property(property="distrito_id", type="number", example=1),
     *                              @OA\Property(property="numero_documento", type="number", example=11111111),
     *                              @OA\Property(property="razon_social", type="string", example="INVERSIONES R SAC"),
     *                              @OA\Property(property="direccion", type="string", example="Los Olivos"),
     *                              @OA\Property(property="estado_pago", type="string", example="0"),
     *                              @OA\Property(property="latitud", type="string", example="19° 25′ 42″ N"),
     *                              @OA\Property(property="longitud", type="string", example="99° 7′ 39″ O"),
     *                              @OA\Property(property="estado_registro", type="string", example="A")
     *                          )
     *                      ),
     *                      @OA\Property(type="array", property="clinica",
     *                          @OA\Items(type="object",
     *                              @OA\Property(property="id",type="number",example=1),
     *                              @OA\Property(property="bregma_id",type="number",example=1),
     *                              @OA\Property(property="tipo_documento_id",type="number",example=1),
     *                              @OA\Property(property="distrito_id",type="number",example=1),
     *                              @OA\Property(property="ruc",type="string",example="1245"),
     *                              @OA\Property(property="razon_social",type="string",example="INVERSIONES R SAC"),
     *                              @OA\Property(property="responsable",type="string",example="Encargado"),
     *                              @OA\Property(property="nombre_comercial",type="string",example="Buenaventura"),
     *                              @OA\Property(property="latitud",type="string",example="19° 25′ 42″ N"),
     *                              @OA\Property(property="longitud",type="string",example="99° 7′ 39″ O"),
     *                              @OA\Property(property="direccion",type="string",example="Los Olivos 165"),
     *                              @OA\Property(property="logo",type="string",example="foto"),
     *                              @OA\Property(property="estado_registro",type="string",example="A"),
     *                          )
     *                      ),
     *                      @OA\Property(type="array",property="empresa",
     *                          @OA\Items(type="object",
     *                              @OA\Property(property="id",type="number",example=1),
     *                              @OA\Property(property="ruc",type="string",example="1245"),
     *                              @OA\Property(property="razon_social",type="string",example="INVERSIONES R SAC"),
     *                              @OA\Property(property="responsable",type="string",example="Eugenio"),
     *                              @OA\Property(property="nombre_comercial",type="string",example="Plaza Vea"),
     *                              @OA\Property(property="latitud",type="string",example="19° 25′ 42″ N"),
     *                              @OA\Property(property="longitud",type="string",example="99° 7′ 39″ O"),
     *                              @OA\Property(property="tipo_documento_id",type="number",example=1),
     *                              @OA\Property(property="distrito_id",type="number",example=1),
     *                              @OA\Property(property="direccion",type="string",example="Av. Cantogrande 415"),
     *                              @OA\Property(property="logo",type="string",example="foto"),
     *                              @OA\Property(property="estado_registro",type="string",example="A"),
     *                          )
     *                      ),
     *                      @OA\Property(type="array",property="user_rol",
     *                          @OA\Items(type="object",
     *                              @OA\Property(property="id",type="number",example=1),
     *                              @OA\Property(property="user_id",type="number",example=1),
     *                              @OA\Property(property="rol_id",type="number",example=1),
     *                              @OA\Property(property="tipo_rol",type="number",example=1),
     *                              @OA\Property( property="estado_registro",type="string",example="A")
     *                          )
     *                      ),
     *                  )
     *              ),
     *          )
     *      ),
     *      @OA\Response(response=400,description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="Detraccion no encontrada"),
     *          )
     *      )
     *  )
     */
    public function show($id)
    {
        try {
            $detraccion = Detraccion::where('estado_registro', 'A')->with(["persona", "bregma", "clinica","empresa", "user_rol"])->find($id);
            //$detraccion = Detraccion::find($id);
            if ($detraccion) {
                return response()->json($detraccion);
            } else {
                return response()->json(['resp' => 'Detraccion no encontrada']);
            }
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(["error" => "error " . $e]);
        }
    }

    /**
     *  Obtener a las detracciones registradas.
     *  @OA\Get(
     *      path="/api/mostrar/detracciones",
     *      summary="Obtener a las detracciones que estan registradas",
     *      security={{ "bearerAuth": {} }},
     *      tags={"Bregma Detracción"},
     *      @OA\response(response=200,description="success",
     *          @OA\JsonContent(
     *              @OA\Property(type="array", property="data",
     *                  @OA\Items(type="object",
     *                      @OA\Property(property="id", type="number", example=1),
     *                      @OA\Property(property="numero_cuenta", type="string", example="11111111111"),
     *                      @OA\Property(property="persona_id", type="number", example=1),
     *                      @OA\Property(property="bregma_id", type="number", example=1),
     *                      @OA\Property(property="clinica_id", type="number", example=1),
     *                      @OA\Property(property="empresa_id", type="number", example=1),
     *                      @OA\Property(property="user_rol_id", type="number", example=1),
     *                      @OA\Property(property="estado_registro", type="string", example="A"),
     *                      @OA\Property(type="array",property="persona",
     *                          @OA\Items(type="object",
     *                              @OA\Property(property="id", type="number", example="1"),
     *                              @OA\Property(property="foto", type="file", example="foto.jpg"),
     *                              @OA\Property(property="numero_documento", type="string", example="12345678"),
     *                              @OA\Property(property="nombres", type="string", example="Juan"),
     *                              @OA\Property(property="apellido_paterno", type="string", example="Perez"),
     *                              @OA\Property(property="apellido_materno", type="string", example="Lopez"),
     *                              @OA\Property(property="fecha_nacimiento", type="string", example="1998-12-12"),
     *                              @OA\Property(property="celular", type="string", example="987654321"),
     *                              @OA\Property(property="telefono", type="string", example="12345"),
     *                              @OA\Property(property="email", type="string", example="juan@gmail.com"),
     *                              @OA\Property(property="direccion", type="string", example="calle los alisos"),
     *                              @OA\Property(property="telefono_emergencia", type="string", example="54321"),
     *                              @OA\Property(property="contacto_emergencia",type="string",example="Maria Silva"),
     *                              @OA\Property(property="tipo_documento_id",type="number",example="1"),
     *                              @OA\Property(property="distrito_id", type="number", example="1"),
     *                              @OA\Property(property="distrito_domicilio_id", type="number", example="341"),
     *                              @OA\Property(property="estado_civil_id", type="number", example="1"),
     *                              @OA\Property(property="religion_id", type="number", example="1"),
     *                              @OA\Property(property="sexo_id", type="number", example="1"),
     *                              @OA\Property(property="grado_instruccion_id", type="number", example="3"),
     *                          )
     *                      ),
     *                      @OA\Property(type="array", property="bregma",
     *                          @OA\Items(type="object",
     *                              @OA\Property(property="id", type="number", example=1),
     *                              @OA\Property(property="tipo_documento_id", type="number", example=1),
     *                              @OA\Property(property="distrito_id", type="number", example=""),
     *                              @OA\Property(property="numero_documento", type="string",example="11111111"),
     *                              @OA\Property(property="razon_social", type="string", example="INVERSIONES R SAC"),
     *                              @OA\Property(property="direccion", type="string", example="Los Olivos"),
     *                              @OA\Property(property="estado_pago", type="string", example=""),
     *                              @OA\Property(property="latitud", type="string", example=""),
     *                              @OA\Property(property="longitud", type="string", example=""),
     *                              @OA\Property(property="estado_registro", type="string", example="A"),
     *                          )
     *                      ),
     *                      @OA\Property(type="array", property="clinica",
     *                          @OA\Items(type="object",
     *                              @OA\Property(property="id", type="number", example=1),
     *                              @OA\Property(property="bregma_id", type="number", example=1),
     *                              @OA\Property(property="tipo_documento_id", type="number", example=1),
     *                              @OA\Property(property="distrito_id", type="number", example=""),
     *                              @OA\Property(property="ruc", type="string", example="1245"),
     *                              @OA\Property(property="razon_social", type="string", example="INVERSIONES R SAC"),
     *                              @OA\Property(property="numero_documento", type="string", example="01245789"),
     *                              @OA\Property(property="responsable", type="string", example=""),
     *                              @OA\Property(property="nombre_comercial", type="string", example=""),
     *                              @OA\Property(property="latitud", type="string", example=""),
     *                              @OA\Property(property="longitud", type="string", example=""),
     *                              @OA\Property(property="direccion", type="string", example=""),
     *                              @OA\Property(property="logo",type="string", example=""),
     *                              @OA\Property(property="estado_registro", type="string", example="A"),
     *                              @OA\Property(property="hospital_id", type="number", example=1),
     *                          )
     *                      ),
     *                      @OA\Property(type="array",property="user_rol",
     *                          @OA\Items(type="object",
     *                              @OA\Property(property="id",type="number",example=1),
     *                              @OA\Property(property="user_id",type="number",example=1),
     *                              @OA\Property(property="rol_id",type="number",example=1),
     *                              @OA\Property(property="tipo_rol",type="number",example=1),
     *                              @OA\Property(property="estado_registro",type="string",example="A"),
     *                          )
     *                      ), 
     *                  )
     *              ),
     *              @OA\Property(property="size",type="number",example=1),
     *          )
     *      ),
     *      @OA\Response(response=400, description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="Error al obtener las detracciones"),
     *          )
     *      )
     *  )
     */
    public function mostrarDetracciones()
    {
        try {
            $detraccion = Detraccion::with(["persona", "bregma", "clinica", "user_rol"])->where('estado_registro', 'A')->with(["bregma"])->get();
            return response()->json(["data" => $detraccion, "size" => count($detraccion)]);
        } catch (Exception $e) {
            return response()->json(["error" => $e]);
        }
    }

    /**
     *  Crear detraccion.
     *  @OA\Post(
     *      path="/api/detraccion/create",
     *      summary="Crear detraccion",
     *      security={{ "bearerAuth": {} }},
     *      tags={"Bregma Detracción"},
     *      @OA\Parameter(description="Número de cuenta de detracción", @OA\Schema(type="number"), name="numero_cuenta", in="query", required = false, example=12345678910),
     *      @OA\RequestBody(
     *          @OA\MediaType(mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(type="object",
     *                      @OA\Property(property="numero_cuenta", type="number"),
     *                  ),
     *                  example={
     *                      "numero_cuenta": "12345678910",
     *                  }
     *              )
     *          )
     *      ),
     *      @OA\Response(response=200, description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="Detracción creada correctamente"),
     *          )
     *      ),
     *      @OA\Response(response=400, description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="Número de cuenta ya existe"),
     *          )
     *      ),
     *      @OA\Response(response=500, description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="Error al crear la detracción, intente otra vez!"),
     *          )
     *      )
     *  )
     */

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $usuario = User::with('persona', 'user_rol.rol')->find(auth()->user()->id);
            if (!$request->numero_cuenta) return response()->json(["resp" => "Ingrese un numero de cuenta"], 400);
            $exist_num_cuenta = Detraccion::where('numero_cuenta', $request->numero_cuenta)
                ->where('persona_id', '!=', $usuario->persona->id)->first();
            if ($exist_num_cuenta) return response()->json(["resp" => "Número de cuenta ya existe!"], 401);
            $detraccion = Detraccion::updateOrCreate([
                'persona_id' => $usuario->persona->id,
                'user_rol_id' => $usuario->user_rol[0]->id,
            ], [
                'numero_cuenta' => $request->numero_cuenta,
                'bregma_id' => $usuario->user_rol[0]->rol->bregma_id,
                'clinica_id' => $usuario->user_rol[0]->rol->clinica_id,
                'empresa_id' => $usuario->user_rol[0]->rol->empresa_id,
            ])->save();
            DB::commit();
            return response()->json(["resp" => "Detracción creada correctamente."]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["resp" => "error", "error" => "Error al crear la detracción, intente otra vez!" . $e]);
        }
    }

    /**
     *  Actualizar detraccion.
     *  @OA\Put(
     *      path="/api/detraccion/update/{iddetraccion}",
     *      summary="Actualizar detraccion",
     *      security={{ "bearerAuth": {} }},
     *      tags={"Bregma Detracción"},
     *      @OA\Parameter(description="ID de la detracción registrado", @OA\Schema(type="number"), name="iddetraccion", in="path", required=true, example=2),
     *      @OA\Parameter(description="Ingrese un numero de cuenta", @OA\Schema(type="string"), name="numero_cuenta", in="query", required=true, example="12345678910"),
     *      @OA\Parameter(description="Ingrese un id de persona", @OA\Schema(type="number"), name="persona_id", in="query", required=false, example=""),
     *      @OA\Parameter(description="Ingrese un id de bregma", @OA\Schema(type="number"),name="bregma_id",in="query",required=true,example=1),
     *      @OA\Parameter(description="Ingrese un id de clinica", @OA\Schema(type="number"), name="clinica_id", in="query", required=false, example=""),
     *      @OA\Parameter(description="Ingrese un id de user_rol", @OA\Schema(type="number"), name="user_rol_id", in="query", required=false, example=""),
     *      @OA\RequestBody(
    *           @OA\MediaType(
    *               mediaType="application/json",
    *               @OA\Schema(
    *                   @OA\Property(
    *                       type="object",
    *                       @OA\Property(property="id", type="number"),
    *                       @OA\Property(property="numero_cuenta", type="number"),
    *                       @OA\Property(property="persona_id", type="number"),
    *                       @OA\Property(property="bregma_id", type="number"),
    *                       @OA\Property(property="clinica_id", type="number"),
    *                       @OA\Property(property="user_rol_id", type="number"),
    *                   ),
     *                  example={
     *                      "numero_cuenta": 12345678910,
     *                      "persona_id":"",
     *                      "bregma_id":1,
     *                      "clinica_id":"",
     *                      "user_rol_id":"",
     *                  }
     *              )
     *          )
     *      ),
     *      @OA\Response(response=200, description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="Detraccion actualizada correctamente"),
     *          )
     *      ),
     *      @OA\Response(response=400, description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="No ingreso un número de cuenta"),
     *          )
     *      ),
     *      @OA\Response(response=401, description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="No existe registro con ese id"),
     *          )
     *      ),
     *      @OA\Response(response=402, description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="Esta detraccion pertenece a otra entidad"),
     *          )
     *      ),
     *      @OA\Response(response=403, description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="El numero de detraccion ya esta en uso"),
     *          )
     *      )
     *  )
     */
    public function updateDetraccion(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            if (strlen($request->numero_cuenta) == 0) return response()->json(["resp" => "No ingreso un número de cuenta"], 400);
            $detraccion = Detraccion::find($id);
            if (!$detraccion) return response()->json(["resp" => "No existe registro con ese id"], 401);
            $usuario = User::with('persona', 'user_rol.rol')->find(auth()->user()->id);
            return response()->json($usuario);
            if ($detraccion->persona_id != $usuario->persona_id) return response()->json(["resp"=>"Esta detraccion pertenece a otra entidad"],402);
            $exist_num_cuenta = Detraccion::where('numero_cuenta', $request->numero_cuenta)
                ->where('persona_id', '!=', $usuario->persona->id)->first();
            if ($exist_num_cuenta) return response()->json(["resp" => "El numero de detraccion ya esta en uso"],403);
            $detraccion = Detraccion::updateOrCreate([
                'bregma_id' => $usuario->user_rol[0]->rol->bregma_id
            ], [
                'numero_cuenta' => $request->numero_cuenta,
                'clinica_id' => $usuario->user_rol[0]->rol->clinica_id,
                'empresa_id' => $usuario->user_rol[0]->rol->empresa_id,
                'user_rol_id' => $usuario->user_rol[0]->id,
                'persona_id' => $usuario->persona->id
            ])->save();
            DB::commit();
            return response()->json(["resp" => "Detracción creada correctamente."],200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(["resp" => "error", "error" => "Error al crear la detracción, intente otra vez!" . $e]);
        }
    }

    /**
     *  Eliminar detracción.
     *  @OA\Delete (
     *      path="/api/detraccion/delete/{iddetraccion}",
     *      summary="Eliminar la detracción registrada",
     *      security={{ "bearerAuth": {} }},
     *      tags={"Bregma Detracción"},
     *      @OA\Parameter(description="ID de la detracción registrada", @OA\Schema(type="number"), name="iddetraccion", in="path", required=true, example=2),
     *      @OA\Response(response=200,description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="Detraccion eliminada correctamente"),
     *          )
     *      ),
     *      @OA\Response(response=400, description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="Detracción a eliminar no encontrado o no existe!"),
     *          )
     *      )
     *  )
     */
    public function deleteDetraccion($id)
    {
        DB::beginTransaction();
        try {
            $detraccion = Detraccion::find($id);
            if ($detraccion) {
                $detraccion->fill([
                    'estado_registro' => 'I',
                ])->save();
                DB::commit();
                return response()->json(["resp" => "Detracción eliminada correctamente"]);
            } else {
                return response()->json(["resp" => "Detracción a eliminar no encontrado o no existe!"]);
            }
            /*if($detraccion){
                $detraccion->delete();
                DB::commit();
                return response()->json(["resp" => "Detraccion eliminada correctamente"]);
            }else{
                return response()->json(["resp" => "El detraccion no existe!"]);
            }*/
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["resp" => "error", "error" => $e]);
        }
    }
}
