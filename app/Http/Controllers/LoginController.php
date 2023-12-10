<?php

namespace App\Http\Controllers;

use App\Models\AlmacenProducto;
use App\Models\Persona;
use App\Models\Producto;
use App\Models\ProductoDetalle;
use App\Models\Trabajador;
use App\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
//use Auth;
use Illuminate\Support\Facades\Auth as Auth;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth as FacadesJWTAuth;
use Tymon\JWTAuth\JWTAuth;

class LoginController extends Controller
{
    public function mostrar_login()
    {
        return view('mostrar_login');
    }
    public static function cambiarDuracionToken()
    {
        JWTAuth::factory()->setTTL(60 * 24 * 30);
    }
    public function mostrar_menu($username)
    {
        $usernameu = User::where('id', $username)->first();

        if (!$usernameu) {
            return redirect()->route('login');
            //return response()->json(["error" => "El nombre de usuario no existe"], 400);
        }

        $user = User::with('persona')->where('id', $username)->where('estado_registro', 'A')->first();

        if (!$user) {
            return redirect()->route('login');
            //return response()->json(['error' => 'Usuario bloqueado'], 402);
        }
        $response = [
            "nombres" => $user->persona->nombres,
            "apellido_paterno" => $user->persona->apellido_paterno,
            "apellido_materno" => $user->persona->apellido_materno,
            "username" => $user->username,
            "celular" => $user->persona->celular,
            "correo" => $user->persona->correo,
            "id" => $user->id
        ];

        //$response['token'] = $token;
        //return response()->json($response);
        return view('menu_principal', $response);
    }
    public function mostrar_usuario()
    {
        return view('crear_login');
    }
    public function asignar_rol()
    {
        return view('asignar_rol_trabajador');
    }
    public function crear_asignar_rol(Request $request)
    {
        $persona = Persona::where('numero_documento', $request->input('numero_documento'))->first();
        //return response()->json($persona);
        if ($persona) {
            $existe_personal_empresa = Trabajador::where('persona_id', $persona->id)->where('estado_registro', 'A')->first();
            if ($existe_personal_empresa) {
                return redirect()->back()->with('error', 'Ya existe otro registro con el numero de documento.');
                //return response()->json(["error" => "Ya existe otro registro con el numero de documento"], 500);
            }
            $usuario = User::updateOrCreate([
                'persona_id' => $persona->id,
                'username' => $persona->numero_documento,
            ], [
                'password' => $persona->numero_documento,
                'estado_registro' => 'A'
            ]);
            $personal = Trabajador::updateOrCreate([
                'persona_id' => $persona->id,
            ], [
                'rol_id' =>  $request->input('rol_id'),
                'empresa_id' => "1",
                'estado_registro' => 'A'
            ]);
            return redirect()->back()->with('success', 'Datos guardados exitosamente.');
            //return response()->json(["resp" => "Personal creado correctamente"], 200);
        }else{
            return redirect()->back()->with('error', 'No existe registro con el numero de documento.');
        }
    }
    public function cambiar_rol($id)
    {
        $user = User::with('persona')->where('id', $id)->where('estado_registro', 'A')->first();
        return view('cambiar_rol_trabajador', compact('user'));
    }
    public function cambiar_rol_trabajador(Request $request, $id)
    {
        $request->validate([
            'rol_id' => 'required|numeric',
        ]);
        // Obtener el trabajador
        $trabajador = Trabajador::findOrFail($id);

        // Actualizar el rol
        $trabajador->update(['rol_id' => $request->input('rol_id')]);

        // Redirigir de vuelta con un mensaje de éxito
        //return View::make('cambiar_rol_trabajador', compact('trabajador', 'roles'));
        return redirect()->back()->with('success', 'Rol cambiado exitosamente.');
    }
    public function buscar_trabajador(Request $request)
    {
        $persona = Persona::where('numero_documento', $request->input('numero_documento'))->first();

        if ($persona) {
            $datos = [
                'numero_documento' => $persona->numero_documento,
                "nombres" => $persona->nombres,
                "apellido_paterno" => $persona->apellido_paterno,
                "apellido_materno" => $persona->apellido_materno,
                "celular" => $persona->celular,
                "correo" => $persona->correo,
            ];

            return view('buscar_trabajador', ['datos' => $datos]);
        } else {
            // Manejar el caso en que no se encuentra el trabajador
            return view('buscar_trabajador', ['datos' => null]);
        }
    }
    public function buscar_producto()
    {
        $productos = Producto::with('producto_detalle.marca', 'producto_detalle.empresa')
            ->where('estado_registro', 'A')
            ->get();

        $datos = [];

        foreach ($productos as $producto) {
            $nom_producto = $producto->nom_producto ?? null;
            $descripcion = $producto->descripcion ?? null;
            $cantidad = $producto->cantidad ?? null;
            $codigo = $producto->producto_detalle->codigo ?? null;
            $marca = $producto->producto_detalle->marca->nombre ?? null;
            $estado_registro = $producto->estado_registro ?? null;

            $datos[] = [
                "nom_producto" => $nom_producto ?? null,
                "descripcion" => $descripcion ?? null,
                "cantidad" => $cantidad ?? null,
                "codigo" => $codigo ?? null,
                "marca" => $marca ?? null,
                "estado_registro" => $estado_registro ?? null,
            ];
        }
        return view('buscar_producto', ['datos' => $datos]);
    }
    public function act_producto()
    {
        //$user = User::with('persona')->where('id', auth()->user()->id)->first();
        $productos = Producto::all();
        return view('actualizar_producto', ['productos' => $productos]);
        //return view('actualizar_producto');
    }
    public function actualizar_producto(Request $request)
    {
        DB::beginTransaction();

        try {

            $producto = Producto::find($request->input('id'));
            $detalle = ProductoDetalle::where('producto_id', $request->input('id'))->where('estado_registro', 'A')->first();

            if ($detalle) {
                $producto->update([
                    "descripcion" => $request->input('descripcion'),
                    "cantidad" => $request->input('cantidad'),
                ]);

                $detalle->update([
                    "codigo" => $request->input('codigo'),
                    "marca_id" => $request->input('marca_id'),
                ]);

                DB::commit();
                return redirect()->back()->with('success', 'Producto actualizado exitosamente.');
            } else {
                // Manejar el caso donde $detalle es nulo
                return redirect()->back()->with('error', 'No existe detalle.');
            }
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(["error" => "Error al actualizar el producto: " . $e->getMessage()], 500);
        }
    }
    public function producto_eliminado()
    {
        return view('eliminar_producto');
    }
    public function eliminar_producto(Request $request)
    {
        DB::beginTransaction();

        try {
            $producto = Producto::findOrFail($request->input('nom_producto'));
            $detalle = ProductoDetalle::where('producto_id', $request->input('nom_producto'))->first();

            if ($detalle) {
                $producto->update([
                    "estado_registro" => "I",
                ]);

                $detalle->update([
                    "estado_registro" => "I",
                ]);

                DB::commit();
                return redirect()->back()->with('success', 'Producto eliminado exitosamente.');
            } else {
                // Manejar el caso donde $detalle es nulo
                return response()->json(["error" => "Detalle no encontrado"], 404);
            }
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(["error" => "Error al eliminar el producto: " . $e->getMessage()], 500);
        }
    }
    public function almacen()
    {
        return view('almacen');
    }
    public function registrar_producto()
    {
        // if (auth()->check()) {
        //     $datos = User::with('persona')->where('id', auth()->user()->id)->first();
        //     return view('registrar_producto', compact('datos'));
        // } else {
        //     return redirect()->back()->with('error', 'No se puede.'); 
        // }
        // $datos = User::with('persona')->where('id', auth()->user()->id)->first();
        // return view('registrar_producto',$datos);
        return view('registrar_producto');
    }
    public function crear_varios_producto(Request $request)
    {
        $productos = $request->input('productos');

        if (!is_array($productos)) {
            return response()->json(["resp" => "La lista de productos no es válida"], 400);
        }

        DB::beginTransaction();

        try {
            foreach ($productos as $productoData) {
                // Verificar si $productoData es un array antes de intentar acceder a sus elementos
                if (!is_array($productoData)) {
                    // Manejar el caso donde $productoData no es un array
                    DB::rollback();
                    return response()->json(["resp" => "Error al crear productos: Formato de datos incorrecto"], 400);
                }

                $producto = Producto::create([
                    "nom_producto" => $productoData['nom_producto'],
                    "descripcion" => $productoData['descripcion'],
                    "cantidad" => $productoData['cantidad']
                ]);

                $detalle = ProductoDetalle::create([
                    "codigo" => $productoData['codigo'],
                    "marca_id" => $productoData['marca_id'],
                    "empresa_id" => 1,
                    "producto_id" => $producto->id
                ]);
            }

            DB::commit();

            // Redirigir a la vista después de crear los productos
            return redirect()->route('registrar_producto')->with('success', 'Productos creados correctamente');
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(["resp" => "Error al crear productos: " . $e->getMessage()], 500);
        }
    }
    public function asignar_producto()
    {
        return view('asignar_producto');
    }
    public function asignar_varios_producto(Request $request)
    {
        $productos = $request->input('productos');

        if (!is_array($productos)) {
            return response()->json(["resp" => "La lista de productos no es válida"], 400);
        }

        DB::beginTransaction();

        try {
            foreach ($productos as $productoData) {
                // Verificar si $productoData es un array antes de intentar acceder a sus elementos
                if (!is_array($productoData)) {
                    // Manejar el caso donde $productoData no es un array
                    DB::rollback();
                    return response()->json(["resp" => "Error al asignar productos: Formato de datos incorrecto"], 400);
                }

                // $producto = Producto::create([
                //     "nom_producto" => $productoData['nom_producto'],
                //     "descripcion" => $productoData['descripcion'],
                //     "cantidad" => $productoData['cantidad']
                // ]);

                // $detalle = ProductoDetalle::create([
                //     "codigo" => $productoData['codigo'],
                //     "marca_id" => $productoData['marca_id'],
                //     "empresa_id" => 1,
                //     "producto_id" => $producto->id
                // ]);
                $producto = AlmacenProducto::updateOrCreate(
                    [
                        "producto_id" => $productoData['id'],
                    ],
                    [
                        "producto_id" => $productoData['id'],
                        "fecha_entrada" => Carbon::now(),
                        "almacen_id" => 1
                    ]

                );
            }

            DB::commit();

            // Redirigir a la vista después de crear los productos
            return redirect()->route('asignar_producto')->with('success', 'Productos asignados correctamente');
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(["resp" => "Error al crear productos: " . $e->getMessage()], 500);
        }
    }
}
