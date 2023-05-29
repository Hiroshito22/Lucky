<?php

namespace App\Http\Controllers;

use App\Models\Religion;
use Illuminate\Http\Request;

class ReligionController extends Controller
{
    public function get()
    {
        $religiones = Religion::get();
        return response()->json(["data"=>$religiones,"size"=>count($religiones)], 200);
    }
}
