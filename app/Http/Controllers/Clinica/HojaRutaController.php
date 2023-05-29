<?php

namespace App\Http\Controllers\Clinica;

use App\Http\Controllers\Controller;
use App\Models\HojaRuta;
use App\Models\Paciente;
use App\Models\Persona;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HojaRutaController extends Controller
{

    /**
     * Crea una de Hoja de Ruta
     * @OA\POST (
     *     path="/api/clinica/hoja_ruta/create",
     *     summary="Crea una hoja de ruta con sesión iniciada",
     *     security={{ "bearerAuth": {} }},
     *     tags={"Hoja de Ruta"},
     *      @OA\Parameter(description="Empresa Personal",
     *          @OA\Schema(type="string"), name="empresa_personal_id", in="query", required= false
     *      ),            
     *      @OA\Response(response=200,description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="Hoja de Ruta creado"),
     *          )
     *      ),
     *      @OA\Response(response=400,description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="Error al crear, intentelo de nuevo"),
     *          )
     *      ),
     * )
     */
    public function create(Request $request)
    {
        DB::beginTransaction();
        try {
            $userclinica = User::with('user_rol.rol')->where('id', auth()->user()->id)->first();
            HojaRuta::create([
                "empresa_personal_id" => $request->empresa_personal_id,
                "clinica_id" => $userclinica->user_rol[0]->rol->clinica_id
            ]);
            DB::commit();
            return response()->json(["resp" => "Hoja de Ruta creado"]);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(["error" => "error " . $e]);
        }
    }


    /**
     * Actualiza un Estado Hoja de Ruta
     * @OA\PUT (
     *     path="/api/clinica/hoja_ruta/update/{id}",
     *     summary="Actualiza una hoja de ruta con sesión iniciada",
     *     security={{ "bearerAuth": {} }},
     *     tags={"Hoja de Ruta"},
     *      @OA\Parameter(description="Id",          
     *          @OA\Schema(type="number"),name="id",in="path",required= true,example=1            
     *      ), 
     *      @OA\Parameter(description="Empresa Personal",
     *          @OA\Schema(type="string"), name="empresa_personal_id", in="query", required= false
     *      ),
     *      @OA\Response(response=200,description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="Hoja de Ruta actualizado"),
     *          )
     *      ),     
     *      @OA\Response(response=400,description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="Error al actualizar, intentelo de nuevo"),
     *          )
     *      ),
     * )
     */
    public function update(Request $request, $Idruta)
    {
        DB::beginTransaction();
        try {
            $userclinica = User::with('user_rol.rol')->where('id', auth()->user()->id)->first();
            $hr = HojaRuta::find($Idruta);
            if ($hr) {
                $hr->fill(array(
                    "empresa_personal_id" => $request->empresa_personal_id,
                    //"clinica_paquete_id" => $request->clinica_paquete_id,
                    "clinica_id" => $userclinica->user_rol[0]->rol->clinica_id
                ));
                $hr->save();
                DB::commit();
                return response()->json(["resp" => "Hoja de Ruta actualizado"]);
            } else {
                return response()->json(["resp" => "El ID no existe en la Base de Datos"]);
            }
        } catch (Exception $e) {
            return response()->json(["resp" => "Error" . $e]);
        }
    }


    /**
     * Elimina una Hoja de Ruta
     * @OA\DELETE (
     *     path="/api/clinica/hoja_ruta/delete/{id}",
     *     summary="Elimina una hoja de ruta con sesión iniciada",
     *     security={{ "bearerAuth": {} }},
     *     tags={"Hoja de Ruta"},
     *      @OA\Parameter(description="Id",          
     *          @OA\Schema(type="number"),name="id",in="path",required= true,example=1            
     *      ), 
     *      @OA\Response(response=200,description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="Hoja de Ruta eliminado"),
     *          )
     *      ),     
     *      @OA\Response(response=400,description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="Error al eliminar, intentelo de nuevo"),
     *          )
     *      ),
     * )
     */
    public function delete($Id)
    {
        try {
            DB::beginTransaction();
            $hr = HojaRuta::find($Id);
            if ($hr) {
                $hr->fill([
                    "estado_registro" => "I",
                ])->save();
                DB::commit();
                return response()->json(["Resp" => "Hoja de Ruta eliminada"]);
            } else {
                return response()->json(["resp" => "El ID no existe en la Base de Datos"]);
            }
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(["error" => "error " . $e]);
        }
    }


    /**
     * Mostrar las hojas de rutas
     * @OA\GET (
     *     path="/api/clinica/hoja_ruta/show",
     *     summary="Muestra las hojas de rutas con sesión iniciada",
     *     security={{ "bearerAuth": {} }},
     *     tags={"Hoja de Ruta"},
     *      @OA\Response(response=200,description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="id", type="number", example=1),
     *              @OA\Property(property="empresa_personal_id", type="number", example=1),
     *              @OA\Property(property="clinica_id", type="number", example=1),
     *              @OA\Property(property="estado_registro", type="string", example="A"),
     *              @OA\Property(type="array",property="clinica",
     *                  @OA\Items(type="object",
     *                      @OA\Property(property="id", type="number", example=1),
     *                      @OA\Property(property="bregma_id", type="number", example=1),
     *                      @OA\Property(property="tipo_documento_id", type="number", example=1),
     *                      @OA\Property(property="distrito_id", type="number", example=1),
     *                      @OA\Property(property="razon_social", type="string", example="razon_social"),
     *                      @OA\Property(property="numero_documento", type="string", example="98765432"),
     *                      @OA\Property(property="responsable", type="string", example="reaponsable"),
     *                      @OA\Property(property="nombre_comercial", type="sting", example="nombre_comercial"),
     *                      @OA\Property(property="latitud", type="sting", example="latitud"),
     *                      @OA\Property(property="longitud", type="sting", example="longitud"),
     *                      @OA\Property(property="direccion", type="sting", example="direccion"),
     *                      @OA\Property(property="logo", type="sting", example="logo"),
     *                      @OA\Property(property="estado_registro", type="string", example="A"),
     *                      @OA\Property(property="hospital_id", type="number", example=1),
     *                      @OA\Property(type="array",property="tipo_documento",
     *                          @OA\Items(type="object",
     *                              @OA\Property(property="id", type="number", example=1),
     *                              @OA\Property(property="nombre", type="string", example="DNI"),
     *                              @OA\Property(property="codigo", type="string", example="codigo"),
     *                              @OA\Property(property="descripcion", type="string", example="Documento Nacional de Identidad"),
     *                              @OA\Property(property="estado_registro", type="string", example="A"),
     *                          )
     *                      ),
     *                  )
     *              ),
     *          )
     *      ),     
     *      @OA\Response(response=400,description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="Error al mostrar, intentelo de nuevo"),
     *          )
     *      ),
     * )
     */
    public function show()
    {
        try {
            $userclinica = User::with('user_rol.rol')->where('id', auth()->user()->id)->first();
            $hr = HojaRuta::with('clinica.tipo_documento', 'empresa_personal')
                ->where('clinica_id', $userclinica->user_rol[0]->rol->clinica_id)
                ->where('estado_registro', 'A')
                ->get();
            return response()->json(["data" => $hr, "size" => count($hr)], 200);
        } catch (Exception $e) {
            return response()->json(["error" => "error", "error" => $e]);
        }
    }

    public function show_general()
    {
        try {
            $userclinica = User::find(auth()->user()->id);
            $persona = Persona::with('tipo_documento')
                ->find($userclinica->persona_id);
            $hr = HojaRuta::select()
                ->with('estado_ruta')
                ->where('clinica_id', $userclinica->user_rol[0]->rol->clinica_id)
                ->where('estado_registro', 'A')
                ->get();
            return response()->json(["Persona" => $persona , "Hoja de Ruta" => $hr], 200);
        } catch (Exception $e) {
            return response()->json(["error" => "error", "error" => $e]);
        }
    }

    public function get_paciente($id_paciente)
    {
        try {
            $user = User::find(auth()->user()->id);
            $paciente = Paciente::with('tipo_documento')
                ->find($user->persona_id);
            /*$hr = HojaRuta::select()
                ->with('estado_ruta')
                ->where('clinica_id', $user->user_rol[0]->rol->clinica_id)
                ->where('hoja_ruta_id',$id_paciente)
                ->where('estado_registro', 'A')
                ->get();*/
        return response()->json(["Paciente" => $paciente /*, "Hoja de Ruta" => $hr*/], 200);
        } catch (Exception $e) {
            return response()->json(["error" => "error", "error" => $e]);
        }
    }
}
