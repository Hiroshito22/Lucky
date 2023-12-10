<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ReportePDFController extends Controller
{
    public function reporte_equipos_entrada()
    {
        $productos = Producto::with('producto_detalle.marca', 'producto_detalle.empresa')
            ->where('estado_registro', 'A')
            ->get();

        $datos = [];

        foreach ($productos as $producto) {
            $nom_producto = $producto->nom_producto ?? null;
            $descripcion = $producto->descripcion ?? null;
            $cantidad = $producto->cantidad ?? null;
            $codigo = $producto->producto_detalle->codigo ?? null;
            $marca = $producto->producto_detalle->marca->nombre ?? null;
            $empresa = $producto->producto_detalle->empresa->razon_social ?? null;

            $datos[] = [
                "nom_producto" => $nom_producto ?? null,
                "descripcion" => $descripcion ?? null,
                "cantidad" => $cantidad ?? null,
                "codigo" => $codigo ?? null,
                "marca" => $marca ?? null,
                "empresa" => $empresa ?? null,
            ];
        }

        $pdf = Pdf::loadView('entrada_equipos', compact('datos'));
        return $pdf->stream('entrada_equipos.pdf');
    }
    public function reporte_equipos_stock()
    {
        $productos = Producto::with('producto_detalle.marca', 'producto_detalle.empresa')
            ->where('estado_registro', 'A')
            ->get();

        $datos = [];

        foreach ($productos as $producto) {
            $nom_producto = $producto->nom_producto ?? null;
            $descripcion = $producto->descripcion ?? null;
            $cantidad = $producto->cantidad ?? null;
            $codigo = $producto->producto_detalle->codigo ?? null;
            $marca = $producto->producto_detalle->marca->nombre ?? null;

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
        $productos = Producto::with('producto_detalle.marca', 'producto_detalle.empresa')
            ->where('estado_registro', 'A')
            ->get();

        $datos = [];

        foreach ($productos as $producto) {
            $nom_producto = $producto->nom_producto ?? null;
            $descripcion = $producto->descripcion ?? null;
            $cantidad = $producto->cantidad ?? null;
            $codigo = $producto->producto_detalle->codigo ?? null;
            $marca = $producto->producto_detalle->marca->nombre ?? null;

            $datos[] = [
                "nom_producto" => $nom_producto,
                "descripcion" => $descripcion,
                "cantidad" => $cantidad,
                "codigo" => $codigo,
                "marca" => $marca,
            ];
        }

        $pdf = Pdf::loadView('salida_equipos', compact('datos'));
        return $pdf->stream('salida_equipos');
    }
}
