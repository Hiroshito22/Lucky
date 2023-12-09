<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|


Route::get('/', function () {
    return view('welcome');
});
*/
//Route::get('/login', [LoginController::class, 'mostrar_login'])->name('/login');
//Route::get('/menu_principal', [LoginController::class, 'mostrar_menu'])->name('/menu');
Route::get('/login', function () {
    return view('mostrar_login');
});
Route::get('/menu', function () {
    return view('menu_principal');
});
Route::get('/crear_usuario', function () {
    return view('crear_login');
});
//Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
/*Route::middleware(['auth'])->group(function () {
    Route::get('/logeo', function(){
        return view('logeo');
    });
});*/
Route::group(['middleware' => ['cors']], function () {

    //Route::get('login/entrar', 'AuthController@mostrar_login');
    
    //Route::post('/login', 'AuthController@authenticate');

    //Route::get('loginn', [LoginController::class, 'showLoginForm'])->name('login');
    //Route::post('loginn', [LoginController::class, 'login']);

    //Route::post('user/create', 'UserController@create');
});
Route::group(['middleware' => ['jwt.verify', 'cors']], function () {

    // Actualizar contraseña
    Route::put('password/update', 'AuthController@updatePassword');

    //Trabajador
    Route::post('trabajador/create','TrabajadorController@create');
    Route::put('trabajador/update/{id_trabajador}','TrabajadorController@update');
    Route::delete('trabajador/delete/{id_trabajador}','TrabajadorController@delete');
    Route::get('trabajador/get','TrabajadorController@get');

    //Persona
    Route::get('persona/show','PersonaController@getShow');
    Route::get('persona/get','PersonaController@get');
    Route::post('persona/store','PersonaController@store');
    Route::post('persona/update/{id}','PersonaController@update');
    Route::delete('persona/delete/{id}','PersonaController@delete');
    Route::delete('persona/destroy/{id}','PersonaController@destroy');
    //Producto
    Route::post('producto/create', 'ProductoController@create');
    Route::put('producto/update/{id}', 'ProductoController@update');
    Route::delete('producto/delete/{id}', 'ProductoController@delete');
    Route::get('producto/get', 'ProductoController@get');
    Route::post('producto/asignar/{id_producto}', 'ProductoController@asignar_almacen');
    //Salida y Entrada de Productos
    Route::post('producto/exportacion/{id_producto}', 'ProductoController@salida_productos');
    Route::post('producto/importar/{id_producto}', 'ProductoController@entrada_productos');

    //Reportes PDF's
    Route::get('/producto/reporte/entrada', 'ReportePDFController@reporte_equipos_entrada');
    Route::get('/producto/reporte/stock', 'ReportePDFController@reporte_equipos_stock');
    Route::get('/producto/reporte/salida', 'ReportePDFController@reporte_equipos_salida');

});