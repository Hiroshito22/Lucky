<?php

namespace App\Http\Controllers;

use App\Models\TipoDocumento;
use Illuminate\Http\Request;

class TipoDocumentoController extends Controller
{
    /**
     * Mostrar los Tipos de Documentos
     * @OA\GET (
     *     path="/api/tipodocumentos/get",
     *     summary="Muestra los tipos de cliente con sesión iniciada",
     *     security={{ "bearerAuth": {} }},
     *     tags={"Tipo de Documento"},

     *      @OA\Response(
     *          response=200,
     *          description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="id", type="number", example="1"),
     *              @OA\Property(property="nombre", type="string", example=null),
     *              @OA\Property(property="codigo", type="string", example=null),
     *              @OA\Property(property="descripcion", type="string", example=null),
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
    public function get()
    {
        $tipo_documento = TipoDocumento::get();
        return response()->json(["data"=>$tipo_documento,"size"=>count($tipo_documento)], 200);
    }
}
