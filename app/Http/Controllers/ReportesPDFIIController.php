<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportesPDFIIController extends Controller
{
    public function CertSufMedicaConduccDeVehiculos()
    {
        $pdf = Pdf::loadView('CertSufMedicaConduccDeVehiculos');
        return $pdf->stream('CertSufMedicaConduccDeVehiculos');
    }
}
