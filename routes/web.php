<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('/home');
});

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/pagina_1', function () {
	return view('pagina_1');

}
     )->name('pagina_1');

Route::get('/solicitudes',  function () {return view('solicitudes');})->name('solicitudes');
Route::get('/viaticos',  function () {return view('viaticos');})->name('viaticos');
Route::get('/s_fondo',  function () {return view('s_fondo');})->name('s_fondo');
Route::get('/r_fondo',  function () {return view('r_fondo');})->name('r_fondo');
Route::get('subdireccion',  function () {return view('subdireccion');})->name('subdireccion/');
Route::get('rendiciones',  function () {return view('rendiciones');})->name('rendiciones'); 
Route::get('rendicionesfinanza',  function () {return view('rendicionesfinanza');})->name('rendicionesfinanza'); 
Route::get('findelasession',  function () {return view('findelasession');})->name('findelasession'); 
Route::get('solicitudeslista',  function () {return view('solicitudes_lista');})->name('solicitudeslista'); 
Route::get('exception_notif',  function () {return view('exception_notif');})->name('exception_notif');

Route::resource('mail', 'MailsController');
Route::resource('persona_anticipo', 'PersonaAnticiposController');
Route::resource('firma_anticipo', 'FirmasAnticiposController');
Route::resource('cpp_anticipos', 'Cpp_AnticipoController');
Route::resource('adjuntos_productos', 'AdjuntosProductosController');
Route::resource('ftp', 'FtpController');
Route::resource('cpp', 'CPPController');
Route::resource('proveedor_anticipos', 'Proveedores_FFController');
Route::resource('productos_aba', 'ProductosABAController');
Route::resource('rendiciones_fondo', 'RendicionesController');
Route::post('rendiciones_fondoupdate', 'RendicionesController@updatefondo');
Route::get('rendiciones_fondo2/{id}', 'RendicionesController@show2');
Route::resource('fondo_fijo', 'AnticiposController');
Route::resource('firma', 'firma_soliicitudesController');
Route::resource('solicitudes_ff', 'SolicitudesController');
Route::resource('fiadores', 'FiadoresController');
Route::resource('adjunto', 'AdjuntosController');
Route::get('subdireccion2/{post}', 'SubdireccionController@show')->name('subdireccion2.index');
Route::post('productoupdate', 'ProductosController@update2');
Route::resource('centros', 'CentrosController');
Route::get('centroscostos/{post}', 'IrCentrosCostosController@show')->name('centroscostos.index');
Route::resource('centro_jt', 'Jefaturas_centrosController');
Route::resource('viaticos_jt', 'ViaticosController');
Route::resource('encargados_cc', 'EncargadosController');
Route::resource('fondo_j', 'FondoFijosController');
Route::resource('productos', 'ProductosController');
Route::resource('ajuntos_ot', 'AdjuntoController');
Route::resource('presucentros', 'PresupuestoAnualCCController');  
Route::resource('gastocentros', 'TotalGastadoCCController'); 
Route::resource('presupustoscentros', 'PresupuestoCentroCosto'); 
Route::resource('totalcentros', 'CentrosCCTotalGastado'); 
Route::resource('ordenesdecompra', 'OrdenesdeComprasController');
Route::resource('encargado_cr', 'EncargadoCRController');
Route::resource('ot_por_asignar', 'OTAsignarController');
Route::resource('firmas', 'FirmasController');
Route::resource('persona', 'PersonaController');
Route::resource('ot_aprobar_persona', 'OT_por_AprobarController');


Route::get('activate-storage', function () {
Artisan::call('storage:link');
});
Route::get('clear-cache', function () {
Artisan::call('cache:clear');
});


