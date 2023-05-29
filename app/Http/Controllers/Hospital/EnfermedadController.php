<?php

namespace App\Http\Controllers\Hospital;

use App\Http\Controllers\Controller;
use App\Models\Enfermedad;
use App\Models\EnfermedadGeneral;
use Illuminate\Http\Request;

class EnfermedadController extends Controller
{
    public function index()
    {
        $enfermedades = EnfermedadGeneral::get();
        return response()->json(["data" => $enfermedades, "size" => count($enfermedades)]);
    }
}
