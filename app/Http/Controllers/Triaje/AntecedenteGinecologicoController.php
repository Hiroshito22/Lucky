<?php

namespace App\Http\Controllers\Triaje;

use App\Http\Controllers\Controller;
use App\Models\AntecedenteGinecologico;
use App\Models\Gestaciones;
use App\Models\Mamografia;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AntecedenteGinecologicoController extends Controller
{
    public function index()
    {
        try {
            $antecendente_ginecologico = AntecedenteGinecologico::where('estado_registro', 'A')->with('mamografia','gestaciones')->get();
            if (!$antecendente_ginecologico) {
                return response()->json(["error"=> "No se encuentran antecentes ginecológicos"],400);
            }else {
                return response()->json(["data" => $antecendente_ginecologico,"size"=>count($antecendente_ginecologico)]);
            }
        } catch (Exception $e) {
            return response()->json(["error" => "error " . $e]);
        }
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $mamo=$request->mamografia;
                $mamografia= Mamografia::create([
                    'se_hizo' => $mamo['se_hizo'],
                    'fecha' => $mamo['fecha'],
                    'estado' => $mamo['estado'],
                    'resultado' => $mamo['resultado'],
                ]);
            $gesta=$request->gestaciones;
                $gestaciones= Gestaciones::create([
                    'gestaciones'=> $gesta['gestaciones'],
                    'abortos'=> $gesta['abortos'],
                    'partos'=> $gesta['partos'],
                    'p_prematuros'=> $gesta['p_prematuros'],
                    'p_eutacico'=> $gesta['p_eutacico'],
                    'p_distocias'=> $gesta['p_distocias'],
                    'cesareas'=> $gesta['cesareas'],
                    'fecha_cesarea'=> $gesta['fecha_cesarea'],
                ]);
            AntecedenteGinecologico::create([
                'fur' => $request->fur,
                'rc' => $request->rc,
                'fup' => $request->fup,
                'menarquia' => $request->menarquia,
                'ultimopap' => $request->ultimopap,
                'estado' => $request->estado,
                'mamografia_id' => $mamografia->id,
                'gestaciones_id' => $gestaciones->id,
                'metodos_anticonceptivos' =>$request->metodos_anticonceptivos
            ]);
            DB::commit();
            return response()->json(["resp" => "El antecente ginecológico fue creado correctamente"],200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["Error: El antecente ginecológico no se ha creado" => "".$e],501);
        }
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $antecedente = AntecedenteGinecologico::where('estado_registro', 'A')->find($id);
            //return response()->json($antecedente);
            if(!$antecedente){
                return response()->json(["error" => "El antecente ginecológico no se encuentra activo o no existe"],400);
            }
            $mamo=$request->mamografia;
                $mamografia= Mamografia::where('id',$antecedente->mamografia_id)->first();
                $mamografia->fill([    
                    'se_hizo' => $mamo['se_hizo'],
                    'fecha' => $mamo['fecha'],
                    'estado' => $mamo['estado'],
                    'resultado' => $mamo['resultado'],
                    ])->save();
            $gesta=$request->gestaciones;
                $gestaciones= Gestaciones::where('id',$antecedente->gestaciones_id)->first();
                $gestaciones->fill([  
                    'gestaciones'=> $gesta['gestaciones'],
                    'abortos'=> $gesta['abortos'],
                    'partos'=> $gesta['partos'],
                    'p_prematuros'=> $gesta['p_prematuros'],
                    'p_eutacico'=> $gesta['p_eutacico'],
                    'p_distocias'=> $gesta['p_distocias'],
                    'cesareas'=> $gesta['cesareas'],
                    'fecha_cesarea'=> $gesta['fecha_cesarea'],
                ])->save();
            $antecedente->fill([
                'fur' => $request->fur,
                'rc' => $request->rc,
                'fup' => $request->fup,
                'menarquia' => $request->menarquia,
                'ultimopap' => $request->ultimopap,
                'estado' => $request->estado,
                'mamografia' => $mamografia->id,
                'gestaciones' => $gestaciones->id,
                'metodos_anticonceptivos' =>$request->metodos_anticonceptivos
                ])->save();
            DB::commit();
            return response()->json(["resp" => "Antecedente Ginecológico actualizado correctamente"],200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["Error: El antecente ginecológico no se ha actualizado" => $e],501);
        }
    }

    /**
     * Activar  
     * @OA\Put (
     *     path="/api/triaje/antecedenteginecologico/activate/{id}",
     *     summary = "Activando Datos de AntecedentesGinecológicos",
     *     security={{ "bearerAuth": {} }},
     *     tags={"Triaje - AntecedentesGinecologicos"},
     *     @OA\Parameter(description="Ingresar el ID por activar",in="path",name="id",required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response=200,description="success",
     *         @OA\JsonContent(
     *             @OA\Property(property="resp", type="string", example="El antecente ginecológico activado correctamente")
     *         )
     *     ),
     *     @OA\Response(response=404,description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="El antecente ginecológico no existe"),
     *              )
     *          ),
     *     @OA\Response(response=401,description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="El antecente ginecológico a activar ya está activado"),
     *              )
     *          ),
     *     @OA\Response(response=501,description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="Error: El antecente ginecológico no se ha activado"),
     *              )
     *          ),
     * )
    */

    public function activate($id)
    {
        DB::beginTransaction();
        try {
            $activate = AntecedenteGinecologico::where('estado_registro', 'I')->find($id);
            $exists = AntecedenteGinecologico::find($id);
            if(!$exists){
                return response()->json(["error"=>"El antecente ginecológico no existe"],402);
            }
            if(!$activate){
                return response()->json(["error" => "El antecente ginecológico a activar ya está activado"],401);
            }
            $activate->fill([
                'estado_registro' => 'A',
            ])->save();
            DB::commit();
            return response()->json(["resp" => "El antecente ginecológico activado correctamente"],200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["Error: El antecente ginecológico no se ha activado" => $e],501);
        }
    }

