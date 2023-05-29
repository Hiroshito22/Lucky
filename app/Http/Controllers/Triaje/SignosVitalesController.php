<?php

// namespace App\Http\Controllers;
namespace App\Http\Controllers\Triaje;

use App\Models\AntecedenteFamiliar;
use App\Models\ClinicaPatologia;
use App\Models\Patologia;
use App\Models\ClinicaPatologiaFamiliar;


use App\Http\Controllers\Controller;
use App\Models\Familiar;
use App\Models\FichaOcupacional;
use App\Models\ServicioClinica;
use App\Models\SignosVitales;
use App\Models\TipoFamiliar;
use App\Models\TipoPatologia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use TheSeer\Tokenizer\Exception;

class SignosVitalesController extends Controller
{
    /**
     * Permite visualizar un listado de todos los registros de la tabla "SignosVitales"
     * @OA\Get (path="/api/signosvitales/get",tags={"Triaje - Signos Vitales"},
     *     @OA\Response(response=200,description="success",
     *         @OA\JsonContent(
     *             @OA\Property(type="array",property="data",
     *                 @OA\Items(type="object",
     *                     @OA\Property(property="id",type="number",example="1"),
     *                     @OA\Property(property="ficha_ocupacional_id",type="foreignId",example="1"),
     *                     @OA\Property(property="servicio_clinica_id",type="foreignId",example="1"),
     *                     @OA\Property(property="frec_cardiaca",type="double",example="1.2"),
     *                     @OA\Property(property="frec_respiratoria",type="double",example="2.5"),
     *                     @OA\Property(property="p_sistolica",type="double",example="2.5"),
     *                     @OA\Property(property="p_diastolica",type="double",example="1.2"),
     *                     @OA\Property(property="p_media",type="double",example="1.2"),
     *                     @OA\Property(property="saturacion",type="double",example="2.5"),
     *                     @OA\Property(property="temperatura",type="double",example="2.5"),
     *                     @OA\Property(property="observaciones",type="string",example="example observaciones"),
     *                     @OA\Property(property="estado_registro",type="char",example="A")
     *                 )
     *             ),
     *             @OA\Property(type="count",property="size",example="1")
     *         )
     *     ),
     *     @OA\Response(response=400,description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="Error", type="string", example="Error: No se encuentran Registros...")
     *          )
     *     )
     * )
     */

    public function get()
    {
        try {
            $registro = SignosVitales::where('estado_registro', 'A')->get();
            return response()->json(["data" => $registro, "size" => count($registro)]);
            if (!$registro) {
                return response()->json(["No hay Registros..."]);
            }
        } catch (Exception $e) {
            return response()->json(["Error: No se encuentran Registros..." => $e], 500);
        }
    }

