<?php

namespace App\Http\Controllers\Clinica;

use App\Http\Controllers\Controller;
use App\Models\TutorialClinica;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TutorialClinicaController extends Controller
{
    /**
     * Crea un Clinica Soporte
     * @OA\POST (
     *     path="/api/clinica/soporte/create",
     *     summary="Crea un soporte con sesión iniciada",
     *     security={{ "bearerAuth": {} }},
     *     tags={"Clinica Soporte"},
     *      @OA\Parameter(description="Nombre",
     *          @OA\Schema(type="string"), name="nombre", in="query", required= true
     *      ),
     *      @OA\Parameter(description="Link",
     *          @OA\Schema(type="string"),name="link",in="query",required= true
     *      ),      
     *      @OA\Response(response=200,description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="Soporte creado"),
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
            $userbregma = User::with('user_rol.rol')->where('id', auth()->user()->id)->first();
            TutorialClinica::create([
                "nombre" => $request->nombre,
                "bregma_id" => $userbregma->user_rol[0]->rol->bregma_id,
                "link" => $request->link
            ]);
            DB::commit();
            return response()->json(["resp" => "Clinica Soporte creado"]);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(["error" => "error " . $e]);
        }
    }



    /**
     * Actualiza un Soporte Clinica
     * @OA\PUT (
     *     path="/api/clinica/soporte/update/{id}",
     *     summary="Actualiza un soporte con sesión iniciada",
     *     security={{ "bearerAuth": {} }},
     *     tags={"Clinica Soporte"},
     *      @OA\Parameter(description="Id",          
     *          @OA\Schema(type="number"),name="id",in="path",required= true,example=1            
     *      ), 
     *      @OA\Parameter(description="Nombre",
     *          @OA\Schema(type="string"),name="nombre",in="query",required= true
     *      ),
     *      @OA\Parameter(description="Link",
     *          @OA\Schema(type="string"),name="link",in="query",required= true
     *      ),
     *      @OA\Response(response=200,description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="Soporte actualizado"),
     *          )
     *      ),     
     *      @OA\Response(response=400,description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="Error al actualizar, intentelo de nuevo"),
     *          )
     *      ),
     * )
     */
    public function update(Request $request, $Idsoporte)
    {
        DB::beginTransaction();
        try {
            $soporte = TutorialClinica::find($Idsoporte);
            if ($soporte) {
                $soporte->fill(array(
                    "nombre" => $request->nombre,
                    "link" => $request->link
                ));
                $soporte->save();
                DB::commit();
                return response()->json(["resp" => "Soporte actualizado"]);
            } else {
                return response()->json(["resp" => "El ID no existe en la Base de Datos"]);
            }
        } catch (Exception $e) {
            return response()->json(["resp" => "Error" . $e]);
        }
    }



    /**
     * Elimina un Soporte
     * @OA\DELETE (
     *     path="/api/clinica/soporte/delete/{id}",
     *     summary="Elimina un Soporte con sesión iniciada",
     *     security={{ "bearerAuth": {} }},
     *     tags={"Clinica Soporte"},
     *      @OA\Parameter(description="Id",          
     *          @OA\Schema(type="number"),name="id",in="path",required= true,example=1            
     *      ), 
     *      @OA\Response(response=200,description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="Soporte eliminado"),
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
            $soporte = TutorialClinica::find($Id);
            if ($soporte) {
                $soporte->fill([
                    "estado_registro" => "I",
                ])->save();
                DB::commit();
                return response()->json(["Resp" => "Soporte eliminado"]);
            } else {
                return response()->json(["resp" => "El ID no existe en la Base de Datos"]);
            }
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(["error" => "error " . $e]);
        }
    }



    /**
     * Mostrar los Soportes
     * @OA\GET (
     *     path="/api/clinica/soporte/show",
     *     summary="Muestra los Soportes con sesión iniciada",
     *     security={{ "bearerAuth": {} }},
     *     tags={"Clinica Soporte"},
     *      @OA\Response(response=200,description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="id", type="number", example=1),
     *              @OA\Property(property="nombre", type="string", example="Juan"),
     *              @OA\Property(property="link", type="string", example="juan.com"),
     *              @OA\Property(property="bregma_id", type="number", example=1),
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
     *          )
     *      ),     
     *      @OA\Response(
     *          response=400,
     *          description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="Error al mostrar, intentelo de nuevo"),
     *          )
     *      ),
     * )
     */
    public function show()
    {
        try {
            $userbregma = User::with('user_rol.rol')->where('id', auth()->user()->id)->first();
            $bregmalocal = TutorialClinica::with('bregma.tipo_documento')
                ->where('bregma_id', $userbregma->user_rol[0]->rol->bregma_id)
                ->where('estado_registro', 'A')
                ->get();
            return response()->json(["data" => $bregmalocal, "size" => count($bregmalocal)], 200);
        } catch (Exception $e) {
            return response()->json(["error" => "error", "error" => $e]);
        }
    }
}
