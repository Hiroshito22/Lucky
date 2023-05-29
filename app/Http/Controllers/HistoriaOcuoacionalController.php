<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class HistoriaOcuoacionalController extends Controller
{
    public function pdf_historia_ocupacional()
    {
        $pdf = Pdf::loadView('HistoriaOcupacional');
        return $pdf->setPaper('a4', 'landscape')->stream('HistoriaOcupacional.pdf');

    }

    public function historia_ocupacional()
    {
        $pdf = Pdf::loadView('HistoriaOcupacional');
        return $pdf->setPaper('a4', 'landscape')->download('HistoriaOcupacional.pdf');

    }   
}