    /**
     *  Permite crear un registro en la tabla "SignosVitales"
     *  @OA\Post (
     *      path="/api/signosvitales/create",
     *      tags={"Triaje - Signos Vitales"},
     *      @OA\Parameter(description="La ID (Llave Primaria) de la tabla 'Ficha Ocupacional'",
     *          @OA\Schema(type="integer"),name="ficha_ocupacional_id",in="query",required= true,example="1"),
     *      @OA\Parameter(description="La ID (Llave Primaria) de la tabla 'Servicio Clinica'",
     *          @OA\Schema(type="integer"),name="servicio_clinica_id",in="query",required= true,example="1"),
     *      @OA\Parameter(description="La Frecuencia Cardiaca del Paciente",
     *          @OA\Schema(type="double"),name="frec_cardiaca",in="query",required= false,example="1.2"),
     *      @OA\Parameter(description="La Frecuencia Respiratoria del Paciente",
     *          @OA\Schema(type="double"),name="frec_respiratoria",in="query",required= false,example="2.5"),
     *      @OA\Parameter(description="La Presión Sistólica del Paciente",
     *          @OA\Schema(type="double"),name="p_sistolica",in="query",required= false,example="2.5"),
     *      @OA\Parameter(description="La Presión Diastólica del Paciente",
     *          @OA\Schema(type="double"),name="p_diastolica",in="query",required= false,example="1.2"),
     *      @OA\Parameter(description="La Presión Media del Paciente",
     *          @OA\Schema(type="double"),name="p_media",in="query",required= false,example="1.2"),
     *      @OA\Parameter(description="La Saturación O2 del Paciente",
     *          @OA\Schema(type="double"),name="saturacion",in="query",required= false,example="2.5"),
     *      @OA\Parameter(description="La Temperatura (°C) del Paciente",
     *          @OA\Schema(type="double"),name="temperatura",in="query",required= false,example="2.5"),
     *      @OA\Parameter(description="Las Observaciones y/o Comentarios acerca del Paciente",
     *          @OA\Schema(type="string"),name="observaciones",in="query",required= false,example="example observaciones"),
     *     @OA\RequestBody(
     *         @OA\MediaType(mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(property="ficha_ocupacional_id",type="foreignId",example=null),
     *                 @OA\Property(property="servicio_clinica_id",type="foreignId",example=null),
     *                 @OA\Property(property="frec_cardiaca",type="double",example="1.2"),
     *                 @OA\Property(property="frec_respiratoria",type="double",example="2.5"),
     *                 @OA\Property(property="p_sistolica",type="double",example="2.5"),
     *                 @OA\Property(property="p_diastolica",type="double",example="1.2"),
     *                 @OA\Property(property="p_media",type="double",example="1.2"),
     *                 @OA\Property(property="saturacion",type="double",example="2.5"),
     *                 @OA\Property(property="temperatura",type="double",example="2.5"),
     *                 @OA\Property(property="observaciones",type="string",example="example observaciones")
     *             )
     *         )
     *      ),
     *     @OA\Response(response=200,description="success",
     *         @OA\JsonContent(
     *             @OA\Property(property="resp", type="string", example="Signo Vital creado correctamente")
     *         )
     *     ),
     *     @OA\Response(response=400,description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="Error", type="string", example="El Signo Vital no se ha creado...")
     *          )
     *      )
     * )
     */

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $search1 = FichaOcupacional::find($request->ficha_ocupacional_id);
            $search2 = ServicioClinica::find($request->servicio_clinica_id);
            //error aqui
            if (!$search1) return response()->json(["Error: El ID ingresado de 'Ficha Ocupacional' no existe"]);
            if (!$search2) return response()->json(["Error: El ID ingresado de 'Servicio Clinica' no existe"]);
            // elseif (!is_int($request->ficha_ocupacional_id)) return response()->json(['error' => 'El ID tiene que ser un número entero...'],400);
            // elseif (!is_int($request->servicio_clinica_id)) return response()->json(['error' => 'El ID tiene que ser un número entero.'],400);

