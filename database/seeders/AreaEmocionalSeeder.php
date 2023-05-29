<?php

// namespace Database\Seeders;

use App\Models\AreaEmocional;
use Illuminate\Database\Seeder;

class AreaEmocionalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AreaEmocional::firstOrCreate(
            [
                "nombre"=>"Se aprecia colaborador durante la entrevista",
                "estado_registro"=>"A",
            ],
            []
        );
        AreaEmocional::firstOrCreate(
            [
                "nombre"=>"Se aprecia colaboradora durante la entrevista",
                "estado_registro"=>"A",
            ],
            []
        );
        AreaEmocional::firstOrCreate(
            [
                "nombre"=>"Se percibe amable en el trato con los demás",
                "estado_registro"=>"A",
            ],
            []
        );
        AreaEmocional::firstOrCreate(
            [
                "nombre"=>"Se aprecia cordial en la entrevista",
                "estado_registro"=>"A",
            ],
            []
        );
        AreaEmocional::firstOrCreate(
            [
                "nombre"=>"Se aprecia cordial y colaborador en la entrevista",
                "estado_registro"=>"A",
            ],
            []
        );
        AreaEmocional::firstOrCreate(
            [
                "nombre"=>"Se aprecia cordial y colaborador en la entrevista, Su autoestima es adecuada",
                "estado_registro"=>"A",
            ],
            []
        );
        AreaEmocional::firstOrCreate(
            [
                "nombre"=>"Se aprecia cordial y colaborador en la entrevista. Su personalidad tiende a la introversión. Ante situaciones adversas",
                "estado_registro"=>"A",
            ],
            []
        );
        AreaEmocional::firstOrCreate(
            [
                "nombre"=>"Se aprecia cordial y colaborador en la entrevista. Su personalidad tiende a la introversión. Posee recursos internos",
                "estado_registro"=>"A",
            ],
            []
        );
        AreaEmocional::firstOrCreate(
            [
                "nombre"=>"Se aprecia reservada en la entrevista",
                "estado_registro"=>"A",
            ],
            []
        );
    }
}
