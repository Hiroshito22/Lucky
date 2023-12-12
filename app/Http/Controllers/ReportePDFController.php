<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\RegistroEntradaDetalle;
use App\Models\RegistroSalidaDetalle;
use App\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ReportePDFController extends Controller
{
    public function reporte_equipos_entrada()
    {
        $productos = RegistroEntradaDetalle::with('producto','registro_entrada')->get();
        //return response()->json($productos);
        $datos = [];

        foreach ($productos as $producto) {
            $precio = $producto->precio ?? null;
            $cantidad = $producto->cantidad ?? null;
            $nom_producto = $producto->producto->nom_producto ?? null;
            $fecha_entrada = $producto->registro_entrada->fecha_entrada ?? null;
            $proveedor = $producto->registro_entrada->proveedor ?? null;

            $datos[] = [
                "precio" => $precio ?? null,
                "cantidad" => $cantidad ?? null,
                "nom_producto" => $nom_producto ?? null,
                "fecha_entrada" => $fecha_entrada ?? null,
                "proveedor" => $proveedor ?? null,
            ];
        }

        $pdf = Pdf::loadView('entrada_equipos', compact('datos'));
        return $pdf->stream('entrada_equipos.pdf');
    }
    public function reporte_equipos_stock()
    {
        $productos = Producto::with('marca')
            ->where('estado_registro', 'A')
            ->get();

        $datos = [];

        foreach ($productos as $producto) {
            $nom_producto = $producto->nom_producto ?? null;
            $descripcion = $producto->descripcion ?? null;
            $cantidad = $producto->cantidad ?? null;
            $marca = $producto->marca->nombre ?? null;

            $datos[] = [
                "nom_producto" => $nom_producto ?? null,
                "descripcion" => $descripcion ?? null,
                "cantidad" => $cantidad ?? null,
                "codigo" => $codigo ?? null,
                "marca" => $marca ?? null,
            ];
        }

        $pdf = Pdf::loadView('stock_equipos', compact('datos'));
        return $pdf->stream('stock_equipos');
    }
    public function reporte_equipos_salida()
    {
        $productos = RegistroSalidaDetalle::with('producto', 'registro_salida')->get();

        $datos = [];

        foreach ($productos as $producto) {
            $precio = $producto->precio ?? null;
            $cantidad = $producto->cantidad ?? null;
            $nom_producto = $producto->producto->nom_producto ?? null;
            $fecha_salida = $producto->registro_salida->fecha_salida ?? null;
            $destinatario = $producto->registro_salida->destinatario ?? null;

            $datos[] = [
                "precio" => $precio ?? null,
                "cantidad" => $cantidad ?? null,
                "nom_producto" => $nom_producto ?? null,
                "fecha_salida" => $fecha_salida ?? null,
                "destinatario" => $destinatario ?? null,
            ];
        }

        $pdf = Pdf::loadView('salida_equipos', compact('datos'));
        return $pdf->stream('salida_equipos');
    }
}