            if (
                !is_double($request->frec_cardiaca) && !is_int($request->frec_cardiaca) or !is_double($request->frec_respiratoria) && !is_int($request->frec_respiratoria)
                or !is_double($request->p_sistolica) && !is_int($request->p_sistolica) or !is_double($request->p_diastolica) && !is_int($request->p_diastolica)
                or !is_double($request->p_media) && !is_int($request->p_media) or !is_double($request->saturacion) && !is_int($request->saturacion)
                or !is_double($request->temperatura) && !is_int($request->temperatura)
            ) {
                return response()->json(['error' => 'El campo debe ser un número decimal o entero.'], 400);
            }
            SignosVitales::create([
                'ficha_ocupacional_id' => $request->ficha_ocupacional_id,
                'servicio_clinica_id' => $request->servicio_clinica_id,
                'frec_cardiaca' => $request->frec_cardiaca,
                'frec_respiratoria' => $request->frec_respiratoria,
                'p_sistolica' => $request->p_sistolica,
                'p_diastolica' => $request->p_diastolica,
                'p_media' => $request->p_media,
                'saturacion' => $request->saturacion,
                'temperatura' => $request->temperatura,
                'observaciones' => $request->observaciones
            ]);
            DB::commit();
            return response()->json(["resp" => "Signo Vital creado correctamente"]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["Error: El Signo Vital no se ha creado..." => $e]);
        }
    }

    /**
     * Permite actualizar un registro de la tabla "SignosVitales" mediante un ID
     * @OA\Put (path="/api/signosvitales/update/{id}",tags={"Triaje - Signos Vitales"},
     *     @OA\Parameter(in="path",name="id",required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(description="La ID (Llave Priumaria) de la tabla 'Ficha Ocupacional'",
     *          @OA\Schema(type="integer"),name="ficha_ocupacional_id",in="query",required= true,example="1"),
     *      @OA\Parameter(description="La ID (Llave Priumaria) de la tabla 'Servicio Clinica'",
     *          @OA\Schema(type="integer"),name="servicio_clinica_id",in="query",required= true,example="1"),
     *      @OA\Parameter(description="La Frecuencia Cardiaca del Paciente",
     *          @OA\Schema(type="double"),name="frec_cardiaca",in="query",required= false,example="1.2"),
     *      @OA\Parameter(description="La Frecuencia Respiratoria del Paciente",
     *          @OA\Schema(type="double"),name="frec_respiratoria",in="query",required= false,example="2.5"),
     *      @OA\Parameter(description="La Presión Sistólica del Paciente",
     *          @OA\Schema(type="double"),name="p_sistolica",in="query",required= false,example="2.5"),
     *      @OA\Parameter(description="La Presión Diastólica del Paciente",
     *          @OA\Schema(type="double"),name="p_diastolica",in="query",required= false,example="1.2"),
     *      @OA\Parameter(description="La Presión Media del Paciente",
     *          @OA\Schema(type="double"),name="p_media",in="query",required= false,example="1.2"),
     *      @OA\Parameter(description="La Saturación O2 del Paciente",
     *          @OA\Schema(type="double"),name="saturacion",in="query",required= false,example="2.5"),
     *      @OA\Parameter(description="La Temperatura (°C) del Paciente",
     *          @OA\Schema(type="double"),name="temperatura",in="query",required= false,example="2.5"),
     *      @OA\Parameter(description="Las Observaciones y/o Comentarios acerca del Paciente",
     *          @OA\Schema(type="string"),name="observaciones",in="query",required= false,example="example observaciones"),
     *     @OA\RequestBody(
     *         @OA\MediaType(mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(property="ficha_ocupacional_id",type="foreignId",example=null),
     *                 @OA\Property(property="servicio_clinica_id",type="foreignId",example=null),
     *                 @OA\Property(property="frec_cardiaca",type="double",example="1.5"),
     *                 @OA\Property(property="frec_respiratoria",type="double",example="3.2"),
     *                 @OA\Property(property="p_sistolica",type="double",example="3.2"),
     *                 @OA\Property(property="p_diastolica",type="double",example="1.5"),
     *                 @OA\Property(property="p_media",type="double",example="1.5"),
     *                 @OA\Property(property="saturacion",type="double",example="3.2"),
     *                 @OA\Property(property="temperatura",type="double",example="3.2"),
     *                 @OA\Property(property="observaciones",type="string",example="example observaciones2")
     *             )
     *         )
     *      ),
     *     @OA\Response(response=200,description="success",
     *         @OA\JsonContent(
     *             @OA\Property(property="resp", type="string", example="Signo Vital actualizado correctamente")
     *         )
     *     ),
     *     @OA\Response(response=400,description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="Error", type="string", example="El Signo Vital no se ha actualizado...")
     *          )
     *      )
     * )
     */

    public function update(Request $request, $id)
    {
        DB::beginTransaction();

        try {
            $search1 = FichaOcupacional::find($request->ficha_ocupacional_id);
            $search2 = ServicioClinica::find($request->servicio_clinica_id);
            $search3 = ServicioClinica::find($id);
            if (!$search1)return response()->json(["Error: El ID ingresado de 'Ficha Ocupacional' no existe..."]);
            elseif (!$search2) return response()->json(["Error: El ID ingresado de 'Servicio Clinica' no existe..."]);
            elseif (!$search3) return response()->json(["Error: El ID ingresado de Registro a actualizar no existe..."]);
            // elseif (!is_int($request->ficha_ocupacional_id)) return response()->json(['error' => 'El ID tiene que ser un número entero...'], 400);
            // elseif (!is_int($request->servicio_clinica_id)) return response()->json(['error' => 'El ID tiene que ser un número entero.'], 400);
            if (
                !is_double($request->frec_cardiaca) && !is_int($request->frec_cardiaca) or !is_double($request->frec_respiratoria) && !is_int($request->frec_respiratoria)
                or !is_double($request->p_sistolica) && !is_int($request->p_sistolica) or !is_double($request->p_diastolica) && !is_int($request->p_diastolica)
                or !is_double($request->p_media) && !is_int($request->p_media) or !is_double($request->saturacion) && !is_int($request->saturacion)
                or !is_double($request->temperatura) && !is_int($request->temperatura)
            ) {
                return response()->json(['error' => 'El campo debe ser un número decimal o entero.'], 400);
            }
            $registro = SignosVitales::where('estado_registro', 'A')->find($id);
            if (!$registro) {
                return response()->json(["resp" => "El Registro no se encuentra activo"]);
            }
            $registro->fill([
                'ficha_ocupacional_id' => $request->ficha_ocupacional_id,
                'servicio_clinica_id' => $request->servicio_clinica_id,
                'frec_cardiaca' => $request->frec_cardiaca,
                'frec_respiratoria' => $request->frec_respiratoria,
                'p_sistolica' => $request->p_sistolica,
                'p_diastolica' => $request->p_diastolica,
                'p_media' => $request->p_media,
                'saturacion' => $request->saturacion,
                'temperatura' => $request->temperatura,
                'observaciones' => $request->observaciones
            ])->save();
            DB::commit();
            return response()->json(["resp" => "Signo Vital actualizado correctamente"]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["Error: El Signo Vital no se ha actualizado..." => $e]);
        }
    }

    /**
     * Permite eliminar/inactivar un registro de la tabla "SignosVitales" mediante un ID
     * @OA\Delete (path="/api/signosvitales/delete/{id}",tags={"Triaje - Signos Vitales"},
     *     @OA\Parameter(in="path",name="id",required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200,description="success",
     *         @OA\JsonContent(
     *             @OA\Property(property="resp", type="string", example="Signo Vital eliminado correctamente")
     *         )
     *     ),
     *     @OA\Response(response=400,description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="Error", type="string", example="El Signo Vital no se ha eliminado...")
     *          )
     *      )
     * )
     */

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $registro = SignosVitales::where('estado_registro', 'A')->find($id);
            if (!$registro) {
                return response()->json(["resp" => "El Signo Vital a eliminar ya está inactivado..."]);
            }
            $registro->fill([
                'estado_registro' => 'I',
            ])->save();
            DB::commit();
            return response()->json(["resp" => "Signo Vital eliminado correctamente"]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["Error: El Signo Vital no se ha eliminado..." => $e]);
        }
    }

    /**
     * Permite activar un registro de la tabla "SignosVitales" mediante un ID
     * @OA\put (path="/api/signosvitales/active/{id}",tags={"Triaje - Signos Vitales"},
     *     @OA\Parameter(in="path",name="id",required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200,description="success",
     *         @OA\JsonContent(
     *             @OA\Property(property="resp", type="string", example="Registro activado correctamente")
     *         )
     *     ),
     *     @OA\Response(response=400,description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="El Registro no se ha activado..."),
     *          )
     *      )
     * )
     */

    public function activar_datos($id)
    {
        DB::beginTransaction();
        try {
            $registro = SignosVitales::where('estado_registro', 'I')->find($id);
            if (!$registro) {
                return response()->json(["resp" => "El Registro a activar ya está activado..."]);
            }
            $registro->fill([
                'estado_registro' => 'A',
            ])->save();
            DB::commit();
            return response()->json(["resp" => "Registro activado correctamente"]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["Error: El Registro no se ha activado..." => $e]);
        }
    }

    /**
     * Permite eliminar PERMANENTEMENTE un registro de la tabla "SignosVitales" mediante un ID
     * @OA\Delete (
     *     path="/api/signosvitales/deleteperm/{id}",
     *     tags={"Triaje - Signos Vitales"},
     *     @OA\Parameter(
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="success",
     *         @OA\JsonContent(
     *             @OA\Property(property="resp", type="string", example="Registro eliminado correctamente de forma permanente")
     *         )
     *     ),
     *     @OA\Response(
     *          response=400,
     *          description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="El Registro no se ha eliminado de forma permanente..."),
     *          )
     *      )
     * )
     */

    public function elim_perm_datos($id)
    {
        DB::beginTransaction();
        try {
            $registro = SignosVitales::where('id', $id)->find($id);
            if (!$registro) {
                return response()->json(["resp" => "No se encuentra el Registro a eliminar de forma permanente..."]);
            }
            $registro->delete();
            DB::commit();
            return response()->json(["resp" => "Registro eliminado correctamente de forma permanente"]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["Error: El Registro no se ha eliminado de forma permanente..." => $e]);
        }
    }
}
