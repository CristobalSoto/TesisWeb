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

Route::get('precios/{tipoProducto}/{producto}', 'PrecioController@custom');
Route::get('precios/{tipoProducto}', 'PrecioController@productoData');
Route::get('precios/{tipoProducto}/{producto}/{sector}', 'PrecioController@productoSector');


Route::get('regiones', 'DatosParametricosController@regiones');
Route::get('sectores/{region}', 'DatosParametricosController@sectores');

Route::get('tipos-producto', 'DatosParametricosController@tiposProducto');
Route::get('productos/{tipoProducto}', 'DatosParametricosController@productos');