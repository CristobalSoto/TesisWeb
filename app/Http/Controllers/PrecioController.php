<?php
namespace App\Http\Controllers;

use App\Precio;
use Illuminate\Http\Request;

class PrecioController extends Controller
{
    
    public function index()
    {
      return Precio::All();
    }

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

    public function productosRegion($tipoProducto, $ano) {

      $anoQuery = '%'.$ano.'%';
      $precios = Precio::where('tipo_producto', $tipoProducto)
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
