<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\SoporteContacto;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SoporteContactoController extends Controller
{
    /**
     * Crea un Contacto Soporte
     * @OA\POST (
     *     path="/api/contacto/soporte/create",
     *     summary="Crea un soporte con sesión iniciada",
     *     security={{ "bearerAuth": {} }},
     *     tags={"Contacto Soporte"},
     *      @OA\Parameter(description="Celular",
     *          @OA\Schema(type="string"), name="celular1", in="query", required= true
     *      ),
     *      @OA\Parameter(description="Celular",
     *          @OA\Schema(type="string"),name="celular2",in="query",required= true
     *      ), 
     *      @OA\Parameter(description="Correo",
     *          @OA\Schema(type="string"),name="correo1",in="query",required= true
     *      ),
     *      @OA\Parameter(description="Correo",
     *          @OA\Schema(type="string"),name="correo2",in="query",required= true
     *      ), 
     *      @OA\Parameter(description="Telefono",
     *          @OA\Schema(type="string"),name="telefono1",in="query",required= true
     *      ), 
     *      @OA\Parameter(description="Telefono",
     *          @OA\Schema(type="string"),name="telefono2",in="query",required= true
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
            SoporteContacto::create([
                "celular1" => $request->celular1,
                "celular2" => $request->celular2,
                "correo1" => $request->correo1,
                "correo2" => $request->correo2,
                "telefono1" => $request->telefono1,
                "telefono2" => $request->telefono2,
                "bregma_id" => $userbregma->user_rol[0]->rol->bregma_id
            ]);
            DB::commit();
            return response()->json(["resp" => "Contacto Soporte creado"]);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(["error" => "error " . $e]);
        }
    }



    /**
     * Actualiza un Soporte Bregma
     * @OA\PUT (
     *     path="/api/contacto/soporte/update/{id}",
     *     summary="Actualiza un soporte con sesión iniciada",
     *     security={{ "bearerAuth": {} }},
     *     tags={"Contacto Soporte"},
     *      @OA\Parameter(description="Id",          
     *          @OA\Schema(type="number"),name="id",in="path",required= true,example=1            
     *      ), 
     *      @OA\Parameter(description="Celular",
     *          @OA\Schema(type="string"), name="celular1", in="query", required= true
     *      ),
     *      @OA\Parameter(description="Celular",
     *          @OA\Schema(type="string"),name="celular2",in="query",required= true
     *      ), 
     *      @OA\Parameter(description="Correo",
     *          @OA\Schema(type="string"),name="correo1",in="query",required= true
     *      ),
     *      @OA\Parameter(description="Correo",
     *          @OA\Schema(type="string"),name="correo2",in="query",required= true
     *      ), 
     *      @OA\Parameter(description="Telefono",
     *          @OA\Schema(type="string"),name="telefono1",in="query",required= true
     *      ), 
     *      @OA\Parameter(description="Telefono",
     *          @OA\Schema(type="string"),name="telefono2",in="query",required= true
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
            $soporte = SoporteContacto::find($Idsoporte);
            if ($soporte) {
                $soporte->fill(array(
                    "celular1" => $request->celular1,
                    "celular2" => $request->celular2,
                    "correo1" => $request->correo1,
                    "correo2" => $request->correo2,
                    "telefono1" => $request->telefono1,
                    "telefono2" => $request->telefono2
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
     *     path="/api/contacto/soporte/delete/{id}",
     *     summary="Elimina un Soporte con sesión iniciada",
     *     security={{ "bearerAuth": {} }},
     *     tags={"Contacto Soporte"},
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
            $soporte = SoporteContacto::find($Id);
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
     *     path="/api/contacto/soporte/show",
     *     summary="Muestra los Soportes con sesión iniciada",
     *     security={{ "bearerAuth": {} }},
     *     tags={"Contacto Soporte"},
     *      @OA\Response(response=200,description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="id", type="number", example=1),
     *              @OA\Property(property="celular1", type="string", example="Juan"),
     *              @OA\Property(property="celular2", type="string", example="juan.com"),
     *              @OA\Property(property="correo1", type="string", example="juan.com"),
     *              @OA\Property(property="correo2", type="string", example="juan.com"),
     *              @OA\Property(property="telefono1", type="string", example="juan.com"),
     *              @OA\Property(property="telefono2", type="string", example="juan.com"),
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
            $soporte = SoporteContacto::with('bregma.tipo_documento')
                ->where('bregma_id', $userbregma->user_rol[0]->rol->bregma_id)
                ->where('estado_registro', 'A')
                ->get();
            return response()->json(["data" => $soporte, "size" => count($soporte)], 200);
        } catch (Exception $e) {
            return response()->json(["error" => "error", "error" => $e]);
        }
    }
}
