<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
        /**
         * Seed the application's database.
         *
         * @return void
         */
        public function run()
        {
                //superadmin
                $this->call(TipoPatologiaSeeder::class);
                $this->call(PatologiaSeeder::class);
                $this->call(TipoEvaluacionSeeder::class);
                $this->call(AccesoSeeder::class);
                $this->call(TipoDocumentoSeeder::class);
                $this->call(TipoTrabajadorSeeder::class);
                // $this->call(RolSeeder::class);
                $this->call(TipoVehiculoSeeder::class);
                $this->call(ReligionSeeder::class);
                $this->call(EstadoCivilSeeder::class);
                $this->call(GradoInstruccionSeeder::class);
                $this->call(SexoSeeder::class);
                $this->call(DepartamentoSeeder::class);
                $this->call(ProvinciaSeeder::class);
                $this->call(DistritoSeeder::class);
                $this->call(SuperadminSeeder::class);
                $this->call(ServicioSeeder::class);
                //fin necesario//
                ///$this->call(DiaSeeder::class);
                $this->call(DeporteSeeder::class);
                $this->call(EnfermedadSeeder::class);

                //$this->call(EnfermedadGeneralSeeder::class);
                //$this->call(EnfermedadEspecificaSeeder::class);
                /*$this->call(PaqueteSeeder::class);
        $this->call(ProductoSeeder::class);
        $this->call(TrabajadorSeeder::class);
        */
                $this->call(EntidadBancariaSeeder::class);
                //$this->call(AtencionPruebaSeeder::class);
                $this->call(ClinicaSeeder::class);
                $this->call(EmpresaSeeder::class);
                $this->call(HabitoNocivoSeeder::class);
                $this->call(FrecuenciaSeeder::class);
                $this->call(TiempoSeeder::class);
                //$this->call(TipoClinicaSeeder::class);
                //$this->call(SucursalClinicaSeeder::class);
                //$this->call(RolClinicaSeeder::class);
                //$this->call(EspecialidadClinicaSeeder::class);

                /*$this->call(PatologiasSeeder::class);
        $this->call(FamiliarSeeder::class);
        $this->call(MedidasSeguridadSeeder::class);
        $this->call(PrincipalesRiesgosSeeder::class);
        //$this->call(ParienteSeeder::class);*/
                //$this->call(EmpresaPaqueteSeeder::class);
                $this->call(TipoClienteSeeder::class);
                $this->call(EvaluacionPsicopatologicaSeeder::class);
                $this->call(EvaluacionOrganicaSeeder::class);
                $this->call(EvaluacionEmocionalSeeder::class);
                $this->call(SanoMentalmenteSeeder::class);
                $this->call(TipoEstresSeeder::class);
                $this->call(TestSomnolendaSeeder::class);
                $this->call(TestFatigaSeeder::class);
                $this->call(EntidadBancariaSeeder::class);
                $this->call(MotivoEvaluacionSeeder::class);
                $this->call(PrincipalRiesgoSeeder::class);
                $this->call(MedidaSeguridadSeeder::class);
                $this->call(HistoriaFamiliarSeeder::class);
                $this->call(AccidentesEnfermedadesSeeder::class);
                $this->call(HabitosSeeder::class);
                $this->call(PersepcionSeeder::class);
                $this->call(OtrasObservacionesSeeder::class);

                $this->call(RecomendacionesSeeder::class);
                $this->call(ResultadoSeeder::class);
                $this->call(AreaCognitivaSeeder::class);
                $this->call(AreaEmocionalSeeder::class);

                $this->call(ClinicaServicioSeeder::class);
                $this->call(ServicioClinicaSeeder::class);

                $this->call(ConductorSeeder::class);
                $this->call(CorrectoresSeeder::class);

                $this->call(PersonaMentalSeeder::class);
                $this->call(CoordinacionVisomotrizSeeder::class);
                $this->call(PresentacionSeeder::class);
                $this->call(PosturaSeeder::class);
                $this->call(RitmoSeeder::class);
                $this->call(TonoSeeder::class);
                $this->call(ArticulacionSeeder::class);
                $this->call(EspacioSeeder::class);
                //$this->call(ExamenMentalSeeder::class);

                $this->call(LucidoAtentoSeeder::class);
                $this->call(PensamientoSeeder::class);
                $this->call(PercepcionSeeder::class);
                $this->call(MemoriaSeeder::class);
                $this->call(InteligenciaSeeder::class);
                $this->call(ApetitoSeeder::class);
                $this->call(SuennoSeeder::class);
                $this->call(PersonalidadSeeder::class);
                $this->call(AfectividadSeeder::class);
                $this->call(ConductaSexualSeeder::class);
                $this->call(CirculosSeeder::class);
                $this->call(StereoFlyTestSeeder::class);

                $this->call(PruebaSeeder::class);
                $this->call(MedidaCercaSeeder::class);
                $this->call(MedidaLejosSeeder::class);
                $this->call(RubroSeeder::class);

                $this->call(TipoPerfilSeeder::class);
                $this->call(AreaMedicaSeeder::class);
                $this->call(CapacitacionSeeder::class);
                $this->call(ExamenSeeder::class);
                $this->call(LaboratorioSeeder::class);
                $this->call(EnfermedadesOcularesSeeder::class);
                $this->call(EnfermedadesSistemicosSeeder::class);
                $this->call(BregmaPaqueteSeeder::class);
                //Opcion
                $this->call(EnfermedadOcularSeeder::class);
                $this->call(VisionColoresSeeder::class);
                $this->call(ReflejoPupilarSeeder::class);
                $this->call(OjoDerechoSeeder::class);
                $this->call(OjoIzquierdoSeeder::class);
                $this->call(ClinicaPaqueteSeeder::class);
                $this->call(BregmaServicioSeeder::class);
                $this->call(EstadoRutaSeeder::class);
        }
}
