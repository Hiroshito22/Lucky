<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class CertificadoSuficienciaMedicaTrabajosAlturaController extends Controller
{
    public function pdf_certificado_suficiencia_medica_trabajos_altura()
    {
        $pdf = Pdf::loadView('CertificadoSuficienciaMedicaTrabajosAltura');
        return $pdf->stream('CertificadoSuficienciaMedicaTrabajosAltura.pdf');

    }

    public function certificado_suficiencia_medica_trabajos_altura()
    {
        $pdf = Pdf::loadView('CertificadoSuficienciaMedicaTrabajosAltura');
        return $pdf->download('CertificadoSuficienciaMedicaTrabajosAltura.pdf');

    }
}
