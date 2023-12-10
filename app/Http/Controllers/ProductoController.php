<?php

namespace App\Http\Controllers;

use App\Models\Almacen;
use App\Models\AlmacenProducto;
use App\Models\Persona;
use App\Models\Producto;
use App\Models\ProductoDetalle;
use App\Models\Trabajador;
use App\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductoController extends Controller
{
    public function create(Request $request)
    {
        DB::beginTransaction();
        try {
            $usuario = User::with('persona')->where('id', auth()->user()->id)->first();
            $producto = Producto::create([
                "nom_producto" => $request->nom_producto,
                "descripcion" => $request->descripcion,
                //"foto" => $request->foto,
                "cantidad" => $request->cantidad
            ]);
            $detalle = ProductoDetalle::create([
                "codigo" => $request->codigo,
                "marca_id" => $request->marca_id,
                "empresa_id" => 1,
                "producto_id" => $producto->id
            ]);
            DB::commit();
            return response()->json(["resp" => "Producto creado correctamente"], 200);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(["error" => "error " . $e], 500);
        }
    }

    public function update(Request $request, $id_producto)
    {
        DB::beginTransaction();
        try {
            $datos = User::with('persona')->where('id', auth()->user()->id)->first();
            $producto = Producto::where('id', $id_producto)->first();
            $detalle = ProductoDetalle::where('producto_id', $id_producto)->first();
            $producto->fill([
                "nom_producto" => $request->nom_producto,
                "descripcion" => $request->descripcion,
                //"foto" => $request->foto,
                "cantidad" => $request->cantidad
            ])
                ->save();
            $detalle->fill([
                "codigo" => $request->codigo,
                "marca_id" => $request->marca_id,
            ])->save();
            DB::commit();
            return response()->json(["resp" => "Producto actualizado correctamente"], 200);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(["error" => "error " . $e], 500);
        }
    }

    public function delete($id_producto)
    {
        DB::beginTransaction();
        try {
            $datos = User::with('persona')->where('id', auth()->user()->id)->first();
            $persona = Producto::find($id_producto);
            $detalle = ProductoDetalle::where('producto_id', $id_producto)->first();
            $persona->fill([
                "estado_registro" => "I",
            ])->save();
            $detalle->fill([
                "estado_registro" => "I",
            ])->save();
            DB::commit();
            return response()->json(["resp" => "Producto eliminada correctamente"], 200);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(["error" => "error " . $e], 500);
        }
    }

    public function get()
    {
        try {
            $usuario = User::with('persona')->where('id', auth()->user()->id)->first();

            $trabajador = Producto::with('producto_detalle.marca', 'producto_detalle.empresa')->where('estado_registro', 'A')->get();

            return response()->json(["data" => $trabajador, "size" => (count($trabajador))], 200);
        } catch (Exception $e) {
            return response()->json(["resp" => "error", "error" => "Error al llamar a los productos  " . $e], 400);
        }
    }

    public function salida_productos(Request $request, $id_producto)
    {
        try {
            $producto = Producto::find($id_producto);
            //return response()->json($producto);
            $cantidad_producto = $request->cantidad_producto;
            if ($producto->cantidad < $cantidad_producto) return response()->json(["resp" => "No hay suficientes productos"]);
            $resultado = $producto->cantidad - $cantidad_producto;
            $producto->fill([
                'cantidad' => $resultado
            ])->save();
            return response()->json(["resp" => "Producto exportado exitosamente"]);
        } catch (Exception $e) {
            return response()->json(["resp" => "error", "error" => "Error al exportar los productos  " . $e], 400);
        }
    }

    public function entrada_productos(Request $request, $id_producto)
    {
        try {
            $producto = Producto::find($id_producto);
            //return response()->json($producto);
            $cantidad_producto = $request->cantidad_producto;
            $resultado = $producto->cantidad + $cantidad_producto;
            $producto->fill([
                'cantidad' => $resultado
            ])->save();
            return response()->json(["resp" => "Producto importado exitosamente"]);
        } catch (Exception $e) {
            return response()->json(["resp" => "error", "error" => "Error al importar los productos  " . $e], 400);
        }
    }
    public function asignar_almacen(Request $request, $id_producto)
    {
        DB::beginTransaction();
        try {
            $usuario = User::with('persona')->where('id', auth()->user()->id)->first();
            $producto_existe = Producto::find($id_producto);
            $almacen_existe = Almacen::where('id', $request->almacen_id)->first();
            if ($almacen_existe) {
                if ($producto_existe) {
                    $producto = AlmacenProducto::updateOrCreate(
                        [
                            "producto_id" => $id_producto,
                        ],
                        $request->all()
                    );
                    DB::commit();
                    return response()->json(["resp" => "Producto asignado correctamente"], 200);
                } else {
                    return response()->json(["resp" => "No existe producto"]);
                }
            } else {
                return response()->json(["resp" => "No hay almacen para asignar"]);
            }
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(["error" => "error " . $e], 500);
        }
    }
    public function crear_varios_producto(Request $request)
    {
        // Obtén los productos del cuerpo de la solicitud
        $productos = $request->productos;

        // Inicia una transacción en la base de datos
        DB::beginTransaction();

        try {
            // Itera sobre los productos
            foreach ($productos as $productoData) {
                // Crea un nuevo producto en la base de datos
                $producto = Producto::create([
                    "nom_producto" => $productoData['nom_producto'],
                    "descripcion" => $productoData['descripcion'],
                    "cantidad" => $productoData['cantidad']
                ]);

                // Crea un nuevo detalle de producto en la base de datos
                $detalle = ProductoDetalle::create([
                    "codigo" => $productoData['codigo'],
                    "marca_id" => $productoData['marca_id'],
                    "empresa_id" => 1,
                    "producto_id" => $producto->id
                ]);
            }

            // Confirma la transacción si todo se realizó correctamente
            DB::commit();

            // Devuelve una respuesta exitosa
            return response()->json(["resp" => "Productos creados correctamente"], 200);
        } catch (\Exception $e) {
            // Revierte la transacción en caso de error
            DB::rollback();

            // Devuelve una respuesta de error
            return response()->json(["resp" => "Error al crear productos"], 500);
        }
    }
    public function asignar_productos_almacen(Request $request)
    {
        // Obtén los productos del cuerpo de la solicitud
        $productos = $request->productos;

        // Inicia una transacción en la base de datos
        DB::beginTransaction();

        try {
            // Itera sobre los productos
            foreach ($productos as $productoData) {
                // Crea un nuevo producto en la base de datos
                $producto = AlmacenProducto::updateOrCreate(
                    [
                        "producto_id" => $productoData['producto_id'],
                    ],
                    [
                        "producto_id" => $productoData['producto_id'],
                        "fecha_entrada" => Carbon::now(),
                        "almacen_id" => 1
                    ]

                );
            }

            // Confirma la transacción si todo se realizó correctamente
            DB::commit();

            // Devuelve una respuesta exitosa
            return response()->json(["resp" => "Productos asignados correctamente"], 200);
        } catch (\Exception $e) {
            // Revierte la transacción en caso de error
            DB::rollback();

            // Devuelve una respuesta de error
            return response()->json(["resp" => "Error al crear productos ".$e], 500);
        }
    }
}
