<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AntecedentesPersonalesController;
use App\Http\Controllers\ClinicaLocalController;
use App\Http\Controllers\Empresa\EmpresaPaqueteController;
use App\Models\Rol;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/



Route::group(['middleware' => ['cors']], function () {

    Route::post('login', 'AuthController@authenticate');
    Route::post('user/create', 'UserController@create');
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
    //Route::get('persona/find/{num_documento}','PersonaController@findbydni');
    Route::post('persona/store','PersonaController@store');
    Route::post('persona/update/{id}','PersonaController@update');
    Route::delete('persona/delete/{id}','PersonaController@delete');
    Route::delete('persona/destroy/{id}','PersonaController@destroy');
    //Producto
    Route::post('producto/create', 'ProductoController@create');
    Route::put('producto/update/{id}', 'ProductoController@update');
    Route::delete('producto/delete/{id}', 'ProductoController@delete');
    Route::get('producto/show', 'ProductoController@show');
    //Route::delete('producto/destroy/{id}', 'ProductoController@destroy');
    //Salida de Producto
    Route::post('producto/exportacion', 'ProductoController@export');

});
/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/
