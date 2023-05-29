<?php

use App\Models\Paquete;
use Illuminate\Database\Seeder;
use App\Models\Producto;
use App\Models\Servicio;
use App\Models\ServicioProducto;
use App\Models\ProductoPaquete;
class PaqueteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $paquete = Paquete::firstOrCreate(
            [
                "nombre"=>"EMO"
            ],
            [
                "precio"=>110
            ]
        );
        //1er producto
        $producto = Producto::firstOrCreate(
            [
                "nombre"=>"Preocupacional"
            ],
            [
                "precio"=>50.00
            ]
        );
        //1er servicio
        $servicio = Servicio::firstOrCreate(
            [
                "nombre"=>"psicologia",
                //"especialidad_medical_id"=>"2"
            ],
            [
                "precio"=>5.55
            ]
        );
        $producto_servicio=ServicioProducto::firstOrCreate(
            [
                "producto_id"=>$producto->id,
                "servicio_id"=>$servicio->id,
            ],
            [

            ]
        );
        $paquete_producto = ProductoPaquete::firstOrCreate(
            [
                "producto_id"=>$producto_servicio->producto_id,
                "paquete_id"=>$paquete->id,
            ],
            []
        );
        //2do producto
        $producto = Producto::firstOrCreate(
            [
                "nombre"=>"Ocupacional"
            ],
            [
                "precio"=>60.00
            ]
        );
        //2do servicio
        $servicio = Servicio::firstOrCreate(
            [
                "nombre"=>"Triaje",
                //"especialidad_medical_id"=>1,
            ],
            [
                "precio"=>2.50
            ]
        );
        $producto_servicio=ServicioProducto::firstOrCreate(
            [
                "producto_id"=>$producto->id,
                "servicio_id"=>$servicio->id,
            ],
            [

            ]
        );
        $paquete_producto = ProductoPaquete::firstOrCreate(
            [
                "producto_id"=>$producto_servicio->producto_id,
                "paquete_id"=>$paquete->id,
            ],
            []
        );

        //segundo paquete
        $paquete = Paquete::firstOrCreate(
            [
                "nombre"=>"Segundo Paquete"
            ],
            [
                "precio"=>200
            ]
        );
        /*$paquete_precio = PaquetePrecio::create([
            "precio"=>$paquete->precio,
            "paquete_id"=>$paquete->id
        ]);*/
        //2do producto
        $producto = Producto::firstOrCreate(
            [
                "nombre"=>"Segundo Producto"
            ],
            [
                "precio"=>70.00
            ]
        );
        /*$precio_producto = ProductoPrecio::create(
            [
                "precio"=>50.00,
                "producto_id"=>$producto->id,
            ]
        );*/
        /*$precio_producto = ProductoPrecio::create(
            [
                "precio"=>60.00,
                "producto_id"=>$producto->id,
            ]
        );*/
        //2do servicio
        $servicio = Servicio::firstOrCreate(
            [
                "nombre"=>"Psicología",
                //"especialidad_medical_id"=>"2"
            ],
            [
                "precio"=>15.55
            ]
        );
        /*$precio_servicio = ServicioPrecio::create(
            [
                "precio"=>7.50,
                "servicio_id"=>$servicio->id,
            ]
        );
        $precio_servicio = ServicioPrecio::create(
            [
                "precio"=>4.55,
                "servicio_id"=>$servicio->id,
            ]
        );*/
        /*$subservicio = Subservicio::firstOrCreate(
            [
                "nombre"=>"test de estres",
                "servicio_id"=>$servicio->id,
            ],
            []
        );*/
        $producto_servicio=ServicioProducto::firstOrCreate(
            [
                "producto_id"=>$producto->id,
                "servicio_id"=>$servicio->id,
            ],
            [

            ]
        );
        /*$paquete_producto_servicio = PaqueteProductoServicio::firstOrCreate(
            [
                "producto_servicio_id"=>$producto_servicio->id,
                "servicio_id"=>$producto_servicio->servicio_id,
                "producto_id"=>$producto_servicio->producto_id,
                "paquete_id"=>$paquete->id,
            ],
            []
        );*/
        $paquete_producto = ProductoPaquete::firstOrCreate(
            [
                "producto_id"=>$producto_servicio->producto_id,
                "paquete_id"=>$paquete->id,
            ],
            []
        );
        //3er producto
        $producto = Producto::firstOrCreate(
            [
                "nombre"=>"Tercer Producto"
            ],
            [
                "precio"=>65.00
            ]
        );
        /*$precio_producto = ProductoPrecio::create(
            [
                "precio"=>65.00,
                "producto_id"=>$producto->id,
            ]
        );*/
        //3er servicio
        $servicio = Servicio::firstOrCreate(
            [
                "nombre"=>"EKG",
                //"especialidad_medical_id"=>1,
            ],
            [
                "precio"=>1.50
            ]
        );
        /*$precio_servicio = ServicioPrecio::create(
            [
                "precio"=>1.50,
                "servicio_id"=>$servicio->id,
            ]
        );*/
        $producto_servicio=ServicioProducto::firstOrCreate(
            [
                "producto_id"=>$producto->id,
                "servicio_id"=>$servicio->id,
            ],
            [

            ]
        );
        /*$paquete_producto_servicio = PaqueteProductoServicio::firstOrCreate(
            [
                "producto_servicio_id"=>$producto_servicio->id,
                "servicio_id"=>$producto_servicio->servicio_id,
                "producto_id"=>$producto_servicio->producto_id,
                "paquete_id"=>$paquete->id,
            ],
            []
        );*/
        $paquete_producto = ProductoPaquete::firstOrCreate(
            [
                "producto_id"=>$producto_servicio->producto_id,
                "paquete_id"=>$paquete->id,
            ],
            []
        );
        //tercer paquete
        $paquete = Paquete::firstOrCreate(
            [
                "nombre"=>"Tercer Paquete"
            ],
            [
                "precio"=>400
            ]
        );
        /*$paquete_precio = PaquetePrecio::create([
            "precio"=>$paquete->precio,
            "paquete_id"=>$paquete->id
        ]);*/
        //3do producto
        $producto = Producto::firstOrCreate(
            [
                "nombre"=>"Tercer Producto"
            ],
            [
                "precio"=>80.00
            ]
        );
        /*$precio_producto = ProductoPrecio::create(
            [
                "precio"=>50.00,
                "producto_id"=>$producto->id,
            ]
        );*/
        /*$precio_producto = ProductoPrecio::create(
            [
                "precio"=>60.00,
                "producto_id"=>$producto->id,
            ]
        );*/
        //3do servicio
        $servicio = Servicio::firstOrCreate(
            [
                "nombre"=>"EKG",
                //"especialidad_medical_id"=>"2"
            ],
            [
                "precio"=>25.55
            ]
        );
        /*$precio_servicio = ServicioPrecio::create(
            [
                "precio"=>7.50,
                "servicio_id"=>$servicio->id,
            ]
        );
        $precio_servicio = ServicioPrecio::create(
            [
                "precio"=>4.55,
                "servicio_id"=>$servicio->id,
            ]
        );*/
        /*$subservicio = Subservicio::firstOrCreate(
            [
                "nombre"=>"test de estres",
                "servicio_id"=>$servicio->id,
            ],
            []
        );*/
        $producto_servicio=ServicioProducto::firstOrCreate(
            [
                "producto_id"=>$producto->id,
                "servicio_id"=>$servicio->id,
            ],
            [

            ]
        );
        /*$paquete_producto_servicio = PaqueteProductoServicio::firstOrCreate(
            [
                "producto_servicio_id"=>$producto_servicio->id,
                "servicio_id"=>$producto_servicio->servicio_id,
                "producto_id"=>$producto_servicio->producto_id,
                "paquete_id"=>$paquete->id,
            ],
            []
        );*/
        $paquete_producto = ProductoPaquete::firstOrCreate(
            [
                "producto_id"=>$producto_servicio->producto_id,
                "paquete_id"=>$paquete->id,
            ],
            []
        );
        //4er producto
        $producto = Producto::firstOrCreate(
            [
                "nombre"=>"Cuarto Producto"
            ],
            [
                "precio"=>65.00
            ]
        );
        /*$precio_producto = ProductoPrecio::create(
            [
                "precio"=>65.00,
                "producto_id"=>$producto->id,
            ]
        );*/
        //3er servicio
        $servicio = Servicio::firstOrCreate(
            [
                "nombre"=>"EKG",
                //"especialidad_medical_id"=>1,
            ],
            [
                "precio"=>1.50
            ]
        );
        /*$precio_servicio = ServicioPrecio::create(
            [
                "precio"=>1.50,
                "servicio_id"=>$servicio->id,
            ]
        );*/
        $producto_servicio=ServicioProducto::firstOrCreate(
            [
                "producto_id"=>$producto->id,
                "servicio_id"=>$servicio->id,
            ],
            [

            ]
        );
        /*$paquete_producto_servicio = PaqueteProductoServicio::firstOrCreate(
            [
                "producto_servicio_id"=>$producto_servicio->id,
                "servicio_id"=>$producto_servicio->servicio_id,
                "producto_id"=>$producto_servicio->producto_id,
                "paquete_id"=>$paquete->id,
            ],
            []
        );*/
        $paquete_producto = ProductoPaquete::firstOrCreate(
            [
                "producto_id"=>$producto_servicio->producto_id,
                "paquete_id"=>$paquete->id,
            ],
            []
        );
    }

}
