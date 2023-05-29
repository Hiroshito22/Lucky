<?php

// namespace Database\Seeders;

use App\Models\AreaMedica;
use App\Models\Capacitacion;
use App\Models\ClinicaPaquete;
use App\Models\Examen;
use App\Models\Laboratorio;
use App\Models\Perfil;
use App\Models\PerfilArea;
use App\Models\PerfilCapacitacion;
use App\Models\PerfilExamen;
use App\Models\PerfilLaboratorio;
use App\Models\PerfilTipo;
use App\Models\TipoPerfil;
use App\User;
use Illuminate\Database\Seeder;

class ClinicaPaqueteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $clinica_paquete = ClinicaPaquete::firstOrCreate([
            "nombre" => "paquete1",
            "clinica_id" => 1,
            "clinica_servicio_id" => 1,
            "precio" => 51840,
        ]);
        // $perf = ClinicaPaquete::where('estado_registro','A')->where('id',$clinica_paquete->id)->get();
        $per = Perfil::firstOrCreate([
            'clinica_paquete_id' => $clinica_paquete->id,
            'nombre' => "perfil1",
            'precio' => 51840,
        ]);
        // $tipo_perf = TipoPerfil::where('estado_registro','A')->where('id',1)->get();

        $per_tip_en = PerfilTipo::create([
            'perfil_id' => $per->id,
            'tipo_perfil_id' => 1,
            'precio' => 51840,
        ]);

        $area_med = PerfilArea::create([
            'perfil_tipo_id' => $per_tip_en->id,
            'area_medica_id' => 1,
        ]);


        $capac = PerfilCapacitacion::create([
            'perfil_tipo_id' => $per_tip_en->id,
            'capacitacion_id' => 1,
        ]);


        $exam = PerfilExamen::create([
            'perfil_tipo_id' => $per_tip_en->id,
            'examen_id' => 1,
        ]);


        $laborat = PerfilLaboratorio::create([
            'perfil_tipo_id' => $per_tip_en->id,
            'laboratorio_id' => 1,
        ]);
        $per_tip_rut = PerfilTipo::create([
            'perfil_id' => $per->id,
            'tipo_perfil_id' => 2,
            'precio' => 51840,
        ]);

        $area_med = PerfilArea::create([
            'perfil_tipo_id' => $per_tip_rut->id,
            'area_medica_id' => 1,
        ]);


        $capac = PerfilCapacitacion::create([
            'perfil_tipo_id' => $per_tip_rut->id,
            'capacitacion_id' => 1,
        ]);


        $exam = PerfilExamen::create([
            'perfil_tipo_id' => $per_tip_rut->id,
            'examen_id' => 1,
        ]);


        $laborat = PerfilLaboratorio::create([
            'perfil_tipo_id' => $per_tip_rut->id,
            'laboratorio_id' => 1,
        ]);

        $per_tip_sal = PerfilTipo::create([
            'perfil_id' => $per->id,
            'tipo_perfil_id' => 3,
            'precio' => 51840,
        ]);

        $area_med = PerfilArea::create([
            'perfil_tipo_id' => $per_tip_sal->id,
            'area_medica_id' => 1,
        ]);


        $capac = PerfilCapacitacion::create([
            'perfil_tipo_id' => $per_tip_sal->id,
            'capacitacion_id' => 1,
        ]);


        $exam = PerfilExamen::create([
            'perfil_tipo_id' => $per_tip_sal->id,
            'examen_id' => 1,
        ]);


        $laborat = PerfilLaboratorio::create([
            'perfil_tipo_id' => $per_tip_sal->id,
            'laboratorio_id' => 1,
        ]);

                    //--------
                    $area_med_sal_2 = PerfilArea::create([
                        'perfil_tipo_id'=>$per_tip_sal->id,
                        'area_medica_id'=>2,
                    ]);
                
                
                    $capac_sal_2 = PerfilCapacitacion::create([
                        'perfil_tipo_id'=>$per_tip_sal->id,
                        'capacitacion_id'=>2,
                    ]);
                
                
                    $exam_sal_2 = PerfilExamen::create([
                        'perfil_tipo_id'=>$per_tip_sal->id,
                        'examen_id'=>2,
                    ]);
                
                
                    $laborat_sal_2 = PerfilLaboratorio::create([
                        'perfil_tipo_id'=>$per_tip_sal->id,
                        'laboratorio_id'=>2,
                    ]);
                    //-------
                    $area_med_sal_1 = PerfilArea::create([
                        'perfil_tipo_id'=>$per_tip_sal->id,
                        'area_medica_id'=>3,
                    ]);
                
                
                    $capac_sal_1 = PerfilCapacitacion::create([
                        'perfil_tipo_id'=>$per_tip_sal->id,
                        'capacitacion_id'=>3,
                    ]);
                
                
                    $exam_sal_1 = PerfilExamen::create([
                        'perfil_tipo_id'=>$per_tip_sal->id,
                        'examen_id'=>3,
                    ]);
                
                
                    $laborat_sal_1 = PerfilLaboratorio::create([
                        'perfil_tipo_id'=>$per_tip_sal->id,
                        'laboratorio_id'=>3,
                    ]);
        
        //clinica_paquete 2------

        $clinica_paquete_2 = ClinicaPaquete::firstOrCreate([
            "nombre" => "paquete2",
            "clinica_id" => 1,
            "clinica_servicio_id" => 1,
            "precio" => 51840,
        ]);
        // $perf = ClinicaPaquete::where('estado_registro','A')->where('id',$clinica_paquete->id)->get();
        $per_2 = Perfil::firstOrCreate([
            'clinica_paquete_id' => $clinica_paquete_2->id,
            'nombre' => "perfil2",
            'precio' => 51840,
        ]);
        // $tipo_perf = TipoPerfil::where('estado_registro','A')->where('id',1)->get();

        $per_tip_ent_2 = PerfilTipo::create([
            'perfil_id' => $per_2->id,
            'tipo_perfil_id' => 1,
            'precio' => 51840,
        ]);

        $area_med = PerfilArea::create([
            'perfil_tipo_id' => $per_tip_ent_2->id,
            'area_medica_id' => 1,
        ]);


        $capac = PerfilCapacitacion::create([
            'perfil_tipo_id' => $per_tip_ent_2->id,
            'capacitacion_id' => 1,
        ]);


        $exam = PerfilExamen::create([
            'perfil_tipo_id' => $per_tip_ent_2->id,
            'examen_id' => 1,
        ]);


        $laborat = PerfilLaboratorio::create([
            'perfil_tipo_id' => $per_tip_ent_2->id,
            'laboratorio_id' => 1,
        ]);
        $per_tip_rut_2 = PerfilTipo::create([
            'perfil_id' => $per_2->id,
            'tipo_perfil_id' => 2,
            'precio' => 51840,
        ]);

        $area_med = PerfilArea::create([
            'perfil_tipo_id' => $per_tip_rut_2->id,
            'area_medica_id' => 1,
        ]);


        $capac = PerfilCapacitacion::create([
            'perfil_tipo_id' => $per_tip_rut_2->id,
            'capacitacion_id' => 1,
        ]);


        $exam = PerfilExamen::create([
            'perfil_tipo_id' => $per_tip_rut_2->id,
            'examen_id' => 1,
        ]);


        $laborat = PerfilLaboratorio::create([
            'perfil_tipo_id' => $per_tip_rut_2->id,
            'laboratorio_id' => 1,
        ]);

        $per_tip_sal_2 = PerfilTipo::create([
            'perfil_id' => $per_2->id,
            'tipo_perfil_id' => 3,
            'precio' => 51840,
        ]);

        $area_med = PerfilArea::create([
            'perfil_tipo_id' => $per_tip_sal_2->id,
            'area_medica_id' => 1,
        ]);


        $capac = PerfilCapacitacion::create([
            'perfil_tipo_id' => $per_tip_sal_2->id,
            'capacitacion_id' => 1,
        ]);


        $exam = PerfilExamen::create([
            'perfil_tipo_id' => $per_tip_sal_2->id,
            'examen_id' => 1,
        ]);


        $laborat = PerfilLaboratorio::create([
            'perfil_tipo_id' => $per_tip_sal_2->id,
            'laboratorio_id' => 1,
        ]);
    }
}
