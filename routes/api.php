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

//Detracciones
// Route::post('detraccion/create', 'DetraccionController@createDetraccion');
// Route::get('detraccion/show/{iddetraccion}', 'DetraccionController@show');
// Route::put('detraccion/update/{iddetraccion}', 'DetraccionController@updateDetraccion');
// Route::delete('detraccion/delete/{iddetraccion}', 'DetraccionController@deleteDetraccion');
// Route::get('mostrar/detracciones/{idpersona}', 'DetraccionController@mostrarDetracciones');
//detraccion cascada
//Route::post('detraccion/updateCascade/{iddetraccion}', 'DetraccionController@updateDetraccionCascade');
//REPORTES PDF
Route::get('reporte/pdfexample', 'ReportesPDFController@pdf_example'); //despues del @ nombre de funcion
Route::get('reporte/pdfenfermedadesagravarsealturageografica', 'ReportesPDFController@enfermedade_agravarse_altura_geografica_reporte');
Route::get('reporte/pdffichaevaluacionmusculoesqueletica', 'ReportesPDFController@ficha_evaluacion_musculo_esqueletica');

//PESO Y TALLA
/*Route::get('reporte/pesotalla','PesoTallaController@pdf_example');//despues del @ nombre de funcion*/

//HistoriaOcupacional
Route::get('reporte/pdfhistoriaocupacional', 'HistoriaOcuoacionalController@pdf_historia_ocupacional');
Route::get('reporte/historiaocupacional', 'HistoriaOcuoacionalController@historia_ocupacional');

//CertificadoSuficienciaMedicaTrabajosAltura
Route::get('reporte/pdfcertificadosuficienciamedicatrabajosaltura', 'CertificadoSuficienciaMedicaTrabajosAlturaController@pdf_certificado_suficiencia_medica_trabajos_altura');
Route::get('reporte/certificadosuficienciamedicatrabajosaltura', 'CertificadoSuficienciaMedicaTrabajosAlturaController@certificado_suficiencia_medica_trabajos_altura');
//REPORTES PDF
Route::get('ficha/pdfficha', 'FichaPDFController@pdf_ficha');
Route::get('reporte/pdfexamaple', 'ReportesPDFController@pdf_example');
Route::get('reporte/pdfmedicoocupacional', 'ReportesPDFController@pdf_example');
Route::get('reporte/informe_radiologia', 'ReportesPDFController@informe_radiologia');
Route::get('reporte/informe_radiologico', 'ReportesPDFController@informe_radiologico');
Route::get('consentimientoinformadorx', 'ReportesPDFController@consentimientoRxShow');
Route::get('patologias/get', 'Hospital\PatologiaController@get_patologias');

Route::get('reporte/pdfexamaple123', 'ReportesPDFController@pdf_example');
Route::get('reporte/pdfmedicoocupacional', 'ReportesPDFController@pdf_example');
Route::get('reporte/prueba', 'ReportesPDFController@prueba');
Route::get('reporte/firstpdf', 'ReportesPDFController@fatiga_somnolencia_reporte');
Route::get('reporte/secondpdf', 'ReportesPDFController@evaluacion_oftalmologica_reporte');
Route::get('reporte/pdfmedicoocupacional', 'ReportesPDFController@medicaAscensoGrandesAltitudesReporte');
Route::get('reporte/pdfcertificacion', 'ReportesPDFIIController@CertSufMedicaConduccDeVehiculos');

