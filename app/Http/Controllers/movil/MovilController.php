<?php

namespace App\Http\Controllers\movil;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\Models\Trabajador;
use App\Models\Persona;
use App\Models\Atencion;
use App\Models\AtencionServicio;
use App\User;

class MovilController extends Controller
{
    public function me(){
        $trabajador = Trabajador::with('empresa','sucursal','subarea',
        'persona','cargo','tipo_trabajador')->where('persona_id',auth()->user()->persona_id)->first();

        return response()->json($trabajador?:array('resp' => 'El trabajador no existe'));
    }

    public function update(Request $request){
        $persona = Persona::find(auth()->user()->persona_id);

        if(!$persona){
            return response()->json(['resp' => 'Trabajador no encontrado']);
        }
        
        $persona->fill([
            'nombres' => $request->nombres ?? $persona->nombres,
            'apellido_paterno' => $request->apellido_paterno ?? $persona->apellido_paterno,
            'apellido_materno' => $request->apellido_materno ?? $persona->apellido_materno,
            'fecha_nacimiento' => $request->fecha_nacimiento ?? $persona->fecha_nacimiento,
            'celular' => $request->celular ?? $persona->celular,
            'telefono' => $request->telefono ?? $persona->telefono,
            'direccion' => $request->direccion ?? $persona->direccion,
            'telefono_emergencia' => $request->telefono_emergencia ?? $persona->telefono_emergencia,
            'contacto_emergencia' => $request->contacto_emergencia ?? $persona->contacto_emergencia,
            'tipo_documento_id' => $request->tipo_documento_id ?? $persona->tipo_documento_id,
            'numero_documento' => $request->numero_documento ?? $persona->numero_documento,
            'distrito_id' => $request->distrito_id ?? $persona->distrito_id,
            'email' => $request->email ?? $persona->email,
            'distrito_domicilio_id' => $request->distrito_domicilio_id ?? $persona->distrito_domicilio_id,
            'estado_civil_id' => $request->estado_civil_id ?? $persona->estado_civil_id,
            'religion_id' => $request->religion_id ?? $persona->religion_id,
            'sexo_id' => $request->sexo_id ?? $persona->sexo_id,
            'grado_instruccion_id' => $request->grado_instruccion_id,
        ])->save();

        if(isset($request->numero_documento) and ($persona->numero_documento != $request->numero_documento)){
            $update_user = User::where('persona_id',$persona->id)->first();
            $update_user->update([
                'username' => $request->numero_documento,
                'password' => Hash::make($request->numero_documento)
            ]);
        }

        return response()->json(['resp' => 'Datos actualizados correctamente!']);
    }

    public function historical(){
        $trabajador = Trabajador::where('persona_id','=',auth()->user()->persona_id)->first();
        $atenciones = Atencion::with('atencion_servicio')->where('trabajador_id',$trabajador->id)->where('estado_atencion',2)->get();

        return response()->json($atenciones);
    }

    public function solicitudes(){
        $trabajador = Trabajador::where('persona_id','=',auth()->user()->persona_id)->first();
        $atenciones = Atencion::with('atencion_servicio')->where('trabajador_id',$trabajador->id)->where('estado_atencion','!=',2)->get();

        return response()->json($atenciones);
    }
}