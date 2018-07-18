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
Route::get('reporteentregas/{zona},{fecha}', 'VentaController@report');
Route::get('reportepagos/{searchText}', 'CobranzaController@report');
Route::get('reportepagos', 'CobranzaController@reporte');
Route::get('reporteref/{searchText}', 'RefinanciacionController@report');
Route::get('reporteref', 'RefinanciacionController@reporte');
Route::get('reporteingresos/{searchText}', 'IngresoController@report');
Route::get('reporteingresos', 'IngresoController@reporte');
Route::get('reportesalidas/{searchText}', 'SalidaController@report');
Route::get('reportesalidas', 'SalidaController@reporte');
Route::get('reporteact/{zona}', 'ActivoController@report');
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
Route::get('editar_cliente/{id}', 'ClienteController@edit');
Route::get('eliminar_cliente/{id}', 'ClienteController@destroy');
Route::get('editar_entrega/{id}', 'VentaController@edit');
Route::get('editar_pago/{id}', 'CobranzaController@edit');
Route::get('eliminar_entrega/{id}', 'VentaController@destroy');
Route::get('eliminar_pago/{id}', 'CobranzaController@destroy');
Route::get('activar_entrega/{id}', 'ActivoController@create');
Route::get('refi_activo/{id}', 'RefinanciacionController@create');
Route::get('editar_activo/{id}', 'ActivoController@edit');
Route::get('eliminar_activo/{id}', 'ActivoController@destroy');
Route::get('reporte_entrega/{id}', 'VentaController@reporte');
Route::get('reporte_activo/{id}', 'ActivoController@reporte');
Route::get('rep_entrega','VentaController@vistaentrega');
Route::get('rep_activo','ActivoController@vistactivo');

//datatables
Route::get('listado_clientes','ClienteController@listar_cliente');
Route::get('listado_clientes_data','ClienteController@data_cliente');
Route::get('listado_entrega','VentaController@listar_entrega');
Route::get('listado_entregas_data','VentaController@data_entrega');
Route::get('listado_activo','ActivoController@listar_activo');
Route::get('listado_activos_data','ActivoController@data_activo');
Route::get('listado_pago','CobranzaController@listar_pago');
Route::get('listado_pagos_data','CobranzaController@data_pago');