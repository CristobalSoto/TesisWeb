<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('precios', 'PrecioController');

//  Búsqueda de productos
Route::get('precios-search/{tipoProducto}/{producto}', 'PrecioController@custom');
Route::get('precios-search/{tipoProducto}', 'PrecioController@productoData');
Route::get('precios-search/{tipoProducto}/{producto}/{sector}/{cantidad}', 'PrecioController@productoSector');

//  Busqueda para información gráficos
Route::get('productos-mensuales/{tipoProducto}/{ano}', 'PrecioController@productosMensuales');
Route::get('productos-region/{tipoProducto}/{ano}', 'PrecioController@productosRegion');
Route::get('productos-sector/{tipoProducto}/{ano}/{region}', 'PrecioController@productosSector');



//  Productos parámetricos
Route::get('regiones', 'DatosParametricosController@regiones');
Route::get('sectores/{region}', 'DatosParametricosController@sectores');
Route::get('tipos-producto', 'DatosParametricosController@tiposProducto');
Route::get('productos/{tipoProducto}', 'DatosParametricosController@productos');
Route::get('puntos-monitoreo/{tipoProducto}/{producto}', 'DatosParametricosController@puntosMonitoreo');