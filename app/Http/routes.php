<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('auth/login');
});

Route::resource('persona/cliente','ClienteController');
Route::resource('persona/empleado','EmpleadoController');
Route::resource('venta/entrega','VentaController');
Route::resource('venta/activo','ActivoController');
Route::resource('venta/refinanciacion','RefinanciacionController');
Route::resource('cobranza/pago','CobranzaController');
Route::resource('herramienta/usuario','UsuarioController');
Route::resource('herramienta/backup','BackupController');
Route::resource('administracion/ingreso','IngresoController');
Route::resource('administracion/salida','SalidaController');
Route::resource('administracion/caja','CajaController');
Route::resource('administracion/resumen','ResumenController');
Route::resource('administracion/liquidacion','LiquidacionController');

Route::auth();

Route::get('/home', 'HomeController@index');

//Reportes
Route::get('reporteclientes', 'ClienteController@reporte');
Route::get('reporteempleados', 'EmpleadoController@reporte');
Route::get('reporteentregas/{searchText}', 'VentaController@report');
Route::get('reporteentregas', 'VentaController@reporte');
Route::get('reportepagos/{searchText}', 'CobranzaController@report');
Route::get('reportepagos', 'CobranzaController@reporte');
Route::get('reporteref/{searchText}', 'RefinanciacionController@report');
Route::get('reporteref', 'RefinanciacionController@reporte');
Route::get('reporteingresos/{searchText}', 'IngresoController@report');
Route::get('reporteingresos', 'IngresoController@reporte');
Route::get('reportesalidas/{searchText}', 'SalidaController@report');
Route::get('reportesalidas', 'SalidaController@reporte');
Route::get('reporteact/{searchText}', 'ActivoController@report');
Route::get('planilla/{searchText}', 'ActivoController@planilla');
Route::get('reporteact', 'ActivoController@reporte');
Route::get('reportecajas/{searchText}', 'CajaController@reporte');
Route::get('reportecajas', 'CajaController@report');
Route::get('reportecaja/{id}', 'CajaController@reportec');
Route::get('reporteresumen', 'ResumenController@reporte');
Route::get('reporteresumen/{searchText}', 'ResumenController@report');
Route::get('reporteliquidaciones/{searchText}', 'LiquidacionController@reporte');
Route::get('reporteliquidaciones', 'LiquidacionController@report');
Route::get('reporteliquidacion/{id}', 'LiquidacionController@reportec');