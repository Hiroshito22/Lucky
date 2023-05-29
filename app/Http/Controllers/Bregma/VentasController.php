<?php

namespace App\Http\Controllers\Bregma;

use App\Http\Controllers\Controller;
use App\Models\BregmaPaquete;
use App\Models\Contrato;
use App\Models\EstadoVenta;
use App\Models\Lead;
use App\Models\Paquete;
use App\Models\Proforma;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VentasController extends Controller
{
    /**
     * Asignar paquete
     *  @OA\Post(
     *      path = "/api/bregma/asignar/paquete/{idContrato}",
     *      summary = "Asignar paquete",
     *      security = {{ "bearerAuth": {} }},
     *      tags = {"Bregma - Ventas"},
     *      @OA\Parameter(description="ID del contrato entre bregma y la clinica",
     *          @OA\Schema(type="number"),name="idContrato",in="path",required= true,example=2),
     *      @OA\Parameter(description = "bregma_paquete_id",
     *          @OA\Schema(type = "number"), name = "bregma_paquete_id", in = "query", required = true, example = 1
     *      ),
     *      @OA\Parameter(description = "Un breve descripción",
     *          @OA\Schema(type = "string"), name = "descripcion", in = "query", required = false, example = "Venta realizado"
     *      ),
     *      @OA\Parameter(description = "nombre",
     *          @OA\Schema(type = "string"), name = "nombre", in = "query", required = false, example = "Paquete 1"
     *      ),
     *      @OA\RequestBody(
     *          @OA\MediaType(mediaType = "application/json",
     *              @OA\Schema(
     *                  @OA\Property(type = "object",
     *                      @OA\Property(property = "bregma_paquete_id", type = "number"),
     *                      @OA\Property(property = "descripcion", type = "string"),
     *                      @OA\Property(property = "nombre", type = "string"),
     *                  ),
     *                  example = {
     *                      "bregma_paquete_id": 1,
     *                      "descripcion": "Venta realizado",
     *                      "nombre": "Paquete 1",
     *                  }
     *              )
     *          )
     *      ),
     *      @OA\Response(response=200, description="success",
     *          @OA\JsonContent(
     *          @OA\Property(property="resp", type="string", example="Paquete Asignado correctamente"),
     *          )
     *      ),
     *      @OA\Response(response=400, description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="Error al asignar paquete, intente más tarde"),
     *          )
     *      ),
     *  )
     */
    public function asignarPaquete($idContrato, Request $request)
    {
        DB::beginTransaction();
        try {
            $datos = User::with('user_rol.rol')->where('id', auth()->user()->id)->first();
            //return response()->json($datos);
            $contrato = Contrato::with('clinica', 'tipo_cliente')->find($idContrato);
            // return response()->json($contrato);
            //$bregmaPaquete = BregmaPaquete::with('bregma', 'bregma_servicio')->where('estado_registro', 'A')->first();
            $bregmaPaquete = BregmaPaquete::with('bregma', 'bregma_servicio')->where('id', $request->bregma_paquete_id)->where('estado_registro', 'A')->first();

            $contrato->bregma_paquete_id = $bregmaPaquete->id;
            $contrato->save();
            $lead = Lead::updateOrCreate([
                'contrato_id'=>$contrato->id,
                //'bregma_paquete_id'=>$bregmaPaquete->id,
                'descripcion'=>$request->descripcion,
            ]);
            $lead->bregma_paquete_id = $bregmaPaquete->id;
            $lead->save();

            $estadoVenta = EstadoVenta::updateOrCreate([
                'user_rol_id'=>$datos->user_rol[0]->id,
                'lead_id' => $lead->id,
                'nombre'=>$request->nombre,
                'descripcion'=>$request->descripcion,
            ]);
            $estadoVenta->save();

            $proforma = Proforma::updateOrCreate([
                'lead_id'=>$lead->id,
                'tipo_cliente_id'=>$contrato->tipo_cliente->id,
                //'bregma_paquete_id'=>$bregmaPaquete->id,
                'codigo'=>$request->codigo,
                'estado'=>$request->estado,
                'tipo_negociacion'=>$request->tipo_negociacion,
                'comentario'=>$request->comentario,
                'documento_proforma'=>$request->documento_proforma,
                'documento_evidencia'=>$request->documento_evidencia,
            ]);
            $proforma->bregma_paquete_id = $bregmaPaquete->id;
            $proforma->save();
            DB::commit();
            return response()->json(["resp" => "Paquete Asignado correctamente"], 200);

        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["resp" => "Error al asignar paquete", "error" => "" . $e], 500);
        }
    }

    /**
     * Mostrar Datos de paquete asignados a una clinica
     * @OA\Get (
     *     path="/api/my/paquetes/get",
     *     summary="Muestra datos de paquete asignados",
     *     security={{ "bearerAuth": {} }},
     *     tags={"Bregma - Ventas"},
     *      @OA\Response(response=200, description="success",
     *          @OA\JsonContent(
     *              @OA\Property(type="array", property="data",
     *                  @OA\Items(type="object",
     *                      @OA\Property(property="id", type="number", example=1),
     *                      @OA\Property(property="bregma_id", type="number", example=1),
     *                      @OA\Property(property="clinica_id", type="number", example=2),
     *                      @OA\Property(property="bregma_servicio_id", type="number", example=1),
     *                      @OA\Property(property="nombre", type="string", example="Bregma Paquete 1"),
     *                      @OA\Property(property="precio_mensual",type="float",example="20"),
     *                      @OA\Property(property="precio_anual",type="float",example="100"),
     *                      @OA\Property(property="estado_registro", type="char", example="A"),
     *
     *                      @OA\Property(type="array", property="clinica",
     *                          @OA\Items(type="object",
     *                              @OA\Property(property="id",type="integer",example="1"),
     *                              @OA\Property(property="tipo_documento_id",type="integer",example="1"),
     *                              @OA\Property(property="distrito_id",type="integer",example=1),
     *                              @OA\Property(property="razon_social",type="string",example="CLÍNICA NUEVO"),
     *                              @OA\Property(property="numero_documento",type="integer",example="44444444"),
     *                              @OA\Property(property="responsable",type="string",example=""),
     *                              @OA\Property(property="nombre_comercial",type="string",example=""),
     *                              @OA\Property(property="latitud",type="string",example=""),
     *                              @OA\Property(property="longitud",type="string",example=""),
     *                              @OA\Property(property="direccion",type="string",example=""),
     *                              @OA\Property(property="logo",type="string",example=""),
     *                              @OA\Property(property="estado_pago",type="char",example="A"),
     *                              @OA\Property(property="estado_registro",type="char",example="A"),
     *                          )
     *                      ),
     *                      @OA\Property(type="array", property="bregma_servicio",
     *                          @OA\Items(type="object",
     *                              @OA\Property(property="id",type="integer",example="1"),
     *                              @OA\Property(property="bregma_id", type="number", example=1),
     *                              @OA\Property(property="icono",type="string",example=""),
     *                              @OA\Property(property="nombre", type="string", example="Bregma servicio 1"),
     *                              @OA\Property(property="descripcion", type="string", example=""),
     *                              @OA\Property(property="parent_id", type="number", example=1),
     *                              @OA\Property(property="estado_registro",type="char",example="A"),
     *                          )
     *                      ),
     *                  )
     *              ),
     *              @OA\Property(type="count", property="size", example="1")
     *          )
     *      ),
     *      @OA\Response(response=400, description="invalid",
     *         @OA\JsonContent(
     *             @OA\Property(property="resp", type="string", example="Paquete no se encontro o no existe"),
     *         )
     *      ),
     *      @OA\Response(response=500, description="invalid",
     *         @OA\JsonContent(
     *             @OA\Property(property="resp", type="string", example="Error al llamar paquete asignado, intente otra vez!"),
     *         ),
     *      )
     * )
     */
    public function getMyPaquetes(){
        try {
            $user = User::with('user_rol.rol')->where('id', auth()->user()->id)->first();
            //return response()->json($user);
            $clinica = $user->user_rol[0]->rol->clinica_id;

            $paquete = BregmaPaquete::with('clinica','bregma_servicio')->where('clinica_id', $clinica,)->where('estado_registro', 'A')->get();


            if(!$paquete){
                return response()->json(["resp"=>"Paquete no se encontro o no existe"]);
            }

            //$paquetes = Paquete::with(['clinica'])->where('clinica_id', $user->id)->first();
            return response()->json(["data" => $paquete, "size" => count($paquete)], 200);
        } catch (Exception $e) {
            return response()->json(["resp" => "error", "error" => "Error al llamar paquete asignado, intente otra vez!" . $e], 500);
        }

    }
}
