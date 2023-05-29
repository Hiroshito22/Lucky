<?php

namespace App\Http\Controllers\Oftalmologia;

use App\Http\Controllers\Controller;
use App\Models\AgudezaVisual;
use App\Models\Clinica;
use App\Models\CorreccionNo;
use App\Models\CorreccionSi;
use App\Models\ExamenExterno;
use App\Models\MedidaCerca;
use App\Models\MedidaLejos;
use App\Models\OpcionEnfermedadOcular;
use App\Models\OpcionOjoDerecho;
use App\Models\OpcionOjoIzquierdo;
use App\Models\OpcionReflejosPupilares;
use App\Models\OpcionVisionColores;
use App\Models\Tonometria;
use App\Models\VisionCerca;
use App\Models\VisionLejos;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AgudezaVisualController extends Controller
{

    /**
     *  Muestra todos los registros de agudeza visual
     *  @OA\Get (
     *      path="/api/oftalmologia/agudezavisual/get",
     *      summary="Mostrando Datos de Agudeza Visual",
     *      security={{ "bearerAuth":{} }},
     *      tags={"Oftalmologia - AgudezaVisual"},
     *      @OA\Response(response=200,description="success",
     *          @OA\JsonContent(
     *              @OA\Property(type="array", property="data",
     *                  @OA\Items(type="object",
     *                      @OA\Property(property="id", type="integer", example=1),
     *                      @OA\Property(property="clinica_servicio_id", type="integer", example=1),
     *                      @OA\Property(property="correccion_si_id", type="integer", example=1),
     *                      @OA\Property(property="correccion_no_id", type="integer", example=1),
     *                      @OA\Property(property="opcion_vision_colores_id", type="integer", example=1),
     *                      @OA\Property(property="opcion_reflejos_pupilares_id", type="integer", example=1),
     *                      @OA\Property(property="opcion_enfermedad_ocular_id", type="integer", example=1),
     *                      @OA\Property(property="examen_externo_id", type="integer", example=1),
     *                      @OA\Property(property="tonometria_id", type="integer", example=1),
     *                      @OA\Property(property="estado_registro", type="string", example="A"),
     *                      @OA\Property(type="object", property="clinica_servicio",
     *                          @OA\Property(property="id", type="integer", example=1),
     *                          @OA\Property(property="servicio_id", type="integer", example=null),
     *                          @OA\Property(property="paquete_clinica_id", type="integer", example=null),
     *                          @OA\Property(property="clinica_id", type="integer", example=1),
     *                          @OA\Property(property="ficha_medico_ocupacional_id", type="integer", example=null),
     *                          @OA\Property(property="nombre", type="string", example="Padre General 1"),
     *                          @OA\Property(property="icono", type="string", example=null),
     *                          @OA\Property(property="parent_id", type="integer", example=null),
     *                          @OA\Property(property="estado_registro", type="char", example="A")
     *                      ),
     *                      @OA\Property(type="object", property="correccion_si",
     *                          @OA\Property(property="id", type="integer", example=1),
     *                          @OA\Property(property="vision_lejos_id", type="integer", example=3),
     *                          @OA\Property(property="vision_cerca_id", type="integer", example=4),
     *                          @OA\Property(property="estado_registro", type="char", example="A"),
     *                           @OA\Property(type="object", property="vision_lejos",
     *                              @OA\Property(property="id", type="integer", example=3),
     *                              @OA\Property(property="ojo_derecho_id", type="integer", example=1),
     *                              @OA\Property(property="ojo_izquierdo_id", type="integer", example=1),
     *                              @OA\Property(property="binocular_id", type="integer", example=1),
     *                              @OA\Property(property="estado_registro", type="char", example="A"),
     *                              @OA\Property(type="object",property="medida_derecho",
     *                                      @OA\Property(property="id", type="integer", example=1),
     *                                      @OA\Property(property="medida", type="string", example="20/10"),
     *                                      @OA\Property(property="estado_registro", type="char", example="A")
     *                              ),
     *                              @OA\Property(type="object",property="medida_izquierdo",
     *                                      @OA\Property(property="id", type="integer", example=1),
     *                                      @OA\Property(property="medida", type="string", example="20/10"),
     *                                      @OA\Property(property="estado_registro", type="char", example="A")
     *                              ),
     *                              @OA\Property(type="object",property="binocular",
     *                                      @OA\Property(property="id", type="integer", example=1),
     *                                      @OA\Property(property="medida", type="string", example="20/10"),
     *                                      @OA\Property(property="estado_registro", type="char", example="A")
     *                              )
     *                          ),
     *                          @OA\Property(type="object", property="vision_cerca",
     *                              @OA\Property(property="id", type="integer", example=4),
     *                              @OA\Property(property="ojo_derecho_id", type="integer", example=1),
     *                              @OA\Property(property="ojo_izquierdo_id", type="integer", example=1),
     *                              @OA\Property(property="binocular_id", type="integer", example=1),
     *                              @OA\Property(property="estado_registro", type="char", example="A"),
     *                              @OA\Property(type="object",property="medida_derecho",
     *                                      @OA\Property(property="id", type="integer", example=1),
     *                                      @OA\Property(property="medida", type="string", example="20/10"),
     *                                      @OA\Property(property="estado_registro", type="char", example="A")
     *                              ),
     *                              @OA\Property(type="object",property="medida_izquierdo",
     *                                      @OA\Property(property="id", type="integer", example=1),
     *                                      @OA\Property(property="medida", type="string", example="20/10"),
     *                                      @OA\Property(property="estado_registro", type="char", example="A")
     *                              ),
     *                              @OA\Property(type="object",property="binocular",
     *                                      @OA\Property(property="id", type="integer", example=1),
     *                                      @OA\Property(property="medida", type="string", example="20/10"),
     *                                      @OA\Property(property="estado_registro", type="char", example="A")
     *                              )
     *                          )
     *                      ),
     *                      @OA\Property(type="object", property="correccion_no",
     *                          @OA\Property(property="id", type="integer", example=1),
     *                          @OA\Property(property="vision_lejos_id", type="integer", example=1),
     *                          @OA\Property(property="vision_cerca_id", type="integer", example=2),
     *                          @OA\Property(property="estado_registro", type="char", example="A"),
     *                           @OA\Property(type="object", property="vision_lejos",
     *                              @OA\Property(property="id", type="integer", example=1),
     *                              @OA\Property(property="ojo_derecho_id", type="integer", example=1),
     *                              @OA\Property(property="ojo_izquierdo_id", type="integer", example=1),
     *                              @OA\Property(property="binocular_id", type="integer", example=1),
     *                              @OA\Property(property="estado_registro", type="char", example="A"),
     *                              @OA\Property(type="object",property="medida_derecho",
     *                                      @OA\Property(property="id", type="integer", example=1),
     *                                      @OA\Property(property="medida", type="string", example="20/10"),
     *                                      @OA\Property(property="estado_registro", type="char", example="A")
     *                              ),
     *                              @OA\Property(type="object",property="medida_izquierdo",
     *                                      @OA\Property(property="id", type="integer", example=1),
     *                                      @OA\Property(property="medida", type="string", example="20/10"),
     *                                      @OA\Property(property="estado_registro", type="char", example="A")
     *                              ),
     *                              @OA\Property(type="object",property="binocular",
     *                                      @OA\Property(property="id", type="integer", example=1),
     *                                      @OA\Property(property="medida", type="string", example="20/10"),
     *                                      @OA\Property(property="estado_registro", type="char", example="A")
     *                              )
     *                          ),
     *                          @OA\Property(type="object", property="vision_cerca",
     *                              @OA\Property(property="id", type="integer", example=2),
     *                              @OA\Property(property="ojo_derecho_id", type="integer", example=1),
     *                              @OA\Property(property="ojo_izquierdo_id", type="integer", example=1),
     *                              @OA\Property(property="binocular_id", type="integer", example=1),
     *                              @OA\Property(property="estado_registro", type="char", example="A"),
     *                              @OA\Property(type="object",property="medida_derecho",
     *                                      @OA\Property(property="id", type="integer", example=1),
     *                                      @OA\Property(property="medida", type="string", example="20/10"),
     *                                      @OA\Property(property="estado_registro", type="char", example="A")
     *                              ),
     *                              @OA\Property(type="object",property="medida_izquierdo",
     *                                      @OA\Property(property="id", type="integer", example=1),
     *                                      @OA\Property(property="medida", type="string", example="20/10"),
     *                                      @OA\Property(property="estado_registro", type="char", example="A")
     *                              ),
     *                              @OA\Property(type="object",property="binocular",
     *                                      @OA\Property(property="id", type="integer", example=1),
     *                                      @OA\Property(property="medida", type="string", example="20/10"),
     *                                      @OA\Property(property="estado_registro", type="char", example="A")
     *                              )
     *                          )
     *                         ),
     *                      @OA\Property(type="object", property="opcion_vision_colores",
     *                          @OA\Property(property="id", type="integer", example=1),
     *                          @OA\Property(property="nombre", type="string", example="Ausente"),
     *                          @OA\Property(property="estado_registro", type="char", example="A"),
     *                      ),
     *                      @OA\Property(type="object", property="opcion_reflejos_pupilares",
     *                          @OA\Property(property="id", type="integer", example=1),
     *                          @OA\Property(property="nombre", type="string", example="Ausente"),
     *                          @OA\Property(property="estado_registro", type="char", example="A"),
     *                      ),
     *                      @OA\Property(type="object", property="opcion_enfermedad_ocular",
     *                          @OA\Property(property="id", type="integer", example=1),
     *                          @OA\Property(property="nombre", type="string", example="Ausente"),
     *                          @OA\Property(property="estado_registro", type="char", example="A"),
     *                      ),
     *                      @OA\Property(type="object", property="examen_externo",
     *                          @OA\Property(property="id", type="integer", example=1),
     *                          @OA\Property(property="opcion_ojo_derecho_id", type="integer", example=1),
     *                          @OA\Property(property="opcion_ojo_izquierdo_id", type="integer", example=1),
     *                          @OA\Property(property="examen_clinico", type="integer", example=null),
     *                          @OA\Property(property="estado_registro", type="char", example="A"),
     *                           @OA\Property(type="object", property="opcion_ojo_izquierdo",
     *                              @OA\Property(property="id", type="integer", example=1),
     *                              @OA\Property(property="nombre", type="string", example="Normal"),
     *                              @OA\Property(property="estado_registro", type="char", example="A"),
     *                          ),
     *                          @OA\Property(type="object", property="opcion_ojo_derecho",
     *                              @OA\Property(property="id", type="integer", example=1),
     *                              @OA\Property(property="nombre", type="string", example="Normal"),
     *                              @OA\Property(property="estado_registro", type="char", example="A"),
     *                          )
     *                        ),
     *                      @OA\Property(type="object", property="tonometria",
     *                          @OA\Property(property="id", type="integer", example=1),
     *                          @OA\Property(property="ojo_derecho", type="integer", example=1),
     *                          @OA\Property(property="ojo_izquierdo", type="integer", example=1),
     *                          @OA\Property(property="estado_registro", type="string", example="A"),
     *                          )
     *                      ),
     *              ),
     *              @OA\Property(property="size", type="number", example=1)
     *          )
     *      ),
     *      @OA\Response(response=400,description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="No se encuentran registros activos...")
     *          )
     *      )
     *  )
     */

    public function index()
    {
        try {
            $agudeza_visual = AgudezaVisual::where('estado_registro', 'A')->with('clinica_servicio',
                'correccion_si.vision_lejos.medida_derecho',
                'correccion_si.vision_lejos.medida_izquierdo',
                'correccion_si.vision_lejos.binocular',
                'correccion_si.vision_cerca.medida_derecho',
                'correccion_si.vision_cerca.medida_izquierdo',
                'correccion_si.vision_cerca.binocular',
                'correccion_no.vision_lejos.medida_derecho',
                'correccion_no.vision_lejos.medida_izquierdo',
                'correccion_no.vision_lejos.binocular',
                'correccion_no.vision_cerca.medida_derecho',
                'correccion_no.vision_cerca.medida_izquierdo',
                'correccion_no.vision_cerca.binocular',
                'opcion_vision_colores',
                'opcion_reflejos_pupilares',
                'opcion_enfermedad_ocular',
                'examen_externo.opcion_ojo_izquierdo',
                'examen_externo.opcion_ojo_derecho',
                'tonometria')->get();
            if (count($agudeza_visual)==0) return response()->json(["error"=> "No se encuentran registros activos..."],400);
            return response()->json(["data" => $agudeza_visual,"size"=>count($agudeza_visual)]);
        } catch (Exception $e) {
            return response()->json(["error" => "".$e]);
        }
    }
/**
     * Crear Datos de Agudeza Visual
     * @OA\Post(
     *     path = "/api/oftalmologia/agudezavisual/create",
     *     summary = "Creando Datos de Agudeza Visual",
     *     security={{ "bearerAuth": {} }},
     *     tags={"Oftalmologia - AgudezaVisual"},
     *      @OA\Parameter(description="El id de la tabla clinica servicio",@OA\Schema(type="integer"), name="clinica_servicio_id", in="query", required=false, example=1),
     *      @OA\Parameter(description="La medida del ojo derecho de la vista lejos sin corregir",@OA\Schema(type="integer"), name="der_med_lej_no", in="query", required=false, example="1"),
     *      @OA\Parameter(description="La medida del ojo izquierdo de la vista lejos sin corregir",@OA\Schema(type="integer"), name="izq_med_lej_no", in="query", required=false, example="1"),
     *      @OA\Parameter(description="La medida de binocular de la vista lejos sin corregir",@OA\Schema(type="integer"), name="bin_med_lej_no", in="query", required=false, example="1"),
     *      @OA\Parameter(description="La medida del ojo derecho de la vista cerca sin corregir",@OA\Schema(type="integer"), name="der_med_cer_no", in="query", required=false, example="1"),
     *      @OA\Parameter(description="La medida del ojo izquierdo de la vista cerca sin corregir",@OA\Schema(type="integer"), name="izq_med_cer_no", in="query", required=false, example="1"),
     *      @OA\Parameter(description="La medida de binocular de la vista cerca sin corregir",@OA\Schema(type="integer"), name="bin_med_cer_no", in="query", required=false, example="1"),
     *      @OA\Parameter(description="La medida del ojo derecho de la vista lejos con correccion",@OA\Schema(type="integer"), name="der_med_lej_si", in="query", required=false, example="1"),
     *      @OA\Parameter(description="La medida del ojo izquierdo de la vista lejos con correccion",@OA\Schema(type="integer"), name="izq_med_lej_si", in="query", required=false, example="1"),
     *      @OA\Parameter(description="La medida de binocular de la vista lejos con correccion",@OA\Schema(type="integer"), name="bin_med_lej_si", in="query", required=false, example="1"),
     *      @OA\Parameter(description="La medida del ojo derecho de la vista cerca con correccion",@OA\Schema(type="integer"), name="der_med_cer_si", in="query", required=false, example="1"),
     *      @OA\Parameter(description="La medida del ojo izquierdo de la vista cerca con correccion",@OA\Schema(type="integer"), name="izq_med_cer_si", in="query", required=false, example="1"),
     *      @OA\Parameter(description="La medida de binocular de la vista cerca con correccion",@OA\Schema(type="integer"), name="bin_med_cer_si", in="query", required=false, example="1"),
     *      @OA\Parameter(description="El id del ojo derecho",@OA\Schema(type="integer"), name="ojo_derecho", in="query", required=false, example="1"),
     *      @OA\Parameter(description="El id del ojo izquierdo",@OA\Schema(type="integer"), name="ojo_izquierdo", in="query", required=false, example="1"),
     *      @OA\Parameter(description="El id de la opcion ojo derecho",@OA\Schema(type="integer"), name="opcion_ojo_derecho_id", in="query", required=false, example="1"),
     *      @OA\Parameter(description="El id de la opcion ojo izquierdo",@OA\Schema(type="integer"), name="opcion_ojo_izquierdo_id", in="query", required=false, example="1"),
     *      @OA\Parameter(description="El id de examen clinica",@OA\Schema(type="integer"), name="examen_clinica", in="query", required=false, example="1"),
     *      @OA\Parameter(description="El id de la opcion enfermedad ocular",@OA\Schema(type="integer"), name="opcion_enfermedad_ocular_id", in="query", required=false, example="1"),
     *      @OA\Parameter(description="El id de la opcion vision colores",@OA\Schema(type="integer"), name="opcion_vision_colores_id", in="query", required=false, example="1"),
     *      @OA\Parameter(description="El id de la opcion reflejos pupilares",@OA\Schema(type="integer"), name="opcion_reflejos_pupilares_id", in="query", required=false, example="1"),
     *      @OA\RequestBody(
     *          @OA\MediaType(mediaType="aplication/json",
     *              @OA\Schema(
     *                      @OA\Property(property="clinica_servicio_id", type="integer", example="1"),
     *                      @OA\Property(property="der_med_lej_no", type="integer", example="1"),
     *                      @OA\Property(property="izq_med_lej_no", type="integer", example="1"),
     *                      @OA\Property(property="bin_med_lej_no", type="integer", example="1"),
     *                      @OA\Property(property="der_med_cer_no", type="integer", example="1"),
     *                      @OA\Property(property="izq_med_cer_no", type="integer", example="1"),
     *                      @OA\Property(property="bin_med_cer_no", type="integer", example="1"),
     *                      @OA\Property(property="der_med_lej_si", type="integer", example="1"),
     *                      @OA\Property(property="izq_med_lej_si", type="integer", example="1"),
     *                      @OA\Property(property="bin_med_lej_si", type="integer", example="1"),
     *                      @OA\Property(property="der_med_cer_si", type="integer", example="1"),
     *                      @OA\Property(property="izq_med_cer_si", type="integer", example="1"),
     *                      @OA\Property(property="bin_med_cer_si", type="integer", example="1"),
     *                      @OA\Property(property="ojo_derecho", type="integer", example="1"),
     *                      @OA\Property(property="ojo_izquierdo", type="integer", example="1"),
     *                      @OA\Property(property="opcion_ojo_derecho_id", type="integer", example="1"),
     *                      @OA\Property(property="opcion_ojo_izquierdo_id", type="integer", example="1"),
     *                      @OA\Property(property="examen_clinica", type="integer", example="1"),
     *                      @OA\Property(property="opcion_enfermedad_ocular_id", type="integer", example="1"),
     *                      @OA\Property(property="opcion_vision_colores_id", type="integer", example="1"),
     *                      @OA\Property(property="opcion_reflejos_pupilares_id", type="integer", example="1"),
     *                  )
     *              )
     *      ),
     *         @OA\Response(response=200,description="success",
     *         @OA\JsonContent(
     *             @OA\Property(property="resp", type="string", example="La agudeza visual fue creada correctamente")
     *         )
     *      ),
     *         @OA\Response(response=400,description="invalid",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="No tiene acceso")
     *             )
     *         ),
     *         @OA\Response(response=501,description="invalid",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Error: La agudeza visual no se ha creado")
     *             )
     *         )
     * )
     */

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $usuario = User::with('user_rol.rol')->where('id', auth()->user()->id)->first();
            $clinica=Clinica::where('id', $usuario->user_rol[0]->rol->clinica_id)->first();

            if($clinica)
            {
                $vileno=VisionLejos::create([
                    'ojo_derecho_id' => $request->der_med_lej_no,
                    'ojo_izquierdo_id' => $request->izq_med_lej_no,
                    'binocular_id' => $request->bin_med_lej_no,
                ]);
                $viceno=VisionCerca::create([
                    'ojo_derecho_id' => $request->der_med_cer_no,
                    'ojo_izquierdo_id' => $request->izq_med_cer_no,
                    'binocular_id' => $request->bin_med_cer_no,
                ]);
                $cono=CorreccionNo::create([
                    'vision_lejos_id' => $vileno->id,
                    'vision_cerca_id' => $viceno->id,
                ]);

                $vilesi=VisionLejos::create([
                    'ojo_derecho_id' => $request->der_med_lej_si,
                    'ojo_izquierdo_id' => $request->izq_med_lej_si,
                    'binocular_id' => $request->bin_med_lej_si,
                ]);
                $vicesi=VisionCerca::create([
                    'ojo_derecho_id' => $request->der_med_cer_si,
                    'ojo_izquierdo_id' => $request->izq_med_cer_si,
                    'binocular_id' => $request->bin_med_cer_si,
                ]);
                $cosi=CorreccionSi::create([
                    'vision_lejos_id' => $vilesi->id,
                    'vision_cerca_id' => $vicesi->id,
                ]);
                $ton=Tonometria::create([
                    'ojo_derecho' => $request->ojo_derecho,
                    'ojo_izquierdo' => $request->ojo_izquierdo,
                ]);
                $exa_ex=ExamenExterno::create([
                    'opcion_ojo_derecho_id' => $request->opcion_ojo_derecho_id,
                    'opcion_ojo_izquierdo_id' => $request->opcion_ojo_izquierdo_id,
                    'examen_clinica'=>$request->examen_clinica,
                ]);

                AgudezaVisual::create([
                'clinica_servicio_id' => $request->clinica_servicio_id,
                'correccion_si_id' => $cono->id,
                'correccion_no_id' => $cosi->id,
                'opcion_enfermedad_ocular_id'=>$request->opcion_enfermedad_ocular_id,
                'opcion_vision_colores_id'=>$request->opcion_vision_colores_id,
                'opcion_reflejos_pupilares_id'=>$request->opcion_reflejos_pupilares_id,
                'tonometria_id'=>$ton->id,
                'examen_externo_id'=>$exa_ex->id,
                ]);
                DB::commit();
            }else{
            return response()->json(["Error"=>"No tiene acceso"],400);
            }
            return response()->json(["resp" => "La agudeza visual fue creada correctamente"],200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["Error" => "" . $e]);
            //return response()->json(["Error: La agudeza visual no se ha creado" => $e],501);
        }
    }
    
  /**
     * Actualiza Datos de Agudeza Visual
     * @OA\Put(
     *     path = "/api/oftalmologia/agudezavisual/update/{id}",
     *     summary = "Actualiza Datos de Agudeza Visual",
     *     security={{ "bearerAuth": {} }},
     *     tags={"Oftalmologia - AgudezaVisual"},
     *      @OA\Parameter(in="path",name="id",required=true,@OA\Schema(type="integer")),
     *      @OA\Parameter(description="El id de la tabla clinica servicio",@OA\Schema(type="integer"), name="clinica_servicio_id", in="query", required=false, example=1),
     *      @OA\Parameter(description="La medida del ojo derecho de la vista lejos sin corregir",@OA\Schema(type="integer"), name="der_med_lej_no", in="query", required=false, example="1"),
     *      @OA\Parameter(description="La medida del ojo izquierdo de la vista lejos sin corregir",@OA\Schema(type="integer"), name="izq_med_lej_no", in="query", required=false, example="1"),
     *      @OA\Parameter(description="La medida de binocular de la vista lejos sin corregir",@OA\Schema(type="integer"), name="bin_med_lej_no", in="query", required=false, example="1"),
     *      @OA\Parameter(description="La medida del ojo derecho de la vista cerca sin corregir",@OA\Schema(type="integer"), name="der_med_cer_no", in="query", required=false, example="1"),
     *      @OA\Parameter(description="La medida del ojo izquierdo de la vista cerca sin corregir",@OA\Schema(type="integer"), name="izq_med_cer_no", in="query", required=false, example="1"),
     *      @OA\Parameter(description="La medida de binocular de la vista cerca sin corregir",@OA\Schema(type="integer"), name="bin_med_cer_no", in="query", required=false, example="1"),
     *      @OA\Parameter(description="La medida del ojo derecho de la vista lejos con correccion",@OA\Schema(type="integer"), name="der_med_lej_si", in="query", required=false, example="1"),
     *      @OA\Parameter(description="La medida del ojo izquierdo de la vista lejos con correccion",@OA\Schema(type="integer"), name="izq_med_lej_si", in="query", required=false, example="1"),
     *      @OA\Parameter(description="La medida de binocular de la vista lejos con correccion",@OA\Schema(type="integer"), name="bin_med_lej_si", in="query", required=false, example="1"),
     *      @OA\Parameter(description="La medida del ojo derecho de la vista cerca con correccion",@OA\Schema(type="integer"), name="der_med_cer_si", in="query", required=false, example="1"),
     *      @OA\Parameter(description="La medida del ojo izquierdo de la vista cerca con correccion",@OA\Schema(type="integer"), name="izq_med_cer_si", in="query", required=false, example="1"),
     *      @OA\Parameter(description="La medida de binocular de la vista cerca con correccion",@OA\Schema(type="integer"), name="bin_med_cer_si", in="query", required=false, example="1"),
     *      @OA\Parameter(description="El id del ojo derecho",@OA\Schema(type="integer"), name="ojo_derecho", in="query", required=false, example="1"),
     *      @OA\Parameter(description="El id del ojo izquierdo",@OA\Schema(type="integer"), name="ojo_izquierdo", in="query", required=false, example="1"),
     *      @OA\Parameter(description="El id de la opcion ojo derecho",@OA\Schema(type="integer"), name="opcion_ojo_derecho_id", in="query", required=false, example="1"),
     *      @OA\Parameter(description="El id de la opcion ojo izquierdo",@OA\Schema(type="integer"), name="opcion_ojo_izquierdo_id", in="query", required=false, example="1"),
     *      @OA\Parameter(description="El id de examen clinica",@OA\Schema(type="integer"), name="examen_clinica", in="query", required=false, example="1"),
     *      @OA\Parameter(description="El id de la opcion enfermedad ocular",@OA\Schema(type="integer"), name="opcion_enfermedad_ocular_id", in="query", required=false, example="1"),
     *      @OA\Parameter(description="El id de la opcion vision colores",@OA\Schema(type="integer"), name="opcion_vision_colores_id", in="query", required=false, example="1"),
     *      @OA\Parameter(description="El id de la opcion reflejos pupilares",@OA\Schema(type="integer"), name="opcion_reflejos_pupilares_id", in="query", required=false, example="1"),
     *      @OA\RequestBody(
     *          @OA\MediaType(mediaType="aplication/json",
     *              @OA\Schema(
     *                      @OA\Property(property="clinica_servicio_id", type="integer", example="1"),
     *                      @OA\Property(property="der_med_lej_no", type="integer", example="1"),
     *                      @OA\Property(property="izq_med_lej_no", type="integer", example="1"),
     *                      @OA\Property(property="bin_med_lej_no", type="integer", example="1"),
     *                      @OA\Property(property="der_med_cer_no", type="integer", example="1"),
     *                      @OA\Property(property="izq_med_cer_no", type="integer", example="1"),
     *                      @OA\Property(property="bin_med_cer_no", type="integer", example="1"),
     *                      @OA\Property(property="der_med_lej_si", type="integer", example="1"),
     *                      @OA\Property(property="izq_med_lej_si", type="integer", example="1"),
     *                      @OA\Property(property="bin_med_lej_si", type="integer", example="1"),
     *                      @OA\Property(property="der_med_cer_si", type="integer", example="1"),
     *                      @OA\Property(property="izq_med_cer_si", type="integer", example="1"),
     *                      @OA\Property(property="bin_med_cer_si", type="integer", example="1"),
     *                      @OA\Property(property="ojo_derecho", type="integer", example="1"),
     *                      @OA\Property(property="ojo_izquierdo", type="integer", example="1"),
     *                      @OA\Property(property="opcion_ojo_derecho_id", type="integer", example="1"),
     *                      @OA\Property(property="opcion_ojo_izquierdo_id", type="integer", example="1"),
     *                      @OA\Property(property="examen_clinica", type="integer", example="1"),
     *                      @OA\Property(property="opcion_enfermedad_ocular_id", type="integer", example="1"),
     *                      @OA\Property(property="opcion_vision_colores_id", type="integer", example="1"),
     *                      @OA\Property(property="opcion_reflejos_pupilares_id", type="integer", example="1"),
     *                  )
     *              )
     *      ),
     *         @OA\Response(response=200,description="success",
     *         @OA\JsonContent(
     *             @OA\Property(property="resp", type="string", example="La agudeza visual fue actualizado correctamente")
     *         )
     *      ),
     *         @OA\Response(response=400,description="invalid",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="No tiene acceso")
     *             )
     *         ),
     *         @OA\Response(response=501,description="invalid",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Error: La agudeza visual no se ha actualizado")
     *             )
     *         )
     * )
     */

    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $dato = AgudezaVisual::with(
                'correccion_si.vision_lejos',
                'correccion_si.vision_cerca',
                'correccion_no.vision_lejos',
                'correccion_no.vision_cerca'
                )->where('estado_registro', 'A')->find($id);
            if(!$dato){
                return response()->json(["error" => "La agudeza visual no se encuentra activo o no existe"],400);
            }
            $vileno=VisionLejos::where('id',$dato->correccion_no->vision_lejos->id)->first();
            // return response()->json($vileno);
            $vileno->fill([
                'ojo_derecho_id' => $request->der_med_lej_no,
                'ojo_izquierdo_id' => $request->izq_med_lej_no,
                'binocular_id' => $request->bin_med_lej_no,
            ])->save();
            $viceno=VisionCerca::where('id',$dato->correccion_no->vision_cerca->id)->first();
            // return response()->json($viceno);
            $viceno->fill([
                'ojo_derecho_id' => $request->der_med_cer_no,
                'ojo_izquierdo_id' => $request->izq_med_cer_no,
                'binocular_id' => $request->bin_med_cer_no,
            ])->save();

            $vilesi=VisionLejos::where('id',$dato->correccion_si->vision_lejos->id)->first();
            // return response()->json($vilesi);
            $vilesi->fill([
                'ojo_derecho_id' => $request->der_med_lej_si,
                'ojo_izquierdo_id' => $request->izq_med_lej_si,
                'binocular_id' => $request->bin_med_lej_si,
            ])->save();
            $vicesi=VisionCerca::where('id',$dato->correccion_si->vision_cerca->id)->first();
            // return response()->json($vicesi);
            $vicesi->fill([
                'ojo_derecho_id' => $request->der_med_cer_si,
                'ojo_izquierdo_id' => $request->izq_med_cer_si,
                'binocular_id' => $request->bin_med_cer_si,
            ])->save();
            $ton=Tonometria::where('id',$dato->tonometria_id)->first();
            // return response()->json($ton);
            $ton->fill([
                'ojo_derecho' => $request->ojo_derecho,
                'ojo_izquierdo' => $request->ojo_izquierdo,
            ])->save();
            $exa_ex=ExamenExterno::where('id',$dato->examen_externo_id)->first();
            // return response()->json($exa_ex);
            $exa_ex->fill([
                'opcion_ojo_derecho_id' => $request->opcion_ojo_derecho_id,
                'opcion_ojo_izquierdo_id' => $request->opcion_ojo_izquierdo_id,
                'examen_clinica'=>$request->examen_clinica,
            ])->save();
            $dato->fill([
                'clinica_servicio_id' => $request->clinica_servicio_id,
                'opcion_enfermedad_ocular_id'=>$request->opcion_enfermedad_ocular_id,
                'opcion_vision_colores_id'=>$request->opcion_vision_colores_id,
                'opcion_reflejos_pupilares_id'=>$request->opcion_reflejos_pupilares_id,
            ])->save();
            DB::commit();
            return response()->json(["resp" => "Agudeza visual actualizado correctamente"],200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["Error: La agudeza visual no se ha actualizado" => $e],501);
        }
    }
    /**
     * Activar
     * @OA\Put (
     *     path="/api/oftalmologia/agudezavisual/activate/{id}",
     *     summary = "Activando Datos de Agudeza Visual",
     *     security={{ "bearerAuth": {} }},
     *     tags={"Oftalmologia - AgudezaVisual"},
     *     @OA\Parameter(in="path",name="id",required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response=200,description="success",
     *         @OA\JsonContent(
     *             @OA\Property(property="resp", type="string", example="Agudeza Visual activado correctamente")
     *         )
     *     ),
     *     @OA\Response(response=401,description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="El agudeza visual no existe"),
     *              )
     *          ),

     *     @OA\Response(response=402,description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="El agudeza visual a activar ya está activado..."),
     *              )
     *          ),
     *     @OA\Response(response=501,description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="Error: Agudeza Visual no se ha activado"),
     *              )
     *          ),
     * )
*/
    public function activate($id)
    {
        DB::beginTransaction();
        try {
            $activate = AgudezaVisual::where('estado_registro', 'I')->find($id);
            $exists = AgudezaVisual::find($id);
            if(!$exists){
                return response()->json(["error"=>"La agudeza visual no existe"],401);
            }
            if(!$activate){
                return response()->json(["error" => "La agudeza visual a activar ya está activado..."],402);
            }
            $activate->fill([
                'estado_registro' => 'A',
            ])->save();
            DB::commit();
            return response()->json(["resp" => "Agudeza visual activado correctamente"],200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["Error: Agudeza visual no se ha activado" => $e],501);
        }
    }
    /**
     * Delete
     * @OA\Delete (
     *     path="/api/oftalmologia/agudezavisual/delete/{id}",
     *     summary = "Eliminando Datos de Agudeza Visual",
     *     security={{ "bearerAuth": {} }},
     *     tags={"Oftalmologia - AgudezaVisual"},
     *     @OA\Parameter(in="path",name="id",required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response=200,description="success",
     *         @OA\JsonContent(
     *             @OA\Property(property="resp", type="string", example="Agudeza visual eliminado correctamente")
     *         )
     *     ),
     *     @OA\Response(response=401,description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="La agudeza visual no existe"),
     *              )
     *          ),
     *     @OA\Response(response=402,description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="La agudeza visual a eliminar ya está inactivado..."),
     *              )
     *          ),
     *     @OA\Response(response=501,description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="Error: Agudeza visual no se ha eliminado"),
     *              )
     *          ),
     * )
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $delete = AgudezaVisual::where('estado_registro', 'A')->find($id);
            $exists = AgudezaVisual::find($id);
            if(!$exists){
                return response()->json(["error"=>"La agudeza visual no existe"],401);
            }
            if(!$delete){
                return response()->json(["error" => "La agudeza visual a eliminar ya está inactivado..."],402);
            }
            $delete->fill([
                'estado_registro' => 'I',
            ])->save();
            DB::commit();
            return response()->json(["resp" => "La agudeza visual eliminado correctamente"],200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["Error: La agudeza visual no se ha eliminado" => $e],501);
        }
    }


    /**
     *  Muestra todos los registros de medida cerca
     *  @OA\Get (
     *      path="/api/oftalmologia/agudezavisual/getmedcer",
     *      summary="Mostrando Datos de medida cerca",
     *      security={{ "bearerAuth":{} }},
     *      tags={"Oftalmologia - AgudezaVisual"},
     *      @OA\Response(response=200,description="success",
     *          @OA\JsonContent(
     *              @OA\Property(type="array", property="data",
     *                  @OA\Items(type="object",
     *                      @OA\Property(property="id", type="integer", example=1),
     *                      @OA\Property(property="medida", type="string", example="20/10"),
     *                      @OA\Property(property="estado_registro", type="char", example="A"),
     *                      )
     *              ),
     *              @OA\Property(property="size", type="number", example=1)
     *          )
     *      ),
     *      @OA\Response(response=400,description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="No se encuentran registros activos...")
     *          )
     *      )
     *  )
     */
    public function getmedcer()
    {
        try {
            $registro = MedidaCerca::where('estado_registro', 'A')->get();
            if (count($registro)==0) return response()->json(["error"=> "No se encuentran registros activos..."],400);
            return response()->json(["data" => $registro,"size"=>count($registro)]);
        } catch (Exception $e) {
            return response()->json(["error" => "error " . $e]);
        }
    }
        /**
     *  Muestra todos los registros de medida lejos
     *  @OA\Get (
     *      path="/api/oftalmologia/agudezavisual/getmedlej",
     *      summary="Mostrando Datos de medida cerca",
     *      security={{ "bearerAuth":{} }},
     *      tags={"Oftalmologia - AgudezaVisual"},
     *      @OA\Response(response=200,description="success",
     *          @OA\JsonContent(
     *              @OA\Property(type="array", property="data",
     *                  @OA\Items(type="object",
     *                      @OA\Property(property="id", type="integer", example=1),
     *                      @OA\Property(property="medida", type="string", example="20/10"),
     *                      @OA\Property(property="estado_registro", type="char", example="A"),
     *                      )
     *              ),
     *              @OA\Property(property="size", type="number", example=1)
     *          )
     *      ),
     *      @OA\Response(response=400,description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="No se encuentran registros activos...")
     *          )
     *      )
     *  )
     */
    public function getmedlej()
    {
        try {
            $registro = MedidaLejos::where('estado_registro', 'A')->get();
            if (count($registro)==0) return response()->json(["error"=> "No se encuentran registros activos..."],400);
            return response()->json(["data" => $registro,"size"=>count($registro)]);
        } catch (Exception $e) {
            return response()->json(["error" => "error " . $e]);
        }
    }

    /**
     *  Muestra todos los registros de Enfermedades Oculares
     *  @OA\Get (
     *      path="/api/oftalmologia/agudezavisual/getenfocul",
     *      summary="Mostrando Datos de Enfermedades Oculares",
     *      security={{ "bearerAuth":{} }},
     *      tags={"Oftalmologia - AgudezaVisual"},
     *      @OA\Response(response=200,description="success",
     *          @OA\JsonContent(
     *              @OA\Property(type="array", property="data",
     *                  @OA\Items(type="object",
     *                      @OA\Property(property="id", type="integer", example=1),
     *                      @OA\Property(property="nombre", type="string", example="Ausente"),
     *                      @OA\Property(property="estado_registro", type="char", example="A"),
     *                      )
     *              ),
     *              @OA\Property(property="size", type="number", example=1)
     *          )
     *      ),
     *      @OA\Response(response=400,description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="No se encuentran registros activos...")
     *          )
     *      )
     *  )
     */
    public function getenfocul()
    {
        try {
            $enfermedad_ocular = OpcionEnfermedadOcular::where('estado_registro', 'A')->with('agudeza_visual')->get();
            if (!$enfermedad_ocular) {
                return response()->json(["error"=> "No se encuentran registros activos..."],400);
            }else {
                return response()->json(["data" => $enfermedad_ocular,"size"=>count($enfermedad_ocular)]);
            }
        } catch (Exception $e) {
            return response()->json(["error" => "error " . $e]);
        }
    }

    /**
     *  Muestra todos los registros de Reflejos Pupilares
     *  @OA\Get (
     *      path="/api/oftalmologia/agudezavisual/getrefpup",
     *      summary="Mostrando Datos de Reflejos Pupilares",
     *      security={{ "bearerAuth":{} }},
     *      tags={"Oftalmologia - AgudezaVisual"},
     *      @OA\Response(response=200,description="success",
     *          @OA\JsonContent(
     *              @OA\Property(type="array", property="data",
     *                  @OA\Items(type="object",
     *                      @OA\Property(property="id", type="integer", example=1),
     *                      @OA\Property(property="nombre", type="string", example="Ausente"),
     *                      @OA\Property(property="estado_registro", type="char", example="A"),
     *                      )
     *              ),
     *              @OA\Property(property="size", type="number", example=1)
     *          )
     *      ),
     *      @OA\Response(response=400,description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="No se encuentran registros activos...")
     *          )
     *      )
     *  )
     */
    public function getrefpup()
    {
        try {
            $reflejos_pupilares = OpcionReflejosPupilares::where('estado_registro', 'A')->with('agudeza_visual')->get();
            if (!$reflejos_pupilares) {
                return response()->json(["error"=> "No se encuentran registros activos..."],400);
            }else {
                return response()->json(["data" => $reflejos_pupilares,"size"=>count($reflejos_pupilares)]);
            }
        } catch (Exception $e) {
            return response()->json(["error" => "error " . $e]);
        }
    }

     /**
     *  Muestra todos los registros de Vision Colores
     *  @OA\Get (
     *      path="/api/oftalmologia/agudezavisual/getviscol",
     *      summary="Mostrando Datos de Vision Colores",
     *      security={{ "bearerAuth":{} }},
     *      tags={"Oftalmologia - AgudezaVisual"},
     *      @OA\Response(response=200,description="success",
     *          @OA\JsonContent(
     *              @OA\Property(type="array", property="data",
     *                  @OA\Items(type="object",
     *                      @OA\Property(property="id", type="integer", example=1),
     *                      @OA\Property(property="nombre", type="string", example="Ausente"),
     *                      @OA\Property(property="estado_registro", type="char", example="A"),
     *                      )
     *              ),
     *              @OA\Property(property="size", type="number", example=1)
     *          )
     *      ),
     *      @OA\Response(response=400,description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="No se encuentran registros activos...")
     *          )
     *      )
     *  )
     */
    public function getviscol()
    {
        try {
            $vision_colores = OpcionVisionColores::with('agudeza_visual')->where('estado_registro', 'A')->get();
            if (!$vision_colores) {
                return response()->json(["error"=> "No se encuentran registros activos..."],400);
            }else {
                return response()->json(["data" => $vision_colores,"size"=>count($vision_colores)]);
            }
        } catch (Exception $e) {
            return response()->json(["error" => "error " . $e]);
        }
    }

    /**
     *  Muestra todos los registros de la Opcion Ojo Derecho
     *  @OA\Get (
     *      path="/api/oftalmologia/agudezavisual/getojoderecho",
     *      summary="Mostrando Datos de la Opcion Ojo Derecho",
     *      security={{ "bearerAuth":{} }},
     *      tags={"Oftalmologia - AgudezaVisual"},
     *      @OA\Response(response=200,description="success",
     *          @OA\JsonContent(
     *              @OA\Property(type="array", property="data",
     *                  @OA\Items(type="object",
     *                      @OA\Property(property="id", type="integer", example=1),
     *                      @OA\Property(property="nombre", type="string", example="Normal"),
     *                      @OA\Property(property="estado_registro", type="char", example="A"),
     *                      )
     *              ),
     *              @OA\Property(property="size", type="number", example=1)
     *          )
     *      ),
     *      @OA\Response(response=400,description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="No se encuentran registros activos...")
     *          )
     *      )
     *  )
     */
    public function getojoderecho()
    {
        try {
            $ojo_derecho = OpcionOjoDerecho::with('examen_externo')->where('estado_registro', 'A')->get();
            if (!$ojo_derecho) {
                return response()->json(["error"=> "No se encuentran registros activos..."],400);
            }else {
                return response()->json(["data" => $ojo_derecho,"size"=>count($ojo_derecho)]);
            }
        } catch (Exception $e) {
            return response()->json(["error" => "error " . $e]);
        }
    }

    /**
     *  Muestra todos los registros de la Opcion Ojo Izquierdo
     *  @OA\Get (
     *      path="/api/oftalmologia/agudezavisual/getojoizquierdo",
     *      summary="Mostrando Datos de la Opcion Ojo Izquierdo",
     *      security={{ "bearerAuth":{} }},
     *      tags={"Oftalmologia - AgudezaVisual"},
     *      @OA\Response(response=200,description="success",
     *          @OA\JsonContent(
     *              @OA\Property(type="array", property="data",
     *                  @OA\Items(type="object",
     *                      @OA\Property(property="id", type="integer", example=1),
     *                      @OA\Property(property="nombre", type="string", example="Normal"),
     *                      @OA\Property(property="estado_registro", type="char", example="A"),
     *                      )
     *              ),
     *              @OA\Property(property="size", type="number", example=1)
     *          )
     *      ),
     *      @OA\Response(response=400,description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="No se encuentran registros activos...")
     *          )
     *      )
     *  )
     */
    public function getojoizquierdo()
    {
        try {
            $ojo_izquierdo = OpcionOjoIzquierdo::with('examen_externo')->where('estado_registro', 'A')->get();
            if (!$ojo_izquierdo) {
                return response()->json(["error"=> "No se encuentran registros activos..."],400);
            }else {
                return response()->json(["data" => $ojo_izquierdo,"size"=>count($ojo_izquierdo)]);
            }
        } catch (Exception $e) {
            return response()->json(["error" => "error " . $e]);
        }
    }

}
