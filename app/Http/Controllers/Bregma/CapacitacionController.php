<?php

namespace App\Http\Controllers\Bregma;

use App\Http\Controllers\Controller;
use App\Models\Capacitacion;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CapacitacionController extends Controller
{
    /**
     *  Crear una capacitación para bregma
     * @OA\Post(
     *  path="/api/capacitacion/create",
     *  summary="Crear una Capacitación con sesión iniciada",
     *  security={{ "bearerAuth": {} }},
     *  tags={"Bregma - Capacitación"},
     *      @OA\Parameter(description="nombre de capacitación",
     *          @OA\Schema(type="string"), name="nombre", in="query", required=true, example="Capacitación 1"),
     *      @OA\Parameter(description="precio referencial",
     *          @OA\Schema(type="double"), name="precio_referencial", in="query", required=false, example=15.69),
     *      @OA\Parameter(description="precio mensual",
     *          @OA\Schema(type="double"), name="precio_mensual", in="query", required=false, example=59.26),
     *      @OA\Parameter(description="precio anual",
     *          @OA\Schema(type="double"), name="precio_anual", in="query", required=false, example=254.55),
     *      @OA\Parameter(description="Carga un icono",
     *          @OA\Schema(type="file"), name="icono", in="query", required=false, example=""
     *      ),
     *      @OA\RequestBody(
     *          @OA\MediaType(mediaType="aplication/json",
     *              @OA\Schema(
     *                  @OA\Property(type="object",
     *                      @OA\Property(property="nombre", type="string"),
     *                      @OA\Property(property="precio_referencial", type="double"),
     *                      @OA\Property(property="precio_mensual", type="double"),
     *                      @OA\Property(property="precio_anual", type="double"),
     *                      @OA\Property(property="icono", type="file"),
     *                  ),
     *                  example={
     *                      "nombre": "Capacitación 1",
     *                      "precio_referencial": 15.69,
     *                      "precio_mensual": 59.26,
     *                      "precio_anual": 254.55,
     *                      "icono": "",
     *                  }
     *              )
     *          )
     *      ),
     *      @OA\Response(response=200, description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="Capacitación creada correctamente"),
     *          )
     *      ),
     *      @OA\Response(response=400, description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="Error al crear Capacitación, intente más tarde"),
     *          )
     *      ),
     * )
     */
    public function create(Request $request)
    {
        DB::beginTransaction();
        try {
            $usuario = User::with('user_rol.rol')->where('id', auth()->user()->id)->first();
            $capacitacion = Capacitacion::create([
                "bregma_id" => $usuario->user_rol[0]->rol->bregma_id,
                "nombre" => $request->nombre,
                "precio_referencial" => $request->precio_referencial,
                "precio_mensual" => $request->precio_mensual,
                "precio_anual" => $request->precio_anual,
                //"icono" => $request->icono,
            ]);

            if ($request->hasFile('icono')) {
                $path = $request->icono->storeAs('public/capacitacion', $capacitacion->id . '.' . $request->icono->extension());
                $image = $capacitacion->id . '.' . $request->icono->extension();
                $capacitacion->icono = $image;
                $capacitacion->save();
            }
            DB::commit();
            return response()->json(["resp" => "Capacitación creada correctamente"], 200);

        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["resp" => "error", "error" => "Error al crear Capacitación, intente más tarde" . $e], 400);
        }
    }

    /**
     *  Actializar el capacitación
     * @OA\Post(
     *  path ="/api/capacitacion/update/{idcapacitacion}",
     *  summary ="Actualizar el Capacitación con sesión iniciada",
     *  security = {{ "bearerAuth": {} }},
     *  tags = {"Bregma - Capacitación"},
     *      @OA\Parameter(description="id de capacitacion a actualizar",
     *          @OA\Schema(type="number"), name="idcapacitacion", in="path", required=true, example=1),
     *      @OA\Parameter(description="nombre de capacitación",
     *          @OA\Schema(type="string"), name="nombre", in="query", required=true, example="Cpacitación 1"),
     *      @OA\Parameter(description="precio referencial",
     *          @OA\Schema(type="double"), name="precio_referencial", in="query", required=false, example="15.69"),
     *      @OA\Parameter(description="precio mensual",
     *          @OA\Schema(type="double"), name="precio_mensual", in="query", required=false, example="59.26"
     *      ),
     *      @OA\Parameter(description="precio anual",
     *          @OA\Schema(type="double"), name="precio_anual", in="query", required=false, example="254.55"
     *      ),
     *      @OA\Parameter(description="Carga un icono",
     *          @OA\Schema(type="file"), name="icono", in="query", required=false, example=""
     *      ),
     *      @OA\RequestBody(
     *          @OA\MediaType(mediaType="aplication/json",
     *              @OA\Schema(
     *                  @OA\Property(type="object",
     *                      @OA\Property(property="nombre", type="string"),
     *                      @OA\Property(property="precio_referencial", type="double"),
     *                      @OA\Property(property="precio_mensual", type="double"),
     *                      @OA\Property(property="precio_anual", type="double"),
     *                      @OA\Property(property="icono", type="file"),
     *                  ),
     *                  example={
     *                      "nombre": "Capacitación 1",
     *                      "precio_referencial": 15.69,
     *                      "precio_mensual": 59.26,
     *                      "precio_anual": 254.55,
     *                      "icono": "",
     *                  }
     *              )
     *          )
     *      ),
     *      @OA\Response(response=200, description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="Capacitación actualizado correctamente"),
     *          )
     *      ),
     *      @OA\Response(response=400, description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="Capacitación no encontrado, o no existe"),
     *          )
     *      ),
     *      @OA\Response(response=500, description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="Error al actualizar capacitación, intente otra vez"),
     *          )
     *      ),
     * )
     */
    public function update(Request $request, $idcapacitacion)
    {
        DB::beginTransaction();
        try {
            $capacitacion = Capacitacion::find($idcapacitacion);

            if(!$capacitacion){
                return response()->json(["resp" => "Capacitación no encontrado, o no existe"], 400);
            }else{
                $capacitacion->fill([
                    "nombre" => $request->nombre,
                    "precio_referencial" => $request->precio_referencial,
                    "precio_mensual" => $request->precio_mensual,
                    "precio_anual" => $request->precio_anual,
                ])->save();
            }

            if ($request->hasFile('icono')) {
                Storage::delete('capacitacion/' . $capacitacion->getRawOriginal('icono'));
                $image = $capacitacion->id . now()->format('Ymd_hms') . '.' . $request->icono->extension();
                $request->file('icono')->storeAs('capacitacion/', $image);
                $capacitacion->icono = $image;
                $capacitacion->save();
            }

            DB::commit();
            return response()->json(["resp" => "Capacitación actualizado correctamente"], 200);

        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["resp" => "error", "error" => "Error al actualizar capacitación, intente otra vez" . $e], 500);
        }
    }

    /**
     *  Eliminar una Capacitación
     * @OA\Delete(
     *  path="/api/capacitacion/delete/{idcapacitacion}",
     *  summary = "Eliminar una Capacitación con sesión iniciado",
     *  security={{ "bearerAuth": {} }},
     *  tags={"Bregma - Capacitación"},
     *      @OA\Parameter(description="Id de capacitación a eliminar",
     *          @OA\Schema(type="number"), name="idcapacitacion", in="path", required=true, example=1),
     *
     *      @OA\Response(response=200,description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="Capacitación eliminado correctamente."),
     *          )
     *      ),
     *      @OA\Response(response=400,description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="Capacitación a eliminar no encontrado."),
     *          )
     *      ),
     *      @OA\Response(response=500,description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="Error al eliminar capacitación, intente otra vez"),
     *          )
     *      ),
     * )
     */
    public function delete($idcapacitacion)
    {
        DB::beginTransaction();
        try {
            $capacitacion = Capacitacion::find($idcapacitacion);

            if(!$capacitacion){
                return response()->json(["resp" => "Capacitación a eliminar no encontrado."], 400);
            }
            $capacitacion->fill([
                "estado_registro" => "I",
            ])->save();

            DB::commit();
            return response()->json(["resp" => "Capacitación eliminado correctamente."], 200);

        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["resp" => "error", "error" => "Error al eliminar capacitación, intente otra vez" . $e], 500);
        }
    }

    /**
     *  Mostrar las Capacitaciones
     * @OA\Get(
     *  path="/api/capacitacion/get",
     *  summary="Mostrar las Capacitaciones con sesión iniciado",
     *  security = {{ "bearerAuth": {}  }},
     *  tags={"Bregma - Capacitación"},
     *      @OA\Response(response= 200, description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="id", type="number", example=1),
     *              @OA\Property(property="bregma_id", type="number", example=1),
     *              @OA\Property(property="nombre", type="string", example="Capacitación 1"),
     *              @OA\Property(property="precio_referencial", type="double", example=15.23),
     *              @OA\Property(property="precio_mensual", type="double", example=86.59),
     *              @OA\Property(property="precio_anual", type="double", example=159.99),
     *              @OA\Property(property="icono", type="string", example=""),
     *              @OA\Property(property="estado_registro", type="string", example="A"),
     *              @OA\Property(type="array",property="bregma",
     *                  @OA\Items(type="object",
     *                      @OA\Property(property="id", type="number", example=1),
     *                      @OA\Property(property="tipo_documento_id", type="number", example=1),
     *                      @OA\Property(property="distrito_id", type="number", example=1),
     *                      @OA\Property(property="numero_documento", type="string", example="Documento Nacional de Identidad"),
     *                      @OA\Property(property="razon_social", type="string", example="PE"),
     *                      @OA\Property(property="direccion", type="string", example="Jr. Girasol"),
     *                      @OA\Property(property="estado_pago", type="string", example="A"),
     *                      @OA\Property(property="latitud", type="string", example="a"),
     *                      @OA\Property(property="longitud", type="string", example="b"),
     *                      @OA\Property(property="estado_registro", type="string", example="A"),
     *                      @OA\Property(type="array",property="tipo_documento",
     *                          @OA\Items(type="object",
     *                              @OA\Property(property="id", type="number", example=1),
     *                              @OA\Property(property="nombre", type="string", example="DNI"),
     *                              @OA\Property(property="codigo", type="string", example="PE"),
     *                              @OA\Property(property="descripcion", type="string", example="Documento Nacional de Identidad"),
     *                              @OA\Property(property="estado_registro", type="string", example="A"),
     *                          )
     *                      ),
     *                  )
     *              ),
     *              @OA\Property(type="count", property="size", example="1")
     *          )
     *      ),
     *      @OA\Response(response=400, description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="Error al llamar las capacitaciones"),
     *          )
     *      ),
     * )
     */
    public function get()
    {
        try {
            $usuario = User::with('user_rol.rol')->where('id', auth()->user()->id)->first();

            $capacitacion = Capacitacion::with('bregma.tipo_documento')->where('bregma_id', $usuario->user_rol[0]->rol->bregma_id)
                ->where('estado_registro', 'A')->get();

            return response()->json(["data" => $capacitacion, "size" => (count($capacitacion))], 200);

        } catch (Exception $e) {
            return response()->json(["resp" => "error", "error" => "Error al llamar las capacitaciones" . $e], 400);
        }
    }

}
