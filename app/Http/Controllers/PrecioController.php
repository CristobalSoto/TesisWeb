<?php
namespace App\Http\Controllers;

use App\Precio;
use Illuminate\Http\Request;

class PrecioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      return Precio::All();
      /*
        return response()->json(
            $precio = Precio::query()
                ->get(),200);
      */
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Precio  $precio
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $precio = Precio::findOrFail($id);
      
    }


    public function productoData($tipoProducto) {
      $precios = Precio::
                        where('tipo_producto', $tipoProducto)
                        //->where('fecha_inicio', 'LIKE', '%12/2008%')
                        ->get();
                        
      return $precios;
    }

    public function productosMensuales($tipoProducto, $ano) {

      $anoQuery = '%'.$ano.'%';
      $precios = Precio::
                        where('tipo_producto', $tipoProducto)
                        ->where('fecha_inicio', 'LIKE', $anoQuery)
                        ->get(); 
                        
      return $precios;
    }

    public function custom($tipoProducto, $producto) 
    {
      $precios = Precio::where('tipo_producto', $tipoProducto)
                        ->where('producto', $producto)
                        ->get();
                        
      return $precios;
    }

    public function productoSector($tipoProducto, $producto, $sector, $cantidad) 
    {
      $precios = Precio::where('tipo_producto', $tipoProducto)
                        ->where('producto', $producto)
                        ->where('sector', $sector)
                        ->take($cantidad)
                        ->orderBy('id', 'desc')
                        ->get();
                        
      return $precios;
    }
  
  
}