/**
     * Delete
     * @OA\Delete (
     *     path="/api/triaje/antecedenteginecologico/delete/{id}",
     *     summary = "Eliminando Datos de AntecedentesGinecológicos",
     *     security={{ "bearerAuth": {} }},
     *     tags={"Triaje - AntecedentesGinecologicos"},
     *     @OA\Parameter(description="Ingresar el ID por eliminar",in="path",name="id",required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response=200,description="success",
     *         @OA\JsonContent(
     *             @OA\Property(property="resp", type="string", example="Antecedente Ginecológico eliminado correctamente")
     *         )
     *     ),
     *     @OA\Response(response=401,description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="El antecente ginecológico a eliminar ya está inactivado"),
     *              )
     *          ),
     *     @OA\Response(response=404,description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="El antecente ginecológico a eliminar no se encuentra"),
     *              )
     *          ),
     *     @OA\Response(response=501,description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="Error: El antecente ginecológico no se ha eliminado"),
     *              )
     *          ),
     * )
     */


    public function destroy($id)
     {
         DB::beginTransaction();
         try {
                 $registro1 = AntecedenteGinecologico::where('estado_registro', 'I')->find($id);
                 if($registro1) return response()->json(["Error" => "El antecente ginecológico a eliminar ya está inactivado"],401);
                 $registro = AntecedenteGinecologico::where('estado_registro', 'A')->find($id);
                 if(!$registro) return response()->json(["Error" => "El antecente ginecológico a eliminar no se encuentra"],402);
                 $registro->fill([
                     'estado_registro' => 'I',
                 ])->save();
             DB::commit();
             return response()->json(["resp" => "Antecedente Ginecológico eliminado correctamente"],200);
         } catch (Exception $e) {
             DB::rollBack();
             return response()->json(["Error: El antecente ginecológico no se ha eliminado" => $e],501);
         }
     }
}


