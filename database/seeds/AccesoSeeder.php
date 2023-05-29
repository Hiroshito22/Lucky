<?php

use Illuminate\Database\Seeder;
use App\Models\Acceso;

class AccesoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // superadmin

        // hospital
        $perfil = Acceso::firstOrCreate(
            [
                "icon" => "pi pi-box",
                "label" => "Perfil",
                "url" => "perfil",
                "parent_id" => null,
                "tipo_acceso" => 1,
                "tipo" => 0
            ],
            [
            ]
        );

        $operaciones = Acceso::firstOrCreate(
            [
                "icon" => "pi pi-box",
                "label" => "Operaciones",
                "url" => "operaciones",
                "parent_id" => null,
                "tipo_acceso" => 1,
                "tipo" => 0
            ],
            [
            ]
        );

        $servicios = Acceso::firstOrCreate(
            [
                "icon" => "pi pi-box",
                "label" => "Servicios",
                "url" => "servicios",
                "parent_id" => $operaciones->id,
                "tipo_acceso" => 1,
                "tipo" => 0
            ],
            [

            ]
        );

        $productoServicio = Acceso::firstOrCreate(
            [
                "icon" => "pi pi-box",
                "label" => "Productos y Servicios",
                "url" => "productosyservicios",
                "parent_id" => null,
                "tipo_acceso" => 1,
                "tipo" => 0
            ],
            [
            ]
        );
        $productos = Acceso::firstOrCreate(
            [
                "icon" => "pi pi-box",
                "label" => "Productos",
                "url" => "productos",
                "parent_id" => $productoServicio->id,
                "tipo_acceso" => 1,
                "tipo" => 0
            ],
            [
            ]
        );
        $servicios = Acceso::firstOrCreate(
            [
                "icon" => "pi pi-box",
                "label" => "Servicios",
                "url" => "servicios",
                "parent_id" => $productoServicio->id,
                "tipo_acceso" => 1,
                "tipo" => 0
            ],
            [
            ]
        );




        $ventas = Acceso::firstOrCreate(
            [
                "icon" => "pi pi-building",
                "label" => "Ventas",
                "url" => "ventas",
                "parent_id" => null,
                "tipo_acceso" => 1,
                "tipo" => 0
            ],
            [

            ]
        );
        $gestiondeventas = Acceso::firstOrCreate(
            [
                "icon" => "pi pi-building",
                "label" => "Gestion de Ventas",
                "url" => "gestiondeventas",
                "parent_id" => $ventas->id,
                "tipo_acceso" => 1,
                "tipo" => 0
            ],
            [

            ]
        );
        $clientes = Acceso::firstOrCreate(
            [
                "icon" => "pi pi-building",
                "label" => "Clientes",
                "url" => "clientes",
                "parent_id" => $ventas->id,
                "tipo_acceso" => 1,
                "tipo" => 0
            ],
            [

            ]
        );
        $recursosHumanos = Acceso::firstOrCreate(
            [
                "icon" => "pi pi-building",
                "label" => "Recursos Humanos",
                "url" => "recursoshumanos",
                "parent_id" => null,
                "tipo_acceso" => 1,
                "tipo" => 0
            ],
            [

            ]
        );
        $locales = Acceso::firstOrCreate(
            [
                "icon" => "pi pi-building",
                "label" => "Mis Locales",
                "url" => "locales",
                "parent_id" => $recursosHumanos->id,
                "tipo_acceso" => 1,
                "tipo" => 0
            ],
            [

            ]
        );
        $areas = Acceso::firstOrCreate(
            [
                "icon" => "pi pi-building",
                "label" => "Mis Áreas",
                "url" => "areas",
                "parent_id" => $recursosHumanos->id,
                "tipo_acceso" => 1,
                "tipo" => 0
            ],
            [

            ]
        );
        $roles = Acceso::firstOrCreate(
            [
                "icon" => "pi pi-building",
                "label" => "Roles",
                "url" => "roles",
                "parent_id" => $recursosHumanos->id,
                "tipo_acceso" => 1,
                "tipo" => 0
            ],
            [

            ]
        );
        $personal = Acceso::firstOrCreate(
            [
                "icon" => "pi pi-building",
                "label" => "Personal",
                "url" => "personal",
                "parent_id" => $recursosHumanos->id,
                "tipo_acceso" => 1,
                "tipo" => 0
            ],
            [

            ]
        );
        $reclutamiento = Acceso::firstOrCreate(
            [
                "icon" => "pi pi-building",
                "label" => "Reclutamiento",
                "url" => "reclutamiento",
                "parent_id" => $recursosHumanos->id,
                "tipo_acceso" => 1,
                "tipo" => 0
            ],
            [

            ]
        );
        $serviciosprestados = Acceso::firstOrCreate(
            [
                "icon" => "pi pi-building",
                "label" => "Servicios Prestados",
                "url" => "serviciosprestados",
                "parent_id" => $recursosHumanos->id,
                "tipo_acceso" => 1,
                "tipo" => 0
            ],
            [

            ]
        );
        $contabilidad = Acceso::firstOrCreate(
            [
                "icon" => "pi pi-building",
                "label" => "Contabilidad",
                "url" => "contabilidad",
                "parent_id" => null,
                "tipo_acceso" => 1,
                "tipo" => 0
            ],
            [

            ]
        );
        $costoporatencion = Acceso::firstOrCreate(
            [
                "icon" => "pi pi-building",
                "label" => "Costo po Atención",
                "url" => "contabilidad",
                "parent_id" => $contabilidad->id,
                "tipo_acceso" => 1,
                "tipo" => 0
            ],
            [

            ]
        );
        $facturacion = Acceso::firstOrCreate(
            [
                "icon" => "pi pi-building",
                "label" => "Facturación",
                "url" => "facturacion",
                "parent_id" => $contabilidad->id,
                "tipo_acceso" => 1,
                "tipo" => 0
            ],
            [

            ]
        );
        $mispagos = Acceso::firstOrCreate(
            [
                "icon" => "pi pi-building",
                "label" => "Mis pagos",
                "url" => "pagos",
                "parent_id" => $contabilidad->id,
                "tipo_acceso" => 1,
                "tipo" => 0
            ],
            [

            ]
        );
        $estadisticas = Acceso::firstOrCreate(
            [
                "icon" => "pi pi-building",
                "label" => "Estadísticas",
                "url" => "estadisticas",
                "parent_id" => null,
                "tipo_acceso" => 1,
                "tipo" => 0
            ],
            [

            ]
        );
        $soportetecnico = Acceso::firstOrCreate(
            [
                "icon" => "pi pi-building",
                "label" => "Soporte Técnico",
                "url" => "soportetecnico",
                "parent_id" => null,
                "tipo_acceso" => 1,
                "tipo" => 0
            ],
            [

            ]
        );

        //CLINICA
        $perfil = Acceso::firstOrCreate(
            [
                "icon" => "pi pi-box",
                "label" => "Perfil",
                "url" => "perfil",
                "parent_id" => null,
                "tipo_acceso" => 2,
                "tipo" => 0,
            ],
            [

            ]
        );
        $operaciones = Acceso::firstOrCreate(
            [
                "icon" => "pi pi-box",
                "label" => "Operaciones",
                "url" => "operaciones",
                "parent_id" => null,
                "tipo_acceso" => 2,
                "tipo" => 0,
            ],
            [

            ]
        );
        $servicios = Acceso::firstOrCreate(
            [
                "icon" => "pi pi-box",
                "label" => "Servicios",
                "url" => "servicios",
                "parent_id" => $operaciones->id,
                "tipo_acceso" => 2,
                "tipo" => 0,
            ],
            [

            ]
        );
        $productoServicio = Acceso::firstOrCreate(
            [
                "icon" => "pi pi-box",
                "label" => "Productos y Servicios",
                "url" => "productosyservicios",
                "parent_id" => null,
                "tipo_acceso" => 2,
                "tipo" => 0,
            ],
            [

            ]
        );
        $productos = Acceso::firstOrCreate(
            [
                "icon" => "pi pi-box",
                "label" => "Productos",
                "url" => "productos",
                "parent_id" => $productoServicio->id,
                "tipo_acceso" => 2,
                "tipo" => 0,
            ],
            [

            ]
        );
        $servicios = Acceso::firstOrCreate(
            [
                "icon" => "pi pi-box",
                "label" => "Servicios",
                "url" => "servicios",
                "parent_id" => $productoServicio->id,
                "tipo_acceso" => 2,
                "tipo" => 0,
            ],
            [

            ]
        );

        $ventas = Acceso::firstOrCreate(
            [
                "icon" => "pi pi-building",
                "label" => "Ventas",
                "url" => "ventas",
                "parent_id" => null,
                "tipo_acceso" => 2,
                "tipo" => 0,
            ],
            [

            ]
        );
        $recursosHumanos = Acceso::firstOrCreate(
            [
                "icon" => "pi pi-building",
                "label" => "Recursos Humanos",
                "url" => "recursoshumanos",
                "parent_id" => null,
                "tipo_acceso" => 2,
                "tipo" => 0,
            ],
            [

            ]
        );
        $contabilidad = Acceso::firstOrCreate(
            [
                "icon" => "pi pi-building",
                "label" => "Contabilidad",
                "url" => "contabilidad",
                "parent_id" => null,
                "tipo_acceso" => 2,
                "tipo" => 0,
            ],
            [

            ]
        );
        $estadisticas = Acceso::firstOrCreate(
            [
                "icon" => "pi pi-building",
                "label" => "Estadísticas",
                "url" => "estadisticas",
                "parent_id" => null,
                "tipo_acceso" => 2,
                "tipo" => 0,
            ],
            [

            ]
        );
        $soportetecnico = Acceso::firstOrCreate(
            [
                "icon" => "pi pi-building",
                "label" => "Soporte Técnico",
                "url" => "soportetecnico",
                "parent_id" => null,
                "tipo_acceso" => 2,
                "tipo" => 0,
            ],
            [

            ]
        );
        $soportetecnico = Acceso::firstOrCreate(
            [
                "icon" => "pi pi-building",
                "label" => "Atención",
                "url" => "atencion",
                "parent_id" => null,
                "tipo_acceso" => 2,
                "tipo" => 0,
            ],
            [

            ]
        );
        $recepcion = Acceso::firstOrCreate(
            [
                "icon" => "pi pi-building",
                "label" => "Recepción",
                "url" => "recepcion",
                "parent_id" => null,
                "tipo_acceso" => 2,
                "tipo" => 1,
            ],
            [

            ]
        );
        $triaje = Acceso::firstOrCreate(
            [
                "icon" => "pi pi-building",
                "label" => "Triaje",
                "url" => "triaje",
                "parent_id" => null,
                "tipo_acceso" => 2,
                "tipo" => 1,
            ],
            [

            ]
        );
        $psicologia = Acceso::firstOrCreate(
            [
                "icon" => "pi pi-building",
                "label" => "Psicología",
                "url" => "psicologia",
                "parent_id" => null,
                "tipo_acceso" => 2,
                "tipo" => 1,
            ],
            [

            ]
        );
        $ekg = Acceso::firstOrCreate(
            [
                "icon" => "pi pi-building",
                "label" => "EKG",
                "url" => "ekg",
                "parent_id" => null,
                "tipo_acceso" => 2,
                "tipo" => 1,
            ],
            [

            ]
        );
        $oftalmologia = Acceso::firstOrCreate(
            [
                "icon" => "pi pi-building",
                "label" => "Oftalmología",
                "url" => "oftalmologia",
                "parent_id" => null,
                "tipo_acceso" => 2,
                "tipo" => 1,
            ],
            [

            ]
        );
        $audiometria = Acceso::firstOrCreate(
            [
                "icon" => "pi pi-building",
                "label" => "Audiometría",
                "url" => "audiometria",
                "parent_id" => null,
                "tipo_acceso" => 2,
                "tipo" => 1,
            ],
            [

            ]
        );
        $radiologia = Acceso::firstOrCreate(
            [
                "icon" => "pi pi-building",
                "label" => "Radiología",
                "url" => "radiologia",
                "parent_id" => null,
                "tipo_acceso" => 2,
                "tipo" => 1,
            ],
            [

            ]
        );
        Acceso::firstOrCreate(
            [
                "icon" => "pi pi-building",
                "label" => "Perfil",
                "url" => "perfil",
                "parent_id" => null,
                "tipo_acceso" => 3,
                "tipo" => 0,
            ],
            [

            ]
        );
        Acceso::firstOrCreate(
            [
                "icon" => "pi pi-building",
                "label" => "Productos y Servicios",
                "url" => "productosyservicios",
                "parent_id" => null,
                "tipo_acceso" => 3,
                "tipo" => 0,
            ],
            [

            ]
        );
        Acceso::firstOrCreate(
            [
                "icon" => "pi pi-building",
                "label" => "Recursos Humanos",
                "url" => "recursoshumanos",
                "parent_id" => null,
                "tipo_acceso" => 3,
                "tipo" => 0,
            ],
            [

            ]
        );
        Acceso::firstOrCreate(
            [
                "icon" => "pi pi-building",
                "label" => "Gestión de atenciones",
                "url" => "gestionatenciones",
                "parent_id" => null,
                "tipo_acceso" => 3,
                "tipo" => 0,
            ],
            [

            ]
        );
        Acceso::firstOrCreate(
            [
                "icon" => "pi pi-building",
                "label" => "Cerco Epidemiológico",
                "url" => "cercoepidemiologico",
                "parent_id" => null,
                "tipo_acceso" => 3,
                "tipo" => 0,
            ],
            [

            ]
        );
        Acceso::firstOrCreate(
            [
                "icon" => "pi pi-building",
                "label" => "Soporte Técnico",
                "url" => "soportetecnico",
                "parent_id" => null,
                "tipo_acceso" => 3,
                "tipo" => 0,
            ],
            [

            ]
        );
        //         $acceso = Acceso::firstOrCreate(
        //             [
        //                 "icon"=> "pi pi-building",
        //                 "label"=> "Clinica",
        //                 "url"=> "/clinicas",
        //             ],[
        //                 "tipo_acceso"=>2
        //             ]
        //         );
        //         $acceso = Acceso::firstOrCreate(
        //             [
        //                 "icon"=> "pi pi-map-marker",
        //                 "label"=> "Sucursal",
        //                 "url"=> "/sucursalEmpresa",
        //             ],[
        //                 "tipo_acceso"=>3
        //             ]
        //         );
        //         $acceso = Acceso::firstOrCreate(
        //             [
        //                 "icon"=> "pi pi-folder",
        //                 "label"=> "Areas",
        //                 "url"=> "/areas",
        //             ],[
        //                 "tipo_acceso"=>3
        //             ]
        //         );
        //         $acceso = Acceso::firstOrCreate(
        //             [
        //                 "icon"=> "pi pi-users",
        //                 "label"=> "Trabajador",
        //                 "url"=> "/trabajadorEmpresa",
        //             ],[
        //                 "tipo_acceso"=>3
        //             ]
        //         );
        //         $acceso = Acceso::firstOrCreate(
        //             [
        //                 "icon"=> "pi pi-heart",
        //                 "label"=> "Atenciones",
        //                 "url"=> "/atenciones",
        //             ],[
        //                 "tipo_acceso"=>3
        //             ]
        //         );
        //         $acceso = Acceso::firstOrCreate(
        //             [
        //                 "icon"=> "pi pi-sitemap",
        //                 "label"=> "Rol",
        //                 "url"=> "/rolHospital",
        //             ],[
        //                 "tipo_acceso"=>2
        //             ]
        //         );
        //         $acceso = Acceso::firstOrCreate(
        //             [
        //                 "icon"=> "pi pi-sitemap",
        //                 "label"=> "Rol",
        //                 "url"=> "/rolEmpresa",
        //             ],[
        //                 "tipo_acceso"=>3
        //             ]
        //         );
        //         Acceso::firstOrCreate(
        //             [
        //                 "icon"=> "pi pi-check-square",
        //                 "label"=> "Cargos",
        //                 "url"=> "/cargosEmpresa",
        //             ],[
        //                 "tipo_acceso"=>3
        //             ]
        //         );
        //         $acceso = Acceso::firstOrCreate(
        //             [
        //                 "icon"=> "pi pi-server",
        //                 "label"=> "Cargos",
        //                 "url"=> "/cargosHospital",
        //             ],[
        //                 "tipo_acceso"=>2
        //             ]
        //         );
        //         $acceso = Acceso::firstOrCreate(
        //             [
        //                 "icon"=> "pi pi-user",
        //                 "label"=> "Personal",
        //                 "url"=> "/personalHospital",
        //             ],[
        //                 "tipo_acceso"=>2
        //             ]
        //         );
        //         $acceso = Acceso::firstOrCreate(
        //             [
        //                 "icon"=> "pi pi-user",
        //                 "label"=> "Patología",
        //                 "url"=> "/patologias",
        //             ],[
        //                 "tipo_acceso"=>2
        //             ]
        //         );
        //         Acceso::firstOrCreate(
        //             [
        //                 "icon"=> "pi pi-users",
        //                 "label"=> "Pacientes",
        //                 "url"=> "/recepcion/pacientes",
        //             ],[
        //                 "tipo_acceso"=>2
        //             ]
        //         );
        //         Acceso::firstOrCreate(
        //             [
        //                 "icon"=> "pi pi-heart",
        //                 "label"=> "Atencion",
        //                 "url"=> "/recepcion/atenciones",
        //             ],[
        //                 "tipo_acceso"=>2
        //             ]
        //         );
        //         Acceso::firstOrCreate(
        //             [
        //                 "icon"=> "pi pi-book",
        //                 "label"=> "Detalle Facturación",
        //                 "url"=> "/facturacion/empresa",
        //             ],[
        //                 "tipo_acceso"=>2
        //             ]
        //         );
        //         Acceso::firstOrCreate(
        //             [
        //                 "icon"=> "pi pi-car",
        //                 "label"=> "Transportista",
        //                 "url"=> "/transportista",
        //             ],[
        //                 "tipo_acceso"=>2
        //             ]
        //         );
        //         Acceso::firstOrCreate(
        //             [
        //                 "icon"=> "pi pi-money-bill",
        //                 "label"=> "Costo",
        //                 "url"=> "/facturacion/costo",
        //             ],[
        //                 "tipo_acceso"=>2
        //             ]
        //         );

        //         Acceso::firstOrCreate(
        //             [
        //                 "icon"=> "pi pi-folder",
        //                 "label"=> "Material",
        //                 "url"=> "/material",
        //             ],[
        //                 "tipo_acceso"=>2
        //             ]
        //         );


        //         Acceso::firstOrCreate(
        //             [
        //                 "icon"=> "pi pi-wallet",
        //                 "label"=> "Liquidación",
        //                 "url"=> "/facturacion/liquidacion",
        //             ],[
        //                 "tipo_acceso"=>2
        //             ]
        //         );
        //         Acceso::firstOrCreate(
        //             [
        //                 "icon"=> "pi pi-wallet",
        //                 "label"=> "Liquidación",
        //                 "url"=> "/empresa/liquidacion",
        //             ],[
        //                 "tipo_acceso"=>3
        //             ]
        //         );
    }
}
