<?php


use Illuminate\Database\Seeder;
use App\Models\TipoDocumento;

class TipoDocumentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        TipoDocumento::firstOrcreate([
            "nombre"=>"DNI",
            "descripcion"=>"Documento Nacional de Identidad",
        ]);
        TipoDocumento::firstOrcreate([
            "nombre"=>"RUC",
            "descripcion"=>"Registro Unico Contribuyente",
        ]);
    }
}
