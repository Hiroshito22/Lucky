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
            $nom_producto = $producto->nom_producto;
            $descripcion = $producto->descripcion;
            $cantidad = $producto->cantidad;
            $codigo = $producto->producto_detalle->codigo;
            $marca = $producto->producto_detalle->marca->nombre;
            $empresa = $producto->producto_detalle->empresa->razon_social;

            $datos[] = [
                "nom_producto" => $nom_producto,
                "descripcion" => $descripcion,
                "cantidad" => $cantidad,
                "codigo" => $codigo,
                "marca" => $marca,
                "empresa" => $empresa,
            ];
        }

        $pdf = Pdf::loadView('entrada_equipos', compact('datos'));
        return $pdf->stream('entrada_equipos');
    }
    public function reporte_equipos_stock()
    {
        $productos = Producto::with('producto_detalle.marca', 'producto_detalle.empresa')
            ->where('estado_registro', 'A')
            ->get();

        $datos = [];

        foreach ($productos as $producto) {
            $nom_producto = $producto->nom_producto;
            $descripcion = $producto->descripcion;
            $cantidad = $producto->cantidad;
            $codigo = $producto->producto_detalle->codigo;
            $marca = $producto->producto_detalle->marca->nombre;

            $datos[] = [
                "nom_producto" => $nom_producto,
                "descripcion" => $descripcion,
                "cantidad" => $cantidad,
                "codigo" => $codigo,
                "marca" => $marca,
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
            $nom_producto = $producto->nom_producto;
            $descripcion = $producto->descripcion;
            $cantidad = $producto->cantidad;
            $codigo = $producto->producto_detalle->codigo;
            $marca = $producto->producto_detalle->marca->nombre;

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
