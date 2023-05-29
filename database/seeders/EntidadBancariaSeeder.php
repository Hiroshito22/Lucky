<?php

//namespace Database\Seeders;

use App\Models\EntidadBancaria;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class EntidadBancariaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $bcp_path = storage_path('app\public\entidadBancaria\bcp.jpg');
        // $bcp_file = new UploadedFile($bcp_path, 'bcp.jpg', null, null, true);
        // $bcp_imagen = $bcp_file->storeAs('entidadBancaria', 'bcp.jpg', 'public');

        // $scotiabank_path = storage_path('app\/public\entidadBancaria\scotiabank.jpg');
        // $scotiabank_file = new UploadedFile($scotiabank_path, 'scotiabank.jpg', null, null, true);
        // $scotiabank_imagen = $scotiabank_file->storeAs('entidadBancaria', 'scotiabank.jpg', 'public');

        // $interbank_path = storage_path('app/public/entidadBancaria/interbank.jpg');
        // $interbank_file = new UploadedFile($interbank_path, 'interbank.jpg', null, null, true);
        // $interbank_imagen = $interbank_file->storeAs('entidadBancaria', 'interbank.jpg', 'public');

        // $contents = Storage::get('/entidadBancaria/bcp.jpg');
        $path1 = Storage::url('entidadBancaria/bcp.jpeg');
        $path2 = Storage::url('entidadBancaria/scotiabank.jpeg');
        $path3 = Storage::url('entidadBancaria/interbank.jpeg');
        EntidadBancaria::firstOrCreate(
            [
                "nombre" => "BCP",
                "logo" => $path1,
                "estado_registro" => "A"
            ]
        );

        EntidadBancaria::firstOrCreate(
            [
                "nombre" => "Scotiabank",
                //"logo"=> Storage::url('scotiabank.jpg'),
                "logo" => $path2,
                "estado_registro" => "A",
            ],
            []
        );

        EntidadBancaria::firstOrCreate(
            [
                "nombre" => "Interbank",
                //"logo"=> Storage::url('interbank.jpg'),
                "logo" => $path3,
                "estado_registro" => "A",
            ],
            []
        );
    }
}
