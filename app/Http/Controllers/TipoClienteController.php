<?php

namespace App\Http\Controllers;

use App\Models\Contrato;
use App\Models\TipoCliente;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TipoClienteController extends Controller
{
    /**
     * Crea un Correo
     * @OA\POST (
     *     path="/api/tipo/cliente/create",
     *     summary="Crea un correo con sesión iniciada",
     *     security={{ "bearerAuth": {} }},
     *     tags={"Tipo de Cliente"},
     *      @OA\Parameter(          
     *          description="Nombre",          
     *          @OA\Schema(type="string"),
     *          name="nombre",
     *          in="query",
     *          required= true                      
     *          ), 
     *      
     *      @OA\Response(
     *          response=200,
     *          description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="id", type="number", example=1),
     *              @OA\Property(property="nombre", type="string", example="nombre"),
     *              @OA\Property(property="estado_registro", type="char", example="A"),
     *          )
     *      ),     
     *      @OA\Response(
     *          response=400,
     *          description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="Error al crear, intentelo de nuevo"),
     *          )
     *      ),
     * )
     */
    public function create(Request $request)
    {
        try {
            DB::beginTransaction();
            $cliente = TipoCliente::create([
                "nombre" => $request->nombre
            ]);
            DB::commit();
            return response()->json($cliente);
        } catch (Exception $e) {
            return response()->json(["resp" => "Error" . $e]);
        }
    }


    /**
     * Actualiza un Tipo de Cliente
     * @OA\PUT (
     *     path="/api/tipo/cliente/update/{id}",
     *     summary="Actualiza un tipo de cliente con sesión iniciada",
     *     security={{ "bearerAuth": {} }},
     *     tags={"Tipo de Cliente"},
     *      @OA\Parameter(          
     *          description="Id del tipo de cliente",          
     *          @OA\Schema(type="number"),
     *          name="id",
     *          in="path",
     *          required= true,
     *          example=1            
     *          ), 
     *      @OA\Parameter(          
     *          description="Nombre",          
     *          @OA\Schema(type="string"),
     *          name="nombre",
     *          in="query",
     *          required= true,
     *          example=null          
     *          ),
     *      @OA\Response(
     *          response=200,
     *          description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="Tipo de cliente actualizado"),
     *          )
     *      ),     
     *      @OA\Response(
     *          response=400,
     *          description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="Error al actualizar, intentelo de nuevo"),
     *          )
     *      ),
     * )
     */
    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $cliente = TipoCliente::find($id);
            //return response()->json($id);
            if ($cliente) {
                $cliente->fill(array(
                    "nombre" => $request->nombre
                ));
                $cliente->save();
                DB::commit();
                return response()->json(["resp" => "Tipo de Cliente actualizado"]);
            } else {
                return response()->json(["resp" => "Id del Tipo no existe"]);
            }
        } catch (Exception $e) {
            return response()->json(["resp" => "Error" . $e]);
        }
    }

    /**
     * Elimina un tipo de cliente
     * @OA\DELETE (
     *     path="/api/tipo/cliente/delete/{id}",
     *     summary="Elimina un tipo de cliente con sesión iniciada",
     *     security={{ "bearerAuth": {} }},
     *     tags={"Tipo de Cliente"},
     *      @OA\Parameter(          
     *          description="Id del tipo de cliente",          
     *          @OA\Schema(type="number"),
     *          name="id",
     *          in="path",
     *          required= true,
     *          example=1            
     *          ), 
     *      @OA\Response(
     *          response=200,
     *          description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="Tipo de Cliente eliminado"),
     *          )
     *      ),     
     *      @OA\Response(
     *          response=400,
     *          description="invalid",
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
            $cliente = TipoCliente::find($Id);
            if ($cliente) {
                $cliente->fill([
                    "estado_registro" => "I",
                ])->save();
                DB::commit();
                return response()->json(["Resp" => "Tipo de Cliente eliminado"]);
            } else {
                return response()->json(["resp" => "Id del Tipo no existe"]);
            }
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(["error" => "error " . $e]);
        }
    }


    /**
     * Mostrar los Tipos de Cliente
     * @OA\GET (
     *     path="/api/tipo/cliente/show",
     *     summary="Muestra los tipos de cliente con sesión iniciada",
     *     security={{ "bearerAuth": {} }},
     *     tags={"Tipo de Cliente"},

     *      @OA\Response(
     *          response=200,
     *          description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="id", type="number", example="1"),
     *              @OA\Property(property="nombre", type="string", example=null),
     *              @OA\Property(property="estado_registro", type="string", example="A"),
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
            $cliente = TipoCliente::where('estado_registro', 'A')->get();
            return response()->json($cliente);
        } catch (Exception $e) {
            return response()->json(["error" => "error", "error" => $e]);
        }
    }


    /**
     * Mostrar los Clientes de acuerdo al tipo elegido
     * @OA\GET (
     *     path="/api/tipo/cliente/get/{id_tipo_cliente}",
     *     summary="Muestra los clientes de un tipo específico con sesión iniciada",
     *     security={{ "bearerAuth": {} }},
     *     tags={"Tipo de Cliente"},
     *      @OA\Parameter(          
     *          description="Id del tipo de cliente",          
     *          @OA\Schema(type="number"),
     *          name="id_tipo_cliente",
     *          in="path",
     *          required= true,
     *          example=1            
     *          ), 
     *      @OA\Response(
     *          response=200,
     *          description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="id", type="number", example="1"),
     *              @OA\Property(property="tipo_cliente_id", type="number", example=1),
     *              @OA\Property(property="bregma_id", type="number", example=1),
     *              @OA\Property(property="clinica_id", type="number", example=1),
     *              @OA\Property(property="empresa_id", type="number", example=1),
     *              @OA\Property(property="fecha_inicio", type="date"),
     *              @OA\Property(property="fecha_vencimiento", type="date"),
     *              @OA\Property(property="estado_contrato", type="number", example=1),
     *              @OA\Property(property="estado_registro", type="string", example="A"),
     *              @OA\Property(type="array",property="tipo_cliente",
     *                  @OA\Items(type="object",
     *                      @OA\Property(property="id", type="number", example=1),
     *                      @OA\Property(property="nombre", type="string", example="corportiva"),
     *                      @OA\Property(property="estado_registro", type="string", example="A"),
     *                  )
     *              ),
     *              @OA\Property(type="array",property="bregma",
     *                  @OA\Items(type="object",
     *                      @OA\Property(property="id", type="number", example=1),
     *                      @OA\Property(property="tipo_documento_id", type="number", example=1),
     *                      @OA\Property(property="distrito_id", type="number", example=1),
     *                      @OA\Property(property="numero_documento", type="string", example="123456789"),
     *                      @OA\Property(property="razon_social", type="string", example="aaaaa"),
     *                      @OA\Property(property="direccion", type="string", example="aaaaaa"),
     *                      @OA\Property(property="estado_pago", type="string", example="a"),
     *                      @OA\Property(property="latitud", type="string", example="aaaaa"),
     *                      @OA\Property(property="longitud", type="string", example="aaaaaaaa"),
     *                      @OA\Property(property="estado_registro", type="string", example="A"),
     *                      @OA\Property(type="array",property="tipo_documento",
     *                          @OA\Items(type="object",
     *                              @OA\Property(property="id", type="number", example=1),
     *                              @OA\Property(property="nombre", type="string"),
     *                              @OA\Property(property="codigo", type="number", example=1),
     *                              @OA\Property(property="descripcion", type="string"),
     *                              @OA\Property(property="estado_registro", type="string", example="A"),
     *                          )
     *                      ),
     *                      @OA\Property(type="array",property="distrito",
     *                          @OA\Items(type="object",
     *                              @OA\Property(property="id", type="number", example=1),
     *                              @OA\Property(property="distrito", type="string", example="MONTEVIDEO"),
     *                              @OA\Property(property="provincia_id", type="number", example=1),
     *                              @OA\Property(type="array",property="provincia",
     *                                  @OA\Items(type="object",
     *                                      @OA\Property(property="id", type="number", example=1),
     *                                      @OA\Property(property="provincia", type="string", example="CHACHAPOYAS"),
     *                                      @OA\Property(property="departamento_id", type="number", example=1),
     *                                      @OA\Property(type="array",property="departamento",
     *                                          @OA\Items(type="object",
     *                                              @OA\Property(property="id", type="number", example=1),
     *                                              @OA\Property(property="departamento", type="string", example="AMAZONAS"),
     *                                          )
     *                                      ),
     *                                  )
     *                              ),
     *                          )
     *                      ),
     *                  )
     *              ),
     *              @OA\Property(type="array",property="clinica",
     *                  @OA\Items(type="object",
     *                      @OA\Property(property="id", type="number", example=1),
     *                      @OA\Property(property="tipo_documento_id", type="number", example="1"),
     *                      @OA\Property(property="distrito_id", type="number", example="1"),
     *                      @OA\Property(property="ruc", type="string", example="123456789"),
     *                      @OA\Property(property="razon_social", type="string", example="corportiva"),
     *                      @OA\Property(property="numero_documento", type="string", example="987654321"),
     *                      @OA\Property(property="responsable", type="string", example="juan"),
     *                      @OA\Property(property="nombre_comercial", type="string", example="juancompany"),
     *                      @OA\Property(property="latitud", type="string", example="12"),
     *                      @OA\Property(property="longitud", type="string", example="21"),
     *                      @OA\Property(property="direccion", type="string", example="12 av."),
     *                      @OA\Property(property="logo", type="string", example="null"),
     *                      @OA\Property(property="estado_registro", type="string", example="A"),
     *                      @OA\Property(type="array",property="tipo_documento",
     *                          @OA\Items(type="object",
     *                              @OA\Property(property="id", type="number", example=1),
     *                              @OA\Property(property="nombre", type="string"),
     *                              @OA\Property(property="codigo", type="number", example=1),
     *                              @OA\Property(property="descripcion", type="string"),
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
    public function get($idTipoCliente)
    {
        try {

            $cliente = TipoCliente::find($idTipoCliente);
            if (!$cliente) {
                return response()->json(["Resp" => "El tipo de cliente no existe"]);
            } else {
                $tipo = Contrato::with(
                    'tipo_cliente',
                    'bregma.tipo_documento',
                    'bregma.distrito.provincia.departamento',
                    'clinica.tipo_documento',
                    'clinica.distrito.provincia.departamento'
                )->where('tipo_cliente_id', $idTipoCliente)->get();
                return response()->json($tipo);
            }
        } catch (Exception $e) {
            return response()->json(["resp" => "Error" . $e]);
        }
    }
}
