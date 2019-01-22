<?php
namespace App\Http\Controllers;

use App\Precio;
use Illuminate\Http\Request;
use DB;

class DatosParametricosController extends Controller
{

    public function regiones() {
      $regiones = DB::table('odepa_precios')->select(DB::raw('distinct region'))->get();
      return $regiones;
    }

    public function sectores($region) {
      $sectores = DB::table('odepa_precios')->select(DB::raw('distinct sector'))
                                            ->where('region', $region)
                                            ->get();
      return $sectores;
    }

    public function tiposProducto() {
      $tiposProducto = DB::table('odepa_precios')->select(DB::raw('distinct tipo_producto'))
                                            ->get();
      return $tiposProducto;
    }
    
    public function productos($tipoProducto) {
      $productos = DB::table('odepa_precios')->select(DB::raw('distinct producto'))
                                                 ->where('tipo_producto', $tipoProducto)
                                                 ->get();
      return $productos;
    }
  
}