Route::group(['middleware' => ['cors']], function () {

    Route::post('login', 'AuthController@authenticate');
    Route::get('tipodocumentos/get', 'TipoDocumentoController@get');
    Route::get('sexos/get', 'SexoController@get');
    Route::get('estadocivil/get', 'EstadoCivilController@get');
    Route::get('gradoinstruccion/get', 'GradoInstruccionController@get');
    Route::get('tipotrabajador/get', 'TipoTrabajadorController@get');
    Route::get('religiones/get', 'ReligionController@get');

    Route::get('ubicacion', 'UbicacionController@get');
    Route::get('frecuencia/get', 'FrecuenciaController@get');
    Route::get('tiposhabito/get', 'TipoHabitoController@get');

    //enfermedad
    Route::get('enfermedades/get', 'Hospital\EnfermedadController@index')->name('GetEnfermedades');

    //Triaje
    // Route::post('triaje/antecedentesfamiliares/create', 'Triaje\AntecedenteFamiliarController@store');
    // Route::delete('triaje/antecedentefamiliares/delete/{id}', 'Triaje\AntecedenteFamiliarController@delete');
    // Route::put('triaje/antecedentefamiliares/activate/{id}', 'Triaje\AntecedenteFamiliarController@activate');
    Route::post('triaje/antecedentespersonales/create', 'Triaje\TriajeController@createAntecedentesPersonales');
    Route::post('triaje/evaluacionmedica/create', 'Triaje\TriajeController@createEvaluacionMedica');
    Route::post('triaje/signosvitales/create', 'Triaje\TriajeController@createSignosVitales');
    Route::post('triaje/habitos/create', 'Triaje\TriajeController@createHabitos');
    Route::post('triaje/habitosfisicos/create', 'Triaje\TriajeController@createHabitosFisicos');
    Route::get('triaje/get', 'Triaje\TriajeController@index');
    Route::post('triaje/create', 'Triaje\TriajeController@store');
    //Route::post('triaje/antecedentesfamiliares/create','Triaje\TriajeController@createAntecedentesFamiliares');
    //Route::post('triaje/antecedentespersonales/create','Triaje\TriajeController@createAntecedentesPersonales');
    //Route::post('triaje/pesostallas/create','Triaje\TriajeController@createPesoTalla');
    Route::get('triaje/pesotalla/get', 'Triaje\PesoTallaController@get');
    Route::post('triaje/pesotalla/create', 'Triaje\PesoTallaController@store');
    Route::put('triaje/pesotalla/update/{id}', 'Triaje\PesoTallaController@update');
    Route::delete('triaje/pesotalla/delete/{id}', 'Triaje\PesoTallaController@destroy');
    Route::put('triaje/pesotalla/reintegrar/{id}', 'Triaje\PesoTallaController@reintegrar');
    /*Route::post('pesotalla/create', PesoTallaController::class,'store');
    Route::put('pesotalla/update', PesoTallaController::class,'store');*/

    //ANTECEDENTE_GINECOLÓGICO
    Route::get('triaje/antecedenteginecologico/get', 'Triaje\AntecedenteGinecologicoController@index');
    Route::post('triaje/antecedenteginecologico/create', 'Triaje\AntecedenteGinecologicoController@store');
    Route::put('triaje/antecedenteginecologico/update/{id}', 'Triaje\AntecedenteGinecologicoController@update');
    Route::put('triaje/antecedenteginecologico/activate/{id}', 'Triaje\AntecedenteGinecologicoController@activate');
    Route::delete('triaje/antecedenteginecologico/delete/{id}', 'Triaje\AntecedenteGinecologicoController@destroy');
    //ANTECEDENTES_PERSONALES
    Route::get('triaje/antecedentespersonal/{idantecedentepersonal}', 'Triaje\AntecedentesPersonalesController@get');
    Route::post('triaje/antecedentespersonal/create', 'Triaje\AntecedentesPersonalesController@store');
    Route::put('triaje/antecedentespersonal/update/{idAntePe}', 'Triaje\AntecedentesPersonalesController@update');
    Route::delete('triaje/antecedentespersonal/delete/{idantecedentepersonal}', 'Triaje\AntecedentesPersonalesController@delete');

    //ENTIDAD_BANCARIA
    Route::get('EntidadBancaria/get', 'EntidadBancariaController@get');
    Route::post('EntidadBancaria/create', 'EntidadBancariaController@store');
    Route::put('EntidadBancaria/update/{idEntidadBancaria}', 'EntidadBancariaController@update');
    Route::delete('EntidadBancaria/delete/{id}', 'EntidadBancariaController@delete');

    //ANTECEDENTE
    Route::get('triaje/antecedentespersonal/antecedentes/get', 'Triaje\AntecedentesPersonalesController@getantecedente');
    Route::post('triaje/antecedentespersonal/antecedentes/create', 'Triaje\AntecedentesPersonalesController@storeantecedente');
    Route::put('triaje/antecedentes/update/{id}', 'Triaje\AntecedentesPersonalesController@updateantecedente');
    Route::delete('triaje/antecedentespersonal/antecedentes/delete/{id}', 'Triaje\AntecedentesPersonalesController@deleteantecdedente');

    //Signos Vitales
    Route::get('signosvitales/get', 'Triaje\SignosVitalesController@get');
    Route::post('signosvitales/create', 'Triaje\SignosVitalesController@store');
    Route::put('signosvitales/update/{id}', 'Triaje\SignosVitalesController@update');
    Route::delete('signosvitales/delete/{id}', 'Triaje\SignosVitalesController@destroy');
    Route::put('signosvitales/active/{id}', 'Triaje\SignosVitalesController@activar_datos');
    Route::delete('signosvitales/deleteperm/{id}', 'Triaje\SignosVitalesController@elim_perm_datos');

    //Celular
    Route::post('celular/create', 'CelularController@create');
    Route::put('celular/update/{Id}', 'CelularController@update');
    Route::delete('celular/delete/{Id}', 'CelularController@delete');
    Route::get('celular/show/{Id_persona}', 'CelularController@show');

    //Correo
    Route::post('correo/create', 'CorreoController@create');
    Route::put('correo/update/{Id}', 'CorreoController@update');
    Route::delete('correo/delete/{Id}', 'CorreoController@delete');
    Route::get('correo/show/{Id_persona}', 'CorreoController@show');

    //Entidad Bancaria
    Route::post('entidad_bancaria/create', 'EntidadBancariaController@create');
    Route::put('entidad_bancaria/update/{id}', 'EntidadBancariaController@update');
    Route::delete('entidad_bancaria/delete/{id}', 'EntidadBancariaController@delete');
    Route::get('entidad_bancaria/get', 'EntidadBancariaController@get');

    //ANTECEDENTES FAMILIARES
    Route::get('triaje/antecedentesfamiliares/get/{id}', 'Triaje\AntecedenteFamiliarController@get');
    Route::post('triaje/antecedentesfamiliares/store', 'Triaje\AntecedenteFamiliarController@store');
    Route::put('triaje/antecedentesfamiliares/update/{id}', 'Triaje\AntecedenteFamiliarController@update');
    Route::delete('triaje/antecedentesfamiliares/delete/{id}', 'Triaje\AntecedenteFamiliarController@delete');
    Route::put('triaje/antecedentesfamiliares/activate/{id}', 'Triaje\AntecedenteFamiliarController@activate');



    //Detracción
    Route::get('detraccion/get','DetraccionController@index');
    Route::post('detraccion/create','DetraccionController@store');
    Route::put('detraccion/update/{id}','DetraccionController@update');
    Route::delete('detraccion/delete/{id}','DetraccionController@destroy');

    //Psicologia
    Route::post('psicologia/motivoEvaluacion/create', 'Psicologia\PsicologiaController@createMotivoEvaluacion');
    Route::post('psicologia/datosOcupacionales/create', 'Psicologia\PsicologiaController@createDatosOcupacionales');
    Route::post('psicologia/anterioresEmpresas/create', 'Psicologia\PsicologiaController@createAnterioresEmpresas');
    Route::post('psicologia/observacionConductas/create', 'Psicologia\PsicologiaController@createObservacionConductas');
    Route::post('psicologia/procesosCognitivos/create', 'Psicologia\PsicologiaController@createProcesosCognitivos');



    //Dep, Dist, Prov
    Route::get('departamento', 'UbicacionController@departamentos');
    Route::get('provincia/{departamentoId}', 'UbicacionController@provincias');
    Route::get('distrito/{provinciaId}', 'UbicacionController@distritos');
});
Route::group(['middleware' => ['jwt.verify', 'cors']], function () {

    // Actualizar contraseña
    Route::put('password/update', 'AuthController@updatePassword');

    //Persona
    Route::get('persona/show','PersonaController@getShow');
    Route::get('persona/get','PersonaController@get');
    Route::get('persona/find/{num_documento}','PersonaController@findbydni');
    Route::post('persona/store','PersonaController@store');
    Route::post('persona/update/{id}','PersonaController@update');
    Route::delete('persona/delete/{id}','PersonaController@delete');
    Route::delete('persona/destroy/{id}','PersonaController@destroy');

    //Dato Ocupacional
    Route::get('psicologia/datosocupacionales/getmotivoev','Psicologia\DatosOcupacionalesController@getMotivoEv');
    Route::get('psicologia/datosocupacionales/getprincipalri','Psicologia\DatosOcupacionalesController@getPrincipalRi');
    Route::get('psicologia/datosocupacionales/getmedidaseg','Psicologia\DatosOcupacionalesController@getMedidaSeg');
    Route::get('psicologia/datosocupacionales/gethistoriafam','Psicologia\DatosOcupacionalesController@getHistoriaFam');
    Route::get('psicologia/datosocupacionales/getaccidentesenf','Psicologia\DatosOcupacionalesController@getAccidentesEnf');
    Route::get('psicologia/datosocupacionales/gethabitos','Psicologia\DatosOcupacionalesController@getHabitos');
    Route::get('psicologia/datosocupacionales/getotrasobs','Psicologia\DatosOcupacionalesController@getOtrasObs');
    Route::get('psicologia/datosocupacionales/get','Psicologia\DatosOcupacionalesController@index');
    Route::post('psicologia/datosocupacionales/create','Psicologia\DatosOcupacionalesController@store');
    Route::put('psicologia/datosocupacionales/update/{id}','Psicologia\DatosOcupacionalesController@update');
    Route::delete('psicologia/datosocupacionales/delete/{id}','Psicologia\DatosOcupacionalesController@destroy');
    Route::put('psicologia/datosocupacionales/activate/{id}','Psicologia\DatosOcupacionalesController@activate');
    //Datos EKG
    Route::get('ekg/datosekg/get','EKG\DatosEkgController@index');
    Route::post('ekg/datosekg/create','EKG\DatosEkgController@store');
    Route::put('ekg/datosekg/update/{id}','EKG\DatosEkgController@update');
    Route::delete('ekg/datosekg/delete/{id}','EKG\DatosEkgController@destroy');
    Route::put('ekg/datosekg/activate/{id}','EKG\DatosEkgController@activate');
    // //Preguntas EKG
    // Route::get('ekg/preguntasekg/get','EKG\PreguntasEkgController@index');
    // Route::post('ekg/preguntasekg/create','EKG\PreguntasEkgController@store');
    // Route::put('ekg/preguntasekg/update/{id}','EKG\PreguntasEkgController@update');
    // Route::delete('ekg/preguntasekg/delete/{id}','EKG\PreguntasEkgController@destroy');
    // Route::put('ekg/preguntasekg/activate/{id}','EKG\PreguntasEkgController@activate');
    //Clinica-Personal
    Route::get('clinica/personal/get','ClinicaPersonalController@get');
    Route::get('clinica/personal/show/{id}','ClinicaPersonalController@show');
    Route::post('clinica/personal/create','ClinicaPersonalController@store');
    Route::put('clinica/personal/update/{id}','ClinicaPersonalController@update');
    Route::delete('clinica/personal/delete/{id}','ClinicaPersonalController@delete');
    Route::delete('clinica/personal/destroy/{id}','ClinicaPersonalController@destroy');
    Route::put('clinica/personal/activar/{id}','ClinicaPersonalController@activar');
    Route::post('clinica/personal/asignararea', 'ClinicaPersonalController@asignarAreas');
    Route::get('clinica/personal/area/get/{id_area}','ClinicaPersonalController@get_personal_area');

    //superadmin
    Route::get('hospitales/get', 'Hospital\HospitalController@index')->name('hospitalesget');
    Route::post('hospitales/create', 'Hospital\HospitalController@store')->name('hospitalescreate');
    Route::post('hospitales/update/{idHospital}', 'Hospital\HospitalController@update');
    Route::delete('hospitales/delete/{idHospital}', 'Hospital\HospitalController@destroy')->name('hospitalesdelete');
    Route::get('hospitales/accesos/get', 'AccesoController@acceso_hospital')->name('hospitalAccesos');
    Route::get('accesos/get', 'AccesoController@getaccesosbylogin');

    Route::get('roles/get', 'RolController@get')->name('hospitalGet');
    Route::post('roles/create', 'RolController@create')->name('hospitalRolCreate');
    Route::put('roles/update/{idRol}', 'RolController@update')->name('hospitalRolUpdate');
    Route::delete('roles/delete/{idRol}', 'RolController@delete')->name('hospitalRolDelete');
    Route::post('roles/asignar', 'RolController@asignarAcceso')->name('hospitalAsignadorRoles');
    Route::put('roles/editar', 'RolController@editarAcceso')->name('hospitalEditarRoles');

    //Psicologia-Preguntas
    Route::get('psicologia/preguntas/get', 'Psicologia\PreguntasController@get');
    Route::post('psicologia/preguntas/create', 'Psicologia\PreguntasController@store');
    Route::put('psicologia/preguntas/update/{id}', 'Psicologia\PreguntasController@update');
    Route::delete('psicologia/preguntas/delete/{id}', 'Psicologia\PreguntasController@destroy');
    Route::put('psicologia/preguntas/reintegrar/{id}', 'Psicologia\PreguntasController@reintegrar');
    Route::get('psicologia/preguntas/Ep/get', 'Psicologia\PreguntasController@getEp');
    Route::get('psicologia/preguntas/Eo/get', 'Psicologia\PreguntasController@getEo');
    Route::get('psicologia/preguntas/Ee/get', 'Psicologia\PreguntasController@getEe');
    Route::get('psicologia/preguntas/Sm/get', 'Psicologia\PreguntasController@getSm');
    Route::get('psicologia/preguntas/Te/get', 'Psicologia\PreguntasController@getTe');
    Route::get('psicologia/preguntas/Ts/get', 'Psicologia\PreguntasController@getTs');
    Route::get('psicologia/preguntas/Tf/get', 'Psicologia\PreguntasController@getTf');

    //Oftalmologia-Antecedentes
    Route::get('oftalmologia/antecedentes/get', 'Oftalmologia\AntecedentesOftalmologiaController@get');
    Route::post('oftalmologia/antecedentes/create', 'Oftalmologia\AntecedentesOftalmologiaController@store');
    Route::put('oftalmologia/antecedentes/update/{id}', 'Oftalmologia\AntecedentesOftalmologiaController@update');
    Route::delete('oftalmologia/antecedentes/delete/{id}', 'Oftalmologia\AntecedentesOftalmologiaController@destroy');
    Route::put('oftalmologia/antecedentes/reintegrar/{id}', 'Oftalmologia\AntecedentesOftalmologiaController@reintegrar');
    Route::get('oftalmologia/antecedentes/Con/get', 'Oftalmologia\AntecedentesOftalmologiaController@getCon');
    Route::get('oftalmologia/antecedentes/Cor/get', 'Oftalmologia\AntecedentesOftalmologiaController@getCor');

    //=================================================================================
    Route::get('hospitales/cargos/get', 'Hospital\CargoController@get')->name('hospitalGetCargo');
    Route::post('hospitales/cargos/create', 'Hospital\CargoController@create')->name('hospitalCargoCreate');
    Route::put('hospitales/cargos/update/{idCargo}', 'Hospital\CargoController@update')->name('hospitalCargoUpdate');
    Route::delete('hospitales/cargos/delete/{idCargo}', 'Hospital\CargoController@delete')->name('hospitalCargoDelete');
    Route::post('hospitales/personal/create', 'Hospital\PersonalController@create')->name('hospitalPersonalCreate');
    Route::get('hospitales/personal/get', 'Hospital\PersonalController@get')->name('hospitalPersonalGet');
    Route::put('hospitales/personal/update/{idPersonal}', 'Hospital\PersonalController@update')->name('hospitalPersonalUpdate');
    Route::delete('hospitales/personal/delete/{idPersonal}', 'Hospital\PersonalController@delete')->name('hospitalPersonalDelete');
    Route::get('hospitales/patologias/get', 'Hospital\PatologiaController@get')->name('hospitalPatologiaGet');
    Route::post('hospitales/patologias/create', 'Hospital\PatologiaController@create')->name('hospitalPatologiaCreate');
    Route::put('hospitales/patologias/update/{idHospitalPatologia}', 'Hospital\PatologiaController@update')->name('hospitalPatologiaUpdate');
    Route::delete('hospitales/patologias/delete/{idHospitalPatologia}', 'Hospital\PatologiaController@delete')->name('hospitalPatologiaDelete');
    Route::put('hospitales/patologias/activar_desactivar/{idHospitalPatologia}', 'Hospital\PatologiaController@activar_desactivar')->name('hospitalPatologiaActivarDesactivar');

    Route::post('hospitales/personal/cargo/create', 'Hospital\PersonalController@asignarCargo')->name('hospitalPersonalCargoCreate');
    Route::post('hospitales/personal/cargo/update/{idPersonalCargo}', 'Hospital\PersonalCargoController@update')->name('hospitalPersonalCargoUpdate');
    Route::get('hospitales/personal/cargo/getPersonal/{idPersonal}', 'Hospital\PersonalCargoController@getPersonal')->name('hospitalPersonalCargoGetPersonal');
    Route::delete('hospitales/personal/cargo/delete/{idPersonalCargo}', 'Hospital\PersonalCargoController@delete')->name('hospitalPersonalCargoDeletePersonal');
    Route::post('my', 'AuthController@my');

    //detracciones
    //Route::post('detraccion/updateCascade/{iddetraccion}', 'DetraccionController@updateDetraccionCascade');
    Route::post('detraccion/create', 'DetraccionController@store');
    Route::post('detraccion/institucion/create', 'DetraccionController@createDetraccionInstitución');
    Route::get('detraccion/show/{iddetraccion}', 'DetraccionController@show');
    Route::put('detraccion/update/{iddetraccion}', 'DetraccionController@updateDetraccion');
    Route::delete('detraccion/delete/{iddetraccion}', 'DetraccionController@deleteDetraccion');
    Route::get('mostrar/detracciones', 'DetraccionController@mostrarDetracciones');

    //Material
    Route::get('hospitales/materiales/get', 'Hospital\MaterialController@index');
    Route::post('hospitales/materiales/create', 'Hospital\MaterialController@create');
    Route::put('hospitales/materiales/update/{idMaterial}', 'Hospital\MaterialController@update');
    Route::delete('hospitales/materiales/delete/{idMaterial}', 'Hospital\MaterialController@delete');

    //Vehiculos
    Route::get('hospitales/vehiculos/get', 'Hospital\VehiculoController@index');
    Route::post('hospitales/vehiculos/create', 'Hospital\VehiculoController@create');
    Route::put('hospitales/vehiculos/update/{idVehiculo}', 'Hospital\VehiculoController@update');
    Route::delete('hospitales/vehiculos/delete/{idVehiculo}', 'Hospital\VehiculoController@delete');
    Route::get('hospitales/tipovehiculos/get', 'Hospital\VehiculoController@getTipoVehiculo');

    //Transportista
    Route::get('hospitales/transportistas/get', 'Hospital\TransportistaController@index');
    Route::get('hospitales/transportistas/getallvehiculos', 'Hospital\TransportistaController@getAllVehiculos');
    Route::get('hospitales/transportistas/getallmateriales', 'Hospital\TransportistaController@getAllMateriales');
    Route::get('hospitales/transportistas/getvehiculo/{idTransportista}', 'Hospital\TransportistaController@getVehiculo');
    Route::post('hospitales/transportistas/create', 'Hospital\TransportistaController@create');
    Route::post('hospitales/transportistas/vehiculo', 'Hospital\TransportistaController@setVehiculo');
    Route::put('hospitales/transportistas/update/{idTransportista}', 'Hospital\TransportistaController@update');
    Route::delete('hospitales/transportistas/delete/{idTransportista}', 'Hospital\TransportistaController@delete');
    Route::get('hospitales/transportistas/getmateriales/{idTransportista}', 'Hospital\TransportistaMaterialController@getMateriales');
    Route::post('hospitales/transportistas/setmateriales', 'Hospital\TransportistaController@setMateriales');

    //Empresa
    Route::get('empresa/get','Empresa\EmpresaController@get');
    Route::get('empresa/show','Empresa\EmpresaController@show');
    Route::post('empresa/create','Empresa\EmpresaController@store');
    Route::put('empresa/update/{id}','Empresa\EmpresaController@update');
    Route::put('empresa/update','Empresa\EmpresaController@update2');
    Route::delete('empresa/delete/{id}','Empresa\EmpresaController@delete');
    Route::delete('empresa/destroy/{id}','Empresa\EmpresaController@destroy');
    Route::put('empresa/active/{id}','Empresa\EmpresaController@active');
    Route::get('rubro/get','Empresa\EmpresaController@getrubro');
    //Empresa Personal
    Route::get('empresa/personal/get','Empresa\EmpresaPersonalController@get');
    Route::get('empresa/personal/show/{id}','Empresa\EmpresaPersonalController@show');
    Route::post('empresa/personal/create','Empresa\EmpresaPersonalController@store');
    Route::put('empresa/personal/update/{id}','Empresa\EmpresaPersonalController@update');
    Route::put('empresa/personal/activar/{id}','Empresa\EmpresaPersonalController@activar');
    Route::delete('empresa/personal/delete/{id}','Empresa\EmpresaPersonalController@delete');
    Route::delete('empresa/personal/destroy/{id}','Empresa\EmpresaPersonalController@destroy');
    Route::post('empresa/personal/asignar/perfil','Empresa\EmpresaPersonalController@asignar_perfil');
    Route::post('empresa/personal/asignarareas','Empresa\EmpresaPersonalController@asignarAreas');
    Route::get('empresa/personal/reclutamiento/get','Empresa\EmpresaReclutamientoController@get');
    Route::post('empresa/personal/reclutamiento/create','Empresa\EmpresaReclutamientoController@store');
    Route::get('empresa/personal/area/get/{id_area}','Empresa\EmpresaPersonalController@get_personal_area');

    //Empresa Operaciones y Servicios
    Route::get('empresa/paquetes/servicios/rutina_entrada/{idContrato}',[EmpresaPaqueteController::class, 'getRutinaSalida']);

    // traer servios del personal empresa
    Route::get('empresa_personal/clinica_servicios/{id}', 'Empresa\EmpresaPersonalController@getClinicaServicios');

    //Empresa Contacto
    Route::get('empresacontacto/get', 'Empresa\EmpresaContactoController@get');
    Route::post('empresacontacto/create/{id}', 'Empresa\EmpresaContactoController@store');
    Route::put('empresacontacto/update/{id}', 'Empresa\EmpresaContactoController@update');
    Route::delete('empresacontacto/delete/{id}', 'Empresa\EmpresaContactoController@destroy');
    Route::put('empresacontacto/active/{id}', 'Empresa\EmpresaContactoController@active');

    //Procesos Cognitivos
    Route::get('procesocognoscitivo/get', 'Psicologia\ProcesoCognoscitivoController@get');
    Route::post('procesocognoscitivo/create', 'Psicologia\ProcesoCognoscitivoController@store');
    Route::put('procesocognoscitivo/update/{id}', 'Psicologia\ProcesoCognoscitivoController@update');
    Route::delete('procesocognoscitivo/delete/{id}', 'Psicologia\ProcesoCognoscitivoController@destroy');
    Route::put('procesocognoscitivo/active/{id}', 'Psicologia\ProcesoCognoscitivoController@activar_datos');
    Route::get('procesocognoscitivo/lucidoatento/get', 'Psicologia\ProcesoCognoscitivoController@getLucidoAtento');
    Route::get('procesocognoscitivo/pensamiento/get', 'Psicologia\ProcesoCognoscitivoController@getPensamiento');
    Route::get('procesocognoscitivo/percepcion/get', 'Psicologia\ProcesoCognoscitivoController@getPercepcion');
    Route::get('procesocognoscitivo/memoria/get', 'Psicologia\ProcesoCognoscitivoController@getMemoria');
    Route::get('procesocognoscitivo/inteligencia/get', 'Psicologia\ProcesoCognoscitivoController@getInteligencia');
    Route::get('procesocognoscitivo/apetito/get', 'Psicologia\ProcesoCognoscitivoController@getApetito');
    Route::get('procesocognoscitivo/suenno/get', 'Psicologia\ProcesoCognoscitivoController@getSuenno');
    Route::get('procesocognoscitivo/personalidad/get', 'Psicologia\ProcesoCognoscitivoController@getPersonalidad');
    Route::get('procesocognoscitivo/afectividad/get', 'Psicologia\ProcesoCognoscitivoController@getAfectividad');
    Route::get('procesocognoscitivo/conductasexual/get', 'Psicologia\ProcesoCognoscitivoController@getConductaSexual');
    //Pruebas Psicológicas
    Route::get('pruebaspsicologicas/get', 'Psicologia\PruebaPsicologicaController@get');
    Route::post('pruebaspsicologicas/create', 'Psicologia\PruebaPsicologicaController@store');
    Route::put('pruebaspsicologicas/update/{id}', 'Psicologia\PruebaPsicologicaController@update');
    Route::delete('pruebaspsicologicas/delete/{id}', 'Psicologia\PruebaPsicologicaController@destroy');
    Route::put('pruebaspsicologicas/active/{id}', 'Psicologia\PruebaPsicologicaController@activar_datos');
    Route::get('pruebas/get', 'Psicologia\PruebaPsicologicaController@getpruebas');

    /*AÑADE AQUI LAS RUTAS QUE QUIERAS PROTEGER CON JWT*/
    Route::get('empresas/sucursales/get', 'Empresa\SucursalEmpresaController@get')->name('getSucursal');
    Route::post('empresas/sucursales/create', 'Empresa\SucursalEmpresaController@create')->name('createSucursal');
    Route::put('empresas/sucursales/update/{idSucursal}', 'Empresa\SucursalEmpresaController@update')->name('updateSucursal');
    Route::delete('empresas/sucursales/delete/{idSucursal}', 'Empresa\SucursalEmpresaController@delete')->name('deleteSucursal');
    //paquetes
    Route::get('empresas/mispaquetes/get', 'Hospital\EmpresaPaqueteController@get')->name('getMisPaquetesEmpresa');
    //superareas
    // Route::get('empresas/superareas/get', 'Empresa\SuperAreaController@get')->name('getSuperarea');
    // Route::post('empresas/superareas/create/{idLocal}', 'Empresa\SuperAreaController@create')->name('createSuperarea');
    // Route::put('empresas/superareas/update/{idSuperarea}', 'Empresa\SuperAreaController@update')->name('updateSuperarea');
    // Route::delete('empresas/superareas/delete/{idSuperarea}', 'Empresa\SuperAreaController@delete')->name('deleteSuperarea');

    Route::get('clinica/local/{idlocal}/areas/get', 'Clinica\ClinicaAreaController@get')->name('getSuperarea');
    Route::post('clinica/areas/create/{idLocal}', 'Clinica\ClinicaAreaController@create')->name('createSuperarea');
    Route::put('clinica/areas/update/{idarea}', 'Clinica\ClinicaAreaController@update')->name('updateSuperarea');
    Route::delete('clinica/areas/delete/{idarea}', 'Clinica\ClinicaAreaController@delete')->name('deleteSuperarea');
    Route::delete('clinica/areas/destroy/{idarea}', 'Clinica\ClinicaAreaController@destroy');
    //areas
    // Route::get('empresas/areas/get', 'Empresa\AreaController@get')->name('getArea');
    // Route::get('empresas/areas/getsuperarea/{idSuperarea}', 'Empresa\AreaController@getSuperarea')->name('getAreaSuperarea');
    // Route::post('empresas/areas/create', 'Empresa\AreaController@create')->name('createArea');
    // Route::put('empresas/areas/update/{idArea}', 'Empresa\AreaController@update')->name('updateArea');
    // Route::delete('empresas/areas/delete/{idArea}', 'Empresa\AreaController@delete')->name('deleteArea');

    // //subareas
    // Route::get('empresas/subareas/get', 'Empresa\SubAreaController@get')->name('getSubarea');
    // Route::get('empresas/subareas/getareas/{idArea}', 'Empresa\SubAreaController@getArea')->name('getSubareaArea');
    // Route::post('empresas/subareas/create', 'Empresa\SubAreaController@create')->name('createSubarea');
    // Route::put('empresas/subareas/update/{idSubarea}', 'Empresa\SubAreaController@update')->name('updateSubarea');
    // Route::delete('empresas/subareas/delete/{idSubarea}', 'Empresa\SubAreaController@delete')->name('deleteSubarea');

    //empresas
    Route::get('empresas/get', 'Hospital\EmpresaController@index');
    Route::post('empresas/create', 'Hospital\EmpresaController@create');
    Route::get('empresas/getpaquetes/{idEmpresa}', 'Hospital\EmpresaController@getPaquetes');
    Route::post('empresas/update/{idEmpresa}', 'Hospital\EmpresaController@update');
    Route::get('empresas/get/{idEmpresa}', 'Hospital\EmpresaController@show');
    Route::delete('empresas/delete/{idEmpresa}', 'Hospital\EmpresaController@destroy');
    Route::get('empresas/getpaquetes/{idEmpresa}', 'Hospital\EmpresaController@getPaquetes');

    //Servicios
    Route::get('servicios/get', 'Hospital\ServicioController@index');
    Route::put('servicios/action/{idServicio}', 'Hospital\ServicioController@changeEstado');
    Route::post('servicios/create', 'Hospital\ServicioController@create');
    Route::put('servicios/udpate/{idServicio}', 'Hospital\ServicioController@update');
    Route::delete('servicios/delete/{idServicio}', 'Hospital\ServicioController@destroy');
    Route::put('servicios/changedelivery/{idServicio}', 'Hospital\ServicioController@changeEstadoDelivery');

    //Servicios Producto
    Route::get('serviciosproductos/get', 'Hospital\ServicioProductoController@index');
    Route::post('serviciosproductos/create', 'Hospital\ServicioProductoController@create');
    Route::delete('serviciosproductos/delete/{idServicioProducto}', 'Hospital\ServicioProductoController@destroy');

    //Productos
    Route::get('productos/get', 'Hospital\ProductoController@index');
    Route::get('productos/getallservicios', 'Hospital\ProductoController@getAllServicios');
    Route::get('productos/getservicios/{idProducto}', 'Hospital\ProductoController@getServicios');
    Route::post('productos/create', 'Hospital\ProductoController@create');
    Route::put('productos/update/{idProducto}', 'Hospital\ProductoController@update');
    Route::delete('productos/delete/{idProducto}', 'Hospital\ProductoController@destroy');

    //Producto Paquete
    Route::get('productospaquetes/get', 'Hospital\ProductoPaqueteController@index');
    Route::post('productospaquetes/create', 'Hospital\ProductoPaqueteController@create');
    Route::delete('productospaquetes/delete/{idProductoPaquete}', 'Hospital\ProductoPaqueteController@destroy');

    //Paquetes
    Route::get('paquetes/get', 'Hospital\PaqueteController@index');
    Route::put('paquetes/update/{idPaquete}', 'Hospital\PaqueteController@update');
    Route::delete('paquetes/delete/{idPaquete}', 'Hospital\PaqueteController@destroy');
    Route::post('paquetes/create', 'Hospital\PaqueteController@create');
    Route::get('paquetes/getproductos/{idPaquete}', 'Hospital\PaqueteController@getProductos');
    Route::put('paquetes/changedelivery/{idPaquete}', 'Hospital\PaqueteController@changeEstadoDelivery');

    //Medical Clinica Paquete
    // Route::get('clinicapaquetes/get', 'Medical\PaqueteClinicaController@index')->name('GetClinicaPaquetes');
    // Route::post('clinicapaquetes/create', 'Medical\PaqueteClinicaController@create')->name('StoreClinicaPaquetes');
    // Route::post('clinicaspaquetes/create', 'Medical\PaqueteClinicaController@createClinicaPaquetes')->name('CreateClinicasPaquetes');
    // Route::get('clinicapaquetes/get/{idPaqueteClinica}', 'Medical\PaqueteClinicaController@show')->name('ShowClinicaPaquetes');
    // Route::put('clinicapaquetes/update/{idPaqueteClinica}', 'Medical\PaqueteClinicaController@update')->name('UpdateClinicaPaquetes');
    // Route::delete('clinicapaquetes/delete/{idPaqueteClinica}', 'Medical\PaqueteClinicaController@delete')->name('DeleteClinicaPaquetes');
    Route::post('clinica/perfil/paquetes/{idPaquete}', 'Clinica\ClinicaPaqueteController@asignar_perfil');

    //Servicio Clinica
    Route::get('clinicaservicios/get', 'Medical\ServicioClinicaController@index')->name('getServicioClinicas');
    Route::post('clinicaservicios/create', 'Medical\ServicioClinicaController@create')->name('createServicioClinicas');
    Route::get('clinicaservicios/get/{idServicioClinica}', 'Medical\ServicioClinicaController@show')->name('showServicioClinicas');
    Route::put('clinicaservicios/update/{idServicioClinica}', 'Medical\ServicioClinicaController@update')->name('updateServicioClinicas');
    Route::delete('clinicaservicios/delete/{idServicioClinica}', 'Medical\ServicioClinicaController@delete')->name('deleteServicioClinicas');

    //Empresa Paquete
    Route::get('empresaspaquetes/get', 'Hospital\EmpresaPaqueteController@get');
    Route::post('empresaspaquetes/create', 'Hospital\EmpresaPaqueteController@create');
    Route::delete('empresaspaquetes/delete/{idEmpresaPaquete}', 'Hospital\EmpresaPaqueteController@delete');

    //trabajadores
    Route::get('empresas/trabajadores/get', 'Empresa\TrabajadorController@get')->name('getTrabajador');
    Route::post('empresas/trabajadores/create', 'Empresa\TrabajadorController@create')->name('createTrabajador');
    Route::post('empresas/trabajadores/import', 'Empresa\TrabajadorController@import')->name('importTrabajador');
    Route::put('empresas/trabajadores/update/{idTrabajador}', 'Empresa\TrabajadorController@update')->name('updateTrabajador');
    Route::delete('empresas/trabajadores/delete/{idTrabajador}', 'Empresa\TrabajadorController@delete')->name('deleteTrabajador');

    //cargos
    Route::get('empresas/cargos/get', 'Empresa\CargoController@get');
    Route::post('empresas/cargos/create', 'Empresa\CargoController@create');
    Route::put('empresas/cargos/update/{idCargo}', 'Empresa\CargoController@update');
    Route::delete('empresas/cargos/delete/{idCargo}', 'Empresa\CargoController@delete');

    //atenciones
    Route::get('empresas/atenciones/get', 'Atencion\AtencionController@getAtencionEmpresa')->name('GetAtencioness');
    Route::post('empresas/atenciones/createsubarea', 'Hospital\AtencionController@createSubarea')->name('ccreateSubarea');
    Route::post('empresas/atenciones/import', 'Atencion\AtencionController@import')->name('importAtenciones');
    Route::post('empresas/atenciones/createtrabajadores', 'Atencion\AtencionController@createTrabajadores')->name('ccreateTrabajadores');
    Route::post('empresas/atencionesPrueba/create', 'Hospital\AtencionController@createPrueba')->name('ccreateAtencionesPrueba');
    Route::get('empresas/FichaOcupacional/get/{ficha_ocupacional_id}', 'Hospital\AtencionController@getFichaOcupacional');
    Route::get('empresas/FichaPsicologicaOcupacional/get/{ficha_psicologica_ocupacional_id}', 'Hospital\AtencionController@getFichaPsicologicaOcupacional');

    Route::post('medico/atenciones/startatencion', 'Hospital\FichaOcupacionalController@startAtention');
    Route::post('medico/triaje/antecendentesPersonales', 'Hospital\FoAPersonalController@create');
    Route::get('recepcion/atenciones/get', 'Atencion\AtencionController@getAtenciones')->name('GetAtencionessTotales');
    Route::post('atencion/enviarpacientes', 'Atencion\AtencionController@enviarpacientes');
    //facturacion
    Route::get('facturaciones/atencionesEmpresa/get', 'Atencion\AtencionController@getAtencionesFacturacion')->name('getAtencionesFacturacion');
    Route::get('facturaciones/liquidacion/empresa/get/{IdEmpresa}', 'Atencion\AtencionController@getAtencionesLiquidacionEmpresa')->name('getAtencionesLiquidacionEmpresa');
    Route::post('facturaciones/liquidacion/create', 'Hospital\LiquidacionController@create')->name('CreateLiquidaciones');
    Route::post('facturaciones/liquidacion/subirFactura/{idLiquidacion}', 'Hospital\LiquidacionController@subirFactura')->name('SubirFacturaLiquidaciones');
    Route::get('facturaciones/liquidacion/get', 'Hospital\LiquidacionController@get')->name('getLiquidaciones');
    Route::put('facturaciones/liquidacion/update/{idLiquidacion}', 'Hospital\LiquidacionController@update')->name('updateLiquidaciones');
    Route::get('facturaciones/empresa/get', 'Empresa\LiquidacionController@get')->name('getFacturacionLiquidacionEmpresa');
    //diagnostico
    Route::get('empresas/diagnosticos/get', 'Empresa\DiagnosticoController@index');
    Route::get('empresas/diagnosticos/create', 'Empresa\DiagnosticoController@store');
    //Clinica
    Route::get('clinicas/contratos/get', 'Hospital\ClinicaController@getcontratos')->name('GetClinicasContratos');
    Route::get('clinicas/get', 'Hospital\ClinicaController@index')->name('GetClinicas');
    Route::post('clinicas/create', 'Hospital\ClinicaController@store')->name('CreateClinicas');
    Route::get('clinicas/get/{idClinica}', 'Hospital\ClinicaController@show')->name('ShowClinica');
    Route::put('clinicas/update/{idClinica}', 'Hospital\ClinicaController@update')->name('UpdateClinicas');
    Route::put('clinicas/updatebylogin', 'Hospital\ClinicaController@updatebylogin')->name('UpdateByLoginClinicas');
    Route::get('clinica/show','Hospital\ClinicaController@me')->name('ShowMeClinica');
    Route::delete('clinicas/delete/{idClinica}', 'Hospital\ClinicaController@destroy')->name('DeleteClinicas');
    Route::put('clinicas/activar/{idClinica}', 'Hospital\ClinicaController@activar')->name('ActivarClinicas');
    Route::get('clinica/contratos/empresa/get', 'Hospital\ClinicaController@getEmpresas');

    //Clinica-Contacto
    Route::post('clinica/contacto/create/{clinica_id}', 'ClinicaContactoController@create');
    Route::put('clinica/contacto/update/{contacto_id}/{clinica_id}', 'ClinicaContactoController@update');
    Route::delete('clinica/contacto/delete/{contacto_id}', 'ClinicaContactoController@delete');
    Route::get('clinica/contacto/show/{contacto_id}', 'ClinicaContactoController@show');
    Route::get('clinica/contacto/get', 'ClinicaContactoController@get');

    //Especialidad Clinica
    Route::get('clinicas/especialidades/get', 'Clinica\EspecialidadClinicaController@index')->name('GetEspecialidades');
    Route::post('clinicas/especialidades/create', 'Clinica\EspecialidadClinicaController@store')->name('CreateEspecialidades');
    Route::get('clinicas/especialidades/get/{idEspecialidad}', 'Clinica\EspecialidadClinicaController@show')->name('ShowEspecialidades');
    Route::put('clinicas/especialidades/update/{idEspecialidad}', 'Clinica\EspecialidadClinicaController@update')->name('UpdateEspecialidades');
    Route::delete('clinicas/especialidades/delete/{idEspecialidad}', 'Clinica\EspecialidadClinicaController@destroy')->name('DeleteEspecialidades');

    //Sucursal
    Route::get('clinicas/sucursales/get', 'Clinica\SucursalClinicaController@index')->name('GetClinicaSucursales');
    Route::post('clinicas/sucursales/create', 'Clinica\SucursalClinicaController@store')->name('CreateClinicaSucursales');
    Route::get('clinicas/sucursales/get/{idSucursal}', 'Clinica\SucursalClinicaController@show')->name('ShowClinicaSucursales');
    Route::put('clinicas/sucursales/update/{idSucursal}', 'Clinica\SucursalClinicaController@update')->name('UpdateClinicaSucursales');
    Route::delete('clinicas/sucursales/delete/{idSucursal}', 'Clinica\SucursalClinicaController@destroy')->name('DeleteClinicaSucursales');
    //Tipos Clinicas
    Route::get('clinicas/tipoclinicas/get', 'Clinica\TipoClinicaController@index')->name('GetTipoClinicas');
    Route::post('clinicas/tipoclinicas/create', 'Clinica\TipoClinicaController@store')->name('CreateTipoClinicas');
    Route::get('clinicas/tipoclinicas/get/{idTipoClinica}', 'Clinica\TipoClinicaController@show')->name('ShowTipoClinicas');
    Route::put('clinicas/tipoclinicas/update/{idTipoClinica}', 'Clinica\TipoClinicaController@update')->name('UpdateTipoClinicas');
    Route::delete('clinicas/tipoclinicas/delete/{idTipoClinica}', 'Clinica\TipoClinicaController@destroy')->name('DeleteTipoClinicas');
    //Trabajador
    Route::get('clinicas/trabajadores/get', 'Clinica\TrabajadorClinicaController@get')->name('getTrabajadoresClinicas');
    //Trabajador Clinica
    Route::get('clinicas/trabajadores/get', 'Clinica\TrabajadorClinicaController@get')->name('getTrabajadoresClinicas');
    Route::get('clinicas/roltrabajadores/get', 'Clinica\TrabajadorClinicaController@getTrabajadorRolClinica')->name('getTrabajadoresRolClinicas');
    Route::get('clinicas/trabajadores/get/{idTrabajador}', 'Clinica\TrabajadorClinicaController@show')->name('getTrabajadorClinicasId');
    Route::post('clinicas/trabajadores/create', 'Clinica\TrabajadorClinicaController@create')->name('createTrabajadoresClinicas');
    Route::put('clinicas/trabajadores/update/{idTrabajador}', 'Clinica\TrabajadorClinicaController@update')->name('updateTrabajadoresClinicas');
    Route::delete('clinicas/trabajadores/delete/{idTrabajador}', 'Clinica\TrabajadorClinicaController@delete')->name('deleteTrabajadoresClinicas');

    //Tipo Cliente
    Route::post('tipo/cliente/create', 'TipoClienteController@create');
    Route::put('tipo/cliente/update/{id}', 'TipoClienteController@update');
    Route::delete('tipo/cliente/delete/{id}', 'TipoClienteController@delete');
    Route::get('tipo/cliente/show', 'TipoClienteController@show');
    Route::get('tipo/cliente/get/{id_tipo_cliente}', 'TipoClienteController@get');

    //RECEPCION - Paciente
    Route::get('recepcion/pacientes/get', 'Recepcion\PacienteController@index');
    Route::post('recepcion/pacientes/create', 'Recepcion\PacienteController@create');
    Route::post('recepcion/pacientes/update/{idPaciente}', 'Recepcion\PacienteController@update');
    Route::delete('recepcion/pacientes/delete/{idPaciente}', 'Recepcion\PacienteController@delete');
    Route::get('recepcion/pacientes/getme', 'Recepcion\PacienteController@getMe');
    Route::get('recepcion/pacientes/getpacientestrabajadores', 'Recepcion\PacienteController@getPacientesTrabajadores');
    Route::put('recepcion/atenciones/empezar/{idPaciente}', 'Recepcion\AtencionController@startAtencion');
    Route::get('atenciones/get', 'Recepcion\AtencionController@getAtenciones');


    //ficha ocupacional
    Route::get('fichaocupacional/tipoevaluaciones/get', 'TipoEvaluacionController@get')->name('getTipoEvaluacionController');
    //actualizar icon servicio
    Route::post('servicio/icon/update/{idServicio}', 'Hospital\ServicioController@subirIcon')->name('subirIconServicios');

    //TRIAJE
    Route::get('atencion/triaje/habitonocivo/get/{idHabitoNocivo}', 'Atencion\HabitoNocivoController@get');
    Route::post('atencion/triaje/habitonocivo/create', 'Atencion\HabitoNocivoController@store');
    Route::put('atencion/triaje/habitonocivo/update/{idHabitoNocivo}', 'Atencion\HabitoNocivoController@update');
    Route::delete('atencion/triaje/habitonocivo/delete/{idHabitoNocivo}', 'Atencion\HabitoNocivoController@delete');

    //MOVIL
    Route::get('movil/profile', 'movil\MovilController@me');
    Route::put('movil/update', 'movil\MovilController@update');
    Route::get('movil/historial', 'movil\MovilController@historical');
    Route::get('movil/solicitud', 'movil\MovilController@solicitudes');

    //Bregma
    Route::post('bregma/create', 'Bregma\BregmaController@store');
    Route::put('bregma/update/{id}', 'Bregma\BregmaController@update');
    Route::delete('bregma/delete/{id}', 'Bregma\BregmaController@delete');
    Route::put('bregma/activar/{id}', 'Bregma\BregmaController@activar');
    Route::get('bregma/show', 'Bregma\BregmaController@show');
    Route::get('bregma/contratos/get', 'Bregma\BregmaController@getcontratos');
    Route::get('bregma/contratos/clinica/get', 'Bregma\BregmaController@getClinicas');

    //Bregma Personal
    Route::post('bregma/personal/create', 'Bregma\BregmaPersonalController@store');
    Route::put('bregma/personal/update/{id}', 'Bregma\BregmaPersonalController@update');
    Route::delete('bregma/personal/delete/{id}', 'Bregma\BregmaPersonalController@delete');
    Route::put('bregma/personal/activar/{id}', 'Bregma\BregmaPersonalController@activar');
    Route::get('bregma/personal/get', 'Bregma\BregmaPersonalController@get');
    Route::get('bregma/personal/show/{personal_bregma_id}', 'Bregma\BregmaPersonalController@show');
    Route::post('bregma/personal/asignararea', 'Bregma\BregmaPersonalController@asignarAreas');
    Route::get('bregma/personal/area/get/{id_area}', 'Bregma\BregmaPersonalController@get_personal_area');
    //Bregma Local
    Route::post('bregma/local/create', 'Bregma\BregmaLocalController@create');
    Route::put('bregma/local/update/{id}', 'Bregma\BregmaLocalController@update');
    Route::delete('bregma/local/delete/{id}', 'Bregma\BregmaLocalController@delete');
    Route::get('bregma/local/show', 'Bregma\BregmaLocalController@show');
    //Bregma Soporte
    Route::post('bregma/soporte/create', 'Bregma\BregmaSoporteController@create');
    Route::put('bregma/soporte/update/{id}', 'Bregma\BregmaSoporteController@update');
    Route::delete('bregma/soporte/delete/{id}', 'Bregma\BregmaSoporteController@delete');
    Route::get('bregma/soporte/show', 'Bregma\BregmaSoporteController@show');

    // Bregma - Servicios
    Route::post('bregma/servicio/create', 'Bregma\BregmaServicioController@create');
    Route::post('bregma/servicio/update/{idBServicio}', 'Bregma\BregmaServicioController@update');
    Route::delete('bregma/servicio/delete/{idBServicio}', 'Bregma\BregmaServicioController@delete');
    Route::get('bregma/servicio/get', 'Bregma\BregmaServicioController@get');

    Route::get('bregma/servicio/getall', 'Bregma\BregmaServicioController@getAll');

    // Bregma - Operacion
    Route::post('bregma/operacion/create', 'Bregma\BregmaOperacionController@create');
    Route::put('bregma/operacion/update/{idBoperacion}', 'Bregma\BregmaOperacionController@update');
    Route::delete('bregma/operacion/delete/{idBoperacion}', 'Bregma\BregmaOperacionController@delete');
    Route::get('bregma/operacion/show', 'Bregma\BregmaOperacionController@show');

    //Bregma - Area
    Route::post('bregma/area/create', 'Bregma\BregmaAreaController@create');
    Route::put('bregma/area/update/{id}', 'Bregma\BregmaAreaController@update');
    Route::delete('bregma/area/delete/{id}', 'Bregma\BregmaAreaController@delete');
    Route::get('bregma/area/show', 'Bregma\BregmaAreaController@show');
    Route::get('bregma/local/area/show/{id_local}', 'Bregma\BregmaAreaController@show_local_bregma');

    Route::get('bregma/local/{idLocal}/areas/get', 'Bregma\BregmaAreaController@get');

    // Celular Institucion
    Route::post('celular/institucion/create', 'CelularInstitucionController@create');
    Route::put('celular/institucion/update/{id}', 'CelularInstitucionController@update');
    Route::delete('celular/institucion/delete/{id}', 'CelularInstitucionController@delete');
    Route::get('celular/institucion/show', 'CelularInstitucionController@show');
    Route::get('celular/institucion/get/{idCelular}', 'CelularInstitucionController@get');
    // Correo Institucion
    Route::post('correo/institucion/create', 'CorreoInstitucionController@create');
    Route::put('correo/institucion/update/{id}', 'CorreoInstitucionController@update');
    Route::delete('correo/institucion/delete/{id}', 'CorreoInstitucionController@delete');
    Route::get('correo/institucion/show', 'CorreoInstitucionController@show');
    Route::get('correo/institucion/get/{idCorreo}', 'CorreoInstitucionController@get');
    ////////////////////////////////////////////////

    //Contrato
    Route::post('contrato/create', 'ContratoController@store');
    Route::put('contrato/update/{id_contrato}', 'ContratoController@update');
    Route::delete('contrato/delete/{id_contrato}', 'ContratoController@delete');
    Route::get('contrato/show', 'ContratoController@show');

    //-----Clinica local-----
    Route::get('recursoshumanos/local/get', 'ClinicaLocalController@get');
    Route::get('recursoshumanos/local/get/{idClinica}', [ClinicaLocalController::class, 'getLocales']);
    Route::post('recursoshumanos/local/create', 'ClinicaLocalController@create');
    Route::put('recursoshumanos/local/update/{id}', 'ClinicaLocalController@update');
    Route::delete('recursoshumanos/local/delete/{id}', 'ClinicaLocalController@delete');

    //Entidad Pago
    Route::post('entidad_pago/create', 'EntidadPagoController@create');
    Route::put('entidad_pago/update/{Id}', 'EntidadPagoController@update');
    Route::delete('entidad_pago/delete/{Id}', 'EntidadPagoController@delete');
    Route::get('entidad_pago/show', 'EntidadPagoController@show');
    Route::get('entidad_pago/show-bregma', 'EntidadPagoController@showEntidadesPagoBregma');
    Route::post('entidad_pago/create-bregma', 'EntidadPagoController@createBregma');
    Route::post('entidad_pago/create/clinica', 'EntidadPagoController@createClinica');


    //Bregma Tutorial
    Route::post('bregma/soporte/create', 'Bregma\TutorialBregmaController@create');
    Route::put('bregma/soporte/update/{id}', 'Bregma\TutorialBregmaController@update');
    Route::delete('bregma/soporte/delete/{id}', 'Bregma\TutorialBregmaController@delete');
    Route::get('bregma/soporte/show', 'Bregma\TutorialBregmaController@show');

    //Empresa Tutorial
    Route::post('empresa/soporte/create', 'Empresa\TutorialEmpresaController@create');
    Route::put('empresa/soporte/update/{id}', 'Empresa\TutorialEmpresaController@update');
    Route::delete('empresa/soporte/delete/{id}', 'Empresa\TutorialEmpresaController@delete');
    Route::get('empresa/soporte/show', 'Empresa\TutorialEmpresaController@show');

    //Clinica Tutorial
    Route::post('clinica/soporte/create', 'Clinica\TutorialClinicaController@create');
    Route::put('clinica/soporte/update/{id}', 'Clinica\TutorialClinicaController@update');
    Route::delete('clinica/soporte/delete/{id}', 'Clinica\TutorialClinicaController@delete');
    Route::get('clinica/soporte/show', 'Clinica\TutorialClinicaController@show');

    // Clinica Paquete
    Route::post('clinica/paquete/create', 'Clinica\ClinicaPaqueteController@create');
    Route::put('clinica/paquete/update/{Idpaquete}', 'Clinica\ClinicaPaqueteController@update');
    Route::delete('clinica/paquete/delete/{Id}', 'Clinica\ClinicaPaqueteController@delete');
    Route::get('clinica/paquete/show', 'Clinica\ClinicaPaqueteController@show');
    // Clinica Paquete Servicio (asignar servicios al paquete)
    Route::post('paquetes/asignar/services/{paquete_id}', 'Clinica\ClinicaPaqueteServicioController@asignarServicios');
    Route::get('paquetes/servicios/show', 'Clinica\ClinicaPaqueteServicioController@show');

    // Clinica Paquete - Contrato
    Route::get('contrato/paquetes/perfiles', 'Clinica\ClinicaContratoPaqueteController@contrato_clinica_paquete_get');

    /*Route::post('clinica/paquete/servicios/create', 'Clinica\ClinicaPaqueteController@create');
    Route::post('paquetes/asignar-services/{id}', 'Clinica\ClinicaPaqueteController@asignarServicios');
    Route::put('clinica/paquete/servicios/update/{id}', 'Clinica\ClinicaPaqueteController@update');
    Route::delete('clinica/paquete/servicios/delete/{id}', 'Clinica\ClinicaPaqueteController@delete');*/

    Route::get('clinica/paquete/get', 'Clinica\ClinicaPaqueteController@get');
    Route::put('clinica/paquete/update/{id_cli_pa}', 'Clinica\ClinicaPaqueteController@update');
    Route::delete('clinica/paquete/delete/{id}', 'Clinica\ClinicaPaqueteController@delete');
    Route::put('clinica/paquete/activate/{id}','Clinica\ClinicaPaqueteController@activate');

    //Soporte Contacto
    Route::post('contacto/soporte/create', 'SoporteContactoController@create');
    Route::put('contacto/soporte/update/{id}', 'SoporteContactoController@update');
    Route::delete('contacto/soporte/delete/{id}', 'SoporteContactoController@delete');
    Route::get('contacto/soporte/show', 'SoporteContactoController@show');

    // Clinica - Servicios
    Route::get('clinica/servicio/get', 'Clinica\ClinicaServicioController@show');
    Route::post('clinica/servicio/create', 'Clinica\ClinicaServicioController@create');
    Route::put('clinica/servicio/update/{idclinicaservicio}', 'Clinica\ClinicaServicioController@update');
    Route::delete('clinica/servicio/delete/{idclinicaservicio}', 'Clinica\ClinicaServicioController@delete');
    Route::get('clinica/operaciones/servicio/get', 'Clinica\ClinicaServicioController@get');

    //Empresa Local Recursos Humanos
    Route::post('empresa/local/create', 'Empresa\EmpresaLocalController@create');
    Route::put('empresa/local/update/{id}', 'Empresa\EmpresaLocalController@update');
    Route::delete('empresa/local/delete/{id}', 'Empresa\EmpresaLocalController@delete');
    Route::get('empresa/local/show', 'Empresa\EmpresaLocalController@show');

    //Empresa Area Recursos Humanos
    Route::post('empresa/area/create', 'Empresa\EmpresaAreaController@create');
    Route::put('empresa/area/update/{id}', 'Empresa\EmpresaAreaController@update');
    Route::delete('empresa/area/delete/{id}', 'Empresa\EmpresaAreaController@delete');
    Route::get('empresa/area/show', 'Empresa\EmpresaAreaController@show');

    Route::get('empresa/local/{idLocal}/areas/get', 'Empresa\EmpresaAreaController@get');

    //Psicologia-Examen Mental
    Route::get('psicologia/examenMental/get','Psicologia\ExamenMentalController@index');
    Route::post('psicologia/examenMental/create','Psicologia\ExamenMentalController@store');
    Route::put('psicologia/examenMental/update/{id}','Psicologia\ExamenMentalController@update');
    Route::put('psicologia/examenMental/activate/{id}','Psicologia\ExamenMentalController@activate');
    Route::delete('psicologia/examenMental/delete/{id}','Psicologia\ExamenMentalController@destroy');

    //Seeders-Examen Mental
    Route::get('psicologia/examenMental/getPresentacion','Psicologia\ExamenMentalController@getPresentacion');
    Route::get('psicologia/examenMental/getPostura','Psicologia\ExamenMentalController@getPostura');
    Route::get('psicologia/examenMental/getRitmo','Psicologia\ExamenMentalController@getRitmo');
    Route::get('psicologia/examenMental/getTono','Psicologia\ExamenMentalController@getTono');
    Route::get('psicologia/examenMental/getArticulacion','Psicologia\ExamenMentalController@getArticulacion');
    Route::get('psicologia/examenMental/getTiempo','Psicologia\ExamenMentalController@getTiempo');
    Route::get('psicologia/examenMental/getEspacio','Psicologia\ExamenMentalController@getEspacio');
    Route::get('psicologia/examenMental/getPersonaMental','Psicologia\ExamenMentalController@getPersonaMental');
    Route::get('psicologia/examenMental/getCoordinacionVisomotriz','Psicologia\ExamenMentalController@getCoordinacionVisomotriz');

    //Psicologia-Diagnostico Final
    Route::get('psicologia/diagnosticofinal/get', 'Psicologia\DiagnosticoFinalController@get');
    Route::post('psicologia/diagnosticofinal/create', 'Psicologia\DiagnosticoFinalController@create');
    Route::put('psicologia/diagnosticofinal/update/{idDiagFinal}', 'Psicologia\DiagnosticoFinalController@update');
    Route::delete('psicologia/diagnosticofinal/delete/{idDiagFinal}', 'Psicologia\DiagnosticoFinalController@delete');

    Route::get('psicologia/diagnosticofinal/area_cognitiva/get', 'Psicologia\DiagnosticoFinalController@get_area_cognitiva');
    Route::get('psicologia/diagnosticofinal/area_emocional/get', 'Psicologia\DiagnosticoFinalController@get_area_emocional');
    Route::get('psicologia/diagnosticofinal/recomendaciones/get', 'Psicologia\DiagnosticoFinalController@get_recomendaciones');
    Route::get('psicologia/diagnosticofinal/resultado/get', 'Psicologia\DiagnosticoFinalController@get_resultado');

    //Oftalmologia - Test
    Route::get('oftalmologia/test/get', 'Oftalmologia\TestController@get');
    Route::post('oftalmologia/test/create', 'Oftalmologia\TestController@create');
    Route::put('oftalmologia/test/update/{idTest}', 'Oftalmologia\TestController@update');
    Route::delete('oftalmologia/test/delete/{idTest}', 'Oftalmologia\TestController@delete');
    Route::put('oftalmologia/test/activate/{idTest}', 'Oftalmologia\TestController@activar');
    Route::get('oftalmologia/test/estereopsis/stereo_fly_test/get', 'Oftalmologia\TestController@get_stereo_fly_test');
    Route::get('oftalmologia/test/estereopsis/circulos/get', 'Oftalmologia\TestController@get_circulos');


    //Oftalmologia - Agudeza visual
    Route::get('oftalmologia/agudezavisual/get', 'Oftalmologia\AgudezaVisualController@index');
    Route::post('oftalmologia/agudezavisual/create', 'Oftalmologia\AgudezaVisualController@store');
    Route::put('oftalmologia/agudezavisual/update/{id}', 'Oftalmologia\AgudezaVisualController@update');
    Route::delete('oftalmologia/agudezavisual/delete/{id}', 'Oftalmologia\AgudezaVisualController@destroy');
    Route::put('oftalmologia/agudezavisual/activate/{id}', 'Oftalmologia\AgudezaVisualController@activate');
    //SEEDERS MEDIDA CERCA-LEJOS
    Route::get('oftalmologia/agudezavisual/getmedcer', 'Oftalmologia\AgudezaVisualController@getmedcer');
    Route::get('oftalmologia/agudezavisual/getmedlej', 'Oftalmologia\AgudezaVisualController@getmedlej');
    //SEEDERS NUEVOS-AGUDEZA VISUAL
    Route::get('oftalmologia/agudezavisual/getenfocul', 'Oftalmologia\AgudezaVisualController@getenfocul');
    Route::get('oftalmologia/agudezavisual/getrefpup', 'Oftalmologia\AgudezaVisualController@getrefpup');
    Route::get('oftalmologia/agudezavisual/getviscol', 'Oftalmologia\AgudezaVisualController@getviscol');
    Route::get('oftalmologia/agudezavisual/getojoderecho', 'Oftalmologia\AgudezaVisualController@getojoderecho');
    Route::get('oftalmologia/agudezavisual/getojoizquierdo', 'Oftalmologia\AgudezaVisualController@getojoizquierdo');
    //
    Route::post('enviartrabajador', 'Empresa\EmpresaPersonalController@enviarTrabajador');

    //Hoja de Ruta - Ficha Medica Ocupacional
    Route::post('clinica/hoja_ruta/create', 'Clinica\HojaRutaController@create');
    Route::put('clinica/hoja_ruta/update/{id}', 'Clinica\HojaRutaController@update');
    Route::delete('clinica/hoja_ruta/delete/{id}', 'Clinica\HojaRutaController@delete');
    Route::get('clinica/hoja_ruta/show', 'Clinica\HojaRutaController@show');
    Route::get('clinica/hoja_ruta/show_general', 'Clinica\HojaRutaController@show_general');
    Route::get('clinica/hoja_ruta/paciente/{id_paciente}', 'Clinica\HojaRutaController@get_paciente');

    //Hoja de Ruta Detalle - Ficha Medica Ocupacional
    Route::post('clinica/hoja_ruta/detalle/create', 'Clinica\HojaRutaDetalleController@create');
    Route::put('clinica/hoja_ruta/detalle/update/{id}', 'Clinica\HojaRutaDetalleController@update');
    Route::delete('clinica/hoja_ruta/detalle/delete/{id}', 'Clinica\HojaRutaDetalleController@delete');
    Route::get('clinica/hoja_ruta/detalle/show', 'Clinica\HojaRutaDetalleController@show');

    //Hoja de Ruta Estado - Ficha Medica Ocupacional
    Route::post('clinica/hoja_ruta/estado/create', 'Clinica\EstadoRutaController@create');
    Route::put('clinica/hoja_ruta/estado/update/{id}', 'Clinica\EstadoRutaController@update');
    Route::delete('clinica/hoja_ruta/estado/delete/{id}', 'Clinica\EstadoRutaController@delete');
    Route::get('clinica/hoja_ruta/estado/show', 'Clinica\EstadoRutaController@show');

    //Bregma Paquete
    Route::post('bregma/paquete/create', 'Bregma\BregmaPaqueteController@create');
    Route::put('bregma/paquete/update/{id}', 'Bregma\BregmaPaqueteController@update');
    Route::delete('bregma/paquete/delete/{id}', 'Bregma\BregmaPaqueteController@delete');
    Route::get('bregma/paquete/get', 'Bregma\BregmaPaqueteController@get');
    Route::get('bregma/paquete/show/{id_paquete}', 'Bregma\BregmaPaqueteController@show_paquete_id');
    Route::get('bregma/operaciones/servicios/get', 'Bregma\BregmaPaqueteController@get_all');

    //Bregma Paquete Area
    Route::post('bregma/paquete/area/create', 'Bregma\BregmaPaqueteAreaController@create');
    Route::put('bregma/paquete/area/update/{id}', 'Bregma\BregmaPaqueteAreaController@update');
    Route::delete('bregma/paquete/area/delete/{id}', 'Bregma\BregmaPaqueteAreaController@delete');
    Route::get('bregma/paquete/area/show', 'Bregma\BregmaPaqueteAreaController@show');

    //Area Medica
    Route::post('area/medica/create', 'AreaMedicaController@create');
    Route::put('area/medica/update/{id}', 'AreaMedicaController@update');
    Route::delete('area/medica/delete/{id}', 'AreaMedicaController@delete');
    Route::get('area/medica/show', 'AreaMedicaController@show');

    // Capacitación
    Route::post('capacitacion/create', 'Bregma\CapacitacionController@create');
    Route::post('capacitacion/update/{idcapacitacion}', 'Bregma\CapacitacionController@update');
    Route::delete('capacitacion/delete/{idcapacitacion}', 'Bregma\CapacitacionController@delete');
    Route::get('capacitacion/get', 'Bregma\CapacitacionController@get');

    // Bregma Paquete Capacitación
    Route::post('bregma/paqute/capacitacion/create', 'Bregma\BregmaPaqueteCapacitacionController@create');
    Route::put('bregma/paqute/capacitacion/update/{idPaquete}', 'Bregma\BregmaPaqueteCapacitacionController@update');
    Route::delete('bregma/paqute/capacitacion/delete/{id}', 'Bregma\BregmaPaqueteCapacitacionController@delete');
    Route::get('bregma/paqute/capacitacion/show', 'Bregma\BregmaPaqueteCapacitacionController@show');

    // Aignar paquete
    Route::post('bregma/asignar/paquete/{idContrato}', 'Bregma\VentasController@asignarPaquete');
    Route::get('my/paquetes/get', 'Bregma\VentasController@getMyPaquetes');

    


    //team big
    Route::post('team/big/create', 'TeamBigController@create');
    Route::put('team/big/update/{id}', 'TeamBigController@update');
    Route::delete('team/big/delete/{id}', 'TeamBigController@delete');
    Route::get('team/big/show', 'TeamBigController@show');
    Route::delete('team/big/destroy/{id}', 'TeamBigController@destroy');
});
/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/
