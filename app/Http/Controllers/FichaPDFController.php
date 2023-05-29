<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class FichaPDFController extends Controller
{
    public function pdf_ficha()
    {
       // $ordenA = 0;
       // $ordenA++;
        $persona = [
            "nombre" => "YERSON RAUL",
            "apellido" => "QUISPE BAZAN",
            "ocupacion" => "OPERARIO DE ALMACEN DE ALUMINIOS",
            "empresa"=> "VIDRIERIA LIMA TAMBOSOCIEDAD ANONIMA CERRADA",
            "plan"=>"OPERARIO+ALTURA NOV 2022",
            "doc"=>"71612169",
            "edad"=>"26 años",
            "fecha"=>"30/12/2022",

            "ordenAtencion"=>"76837"

           // "ordenAtencion"=>$ordenA++

        ];
        $pdf = Pdf::loadView('pdfFicha',$persona);
        return $pdf->stream('pdfFicha.pdf');
    }

    public function medico_ocupacional_reporte()
    {
        $pdf = Pdf::loadView('pdfExample');
        return $pdf->download('pdfExample');
    }
}
