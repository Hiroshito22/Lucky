<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportesPDFController extends Controller
{
    public function enfermedade_agravarse_altura_geografica_reporte()
    {
        $pdf = Pdf::loadView('pdfEnfermedadesAgravarseAlturaGeografica');
        return $pdf->download('pdfEnfermedadesAgravarseAlturaGeografica');
    }

    public function ficha_evaluacion_musculo_esqueletica()
    {
        $pdf = Pdf::loadView('pdfFichaEvaluacionMusculoEsqueletica');
        return $pdf->stream('pdfFichaEvaluacionMusculoEsqueletica.pdf');
    }

    public function medicaAscensoGrandesAltitudesReporte()
    {
        $pdf = Pdf::loadView('pdfExample');
        return $pdf->stream('pdfExample');
    }

    public function informe_radiologia()
    {
        $pdf = Pdf::loadView('informe_radiologia');
        return $pdf->download('informe_radiologia');
    }

    public function informe_radiologico()
    {
        $pdf = Pdf::loadView('informe_radiologico');
        return $pdf->stream('informe_radiologico.pdf');
    }

    public function prueba()
    {
        $pdf = Pdf::loadView('prueba');
        return $pdf->stream('prueba.pdf');
    }

    public function fatiga_somnolencia_reporte()
    {
        $pdf = Pdf::loadView('Firstpdf');
        return $pdf->stream('Test_de_Fatiga_y_Somnolencia.pdf');
    }

    public function evaluacion_oftalmologica_reporte()
    {
        $pdf = Pdf::loadView('Secondpdf');
        return $pdf->stream('Ficha_de_Evaluacion_Oftalmologica.pdf');
        $pdf = Pdf::loadView('medicaAscensoGrandesAltitudesReporte');
        return $pdf->stream('medicaAscensoGrandesAltitudesReporte');
    }
    public function pdf_example()
    {
        $pdf = Pdf::loadView('pdfExample');
        return $pdf->download('pdfExample');

    }

    public function medico_ocupacional_reporte()
    {
        $pdf = Pdf::loadView('pdfExample');
        return $pdf->download('pdfExample');

    }
    public function consentimientoRxShow(){
        $persona = [
            'nombre'=> "CONDORI HIDALGO, RENZO JESUS",
            'edad'=>20,
            'sexo'=>'M',
            'nroDocumento'=>'71537459',
            'fecha'=>date('d/m/Y')
        ];
        $pdf = Pdf::loadview('ConsentimientoRx',$persona);
        return $pdf->stream('ConsentimientoRx.pdf');
    }
}
